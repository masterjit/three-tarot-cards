<?php
/**
 * Tarot Admin Class
 * Handles the WordPress admin interface for the Three Card Tarot plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

class Tarot_Admin {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_tarot_save_card', array($this, 'ajax_save_card'));
        add_action('wp_ajax_tarot_delete_card', array($this, 'ajax_delete_card'));
        add_action('wp_ajax_tarot_get_card', array($this, 'ajax_get_card'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Three Card Tarot', 'three-card-tarot'),
            __('Tarot Cards', 'three-card-tarot'),
            'manage_options',
            'tarot-cards',
            array($this, 'admin_page'),
            'dashicons-cards',
            30
        );
        
        add_submenu_page(
            'tarot-cards',
            __('All Cards', 'three-card-tarot'),
            __('All Cards', 'three-card-tarot'),
            'manage_options',
            'tarot-cards',
            array($this, 'admin_page')
        );
        
        add_submenu_page(
            'tarot-cards',
            __('Add New Card', 'three-card-tarot'),
            __('Add New Card', 'three-card-tarot'),
            'manage_options',
            'tarot-add-card',
            array($this, 'add_card_page')
        );
        
        add_submenu_page(
            'tarot-cards',
            __('Settings', 'three-card-tarot'),
            __('Settings', 'three-card-tarot'),
            'manage_options',
            'tarot-settings',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'tarot') === false) {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_style('tarot-admin', TAROT_PLUGIN_URL . 'assets/css/admin.css', array(), TAROT_PLUGIN_VERSION);
        wp_enqueue_script('tarot-admin', TAROT_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'media-upload'), TAROT_PLUGIN_VERSION, true);
        
        wp_localize_script('tarot-admin', 'tarot_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tarot_nonce'),
            'strings' => array(
                'confirm_delete' => __('Are you sure you want to delete this card?', 'three-card-tarot'),
                'saving' => __('Saving...', 'three-card-tarot'),
                'saved' => __('Card saved successfully!', 'three-card-tarot'),
                'error' => __('An error occurred. Please try again.', 'three-card-tarot')
            )
        ));
    }
    
    /**
     * Main admin page
     */
    public function admin_page() {
        $database = new Tarot_Database();
        $cards = $database->get_active_cards();
        
        include TAROT_PLUGIN_PATH . 'templates/admin-page.php';
    }
    
    /**
     * Add new card page
     */
    public function add_card_page() {
        $card = array(
            'card_name' => '',
            'card_image' => '',
            'card_content' => '',
            'card_position' => 0,
            'is_active' => 1
        );
        
        include TAROT_PLUGIN_PATH . 'templates/add-card-page.php';
    }
    
    /**
     * Settings page
     */
    public function settings_page() {
        $settings = get_option('tarot_settings', array());
        
        if (isset($_POST['submit'])) {
            $settings = array(
                'cards_per_reading' => intval($_POST['cards_per_reading']),
                'total_cards_display' => intval($_POST['total_cards_display']),
                'enable_animations' => isset($_POST['enable_animations']),
                'enable_sound' => isset($_POST['enable_sound']),
                'card_back_image' => esc_url_raw($_POST['card_back_image']),
                'reading_title' => sanitize_text_field($_POST['reading_title']),
                'reading_description' => sanitize_textarea_field($_POST['reading_description'])
            );
            
            update_option('tarot_settings', $settings);
            echo '<div class="notice notice-success"><p>' . __('Settings saved successfully!', 'three-card-tarot') . '</p></div>';
        }
        
        include TAROT_PLUGIN_PATH . 'templates/settings-page.php';
    }
    
    /**
     * AJAX save card
     */
    public function ajax_save_card() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to perform this action.', 'three-card-tarot'));
        }
        
        $database = new Tarot_Database();
        
        $card_data = array(
            'card_name' => sanitize_text_field($_POST['card_name']),
            'card_image' => esc_url_raw($_POST['card_image']),
            'card_content' => wp_kses_post($_POST['card_content']),
            'card_position' => intval($_POST['card_position']),
            'is_active' => intval($_POST['is_active'])
        );
        
        if (isset($_POST['card_id']) && !empty($_POST['card_id'])) {
            // Update existing card
            $result = $database->update_card(intval($_POST['card_id']), $card_data);
        } else {
            // Insert new card
            $result = $database->insert_card($card_data);
        }
        
        if ($result) {
            wp_send_json_success(array(
                'message' => __('Card saved successfully!', 'three-card-tarot')
            ));
        } else {
            wp_send_json_error(array(
                'message' => __('Failed to save card. Please try again.', 'three-card-tarot')
            ));
        }
    }
    
    /**
     * AJAX delete card
     */
    public function ajax_delete_card() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to perform this action.', 'three-card-tarot'));
        }
        
        $database = new Tarot_Database();
        $result = $database->delete_card(intval($_POST['card_id']));
        
        if ($result) {
            wp_send_json_success(array(
                'message' => __('Card deleted successfully!', 'three-card-tarot')
            ));
        } else {
            wp_send_json_error(array(
                'message' => __('Failed to delete card. Please try again.', 'three-card-tarot')
            ));
        }
    }
    
    /**
     * AJAX get card
     */
    public function ajax_get_card() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to perform this action.', 'three-card-tarot'));
        }
        
        $database = new Tarot_Database();
        $card = $database->get_card(intval($_POST['card_id']));
        
        if ($card) {
            wp_send_json_success($card);
        } else {
            wp_send_json_error(array(
                'message' => __('Card not found.', 'three-card-tarot')
            ));
        }
    }
} 
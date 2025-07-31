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
        add_action('wp_ajax_tarot_update_positions', array($this, 'ajax_update_positions'));
        add_action('wp_ajax_tarot_bulk_action', array($this, 'ajax_bulk_action'));
        add_action('wp_ajax_tarot_set_daily_card', array($this, 'ajax_set_daily_card'));
        add_action('wp_ajax_tarot_regenerate_daily_card', array($this, 'ajax_regenerate_daily_card'));
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Three Card Tarot', 'three-card-tarot'),
            __('Three Card Tarot', 'three-card-tarot'),
            'manage_options',
            'three-card-tarot',
            array($this, 'admin_page'),
            'dashicons-admin-plugins',
            30
        );
        
        add_submenu_page(
            'three-card-tarot',
            __('All Cards', 'three-card-tarot'),
            __('All Cards', 'three-card-tarot'),
            'manage_options',
            'three-card-tarot',
            array($this, 'admin_page')
        );
        
        add_submenu_page(
            'three-card-tarot',
            __('Add New Card', 'three-card-tarot'),
            __('Add New Card', 'three-card-tarot'),
            'manage_options',
            'three-card-tarot-add',
            array($this, 'add_card_page')
        );
        
        add_submenu_page(
            'three-card-tarot',
            __('Daily Tarot', 'three-card-tarot'),
            __('Daily Tarot', 'three-card-tarot'),
            'manage_options',
            'three-card-tarot-daily',
            array($this, 'daily_tarot_page')
        );
        
        add_submenu_page(
            'three-card-tarot',
            __('Settings', 'three-card-tarot'),
            __('Settings', 'three-card-tarot'),
            'manage_options',
            'three-card-tarot-settings',
            array($this, 'settings_page')
        );
    }
    
    /**
     * Enqueue admin scripts and styles
     */
    public function enqueue_admin_scripts($hook) {
        if (strpos($hook, 'tarot') === false && strpos($hook, 'three-card-tarot') === false) {
            return;
        }
        
        wp_enqueue_media();
        wp_enqueue_editor();
        wp_enqueue_style('tarot-admin', TAROT_PLUGIN_URL . 'assets/css/admin.css', array(), TAROT_PLUGIN_VERSION);
        wp_enqueue_script('tarot-admin', TAROT_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'media-upload', 'editor'), TAROT_PLUGIN_VERSION, true);
        
        $settings = get_option('tarot_settings', array());
        
        wp_localize_script('tarot-admin', 'tarot_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tarot_nonce'),
            'settings' => $settings,
            'strings' => array(
                'confirm_delete' => __('Are you sure you want to delete this card?', 'three-card-tarot'),
                'saving' => __('Saving...', 'three-card-tarot'),
                'saved' => __('Card saved successfully!', 'three-card-tarot'),
                'error' => __('An error occurred. Please try again.', 'three-card-tarot')
            )
        ));
    }
    
    /**
     * Admin page
     */
    public function admin_page() {
        $database = new Tarot_Database();
        $cards = $database->get_active_cards();
        
        include TAROT_PLUGIN_PATH . 'templates/admin-page.php';
    }
    
    /**
     * Daily tarot admin page
     */
    public function daily_tarot_page() {
        $database = new Tarot_Database();
        $today_card = $database->get_daily_card();
        $all_cards = $database->get_active_cards();
        
        include TAROT_PLUGIN_PATH . 'templates/daily-tarot-admin.php';
    }
    
    /**
     * Add new card page
     */
    public function add_card_page() {
        $card = array(
            'card_name' => '',
            'card_image' => '',
            'card_content' => '',
            'card_content_reversed' => '',
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
                'enable_reversed_cards' => isset($_POST['enable_reversed_cards']),
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
            'card_content_reversed' => wp_kses_post($_POST['card_content_reversed'] ?? ''),
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
        
        $card_id = intval($_POST['card_id']);
        $database = new Tarot_Database();
        $card = $database->get_card($card_id);
        
        if ($card) {
            wp_send_json_success($card);
        } else {
            wp_send_json_error(array('message' => __('Card not found.', 'three-card-tarot')));
        }
    }
    
    /**
     * AJAX set daily card
     */
    public function ajax_set_daily_card() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        $card_id = intval($_POST['card_id']);
        $orientation = sanitize_text_field($_POST['orientation']);
        
        if (!in_array($orientation, array('upright', 'reversed'))) {
            $orientation = 'upright';
        }
        
        $database = new Tarot_Database();
        $result = $database->set_daily_card($card_id, $orientation);
        
        if ($result) {
            wp_send_json_success(array('message' => __('Daily card updated successfully.', 'three-card-tarot')));
        } else {
            wp_send_json_error(array('message' => __('Error updating daily card.', 'three-card-tarot')));
        }
    }
    
    /**
     * AJAX regenerate daily card
     */
    public function ajax_regenerate_daily_card() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        $database = new Tarot_Database();
        $result = $database->select_random_daily_card();
        
        if ($result) {
            wp_send_json_success(array('message' => __('Daily card regenerated successfully.', 'three-card-tarot')));
        } else {
            wp_send_json_error(array('message' => __('Error regenerating daily card.', 'three-card-tarot')));
        }
    }
    
    /**
     * AJAX update card positions
     */
    public function ajax_update_positions() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to perform this action.', 'three-card-tarot'));
        }
        
        $positions = $_POST['positions'];
        $database = new Tarot_Database();
        $success = true;
        
        foreach ($positions as $card_id => $position) {
            $result = $database->update_card_position(intval($card_id), intval($position));
            if (!$result) {
                $success = false;
            }
        }
        
        if ($success) {
            wp_send_json_success(array('message' => __('Card positions updated successfully!', 'three-card-tarot')));
        } else {
            wp_send_json_error(array('message' => __('Failed to update some card positions.', 'three-card-tarot')));
        }
    }
    
    /**
     * AJAX bulk action
     */
    public function ajax_bulk_action() {
        check_ajax_referer('tarot_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have permission to perform this action.', 'three-card-tarot'));
        }
        
        $action = sanitize_text_field($_POST['bulk_action']);
        $card_ids = array_map('intval', $_POST['card_ids']);
        $database = new Tarot_Database();
        $success_count = 0;
        
        switch ($action) {
            case 'activate':
                foreach ($card_ids as $card_id) {
                    if ($database->update_card_status($card_id, 1)) {
                        $success_count++;
                    }
                }
                break;
                
            case 'deactivate':
                foreach ($card_ids as $card_id) {
                    if ($database->update_card_status($card_id, 0)) {
                        $success_count++;
                    }
                }
                break;
                
            case 'delete':
                foreach ($card_ids as $card_id) {
                    if ($database->delete_card($card_id)) {
                        $success_count++;
                    }
                }
                break;
        }
        
        wp_send_json_success(array(
            'message' => sprintf(__('%d cards updated successfully!', 'three-card-tarot'), $success_count)
        ));
    }
} 
<?php
/**
 * Tarot Frontend Class
 * Handles the public frontend display of the Three Card Tarot plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

class Tarot_Frontend {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('ac_three_tarot_card_reading', array($this, 'tarot_reading_shortcode'));
        add_action('wp_ajax_tarot_get_reading', array($this, 'ajax_get_reading'));
        add_action('wp_ajax_nopriv_tarot_get_reading', array($this, 'ajax_get_reading'));
        add_action('wp_ajax_tarot_get_random_cards', array($this, 'ajax_get_random_cards'));
        add_action('wp_ajax_nopriv_tarot_get_random_cards', array($this, 'ajax_get_random_cards'));
    }
    
    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style('tarot-frontend', TAROT_PLUGIN_URL . 'assets/css/frontend.css', array(), TAROT_PLUGIN_VERSION);
        wp_enqueue_script('tarot-frontend', TAROT_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), TAROT_PLUGIN_VERSION, true);
        
        wp_localize_script('tarot-frontend', 'tarot_frontend', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('tarot_frontend_nonce'),
            'card_back_image' => $this->get_card_back_image(),
            'strings' => array(
                'select_card' => __('Select a card', 'three-card-tarot'),
                'card_selected' => __('Card selected', 'three-card-tarot'),
                'draw_again' => __('Draw Again', 'three-card-tarot'),
                'loading' => __('Loading...', 'three-card-tarot'),
                'error' => __('An error occurred. Please try again.', 'three-card-tarot')
            )
        ));
    }
    
    /**
     * Tarot reading shortcode
     */
    public function tarot_reading_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => '',
            'description' => ''
        ), $atts);
        
        ob_start();
        include TAROT_PLUGIN_PATH . 'templates/frontend-display.php';
        return ob_get_clean();
    }
    
    /**
     * AJAX get reading
     */
    public function ajax_get_reading() {
        check_ajax_referer('tarot_frontend_nonce', 'nonce');
        
        $card_ids = array_map('intval', $_POST['card_ids']);
        
        if (count($card_ids) !== 3) {
            wp_send_json_error(array(
                'message' => __('Please select exactly 3 cards.', 'three-card-tarot')
            ));
        }
        
        $database = new Tarot_Database();
        $cards = $database->get_cards_by_ids($card_ids);
        
        if (count($cards) !== 3) {
            wp_send_json_error(array(
                'message' => __('Some cards could not be found.', 'three-card-tarot')
            ));
        }
        
        $reading = array(
            'cards' => $cards,
            'timestamp' => current_time('timestamp'),
            'interpretation' => $this->generate_reading_interpretation($cards)
        );
        
        wp_send_json_success($reading);
    }
    
    /**
     * AJAX get random cards
     */
    public function ajax_get_random_cards() {
        check_ajax_referer('tarot_frontend_nonce', 'nonce');
        
        $settings = get_option('tarot_settings', array());
        $total_cards = $settings['total_cards_display'] ?? 8;
        
        $database = new Tarot_Database();
        $cards = $database->get_random_cards($total_cards);
        
        if (empty($cards)) {
            wp_send_json_error(array(
                'message' => __('No cards available.', 'three-card-tarot')
            ));
        }
        
        // Format cards for frontend
        $formatted_cards = array();
        foreach ($cards as $card) {
            $formatted_cards[] = array(
                'id' => $card->id,
                'name' => $card->card_name,
                'image' => $card->card_image,
                'content' => stripslashes(wp_kses_post($card->card_content))
            );
        }
        
        wp_send_json_success(array(
            'cards' => $formatted_cards
        ));
    }
    
    /**
     * Generate reading interpretation
     */
    private function generate_reading_interpretation($cards) {
        $interpretation = '';
        
        if (count($cards) === 3) {
            $interpretation = sprintf(
                '<h3>%s</h3><p>%s</p><h4>%s</h4><p>%s</p><h4>%s</h4><p>%s</p><h4>%s</h4><p>%s</p>',
                __('Your Three Card Reading', 'three-card-tarot'),
                __('Here is your personalized tarot reading based on the cards you selected:', 'three-card-tarot'),
                sprintf(__('Card 1: %s', 'three-card-tarot'), $cards[0]->card_name),
                stripslashes(wp_kses_post($cards[0]->card_content)),
                sprintf(__('Card 2: %s', 'three-card-tarot'), $cards[1]->card_name),
                stripslashes(wp_kses_post($cards[1]->card_content)),
                sprintf(__('Card 3: %s', 'three-card-tarot'), $cards[2]->card_name),
                stripslashes(wp_kses_post($cards[2]->card_content))
            );
        }
        
        return $interpretation;
    }
    
    /**
     * Get card back image
     */
    public function get_card_back_image() {
        $settings = get_option('tarot_settings', array());
        $card_back = $settings['card_back_image'] ?? '';
        
        if (empty($card_back)) {
            $card_back = TAROT_PLUGIN_URL . 'assets/images/card-back.svg';
        }
        
        return $card_back;
    }
} 
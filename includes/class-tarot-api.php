<?php
/**
 * Tarot API Class
 * Handles REST API endpoints for the Three Card Tarot plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

class Tarot_API {
    
    /**
     * Constructor
     */
    public function __construct() {
        add_action('rest_api_init', array($this, 'register_routes'));
    }
    
    /**
     * Register REST API routes
     */
    public function register_routes() {
        register_rest_route('tarot/v1', '/cards', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_cards'),
                'permission_callback' => '__return_true'
            )
        ));
        
        register_rest_route('tarot/v1', '/reading', array(
            array(
                'methods' => WP_REST_Server::CREATABLE,
                'callback' => array($this, 'create_reading'),
                'permission_callback' => '__return_true',
                'args' => array(
                    'card_ids' => array(
                        'required' => true,
                        'type' => 'array',
                        'items' => array(
                            'type' => 'integer'
                        ),
                        'validate_callback' => array($this, 'validate_card_ids')
                    )
                )
            )
        ));
        
        register_rest_route('tarot/v1', '/reading/(?P<id>\d+)', array(
            array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_reading'),
                'permission_callback' => '__return_true'
            )
        ));
    }
    
    /**
     * Get all cards
     */
    public function get_cards($request) {
        $database = new Tarot_Database();
        $cards = $database->get_active_cards();
        
        return new WP_REST_Response($cards, 200);
    }
    
    /**
     * Create a new reading
     */
    public function create_reading($request) {
        $card_ids = $request->get_param('card_ids');
        
        if (count($card_ids) !== 3) {
            return new WP_Error(
                'invalid_card_count',
                __('Please select exactly 3 cards.', 'three-card-tarot'),
                array('status' => 400)
            );
        }
        
        $database = new Tarot_Database();
        $cards = $database->get_cards_by_ids($card_ids);
        
        if (count($cards) !== 3) {
            return new WP_Error(
                'cards_not_found',
                __('Some cards could not be found.', 'three-card-tarot'),
                array('status' => 404)
            );
        }
        
        $reading = array(
            'id' => uniqid('reading_'),
            'cards' => $cards,
            'timestamp' => current_time('timestamp'),
            'interpretation' => $this->generate_reading_interpretation($cards)
        );
        
        // Store reading in transient for demo purposes
        // In production, you might want to store in database
        set_transient('tarot_reading_' . $reading['id'], $reading, HOUR_IN_SECONDS);
        
        return new WP_REST_Response($reading, 201);
    }
    
    /**
     * Get a specific reading
     */
    public function get_reading($request) {
        $reading_id = $request->get_param('id');
        $reading = get_transient('tarot_reading_' . $reading_id);
        
        if (!$reading) {
            return new WP_Error(
                'reading_not_found',
                __('Reading not found.', 'three-card-tarot'),
                array('status' => 404)
            );
        }
        
        return new WP_REST_Response($reading, 200);
    }
    
    /**
     * Validate card IDs
     */
    public function validate_card_ids($param, $request, $key) {
        if (!is_array($param)) {
            return false;
        }
        
        if (count($param) !== 3) {
            return false;
        }
        
        foreach ($param as $id) {
            if (!is_numeric($id) || $id <= 0) {
                return false;
            }
        }
        
        return true;
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
                $cards[0]->card_content,
                sprintf(__('Card 2: %s', 'three-card-tarot'), $cards[1]->card_name),
                $cards[1]->card_content,
                sprintf(__('Card 3: %s', 'three-card-tarot'), $cards[2]->card_name),
                $cards[2]->card_content
            );
        }
        
        return $interpretation;
    }
} 
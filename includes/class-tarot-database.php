<?php
/**
 * Tarot Database Class
 * Handles all database operations for the Three Card Tarot plugin
 */

if (!defined('ABSPATH')) {
    exit;
}

class Tarot_Database {
    
    /**
     * Database table name
     */
    private $table_name;
    
    /**
     * Constructor
     */
    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'ac_three_tarot_cards';
    }
    
    /**
     * Create database tables
     */
    public function create_tables() {
        global $wpdb;
        
        // Drop the table if it exists
        $wpdb->query("DROP TABLE IF EXISTS {$this->table_name}");
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            card_name varchar(255) NOT NULL,
            card_image varchar(500) NOT NULL,
            card_content longtext NOT NULL,
            card_content_reversed longtext NOT NULL,
            card_position int(11) DEFAULT 0,
            is_active tinyint(1) DEFAULT 1,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY card_position (card_position),
            KEY is_active (is_active)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    
    /**
     * Insert default cards
     */
    public function insert_default_cards() {
        // Load the comprehensive tarot cards data
        require_once TAROT_PLUGIN_PATH . 'includes/tarot-cards-data.php';
        
        $all_cards = Tarot_Cards_Data::get_all_cards();
        
        foreach ($all_cards as $card) {
            $this->insert_card($card);
        }
    }
    
    /**
     * Insert a new card
     */
    public function insert_card($card_data) {
        global $wpdb;
        
        $defaults = array(
            'card_name' => '',
            'card_image' => '',
            'card_content' => '',
            'card_content_reversed' => '',
            'card_position' => 0,
            'is_active' => 1
        );
        
        $card_data = wp_parse_args($card_data, $defaults);
        
        $result = $wpdb->insert(
            $this->table_name,
            array(
                'card_name' => sanitize_text_field($card_data['card_name']),
                'card_image' => esc_url_raw($card_data['card_image']),
                'card_content' => wp_kses_post($card_data['card_content']),
                'card_content_reversed' => wp_kses_post($card_data['card_content_reversed']),
                'card_position' => intval($card_data['card_position']),
                'is_active' => intval($card_data['is_active'])
            ),
            array('%s', '%s', '%s', '%s', '%d', '%d')
        );
        
        return $result;
    }
    
    /**
     * Get all active cards
     */
    public function get_active_cards($limit = null) {
        global $wpdb;
        
        $sql = "SELECT * FROM {$this->table_name} WHERE is_active = 1 ORDER BY card_position ASC";
        
        if ($limit) {
            $sql .= $wpdb->prepare(" LIMIT %d", $limit);
        }
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get card by ID
     */
    public function get_card($id) {
        global $wpdb;
        
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_name} WHERE id = %d",
                $id
            )
        );
    }
    
    /**
     * Update card
     */
    public function update_card($id, $card_data) {
        global $wpdb;
        
        $result = $wpdb->update(
            $this->table_name,
            array(
                'card_name' => sanitize_text_field($card_data['card_name']),
                'card_image' => esc_url_raw($card_data['card_image']),
                'card_content' => wp_kses_post($card_data['card_content']),
                'card_content_reversed' => wp_kses_post($card_data['card_content_reversed']),
                'card_position' => intval($card_data['card_position']),
                'is_active' => intval($card_data['is_active'])
            ),
            array('id' => $id),
            array('%s', '%s', '%s', '%s', '%d', '%d'),
            array('%d')
        );
        
        return $result;
    }
    
    /**
     * Delete card
     */
    public function delete_card($id) {
        global $wpdb;
        
        return $wpdb->delete(
            $this->table_name,
            array('id' => $id),
            array('%d')
        );
    }
    
    /**
     * Get random cards for reading
     */
    public function get_random_cards($count = 8) {
        global $wpdb;
        
        $sql = $wpdb->prepare(
            "SELECT * FROM {$this->table_name} WHERE is_active = 1 ORDER BY RAND() LIMIT %d",
            $count
        );
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Get cards by IDs
     */
    public function get_cards_by_ids($ids) {
        global $wpdb;
        
        if (empty($ids)) {
            return array();
        }
        
        $ids = array_map('intval', $ids);
        $ids_string = implode(',', $ids);
        
        $sql = "SELECT * FROM {$this->table_name} WHERE id IN ({$ids_string}) ORDER BY FIELD(id, {$ids_string})";
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Count total cards
     */
    public function count_cards($active_only = true) {
        global $wpdb;
        
        $sql = "SELECT COUNT(*) FROM {$this->table_name}";
        
        if ($active_only) {
            $sql .= " WHERE is_active = 1";
        }
        
        return $wpdb->get_var($sql);
    }
} 
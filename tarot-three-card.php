<?php
/**
 * Plugin Name: Three Card Tarot
 * Plugin URI: https://example.com/three-card-tarot
 * Description: A WordPress plugin for interactive three card tarot readings with customizable cards.
 * Version: 1.0.0
 * Author: AstrologyCosmic
 * Author URI: https://example.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: three-card-tarot
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TAROT_PLUGIN_VERSION', '1.0.0');
define('TAROT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TAROT_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TAROT_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Three Card Tarot Plugin Class
 */
class ThreeCardTarot {
    
    /**
     * Plugin instance
     */
    private static $instance = null;
    
    /**
     * Get plugin instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->init_hooks();
        $this->load_dependencies();
    }
    
    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        add_action('init', array($this, 'init'));
    }
    
    /**
     * Load plugin dependencies
     */
    private function load_dependencies() {
        // Load core classes
        require_once TAROT_PLUGIN_PATH . 'includes/class-tarot-database.php';
        require_once TAROT_PLUGIN_PATH . 'includes/class-tarot-admin.php';
        require_once TAROT_PLUGIN_PATH . 'includes/class-tarot-frontend.php';
        require_once TAROT_PLUGIN_PATH . 'includes/class-tarot-api.php';
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Create database tables
        $database = new Tarot_Database();
        $database->create_tables();
        
        // Insert default cards
        $database->insert_default_cards();
        
        // Set default options
        $this->set_default_options();
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    /**
     * Load plugin textdomain
     */
    public function load_textdomain() {
        load_plugin_textdomain(
            'three-card-tarot',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages'
        );
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Initialize components
        new Tarot_Admin();
        new Tarot_Frontend();
        new Tarot_API();
    }
    
    /**
     * Set default plugin options
     */
    private function set_default_options() {
        $default_options = array(
            'cards_per_reading' => 3,
            'total_cards_display' => 8,
            'enable_animations' => true,
            'enable_sound' => false,
            'card_back_image' => '',
            'reading_title' => __('Three Card Tarot Reading', 'three-card-tarot'),
            'reading_description' => __('Select three cards for your tarot reading.', 'three-card-tarot')
        );
        
        add_option('tarot_settings', $default_options);
    }
}

// Initialize the plugin
ThreeCardTarot::get_instance(); 
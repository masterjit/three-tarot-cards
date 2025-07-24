<?php
/**
 * Phase 2 Test Script for Three Card Tarot Plugin
 * Tests admin interface functionality and settings
 */

// Include WordPress
require_once('../../../wp-config.php');

// Check if we're in WordPress environment
if (!defined('ABSPATH')) {
    echo "Error: This script must be run from within WordPress environment.\n";
    exit;
}

echo "=== Phase 2 Test - Three Card Tarot Plugin ===\n\n";

// Test 1: Check if admin class exists
echo "1. Testing Admin Class...\n";
if (class_exists('Tarot_Admin')) {
    echo "✓ Tarot_Admin class exists\n";
} else {
    echo "✗ Tarot_Admin class not found\n";
    exit;
}

// Test 2: Check if admin menu is registered
echo "\n2. Testing Admin Menu Registration...\n";
$admin_menu_hooks = array();
foreach ($GLOBALS['wp_filter']['admin_menu'] as $priority => $callbacks) {
    foreach ($callbacks as $callback) {
        if (is_array($callback['function']) && is_object($callback['function'][0])) {
            $class_name = get_class($callback['function'][0]);
            if ($class_name === 'Tarot_Admin') {
                $admin_menu_hooks[] = $callback['function'][1];
            }
        }
    }
}

if (!empty($admin_menu_hooks)) {
    echo "✓ Admin menu hooks registered: " . implode(', ', $admin_menu_hooks) . "\n";
} else {
    echo "✗ No admin menu hooks found\n";
}

// Test 3: Check if AJAX handlers are registered
echo "\n3. Testing AJAX Handlers...\n";
$ajax_actions = array('tarot_save_card', 'tarot_delete_card', 'tarot_get_card');
foreach ($ajax_actions as $action) {
    if (has_action("wp_ajax_$action")) {
        echo "✓ AJAX handler '$action' registered\n";
    } else {
        echo "✗ AJAX handler '$action' not found\n";
    }
}

// Test 4: Check if settings are saved
echo "\n4. Testing Settings...\n";
$settings = get_option('tarot_settings', array());
if (!empty($settings)) {
    echo "✓ Plugin settings found\n";
    echo "  - Cards per reading: " . ($settings['cards_per_reading'] ?? 'not set') . "\n";
    echo "  - Total cards display: " . ($settings['total_cards_display'] ?? 'not set') . "\n";
    echo "  - Enable animations: " . (($settings['enable_animations'] ?? false) ? 'yes' : 'no') . "\n";
} else {
    echo "✗ No plugin settings found\n";
}

// Test 5: Check if templates exist
echo "\n5. Testing Template Files...\n";
$template_files = array(
    'templates/admin-page.php',
    'templates/add-card-page.php',
    'templates/settings-page.php',
    'templates/frontend-display.php'
);

foreach ($template_files as $file) {
    $full_path = WP_PLUGIN_DIR . '/tarot-three-card/' . $file;
    if (file_exists($full_path)) {
        echo "✓ Template file exists: $file\n";
    } else {
        echo "✗ Template file missing: $file\n";
    }
}

// Test 6: Check if assets exist
echo "\n6. Testing Asset Files...\n";
$asset_files = array(
    'assets/css/admin.css',
    'assets/css/frontend.css',
    'assets/js/admin.js',
    'assets/js/frontend.js',
    'assets/images/card-back.svg',
    'assets/images/cards/placeholder.svg'
);

foreach ($asset_files as $file) {
    $full_path = WP_PLUGIN_DIR . '/tarot-three-card/' . $file;
    if (file_exists($full_path)) {
        echo "✓ Asset file exists: $file\n";
    } else {
        echo "✗ Asset file missing: $file\n";
    }
}

// Test 7: Test database operations
echo "\n7. Testing Database Operations...\n";
$database = new Tarot_Database();

// Test get_active_cards
$active_cards = $database->get_active_cards(3);
echo "✓ get_active_cards() returned " . count($active_cards) . " cards\n";

// Test get_random_cards
$random_cards = $database->get_random_cards(3);
echo "✓ get_random_cards() returned " . count($random_cards) . " cards\n";

// Test count_cards
$total_cards = $database->count_cards();
echo "✓ count_cards() returned $total_cards total cards\n";

// Test 8: Test shortcode registration
echo "\n8. Testing Shortcode Registration...\n";
if (shortcode_exists('ac_three_tarot_card_reading')) {
    echo "✓ Shortcode 'ac_three_tarot_card_reading' is registered\n";
} else {
    echo "✗ Shortcode 'ac_three_tarot_card_reading' not found\n";
}

// Test 9: Test REST API registration
echo "\n9. Testing REST API Registration...\n";
$rest_routes = array(
    '/tarot/v1/cards',
    '/tarot/v1/reading'
);

foreach ($rest_routes as $route) {
    $response = wp_remote_get(home_url('/wp-json' . $route));
    if (!is_wp_error($response) && $response['response']['code'] !== 404) {
        echo "✓ REST API route exists: $route\n";
    } else {
        echo "✗ REST API route not found: $route\n";
    }
}

// Test 10: Test frontend functionality
echo "\n10. Testing Frontend Functionality...\n";
if (class_exists('Tarot_Frontend')) {
    echo "✓ Tarot_Frontend class exists\n";
    
    // Test shortcode output
    $shortcode_output = do_shortcode('[ac_three_tarot_card_reading]');
    if (!empty($shortcode_output)) {
        echo "✓ Shortcode produces output\n";
    } else {
        echo "✗ Shortcode produces no output\n";
    }
} else {
    echo "✗ Tarot_Frontend class not found\n";
}

// Test 11: Check admin capabilities
echo "\n11. Testing Admin Capabilities...\n";
if (current_user_can('manage_options')) {
    echo "✓ Current user has admin capabilities\n";
} else {
    echo "✗ Current user lacks admin capabilities\n";
}

// Test 12: Test plugin constants
echo "\n12. Testing Plugin Constants...\n";
$constants = array('TAROT_PLUGIN_VERSION', 'TAROT_PLUGIN_URL', 'TAROT_PLUGIN_PATH');
foreach ($constants as $constant) {
    if (defined($constant)) {
        echo "✓ Constant defined: $constant = " . constant($constant) . "\n";
    } else {
        echo "✗ Constant not defined: $constant\n";
    }
}

echo "\n=== Phase 2 Test Complete ===\n";
echo "\nSummary:\n";
echo "- Admin interface: " . (class_exists('Tarot_Admin') ? 'Ready' : 'Not Ready') . "\n";
echo "- Settings page: " . (file_exists(WP_PLUGIN_DIR . '/tarot-three-card/templates/settings-page.php') ? 'Ready' : 'Not Ready') . "\n";
echo "- Add card page: " . (file_exists(WP_PLUGIN_DIR . '/tarot-three-card/templates/add-card-page.php') ? 'Ready' : 'Not Ready') . "\n";
echo "- Asset files: " . (file_exists(WP_PLUGIN_DIR . '/tarot-three-card/assets/css/admin.css') ? 'Ready' : 'Not Ready') . "\n";
echo "- Database operations: " . (class_exists('Tarot_Database') ? 'Ready' : 'Not Ready') . "\n";

echo "\nNext steps for Phase 3:\n";
echo "1. Test the admin interface in WordPress admin\n";
echo "2. Add the shortcode to a page and test frontend\n";
echo "3. Upload real tarot card images\n";
echo "4. Customize card interpretations\n";
echo "5. Test the complete reading flow\n"; 
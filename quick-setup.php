<?php
/**
 * Quick Setup Script for Three Card Tarot Plugin
 * Run this script to quickly set up and test the plugin on your local environment
 */

// Check if we're in WordPress environment
if (!defined('ABSPATH')) {
    echo "=== Three Card Tarot Plugin - Quick Setup ===\n\n";
    echo "This script helps you set up the plugin for local testing.\n\n";
    
    // Check if WordPress is available
    $wp_config_path = '../../../wp-config.php';
    if (file_exists($wp_config_path)) {
        echo "✓ WordPress configuration found\n";
        echo "Loading WordPress environment...\n\n";
        require_once($wp_config_path);
    } else {
        echo "✗ WordPress configuration not found\n";
        echo "Please run this script from within your WordPress plugins directory.\n";
        echo "Expected path: wp-content/plugins/tarot-three-card/quick-setup.php\n\n";
        exit;
    }
}

echo "=== Three Card Tarot Plugin - Quick Setup ===\n\n";

// Step 1: Check Plugin Status
echo "1. Checking Plugin Status...\n";
$active_plugins = get_option('active_plugins', array());
$plugin_file = 'tarot-three-card/tarot-three-card.php';

if (in_array($plugin_file, $active_plugins)) {
    echo "✓ Plugin is activated\n";
} else {
    echo "✗ Plugin is not activated\n";
    echo "  Please activate the plugin in WordPress Admin → Plugins\n";
    echo "  Then run this script again.\n\n";
    exit;
}

// Step 2: Check Database
echo "\n2. Checking Database...\n";
if (class_exists('Tarot_Database')) {
    $database = new Tarot_Database();
    $table_name = $database->get_table_name();
    
    global $wpdb;
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name;
    
    if ($table_exists) {
        echo "✓ Database table exists: $table_name\n";
        
        $total_cards = $database->count_cards();
        $active_cards = $database->count_cards(true);
        
        echo "  - Total cards: $total_cards\n";
        echo "  - Active cards: $active_cards\n";
        echo "  - Inactive cards: " . ($total_cards - $active_cards) . "\n";
    } else {
        echo "✗ Database table does not exist\n";
        echo "  Please deactivate and reactivate the plugin\n";
        exit;
    }
} else {
    echo "✗ Tarot_Database class not found\n";
    exit;
}

// Step 3: Check Admin Interface
echo "\n3. Checking Admin Interface...\n";
if (class_exists('Tarot_Admin')) {
    echo "✓ Tarot_Admin class exists\n";
    
    // Check admin menu
    $admin_menu_exists = false;
    foreach ($GLOBALS['wp_filter']['admin_menu'] as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
            if (is_array($callback['function']) && is_object($callback['function'][0])) {
                $class_name = get_class($callback['function'][0]);
                if ($class_name === 'Tarot_Admin') {
                    $admin_menu_exists = true;
                    break 2;
                }
            }
        }
    }
    
    if ($admin_menu_exists) {
        echo "✓ Admin menu registered\n";
    } else {
        echo "✗ Admin menu not registered\n";
    }
} else {
    echo "✗ Tarot_Admin class not found\n";
}

// Step 4: Check Shortcode
echo "\n4. Checking Shortcode...\n";
if (shortcode_exists('ac_three_tarot_card_reading')) {
    echo "✓ Shortcode 'ac_three_tarot_card_reading' is registered\n";
    
    // Test shortcode output
    $shortcode_output = do_shortcode('[ac_three_tarot_card_reading]');
    if (!empty($shortcode_output)) {
        echo "✓ Shortcode produces output\n";
    } else {
        echo "✗ Shortcode produces no output\n";
    }
} else {
    echo "✗ Shortcode 'ac_three_tarot_card_reading' not found\n";
}

// Step 5: Check Asset Files
echo "\n5. Checking Asset Files...\n";
$asset_files = array(
    'assets/css/admin.css' => 'Admin CSS',
    'assets/css/frontend.css' => 'Frontend CSS',
    'assets/js/admin.js' => 'Admin JS',
    'assets/js/frontend.js' => 'Frontend JS',
    'assets/images/card-back.svg' => 'Card back image',
    'assets/images/cards/placeholder.svg' => 'Card placeholder'
);

$missing_files = array();
foreach ($asset_files as $file => $description) {
    $full_path = WP_PLUGIN_DIR . '/tarot-three-card/' . $file;
    if (file_exists($full_path)) {
        echo "✓ $description exists\n";
    } else {
        echo "✗ $description missing\n";
        $missing_files[] = $file;
    }
}

// Step 6: Generate Test Page
echo "\n6. Generating Test Page...\n";

// Check if test page already exists
$test_page = get_page_by_title('Tarot Reading Test');
if ($test_page) {
    echo "✓ Test page already exists (ID: {$test_page->ID})\n";
    $page_id = $test_page->ID;
} else {
    // Create test page
    $page_data = array(
        'post_title' => 'Tarot Reading Test',
        'post_content' => '[ac_three_tarot_card_reading]',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_author' => 1
    );
    
    $page_id = wp_insert_post($page_data);
    if ($page_id) {
        echo "✓ Test page created (ID: $page_id)\n";
    } else {
        echo "✗ Failed to create test page\n";
    }
}

// Step 7: Summary and Next Steps
echo "\n=== Setup Summary ===\n";

if (empty($missing_files)) {
    echo "✅ All files present\n";
} else {
    echo "⚠️  Missing files:\n";
    foreach ($missing_files as $file) {
        echo "   - $file\n";
    }
}

echo "\n=== Next Steps ===\n";
echo "1. Go to WordPress Admin → Tarot Cards\n";
echo "2. Test the admin interface\n";
echo "3. Visit your test page: " . get_permalink($page_id) . "\n";
echo "4. Test the frontend card selection\n";
echo "5. Run comprehensive tests: php test-phase3.php\n";

echo "\n=== Quick Test Commands ===\n";
echo "Database test: php test-database.php\n";
echo "Phase 2 test: php test-phase2.php\n";
echo "Phase 3 test: php test-phase3.php\n";

echo "\n=== Admin URLs ===\n";
echo "Main Admin: " . admin_url('admin.php?page=tarot-cards') . "\n";
echo "Add Card: " . admin_url('admin.php?page=tarot-add-card') . "\n";
echo "Settings: " . admin_url('admin.php?page=tarot-settings') . "\n";

echo "\n=== Frontend URLs ===\n";
echo "Test Page: " . get_permalink($page_id) . "\n";

echo "\n=== API Endpoints ===\n";
echo "Cards API: " . home_url('/wp-json/tarot/v1/cards') . "\n";
echo "Reading API: " . home_url('/wp-json/tarot/v1/reading') . "\n";

echo "\n=== Troubleshooting ===\n";
echo "If you encounter issues:\n";
echo "1. Check WordPress error logs\n";
echo "2. Enable debug mode in wp-config.php\n";
echo "3. Verify file permissions (755 for directories, 644 for files)\n";
echo "4. Check browser console for JavaScript errors\n";

echo "\n=== Success! ===\n";
echo "Your Three Card Tarot plugin is ready for testing!\n";
echo "Shortcode: [ac_three_tarot_card_reading]\n";
echo "Admin Menu: WordPress Admin → Tarot Cards\n\n";

echo "Happy Testing! 🎴✨\n"; 
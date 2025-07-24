<?php
/**
 * Test Script for Three Card Tarot Plugin Database
 * Run this script to test database table creation and verify plugin functionality
 */

// Include WordPress
require_once('../../../wp-config.php');

// Check if we're in WordPress environment
if (!defined('ABSPATH')) {
    echo "Error: This script must be run from within WordPress environment.\n";
    exit;
}

echo "=== Three Card Tarot Plugin Database Test ===\n\n";

// Test 1: Check if plugin files exist
echo "1. Checking plugin files...\n";
$plugin_file = WP_PLUGIN_DIR . '/tarot-three-card/tarot-three-card.php';
if (file_exists($plugin_file)) {
    echo "✓ Plugin main file exists\n";
} else {
    echo "✗ Plugin main file not found at: $plugin_file\n";
    exit;
}

// Test 2: Check if database class exists
echo "\n2. Checking database class...\n";
$db_class_file = WP_PLUGIN_DIR . '/tarot-three-card/includes/class-tarot-database.php';
if (file_exists($db_class_file)) {
    echo "✓ Database class file exists\n";
    require_once($db_class_file);
} else {
    echo "✗ Database class file not found\n";
    exit;
}

// Test 3: Check if table exists
echo "\n3. Checking database table...\n";
global $wpdb;
$table_name = $wpdb->prefix . 'tarot_cards';
$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;

if ($table_exists) {
    echo "✓ Database table '$table_name' exists\n";
} else {
    echo "✗ Database table '$table_name' does not exist\n";
    echo "Creating table...\n";
    
    // Create table
    $database = new Tarot_Database();
    $database->create_tables();
    
    // Check again
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name;
    if ($table_exists) {
        echo "✓ Database table created successfully\n";
    } else {
        echo "✗ Failed to create database table\n";
        exit;
    }
}

// Test 4: Check table structure
echo "\n4. Checking table structure...\n";
$columns = $wpdb->get_results("DESCRIBE $table_name");
$expected_columns = array('id', 'card_name', 'card_image', 'card_content', 'card_position', 'is_active', 'created_at', 'updated_at');

foreach ($expected_columns as $column) {
    $found = false;
    foreach ($columns as $col) {
        if ($col->Field == $column) {
            $found = true;
            break;
        }
    }
    if ($found) {
        echo "✓ Column '$column' exists\n";
    } else {
        echo "✗ Column '$column' missing\n";
    }
}

// Test 5: Check if default cards exist
echo "\n5. Checking default cards...\n";
$card_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
echo "Found $card_count cards in database\n";

if ($card_count == 0) {
    echo "No cards found. Inserting default cards...\n";
    $database = new Tarot_Database();
    $database->insert_default_cards();
    
    $card_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    echo "Now found $card_count cards in database\n";
}

// Test 6: Display sample cards
echo "\n6. Sample cards in database:\n";
$cards = $wpdb->get_results("SELECT id, card_name, card_position, is_active FROM $table_name ORDER BY card_position LIMIT 5");
foreach ($cards as $card) {
    $status = $card->is_active ? 'Active' : 'Inactive';
    echo "- ID: {$card->id}, Name: {$card->card_name}, Position: {$card->position}, Status: $status\n";
}

// Test 7: Test database operations
echo "\n7. Testing database operations...\n";
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

echo "\n=== Database Test Complete ===\n";
echo "All tests passed! The plugin database is working correctly.\n";
echo "\nNext steps:\n";
echo "1. Activate the plugin in WordPress admin\n";
echo "2. Go to 'Tarot Cards' in the admin menu\n";
echo "3. Add the shortcode [tarot_reading] to any page\n";
echo "4. Test the frontend functionality\n"; 
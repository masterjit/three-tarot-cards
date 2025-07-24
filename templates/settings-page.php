<?php
/**
 * Settings Page Template
 * Template for the Three Card Tarot plugin settings page
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get current settings with defaults
$default_settings = array(
    'cards_per_reading' => 3,
    'total_cards_display' => 8,
    'enable_animations' => true,
    'enable_sound' => false,
    'card_back_image' => '',
    'reading_title' => __('Three Card Tarot Reading', 'three-card-tarot'),
    'reading_description' => __('Select three cards for your tarot reading.', 'three-card-tarot')
);

$settings = wp_parse_args($settings, $default_settings);
?>

<div class="wrap">
    <h1><?php echo esc_html__('Three Card Tarot Settings', 'three-card-tarot'); ?></h1>
    
    <div class="tarot-admin-header">
        <a href="<?php echo admin_url('admin.php?page=tarot-cards'); ?>" class="button">
            <?php echo esc_html__('← Back to Cards', 'three-card-tarot'); ?>
        </a>
    </div>
    
    <form method="post" action="">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="cards_per_reading"><?php echo esc_html__('Cards per Reading', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <input type="number" id="cards_per_reading" name="cards_per_reading" value="<?php echo esc_attr($settings['cards_per_reading']); ?>" min="1" max="10" class="small-text">
                    <p class="description"><?php echo esc_html__('Number of cards users must select for a reading (default: 3)', 'three-card-tarot'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="total_cards_display"><?php echo esc_html__('Total Cards Display', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <input type="number" id="total_cards_display" name="total_cards_display" value="<?php echo esc_attr($settings['total_cards_display']); ?>" min="3" max="20" class="small-text">
                    <p class="description"><?php echo esc_html__('Number of cards to display for selection (default: 8)', 'three-card-tarot'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="enable_animations"><?php echo esc_html__('Enable Animations', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <label>
                        <input type="checkbox" id="enable_animations" name="enable_animations" value="1" <?php checked($settings['enable_animations'], true); ?>>
                        <?php echo esc_html__('Enable card flip animations and hover effects', 'three-card-tarot'); ?>
                    </label>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="enable_sound"><?php echo esc_html__('Enable Sound Effects', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <label>
                        <input type="checkbox" id="enable_sound" name="enable_sound" value="1" <?php checked($settings['enable_sound'], true); ?>>
                        <?php echo esc_html__('Enable sound effects for card interactions (future feature)', 'three-card-tarot'); ?>
                    </label>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="card_back_image"><?php echo esc_html__('Card Back Image', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <input type="text" id="card_back_image" name="card_back_image" value="<?php echo esc_attr($settings['card_back_image']); ?>" class="regular-text">
                    <button type="button" class="button upload-image"><?php echo esc_html__('Choose Image', 'three-card-tarot'); ?></button>
                    <div id="card-back-preview">
                        <?php if (!empty($settings['card_back_image'])) : ?>
                            <img src="<?php echo esc_url($settings['card_back_image']); ?>" alt="Card Back Preview" style="max-width: 200px; max-height: 150px; margin-top: 10px;">
                        <?php endif; ?>
                    </div>
                    <p class="description"><?php echo esc_html__('Image to display on the back of cards (optional)', 'three-card-tarot'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="reading_title"><?php echo esc_html__('Reading Title', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <input type="text" id="reading_title" name="reading_title" value="<?php echo esc_attr($settings['reading_title']); ?>" class="regular-text">
                    <p class="description"><?php echo esc_html__('Title displayed on the reading interface', 'three-card-tarot'); ?></p>
                </td>
            </tr>
            
            <tr>
                <th scope="row">
                    <label for="reading_description"><?php echo esc_html__('Reading Description', 'three-card-tarot'); ?></label>
                </th>
                <td>
                    <textarea id="reading_description" name="reading_description" rows="3" class="large-text"><?php echo esc_textarea($settings['reading_description']); ?></textarea>
                    <p class="description"><?php echo esc_html__('Description displayed below the reading title', 'three-card-tarot'); ?></p>
                </td>
            </tr>
        </table>
        
        <h2><?php echo esc_html__('Shortcode Usage', 'three-card-tarot'); ?></h2>
        <p><?php echo esc_html__('Use this shortcode to display the tarot reading interface on any page or post:', 'three-card-tarot'); ?></p>
        <code>[ac_three_tarot_card_reading]</code>
        
        <p><?php echo esc_html__('Or with custom parameters:', 'three-card-tarot'); ?></p>
        <code>[ac_three_tarot_card_reading title="My Custom Reading" description="Select your cards wisely"]</code>
        
        <h2><?php echo esc_html__('API Endpoints', 'three-card-tarot'); ?></h2>
        <p><?php echo esc_html__('The plugin provides REST API endpoints for external access:', 'three-card-tarot'); ?></p>
        <ul>
            <li><code>GET /wp-json/tarot/v1/cards</code> - <?php echo esc_html__('Get all cards', 'three-card-tarot'); ?></li>
            <li><code>POST /wp-json/tarot/v1/reading</code> - <?php echo esc_html__('Create a new reading', 'three-card-tarot'); ?></li>
            <li><code>GET /wp-json/tarot/v1/reading/{id}</code> - <?php echo esc_html__('Get a specific reading', 'three-card-tarot'); ?></li>
        </ul>
        
        <h2><?php echo esc_html__('Statistics', 'three-card-tarot'); ?></h2>
        <?php
        $database = new Tarot_Database();
        $total_cards = $database->count_cards();
        $active_cards = $database->count_cards(true);
        ?>
        <table class="widefat">
            <tr>
                <td><strong><?php echo esc_html__('Total Cards:', 'three-card-tarot'); ?></strong></td>
                <td><?php echo esc_html($total_cards); ?></td>
            </tr>
            <tr>
                <td><strong><?php echo esc_html__('Active Cards:', 'three-card-tarot'); ?></strong></td>
                <td><?php echo esc_html($active_cards); ?></td>
            </tr>
            <tr>
                <td><strong><?php echo esc_html__('Inactive Cards:', 'three-card-tarot'); ?></strong></td>
                <td><?php echo esc_html($total_cards - $active_cards); ?></td>
            </tr>
        </table>
        
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_attr__('Save Settings', 'three-card-tarot'); ?>">
        </p>
    </form>
</div>

<script>
jQuery(document).ready(function($) {
    // Live preview updates
    $('#reading_title').on('input', function() {
        $('#preview-title').text($(this).val() || 'Three Card Tarot Reading');
    });
    
    $('#reading_description').on('input', function() {
        $('#preview-desc').text($(this).val() || 'Select three cards for your tarot reading.');
    });
    
    $('#total_cards_display').on('input', function() {
        var count = parseInt($(this).val()) || 8;
        var maxDisplay = Math.min(count, 6);
        updatePreviewCards(maxDisplay);
    });
    
    function updatePreviewCards(count) {
        var grid = $('.preview-card-grid');
        grid.empty();
        
        for (var i = 0; i < count; i++) {
            grid.append('<div class="preview-card-item"><div class="preview-card-back"></div></div>');
        }
    }
    
    // Initialize preview
    updatePreviewCards(Math.min(<?php echo esc_js($settings['total_cards_display']); ?>, 6));
});
</script> 
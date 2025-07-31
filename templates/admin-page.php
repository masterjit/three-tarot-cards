<?php
/**
 * Admin Page Template
 * Template for the main admin page of the Three Card Tarot plugin
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html__('Three Card Tarot - Manage Cards', 'three-card-tarot'); ?></h1>
    
    <div class="tarot-admin-header">
        <a href="<?php echo admin_url('admin.php?page=three-card-tarot-add'); ?>" class="button button-primary">
            <?php echo esc_html__('Add New Card', 'three-card-tarot'); ?>
        </a>
        <a href="<?php echo admin_url('admin.php?page=three-card-tarot-settings'); ?>" class="button">
            <?php echo esc_html__('Settings', 'three-card-tarot'); ?>
        </a>
    </div>
    
    <div class="tarot-cards-grid">
        <?php if (!empty($cards)) : ?>
            <?php foreach ($cards as $card) : ?>
                <div class="tarot-card-item" data-card-id="<?php echo esc_attr($card->id); ?>">
                    <div class="card-image">
                        <?php if (!empty($card->card_image)) : ?>
                            <img src="<?php echo esc_url($card->card_image); ?>" alt="<?php echo esc_attr($card->card_name); ?>">
                        <?php else : ?>
                            <div class="no-image">
                                <?php echo esc_html__('Image Not Available', 'three-card-tarot'); ?>
                                <br>
                                <small><?php echo esc_html__('Click Edit to add an image', 'three-card-tarot'); ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-details">
                        <h3><?php echo esc_html($card->card_name); ?></h3>
                        <p class="card-position"><?php echo esc_html__('Position:', 'three-card-tarot'); ?> <?php echo esc_html($card->card_position); ?></p>
                        <p class="card-status">
                            <?php if ($card->is_active) : ?>
                                <span class="status-active"><?php echo esc_html__('Active', 'three-card-tarot'); ?></span>
                            <?php else : ?>
                                <span class="status-inactive"><?php echo esc_html__('Inactive', 'three-card-tarot'); ?></span>
                            <?php endif; ?>
                        </p>
                        <div class="card-content-preview">
                            <?php echo wp_trim_words($card->card_content, 20); ?>
                        </div>
                    </div>
                    
                    <div class="card-actions">
                        <button class="button edit-card" data-card-id="<?php echo esc_attr($card->id); ?>">
                            <?php echo esc_html__('Edit', 'three-card-tarot'); ?>
                        </button>
                        <button class="button button-link-delete delete-card" data-card-id="<?php echo esc_attr($card->id); ?>">
                            <?php echo esc_html__('Delete', 'three-card-tarot'); ?>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="no-cards">
                <p><?php echo esc_html__('No cards found. Add your first card!', 'three-card-tarot'); ?></p>
                <a href="<?php echo admin_url('admin.php?page=three-card-tarot-add'); ?>" class="button button-primary">
                    <?php echo esc_html__('Add First Card', 'three-card-tarot'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Edit Card Modal -->
<div id="edit-card-modal" class="tarot-modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2><?php echo esc_html__('Edit Card', 'three-card-tarot'); ?></h2>
        
        <form id="edit-card-form">
            <input type="hidden" id="edit-card-id" name="card_id">
            
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="edit-card-name"><?php echo esc_html__('Card Name', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="edit-card-name" name="card_name" class="regular-text" required>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="edit-card-image"><?php echo esc_html__('Card Image', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="edit-card-image" name="card_image" class="regular-text">
                        <button type="button" class="button upload-image"><?php echo esc_html__('Choose Image', 'three-card-tarot'); ?></button>
                        <div id="edit-image-preview"></div>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="edit-card-content"><?php echo esc_html__('Card Content (Upright)', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <textarea id="edit-card-content" name="card_content" rows="5" class="large-text" required></textarea>
                    </td>
                </tr>
                
                <tr id="edit-reversed-content-row">
                    <th scope="row">
                        <label for="edit-card-content-reversed"><?php echo esc_html__('Card Content (Reversed)', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <textarea id="edit-card-content-reversed" name="card_content_reversed" rows="5" class="large-text"></textarea>
                        <p class="description"><?php echo esc_html__('Enter the interpretation when the card appears reversed (optional)', 'three-card-tarot'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="edit-card-position"><?php echo esc_html__('Position', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <input type="number" id="edit-card-position" name="card_position" class="small-text" min="0">
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="edit-is-active"><?php echo esc_html__('Status', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" id="edit-is-active" name="is_active" value="1">
                            <?php echo esc_html__('Active', 'three-card-tarot'); ?>
                        </label>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <button type="submit" class="button button-primary"><?php echo esc_html__('Update Card', 'three-card-tarot'); ?></button>
                <button type="button" class="button cancel-edit"><?php echo esc_html__('Cancel', 'three-card-tarot'); ?></button>
            </p>
        </form>
    </div>
</div> 
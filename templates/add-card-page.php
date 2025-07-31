<?php
/**
 * Add Card Page Template
 * Template for adding new tarot cards in the WordPress admin
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html__('Add New Tarot Card', 'three-card-tarot'); ?></h1>
    
    <div class="tarot-admin-header">
        <a href="<?php echo admin_url('admin.php?page=three-card-tarot'); ?>" class="button">
            <?php echo esc_html__('← Back to All Cards', 'three-card-tarot'); ?>
        </a>
    </div>
    
    <div class="tarot-form-container">
        <form id="add-card-form" method="post">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="card_name"><?php echo esc_html__('Card Name', 'three-card-tarot'); ?> *</label>
                    </th>
                    <td>
                        <input type="text" id="card_name" name="card_name" class="regular-text" value="<?php echo esc_attr($card['card_name']); ?>" required>
                        <p class="description"><?php echo esc_html__('Enter the name of the tarot card (e.g., "The Fool", "The Magician")', 'three-card-tarot'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="card_image"><?php echo esc_html__('Card Image', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="card_image" name="card_image" class="regular-text" value="<?php echo esc_attr($card['card_image']); ?>">
                        <button type="button" class="button upload-image"><?php echo esc_html__('Choose Image', 'three-card-tarot'); ?></button>
                        <div id="image-preview">
                            <?php if (!empty($card['card_image'])) : ?>
                                <img src="<?php echo esc_url($card['card_image']); ?>" alt="Preview" style="max-width: 200px; max-height: 150px; margin-top: 10px;">
                            <?php endif; ?>
                        </div>
                        <p class="description"><?php echo esc_html__('Upload or select an image for this tarot card', 'three-card-tarot'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="card_content"><?php echo esc_html__('Card Interpretation (Upright)', 'three-card-tarot'); ?> *</label>
                    </th>
                    <td>
                        <?php
                        wp_editor(
                            $card['card_content'],
                            'card_content',
                            array(
                                'textarea_name' => 'card_content',
                                'media_buttons' => false,
                                'textarea_rows' => 8,
                                'teeny' => true,
                                'tinymce' => array(
                                    'toolbar1' => 'bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo',
                                    'toolbar2' => '',
                                    'toolbar3' => ''
                                ),
                                'quicktags' => array(
                                    'buttons' => 'strong,em,link,ul,ol,li,close'
                                )
                            )
                        );
                        ?>
                        <p class="description"><?php echo esc_html__('Enter the interpretation and meaning of this tarot card when upright', 'three-card-tarot'); ?></p>
                    </td>
                </tr>
                
                <tr id="reversed-content-row">
                    <th scope="row">
                        <label for="card_content_reversed"><?php echo esc_html__('Card Interpretation (Reversed)', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <?php
                        wp_editor(
                            $card['card_content_reversed'],
                            'card_content_reversed',
                            array(
                                'textarea_name' => 'card_content_reversed',
                                'media_buttons' => false,
                                'textarea_rows' => 8,
                                'teeny' => true,
                                'tinymce' => array(
                                    'toolbar1' => 'bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo',
                                    'toolbar2' => '',
                                    'toolbar3' => ''
                                ),
                                'quicktags' => array(
                                    'buttons' => 'strong,em,link,ul,ol,li,close'
                                )
                            )
                        );
                        ?>
                        <p class="description"><?php echo esc_html__('Enter the interpretation and meaning of this tarot card when reversed (optional). This will be used when the global "Enable Reversed Cards" setting is turned on.', 'three-card-tarot'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="card_position"><?php echo esc_html__('Position', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <input type="number" id="card_position" name="card_position" class="small-text" value="<?php echo esc_attr($card['card_position']); ?>" min="0">
                        <p class="description"><?php echo esc_html__('Order in which this card appears (0 = auto-assign)', 'three-card-tarot'); ?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="is_active"><?php echo esc_html__('Status', 'three-card-tarot'); ?></label>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" id="is_active" name="is_active" value="1" <?php checked($card['is_active'], 1); ?>>
                            <?php echo esc_html__('Active (card will be available for readings)', 'three-card-tarot'); ?>
                        </label>
                    </td>
                </tr>
            </table>
            
            <p class="submit">
                <button type="submit" class="button button-primary"><?php echo esc_html__('Add Card', 'three-card-tarot'); ?></button>
                <a href="<?php echo admin_url('admin.php?page=three-card-tarot'); ?>" class="button"><?php echo esc_html__('Cancel', 'three-card-tarot'); ?></a>
            </p>
        </form>
    </div>
    
    <!-- Card Preview -->
    <div class="card-preview-section">
        <h3><?php echo esc_html__('Card Preview', 'three-card-tarot'); ?></h3>
        <div class="card-preview" id="card-preview">
            <div class="preview-card">
                <div class="preview-image">
                    <img id="preview-image" src="<?php echo esc_url(plugin_dir_url(__FILE__) . '../../assets/images/card-back.jpg'); ?>" alt="Card Preview">
                </div>
                <div class="preview-details">
                    <h4 id="preview-name"><?php echo esc_html__('Card Name', 'three-card-tarot'); ?></h4>
                    <p id="preview-content"><?php echo esc_html__('Card interpretation will appear here...', 'three-card-tarot'); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Live preview updates
    $('#card_name').on('input', function() {
        $('#preview-name').text($(this).val() || 'Card Name');
    });
    
    // Handle WordPress editor content updates for live preview
    function updatePreviewContent() {
        var content = '';
        if (typeof tinymce !== 'undefined' && tinymce.get('card_content')) {
            content = tinymce.get('card_content').getContent({format: 'text'});
        } else {
            content = $('#card_content').val();
        }
        $('#preview-content').text(content || 'Card interpretation will appear here...');
    }
    
    // Listen for WordPress editor changes
    if (typeof tinymce !== 'undefined') {
        tinymce.on('AddEditor', function(e) {
            if (e.editor.id === 'card_content') {
                e.editor.on('keyup', updatePreviewContent);
                e.editor.on('change', updatePreviewContent);
            }
        });
    }
    
    // Fallback for non-TinyMCE
    $('#card_content').on('input', updatePreviewContent);
    
    $('#card_image').on('input', function() {
        var imageUrl = $(this).val();
        if (imageUrl) {
            $('#preview-image').attr('src', imageUrl);
        }
    });
    
    // Form submission
    $('#add-card-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('action', 'tarot_save_card');
        formData.append('nonce', tarot_ajax.nonce);
        
        $.ajax({
            url: tarot_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(response.data.message || 'Card added successfully!');
                    window.location.href = '<?php echo admin_url('admin.php?page=three-card-tarot'); ?>';
                } else {
                    alert(response.data.message || 'Error adding card');
                }
            },
            error: function() {
                alert('Error adding card');
            }
        });
    });
});
</script> 
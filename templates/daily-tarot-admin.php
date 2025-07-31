<?php
/**
 * Daily Tarot Admin Template
 * Template for managing daily tarot cards in admin
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php echo esc_html__('Daily Tarot Management', 'three-card-tarot'); ?></h1>
    
    <div class="daily-tarot-admin-container">
        <!-- Today's Card Section -->
        <div class="today-card-section">
            <h2><?php echo esc_html__('Today\'s Card', 'three-card-tarot'); ?> - <?php echo esc_html(date('l, F j, Y')); ?></h2>
            
            <?php if ($today_card): ?>
                <div class="today-card-display">
                    <div class="card-image">
                        <?php if (!empty($today_card->card_image)) : ?>
                            <img src="<?php echo esc_url($today_card->card_image); ?>" 
                                 alt="<?php echo esc_attr($today_card->card_name); ?>"
                                 <?php echo ($today_card->daily_orientation === 'reversed') ? 'class="card-image-reversed"' : ''; ?>>
                        <?php else : ?>
                            <div class="no-image">
                                <?php echo esc_html__('Image Not Available', 'three-card-tarot'); ?>
                                <br>
                                <small><?php echo esc_html__('Card image missing', 'three-card-tarot'); ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-info">
                        <h3><?php echo esc_html($today_card->card_name); ?></h3>
                        <p class="orientation">
                            <strong><?php echo esc_html__('Orientation:', 'three-card-tarot'); ?></strong> 
                            <?php echo esc_html(ucfirst($today_card->daily_orientation)); ?>
                        </p>
                        
                        <div class="meaning">
                            <h4><?php echo esc_html__('Today\'s Message:', 'three-card-tarot'); ?></h4>
                            <p>
                                <?php 
                                if ($today_card->daily_orientation === 'reversed') {
                                    echo wp_kses_post($today_card->card_content_reversed);
                                } else {
                                    echo wp_kses_post($today_card->card_content);
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="card-actions">
                    <button type="button" class="button button-primary" id="change-today-card">
                        <?php echo esc_html__('Change Today\'s Card', 'three-card-tarot'); ?>
                    </button>
                    <button type="button" class="button" id="regenerate-card">
                        <?php echo esc_html__('Regenerate Random Card', 'three-card-tarot'); ?>
                    </button>
                </div>
                
            <?php else: ?>
                <div class="no-card-message">
                    <p><?php echo esc_html__('No card selected for today. Please select a card below.', 'three-card-tarot'); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Card Selection Section -->
        <div class="card-selection-section" id="card-selection-section" style="display: none;">
            <h2><?php echo esc_html__('Change Today\'s Card', 'three-card-tarot'); ?></h2>
            
            <div class="card-selection-form">
                <label for="card-select"><?php echo esc_html__('Choose a card:', 'three-card-tarot'); ?></label>
                <select id="card-select" name="card_id">
                    <option value=""><?php echo esc_html__('-- Select a card --', 'three-card-tarot'); ?></option>
                    <?php foreach ($all_cards as $card): ?>
                        <option value="<?php echo esc_attr($card->id); ?>">
                            <?php echo esc_html($card->card_name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <label for="orientation-select"><?php echo esc_html__('Orientation:', 'three-card-tarot'); ?></label>
                <select id="orientation-select" name="orientation">
                    <option value="upright"><?php echo esc_html__('Upright', 'three-card-tarot'); ?></option>
                    <option value="reversed"><?php echo esc_html__('Reversed', 'three-card-tarot'); ?></option>
                </select>
                
                <button type="button" class="button button-primary" id="set-daily-card">
                    <?php echo esc_html__('Set as Today\'s Card', 'three-card-tarot'); ?>
                </button>
                <button type="button" class="button" id="cancel-change">
                    <?php echo esc_html__('Cancel', 'three-card-tarot'); ?>
                </button>
            </div>
        </div>
        
        <!-- History Section -->
        <div class="history-section">
            <h2><?php echo esc_html__('Recent Daily Cards', 'three-card-tarot'); ?></h2>
            
            <?php
            $history = $database->get_daily_card_history(7);
            if ($history): ?>
                <div class="history-cards">
                    <?php foreach ($history as $card): ?>
                        <div class="history-card">
                            <?php if (!empty($card->card_image)) : ?>
                                <img src="<?php echo esc_url($card->card_image); ?>" 
                                     alt="<?php echo esc_attr($card->card_name); ?>"
                                     <?php echo ($card->orientation === 'reversed') ? 'class="card-image-reversed"' : ''; ?>>
                            <?php else : ?>
                                <div class="no-image">
                                    <?php echo esc_html__('No Image', 'three-card-tarot'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="history-info">
                                <h4><?php echo esc_html($card->card_name); ?></h4>
                                <p class="date"><?php echo esc_html(date('M j, Y', strtotime($card->date))); ?></p>
                                <p class="orientation"><?php echo esc_html(ucfirst($card->orientation)); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p><?php echo esc_html__('No history available.', 'three-card-tarot'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Change today's card button
    $('#change-today-card').on('click', function() {
        // Show the card selection section
        $('#card-selection-section').show();
        
        // Pre-select the current card if it exists
        <?php if ($today_card): ?>
        $('#card-select').val('<?php echo esc_js($today_card->id); ?>');
        $('#orientation-select').val('<?php echo esc_js($today_card->daily_orientation); ?>');
        <?php endif; ?>
        
        // Scroll to the selection section
        $('html, body').animate({
            scrollTop: $('#card-selection-section').offset().top - 50
        }, 500);
    });
    
    // Set daily card
    $('#set-daily-card').on('click', function() {
        var cardId = $('#card-select').val();
        var orientation = $('#orientation-select').val();
        
        if (!cardId) {
            alert('<?php echo esc_js(__('Please select a card.', 'three-card-tarot')); ?>');
            return;
        }
        
        $.ajax({
            url: tarot_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_set_daily_card',
                card_id: cardId,
                orientation: orientation,
                nonce: tarot_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.data.message || '<?php echo esc_js(__('Error setting daily card.', 'three-card-tarot')); ?>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('<?php echo esc_js(__('Network error. Please try again.', 'three-card-tarot')); ?>');
            }
        });
    });
    
    // Regenerate random card
    $('#regenerate-card').on('click', function() {
        if (confirm('<?php echo esc_js(__('Are you sure you want to regenerate today\'s card?', 'three-card-tarot')); ?>')) {
            $.ajax({
                url: tarot_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'tarot_regenerate_daily_card',
                    nonce: tarot_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.data.message || '<?php echo esc_js(__('Error regenerating card.', 'three-card-tarot')); ?>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('<?php echo esc_js(__('Network error. Please try again.', 'three-card-tarot')); ?>');
                }
            });
        }
    });
    
    // Cancel change button
    $('#cancel-change').on('click', function() {
        $('#card-selection-section').hide();
    });
});
</script> 
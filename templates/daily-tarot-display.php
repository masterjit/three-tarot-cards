<?php
/**
 * Daily Tarot Display Template
 * Template for displaying the daily tarot card
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('tarot_settings', array());
$title = !empty($atts['title']) ? $atts['title'] : ($settings['daily_tarot_title'] ?? __('Daily Tarot Card', 'three-card-tarot'));
$show_previous = $atts['show_previous'] === 'true';
?>

<div class="daily-tarot-container">
    <div class="daily-tarot-header">
        <h2 class="daily-tarot-title"><?php echo esc_html($title); ?></h2>
    </div>
    
    <?php if ($daily_card): ?>
        <div class="daily-tarot-card">
            <div class="daily-card-image">
                <img src="<?php echo esc_url($daily_card->card_image); ?>" 
                     alt="<?php echo esc_attr($daily_card->card_name); ?>"
                     <?php echo ($daily_card->daily_orientation === 'reversed') ? 'class="card-image-reversed"' : ''; ?>>
            </div>
            
            <div class="daily-card-info">
                <h3 class="daily-card-name">
                    <?php echo esc_html($daily_card->card_name); ?>
                    <?php if ($daily_card->daily_orientation === 'reversed'): ?>
                        <span class="orientation-badge reversed">Reversed</span>
                    <?php else: ?>
                        <span class="orientation-badge upright">Upright</span>
                    <?php endif; ?>
                </h3>
                
                <div class="daily-card-meaning">
                    <h4><?php echo esc_html__('Today\'s Message', 'three-card-tarot'); ?></h4>
                    <p>
                        <?php 
                        if ($daily_card->daily_orientation === 'reversed') {
                            echo wp_kses_post($daily_card->card_content_reversed);
                        } else {
                            echo wp_kses_post($daily_card->card_content);
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        
        <?php if ($show_previous): ?>
            <div class="daily-tarot-history">
                <h4><?php echo esc_html__('Previous Daily Cards', 'three-card-tarot'); ?></h4>
                <?php
                $database = new Tarot_Database();
                $history = $database->get_daily_card_history(7);
                if ($history): ?>
                    <div class="history-cards">
                        <?php foreach ($history as $index => $card): ?>
                            <?php if ($index > 0): // Skip today's card ?>
                                <div class="history-card">
                                    <img src="<?php echo esc_url($card->card_image); ?>" 
                                         alt="<?php echo esc_attr($card->card_name); ?>"
                                         <?php echo ($card->orientation === 'reversed') ? 'class="card-image-reversed"' : ''; ?>>
                                    <p class="history-card-name"><?php echo esc_html($card->card_name); ?></p>
                                    <p class="history-card-date"><?php echo esc_html(date('M j', strtotime($card->date))); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
    <?php else: ?>
        <div class="daily-tarot-error">
            <p><?php echo esc_html__('No daily card available. Please try again later.', 'three-card-tarot'); ?></p>
        </div>
    <?php endif; ?>
</div> 
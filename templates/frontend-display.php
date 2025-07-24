<?php
/**
 * Frontend Display Template
 * Template for the public tarot reading interface
 */

if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('tarot_settings', array());
$title = !empty($atts['title']) ? $atts['title'] : ($settings['reading_title'] ?? __('Three Card Tarot Reading', 'three-card-tarot'));
$description = !empty($atts['description']) ? $atts['description'] : ($settings['reading_description'] ?? __('Select three cards for your tarot reading.', 'three-card-tarot'));
?>

<div class="tarot-reading-container">
    <div class="tarot-header">
        <h2 class="tarot-title"><?php echo esc_html($title); ?></h2>
        <p class="tarot-description"><?php echo esc_html($description); ?></p>
    </div>
    
    <div class="tarot-game-area">
        <!-- Card Selection Area -->
        <div class="tarot-cards-area" id="tarot-cards-area">
            <div class="cards-grid">
                <?php foreach ($cards as $index => $card) : ?>
                    <div class="tarot-card" data-card-id="<?php echo esc_attr($card->id); ?>" data-card-index="<?php echo esc_attr($index); ?>">
                        <div class="card-inner">
                            <div class="card-front">
                                <img src="<?php echo esc_url($card->card_image); ?>" alt="<?php echo esc_attr($card->card_name); ?>">                                
                            </div>
                            <div class="card-back">
                                <img src="<?php echo esc_url($this->get_card_back_image()); ?>" alt="<?php echo esc_attr__('Card Back', 'three-card-tarot'); ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Selection Progress -->
        <div class="selection-progress" id="selection-progress" style="display: none;">
            <div class="progress-text">
                <span id="selected-count">0</span> / 3 <?php echo esc_html__('cards selected', 'three-card-tarot'); ?>
            </div>
            <div class="progress-bar">
                <div class="progress-fill" id="progress-fill"></div>
            </div>
        </div>
        
        <!-- Selected Cards Display -->
        <div class="selected-cards" id="selected-cards" style="display: none;">
            <h3><?php echo esc_html__('Your Selected Cards', 'three-card-tarot'); ?></h3>
            <div class="selected-cards-grid" id="selected-cards-grid"></div>
            <button class="button button-primary" id="get-reading-btn">
                <?php echo esc_html__('Get My Reading', 'three-card-tarot'); ?>
            </button>
        </div>
        
        <!-- Reading Results -->
        <div class="reading-results" id="reading-results" style="display: none;">
            <div class="reading-header">
                <h3><?php echo esc_html__('Your Three Card Reading', 'three-card-tarot'); ?></h3>
                <p class="reading-timestamp" id="reading-timestamp"></p>
            </div>
            
            <div class="reading-cards" id="reading-cards"></div>
            
            <div class="reading-interpretation" id="reading-interpretation"></div>
            
            <div class="reading-actions">
                <button class="button button-primary" id="draw-again-btn">
                    <?php echo esc_html__('Draw Again', 'three-card-tarot'); ?>
                </button>
                <button class="button" id="share-reading-btn">
                    <?php echo esc_html__('Share Reading', 'three-card-tarot'); ?>
                </button>
            </div>
        </div>
        
        <!-- Loading Indicator -->
        <div class="loading-indicator" id="loading-indicator" style="display: none;">
            <div class="spinner"></div>
            <p><?php echo esc_html__('Generating your reading...', 'three-card-tarot'); ?></p>
        </div>
    </div>
    
    <!-- Instructions -->
    <div class="tarot-instructions">
        <h4><?php echo esc_html__('How to Use', 'three-card-tarot'); ?></h4>
        <ol>
            <li><?php echo esc_html__('Click on any card to select it', 'three-card-tarot'); ?></li>
            <li><?php echo esc_html__('Select exactly 3 cards for your reading', 'three-card-tarot'); ?></li>
            <li><?php echo esc_html__('Click "Get My Reading" to see your interpretation', 'three-card-tarot'); ?></li>
            <li><?php echo esc_html__('Click "Draw Again" to start a new reading', 'three-card-tarot'); ?></li>
        </ol>
    </div>
</div>

<!-- Share Modal -->
<div id="share-modal" class="tarot-modal" style="display: none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3><?php echo esc_html__('Share Your Reading', 'three-card-tarot'); ?></h3>
        
        <div class="share-options">
            <button class="button share-facebook">
                <i class="fab fa-facebook"></i> <?php echo esc_html__('Facebook', 'three-card-tarot'); ?>
            </button>
            <button class="button share-email">
                <i class="fas fa-envelope"></i> <?php echo esc_html__('Email', 'three-card-tarot'); ?>
            </button>
        </div>
        
        <div class="share-link">
            <label for="share-url"><?php echo esc_html__('Direct Link:', 'three-card-tarot'); ?></label>
            <input type="text" id="share-url" readonly>
            <button class="button copy-link"><?php echo esc_html__('Copy', 'three-card-tarot'); ?></button>
        </div>
    </div>
</div> 
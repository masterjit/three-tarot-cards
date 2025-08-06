/**
 * Daily Tarot JavaScript for Three Card Tarot Plugin
 */

jQuery(document).ready(function($) {
    
    // Daily tarot functionality
    function initDailyTarot() {
        // Check if daily tarot container exists
        if ($('.daily-tarot-container').length > 0) {
            loadDailyCard();
        }
    }
    
    // Load daily card via AJAX
    function loadDailyCard() {
        var container = $('.daily-tarot-container');
        
        // Show loading state
        container.find('.daily-tarot-loading').show();
        container.find('.daily-tarot-card').hide();
        container.find('.daily-tarot-error').hide();
        
        $.ajax({
            url: tarot_frontend.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_get_daily_card',
                nonce: tarot_frontend.nonce
            },
            success: function(response) {
                if (response.success && response.data.card) {
                    displayDailyCard(response.data.card);
                } else {
                    showDailyCardError(response.data.message || 'No daily card available.');
                }
            },
            error: function() {
                showDailyCardError('Error loading daily card. Please try again.');
            }
        });
    }
    
    // Display daily card
    function displayDailyCard(card) {
        var container = $('.daily-tarot-container');
        
        // Update card image
        container.find('.daily-card-image img').attr('src', card.image).attr('alt', card.name);
        
        // Update card name
        container.find('.daily-card-name').html(
            card.name + 
            '<span class="orientation-badge ' + card.orientation + '">' + 
            (card.orientation === 'reversed' ? 'Reversed' : 'Upright') + 
            '</span>'
        );
        
        // Update card content
        container.find('.daily-card-meaning p').html(card.content);
        
        // Add reversed class to image if needed
        if (card.orientation === 'reversed') {
            container.find('.daily-card-image img').addClass('card-image-reversed');
        } else {
            container.find('.daily-card-image img').removeClass('card-image-reversed');
        }
        
        // Hide loading and show the card
        container.find('.daily-tarot-loading').hide();
        container.find('.daily-tarot-card').show();
        container.find('.daily-tarot-error').hide();
    }
    
    // Show error message
    function showDailyCardError(message) {
        var container = $('.daily-tarot-container');
        container.find('.daily-tarot-error p').text(message);
        container.find('.daily-tarot-loading').hide();
        container.find('.daily-tarot-card').hide();
        container.find('.daily-tarot-error').show();
    }
    
    // Initialize daily tarot on page load
    initDailyTarot();
    
    // Refresh daily card (optional - can be called manually)
    window.refreshDailyCard = function() {
        loadDailyCard();
    };
    
}); 
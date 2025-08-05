/**
 * Frontend JavaScript for Three Card Tarot Plugin
 */

jQuery(document).ready(function($) {
    
    // Game state
    var gameState = {
        selectedCards: [],
        maxCards: 3,
        isReading: false,
        enableReversedCards: tarot_frontend.settings.enable_reversed_cards || false
    };
    
    // Initialize the game
    function initGame() {
        gameState.selectedCards = [];
        gameState.isReading = false;
        
        // Reset UI
        $('.tarot-card').removeClass('selected');
        $('#selection-progress').hide();
        $('#selected-cards').hide();
        $('#reading-results').hide();
        $('#loading-indicator').hide();
        $('#get-reading-btn').hide(); // Hide the button by default
        
        // Clear selected cards grid
        $('#selected-cards-grid').empty();
        
        // Show cards area
        $('#tarot-cards-area').show();
        
        // Ensure all cards show back cover and reset transform
        $('.tarot-card .card-inner').css({
            'transform': 'rotateY(180deg) !important',
            '-webkit-transform': 'rotateY(180deg) !important',
            'transition': 'none !important'
        });
        $('.tarot-card').css('transform', 'none'); // Reset lift effect
        
        // Double-check after a brief delay to ensure back cover is showing
        setTimeout(function() {
            $('.tarot-card .card-inner').css({
                'transform': 'rotateY(180deg) !important',
                '-webkit-transform': 'rotateY(180deg) !important',
                'transition': 'transform 0.6s'
            });
        }, 50);
        
        // Re-enable clicking on all cards
        $('.tarot-card').css('pointer-events', 'auto');
        
        // Update progress
        updateProgress();
    }
    
    // Load initial cards on page load
    function loadInitialCards() {
        fetchNewRandomCards(function() {
            initGame();
            // Adjust card widths after initial load
            setTimeout(function() {
                adjustCardWidths(tarot_frontend.total_cards_display);
            }, 200);
            
            // Force cards to show back cover one more time after everything is loaded
            setTimeout(function() {
                $('.tarot-card .card-inner').css({
                    'transform': 'rotateY(180deg) !important',
                    '-webkit-transform': 'rotateY(180deg) !important'
                });
            }, 300);
        });
    }
    
    // Initialize card events
    bindCardEvents();
    
    // Initialize hover effects
    setupCardHoverEffects();
    
    // Handle window resize to adjust card widths
    $(window).on('resize', function() {
        if ($('.tarot-card').length > 0) {
            adjustCardWidths($('.tarot-card').length);
        }
    });
    
    // Update progress display
    function updateProgress() {
        var count = gameState.selectedCards.length;
        var progress = (count / gameState.maxCards) * 100;
        
        $('#selected-count').text(count);
        $('#progress-fill').css('width', progress + '%');
        
        if (count > 0) {
            $('#selection-progress').show();
        } else {
            $('#selection-progress').hide();
        }
        
        // Show/hide "Get Reading" button based on card count
        if (count === gameState.maxCards) {
            $('#get-reading-btn').show();
        } else {
            $('#get-reading-btn').hide();
        }
    }
    

    
    // Add a single card to the selected cards summary
    function addCardToSummary(cardId, orientation, cardNumber) {
        var cardElement = $('.tarot-card[data-card-id="' + cardId + '"]');
        var cardName = cardElement.find('.card-front img').attr('alt');
        var cardImage = cardElement.find('.card-front img').attr('src');
        var orientationText = orientation === 'reversed' ? ' (Reversed)' : '';
        

        
        var selectedCard = $('<div class="selected-card" data-card-id="' + cardId + '">' +
            '<img src="' + cardImage + '" alt="' + cardName + '"' + (orientation === 'reversed' ? ' class="card-image-reversed"' : '') + '>' +
            '<h4>' + cardName + orientationText + '</h4>' +
            '<p>Card ' + cardNumber + '</p>' +
            '</div>');
        
        $('#selected-cards-grid').append(selectedCard);
    }
    
    // Show selected cards at the bottom
    function showSelectedCards() {
        var selectedCardsGrid = $('#selected-cards-grid');
        selectedCardsGrid.empty();
        
        // Get selected card data
        gameState.selectedCards.forEach(function(cardData, index) {
            var cardElement = $('.tarot-card[data-card-id="' + cardData.id + '"]');
            var cardName = cardElement.find('.card-front img').attr('alt');
            var cardImage = cardElement.find('.card-front img').attr('src');
            var orientationText = cardData.orientation === 'reversed' ? ' (Reversed)' : '';
            
            var selectedCard = $('<div class="selected-card">' +
                '<img src="' + cardImage + '" alt="' + cardName + '"' + (cardData.orientation === 'reversed' ? ' class="card-image-reversed"' : '') + '>' +
                '<h4>' + cardName + orientationText + '</h4>' +
                '<p>Card ' + (index + 1) + '</p>' +
                '</div>');
            
            selectedCardsGrid.append(selectedCard);
        });
        
        // Show selected cards section at the bottom
        $('#selected-cards').show();
        // Don't hide the cards area - keep it visible so selected cards appear below
    }
    
    // Handle get reading button
    $('#get-reading-btn').on('click', function(e) {
        // Prevent default behavior to avoid page scrolling
        e.preventDefault();
        e.stopPropagation();
        
        // Show loading
        $('#loading-indicator').show();
        $('#selected-cards').hide();
        
        // Update loading message
        $('#loading-indicator p').text('Preparing your reading...');
        
        // Prepare card data with orientations
        var cardData = gameState.selectedCards.map(function(card) {
            return {
                id: card.id,
                orientation: card.orientation
            };
        });
        
        // Get reading via AJAX
        $.ajax({
            url: tarot_frontend.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_get_reading',
                card_data: cardData,
                nonce: tarot_frontend.nonce
            },
            success: function(response) {
                if (response.success) {
                    displayReading(response.data);
                } else {
                    alert(response.data.message || 'Error getting reading');
                    $('#loading-indicator').hide();
                    $('#selected-cards').show();
                }
            },
            error: function() {
                alert(tarot_frontend.strings.error || 'An error occurred');
                $('#loading-indicator').hide();
                $('#selected-cards').show();
            }
        });
    });
    
    // Display reading results
    function displayReading(reading) {
        gameState.isReading = true;
        
        // Hide loading
        $('#loading-indicator').hide();
        
        // Display reading cards
        var readingCards = $('#reading-cards');
        readingCards.empty();
        
        reading.cards.forEach(function(card, index) {
            var orientationText = card.orientation === 'reversed' ? ' (Reversed)' : '';
            var readingCard = $('<div class="reading-card">' +
                '<img src="' + card.card_image + '" alt="' + card.card_name + '"' + (card.orientation === 'reversed' ? ' class="card-image-reversed"' : '') + '>' +
                '<h4>' + card.card_name + orientationText + '</h4>' +
                '<p>Card ' + (index + 1) + '</p>' +
                '</div>');
            
            readingCards.append(readingCard);
        });
        
        // Display interpretation
        $('#reading-interpretation').html(reading.interpretation);
        
        // Display timestamp
        var timestamp = new Date(reading.timestamp * 1000);
        $('#reading-timestamp').text('Reading on ' + timestamp.toLocaleDateString() + ' at ' + timestamp.toLocaleTimeString());
        
        // Show results
        $('#reading-results').show();
        
        // Scroll to reading results with smooth animation
        $('html, body').animate({
            scrollTop: $('#reading-results').offset().top - 50
        }, 800);
        

    }
    
    // Handle draw again button
    $('#draw-again-btn').on('click', function(e) {
        // Prevent default behavior to avoid page scrolling
        e.preventDefault();
        e.stopPropagation();
        
        var button = $(this);
        var originalText = button.text();
        
        // Disable button and show shuffling text
        button.prop('disabled', true).text('Shuffling...');
        
        // Scroll to top of tarot section with smooth animation
        $('html, body').animate({
            scrollTop: $('.tarot-reading-container').offset().top - 50
        }, 800);
        
        // First shuffle the cards with animation
        shuffleCardsWithAnimation();
        
        // Then fetch new random cards and reset the game after shuffle animation completes
        setTimeout(function() {
            fetchNewRandomCards(function() {
                initGame();
                // Re-enable button and restore original text
                button.prop('disabled', false).text(originalText);
            });
        }, 1000); // Wait for shuffle animation to complete
    });
    
    // Function to fetch new random cards from server
    function fetchNewRandomCards(callback) {
        $.ajax({
            url: tarot_frontend.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_get_random_cards',
                nonce: tarot_frontend.nonce
            },
            success: function(response) {
                if (response.success && response.data.cards) {
                    updateCardsDisplay(response.data.cards);
                    if (callback) callback();
                } else {
                    console.error('Failed to fetch new cards:', response.data);
                    if (callback) callback();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching new cards:', error);
                if (callback) callback();
            }
        });
    }
    
    // Function to update cards display with new cards
    function updateCardsDisplay(cards) {
        var cardsGrid = $('#cards-grid');
        cardsGrid.empty();
        
        cards.forEach(function(card, index) {
            // All cards start as upright by default (no orientation class needed)
            var cardHtml = '<div class="tarot-card" data-card-id="' + card.id + '" data-card-index="' + index + '" data-orientation="upright" style="opacity: 0;">' +
                '<div class="card-inner" style="transform: rotateY(180deg) !important; transition: none !important;">' +
                '<div class="card-front">' +
                '<img src="' + card.image + '" alt="' + card.name + '">' +
                '</div>' +
                '<div class="card-back">' +
                '<img src="' + tarot_frontend.card_back_image + '" alt="Card Back" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.style.display=\'none\'; this.parentElement.style.background=\'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)\';">' +
                '</div>' +
                '</div>' +
                '</div>';
            
            cardsGrid.append(cardHtml);
        });
        
        // Adjust card widths based on number of cards
        adjustCardWidths(cards.length);
        
        // Force cards to show back cover immediately and after rendering
        $('.tarot-card .card-inner').css({
            'transform': 'rotateY(180deg) !important',
            '-webkit-transform': 'rotateY(180deg) !important',
            'transition': 'none !important'
        });
        
        // Double-check after a brief delay to ensure back cover is showing
        setTimeout(function() {
            $('.tarot-card .card-inner').css({
                'transform': 'rotateY(180deg) !important',
                '-webkit-transform': 'rotateY(180deg) !important',
                'transition': 'transform 0.6s'
            });
            
            // Fade in the cards after they're properly positioned
            $('.tarot-card').css({
                'opacity': '1',
                'transition': 'opacity 0.3s ease-in-out'
            });
        }, 50);
        
        // Re-bind click events to new cards
        bindCardEvents();
        
        // Re-setup hover effects for new cards
        setupCardHoverEffects();
    }
    
    // Function to adjust card widths based on number of cards
    function adjustCardWidths(cardCount) {
        var containerWidth = $('#cards-grid').width();
        var maxCardWidth = 192; // Original card width
        var minCardWidth = 80; // Minimum card width
        var overlap = 30; // Overlap amount
        
        // Responsive adjustments
        if (window.innerWidth <= 480) {
            maxCardWidth = 110;
            minCardWidth = 60;
            overlap = 15;
        } else if (window.innerWidth <= 768) {
            maxCardWidth = 140;
            minCardWidth = 70;
            overlap = 20;
        }
        
        // Calculate available width (container width minus padding)
        var availableWidth = containerWidth - 40; // 20px padding on each side
        
        // Calculate optimal card width
        var optimalWidth = Math.max(minCardWidth, Math.min(maxCardWidth, (availableWidth + (cardCount - 1) * overlap) / cardCount));
        
        // Apply width to all cards and set z-index
        $('.tarot-card').each(function(index) {
            var card = $(this);
            var isSelected = card.hasClass('selected');
            var currentTransform = isSelected ? 'translateY(-15px)' : 'none';
            
            card.css({
                'width': optimalWidth + 'px',
                'height': (optimalWidth * 1.73) + 'px', // Maintain aspect ratio
                'z-index': cardCount - index, // First card gets highest z-index
                'transform': currentTransform // Preserve lift effect for selected cards
            });
        });
        
        // Update card-inner height
        $('.card-inner').css('height', (optimalWidth * 1.73) + 'px');
    }
    
    // Function to bind card click events
    function bindCardEvents() {
        $('.tarot-card').off('click').on('click', function() {
            if (gameState.isReading) return;
            
            var card = $(this);
            var cardId = card.data('card-id');
            var orientation = card.data('orientation');
            
            // Check if card is already selected
            if (card.hasClass('selected')) {
                // Deselect card - flip back to show back cover and remove lift
                card.removeClass('selected hover'); // Also remove hover class
                card.find('.card-inner').css('transform', 'rotateY(180deg) !important');
                card.css('transform', 'none'); // Remove lift effect
                
                // Remove card from game state
                gameState.selectedCards = gameState.selectedCards.filter(function(cardData) {
                    return cardData.id !== cardId;
                });
                
                // Remove card from summary
                $('.selected-card[data-card-id="' + cardId + '"]').remove();
                
                // Hide selected cards section if no cards are selected
                if (gameState.selectedCards.length === 0) {
                    $('#selected-cards').hide();
                }
                
                // Re-enable clicking on all cards since we now have less than 3 selected
                $('.tarot-card').css('pointer-events', 'auto');
            } else {
                // Check if we can select more cards
                if (gameState.selectedCards.length >= gameState.maxCards) {
                    alert(tarot_frontend.strings.select_card || 'You can only select 3 cards');
                    return;
                }
                
                // Select card and immediately flip to show upright/reversed
                card.addClass('selected').removeClass('hover'); // Remove hover when selected
                
                // Apply lift effect
                card.css('transform', 'translateY(-15px)');
                
                // Determine if this card should be reversed (only if reversed feature is enabled)
                var shouldBeReversed = gameState.enableReversedCards && Math.random() < 0.5;
                var newOrientation = shouldBeReversed ? 'reversed' : 'upright';
                
                // Store orientation in game state (no visual change to initial cards)
                card.attr('data-orientation', newOrientation);
                
                // Flip card to show front (without orientation indicators)
                card.find('.card-inner').css({
                    'transform': 'rotateY(0deg) !important',
                    'transition': 'transform 0.6s ease-in-out'
                });
                
                // Store orientation in game state
                gameState.selectedCards.push({
                    id: cardId,
                    orientation: newOrientation
                });
                
                // Add card to selected cards summary immediately
                addCardToSummary(cardId, newOrientation, gameState.selectedCards.length);
            }
            
            // Update progress
            updateProgress();
            
            // Show selected cards section if this is the first card
            if (gameState.selectedCards.length === 1) {
                $('#selected-cards').show();
            }
            
            // Check if we have enough cards
            if (gameState.selectedCards.length === gameState.maxCards) {
                // All cards selected - disable clicking on all cards
                $('.tarot-card').css('pointer-events', 'none');
            }
        });
    }
    
    // Enhanced shuffle function with animation
    function shuffleCardsWithAnimation() {
        var cards = $('.tarot-card');
        var cardArray = cards.toArray();
        
        // Add shuffle animation class
        cards.addClass('shuffling');
        
        // Fisher-Yates shuffle
        for (var i = cardArray.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = cardArray[i];
            cardArray[i] = cardArray[j];
            cardArray[j] = temp;
        }
        
        // Animate cards to new positions with staggered timing
        cards.each(function(index) {
            var card = $(this);
            setTimeout(function() {
                card.css({
                    'order': index,
                    'transform': 'rotateY(180deg) scale(0.9)',
                    'transition': 'all 0.3s ease-in-out'
                });
            }, index * 50); // Stagger the animation
        });
        
        // After shuffle animation, flip cards back and remove animation classes
        setTimeout(function() {
            cards.each(function(index) {
                var card = $(this);
                card.css({
                    'transform': 'rotateY(0deg) scale(1)',
                    'transition': 'all 0.3s ease-in-out'
                });
            });
            
            // Remove animation classes after animation completes
            setTimeout(function() {
                cards.removeClass('shuffling').css({
                    'animation': '',
                    'transition': ''
                });
            }, 300);
        }, 500);
    }
    
    // Handle share reading button
    $('#share-reading-btn').on('click', function() {
        showShareModal();
    });
    
    // Show share modal
    function showShareModal() {
        var modal = $('#share-modal');
        var shareUrl = window.location.href;
        
        $('#share-url').val(shareUrl);
        modal.show();
    }
    
    // Handle share modal close
    $('.close').on('click', function() {
        $('#share-modal').hide();
    });
    
    // Close modal when clicking outside
    $(window).on('click', function(e) {
        var modal = $('#share-modal');
        if (e.target === modal[0]) {
            modal.hide();
        }
    });
    
    // Handle share buttons
    $('.share-facebook').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var url = encodeURIComponent(window.location.href);
        var text = encodeURIComponent('Check out my tarot reading!');
        window.open('https://www.facebook.com/sharer/sharer.php?u=' + url, '_blank');
    });
    
    $('.share-twitter').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var url = encodeURIComponent(window.location.href);
        var text = encodeURIComponent('Check out my tarot reading!');
        window.open('https://twitter.com/intent/tweet?text=' + text + '&url=' + url, '_blank');
    });
    
    $('.share-email').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var subject = encodeURIComponent('My Tarot Reading');
        var body = encodeURIComponent('Check out my tarot reading: ' + window.location.href);
        window.open('mailto:?subject=' + subject + '&body=' + body);
    });
    
    // Handle copy link button
    $('.copy-link').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var shareUrl = $('#share-url');
        shareUrl.select();
        document.execCommand('copy');
        
        // Show feedback
        var button = $(this);
        var originalText = button.text();
        button.text('Copied!');
        
        setTimeout(function() {
            button.text(originalText);
        }, 2000);
    });
    
    // Handle keyboard shortcuts
    $(document).on('keydown', function(e) {
        // ESC to close modals
        if (e.keyCode === 27) {
            $('#share-modal').hide();
        }
        
        // Enter to get reading when cards are selected
        if (e.keyCode === 13 && gameState.selectedCards.length === gameState.maxCards && !gameState.isReading) {
            $('#get-reading-btn').click();
        }
    });
    
    // Enhanced hover and touch effects for both desktop and mobile
    function setupCardHoverEffects() {
        var isMobile = 'ontouchstart' in window || window.innerWidth <= 768;
        
        if (isMobile) {
            // Mobile: Use touch events for hover effect
            $('.tarot-card').off('touchstart touchend').on('touchstart', function(e) {
                e.preventDefault();
                var card = $(this);
                if (!card.hasClass('selected')) {
                    card.addClass('hover');
                }
            }).on('touchend', function(e) {
                e.preventDefault();
                var card = $(this);
                card.removeClass('hover');
                // Trigger click after a brief delay to allow hover effect to be seen
                setTimeout(function() {
                    card.trigger('click');
                }, 150);
            });
        } else {
            // Desktop: Use mouse events for hover effect
            $('.tarot-card').off('mouseenter mouseleave').on('mouseenter', function() {
                if (!$(this).hasClass('selected')) {
                    $(this).addClass('hover');
                }
            }).on('mouseleave', function() {
                $(this).removeClass('hover');
            });
        }
    }
    
    // Initialize hover effects
    setupCardHoverEffects();
    
    // Add sound effects (if enabled)
    function playSound(soundType) {
        // This would be implemented if sound is enabled
        // var audio = new Audio(tarot_frontend.sounds[soundType]);
        // audio.play();
    }
    
    // Handle responsive design
    function handleResponsive() {
        var windowWidth = $(window).width();
        
        if (windowWidth < 768) {
            $('.cards-grid').addClass('mobile');
            $('.selected-cards-grid').addClass('mobile');
            $('.reading-cards').addClass('mobile');
        } else {
            $('.cards-grid').removeClass('mobile');
            $('.selected-cards-grid').removeClass('mobile');
            $('.reading-cards').removeClass('mobile');
        }
        
        // Re-setup hover effects when screen size changes
        setupCardHoverEffects();
    }
    
    // Call on load and resize
    handleResponsive();
    $(window).on('resize', handleResponsive);
    
    // Add card shuffle animation
    function shuffleCards() {
        var cards = $('.tarot-card');
        var cardArray = cards.toArray();
        
        // Fisher-Yates shuffle
        for (var i = cardArray.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = cardArray[i];
            cardArray[i] = cardArray[j];
            cardArray[j] = temp;
        }
        
        // Animate cards to new positions
        cards.each(function(index) {
            $(this).css({
                'order': index,
                'animation': 'shuffle 0.5s ease-in-out'
            });
        });
        
        // Remove animation class after animation completes
        setTimeout(function() {
            cards.css('animation', '');
        }, 500);
    }
    
    // Check if reversed cards are enabled
    if (tarot_frontend.settings && tarot_frontend.settings.enable_reversed_cards) {
        gameState.enableReversedCards = true;
    }
    
    // Load initial cards and initialize game on page load
    loadInitialCards();
    
    // Add shuffle button functionality (if needed)
    $('.shuffle-cards').on('click', function() {
        shuffleCards();
    });
    
    // Re-setup hover effects after cards are updated
    setupCardHoverEffects();
    
    // Add loading animation for card images
    $('.tarot-card img').on('load', function() {
        $(this).addClass('loaded');
    }).on('error', function() {
        $(this).attr('src', tarot_frontend.default_card_image || '');
    });
    
    // Handle form submission for custom readings
    $('#custom-reading-form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('action', 'tarot_custom_reading');
        formData.append('nonce', tarot_frontend.nonce);
        
        $.ajax({
            url: tarot_frontend.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    displayReading(response.data);
                } else {
                    alert(response.data.message || 'Error creating custom reading');
                }
            }
        });
    });
    
    // Add accessibility features
    $('.tarot-card').attr('tabindex', '0').on('keydown', function(e) {
        if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
            e.preventDefault();
            $(this).trigger('click');
        }
    });
    
    // Add ARIA labels for accessibility
    $('.tarot-card').each(function(index) {
        $(this).attr('aria-label', 'Select card ' + (index + 1));
    });
    
    // Handle high contrast mode
    if (window.matchMedia && window.matchMedia('(prefers-contrast: high)').matches) {
        $('body').addClass('high-contrast');
    }
    
    // Handle reduced motion preferences
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        $('body').addClass('reduced-motion');
    }
}); 
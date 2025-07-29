/**
 * Frontend JavaScript for Three Card Tarot Plugin
 */

jQuery(document).ready(function($) {
    
    // Game state
    var gameState = {
        selectedCards: [],
        maxCards: 3,
        isReading: false
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
        
        // Show cards area
        $('#tarot-cards-area').show();
        
        // Update progress
        updateProgress();
    }
    
    // Load initial cards on page load
    function loadInitialCards() {
        fetchNewRandomCards(function() {
            initGame();
        });
    }
    
    // Initialize card events
    bindCardEvents();
    
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
    }
    
    // Show selected cards
    function showSelectedCards() {
        var selectedCardsGrid = $('#selected-cards-grid');
        selectedCardsGrid.empty();
        
        // Get selected card data
        gameState.selectedCards.forEach(function(cardId, index) {
            var cardElement = $('.tarot-card[data-card-id="' + cardId + '"]');
            var cardName = cardElement.find('.card-name').text();
            var cardImage = cardElement.find('.card-front img').attr('src');
            
            var selectedCard = $('<div class="selected-card">' +
                '<img src="' + cardImage + '" alt="' + cardName + '">' +
                '<h4>' + cardName + '</h4>' +
                '<p>Card ' + (index + 1) + '</p>' +
                '</div>');
            
            selectedCardsGrid.append(selectedCard);
        });
        
        // Show selected cards section
        $('#selected-cards').show();
        $('#tarot-cards-area').hide();
    }
    
    // Handle get reading button
    $('#get-reading-btn').on('click', function(e) {
        // Prevent default behavior to avoid page scrolling
        e.preventDefault();
        e.stopPropagation();
        
        if (gameState.selectedCards.length !== gameState.maxCards) {
            alert('Please select exactly 3 cards');
            return;
        }
        
        // Show loading
        $('#loading-indicator').show();
        $('#selected-cards').hide();
        
        // Get reading via AJAX
        $.ajax({
            url: tarot_frontend.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_get_reading',
                card_ids: gameState.selectedCards,
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
            var readingCard = $('<div class="reading-card">' +
                '<img src="' + card.card_image + '" alt="' + card.card_name + '">' +
                '<h4>' + card.card_name + '</h4>' +
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
        }, 500);
        
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
            var cardHtml = '<div class="tarot-card" data-card-id="' + card.id + '" data-card-index="' + index + '">' +
                '<div class="card-inner">' +
                '<div class="card-front">' +
                '<img src="' + card.image + '" alt="' + card.name + '">' +
                '</div>' +
                '<div class="card-back">' +
                '<img src="' + tarot_frontend.card_back_image + '" alt="Card Back">' +
                '</div>' +
                '</div>' +
                '</div>';
            
            cardsGrid.append(cardHtml);
        });
        
        // Re-bind click events to new cards
        bindCardEvents();
    }
    
    // Function to bind card click events
    function bindCardEvents() {
        $('.tarot-card').off('click').on('click', function() {
            if (gameState.isReading) return;
            
            var card = $(this);
            var cardId = card.data('card-id');
            
            // Check if card is already selected
            if (card.hasClass('selected')) {
                // Deselect card
                card.removeClass('selected');
                gameState.selectedCards = gameState.selectedCards.filter(function(id) {
                    return id !== cardId;
                });
            } else {
                // Check if we can select more cards
                if (gameState.selectedCards.length >= gameState.maxCards) {
                    alert(tarot_frontend.strings.select_card || 'You can only select 3 cards');
                    return;
                }
                
                // Select card
                card.addClass('selected');
                gameState.selectedCards.push(cardId);
            }
            
            // Update progress
            updateProgress();
            
            // Check if we have enough cards
            if (gameState.selectedCards.length === gameState.maxCards) {
                showSelectedCards();
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
    
    // Add card flip animation
    $('.tarot-card').on('mouseenter', function() {
        if (!$(this).hasClass('selected')) {
            $(this).addClass('hover');
        }
    }).on('mouseleave', function() {
        $(this).removeClass('hover');
    });
    
    // Handle touch events for mobile
    if ('ontouchstart' in window) {
        $('.tarot-card').on('touchstart', function(e) {
            e.preventDefault();
            $(this).trigger('click');
        });
    }
    
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
    
    // Load initial cards and initialize game on page load
    loadInitialCards();
    
    // Add shuffle button functionality (if needed)
    $('.shuffle-cards').on('click', function() {
        shuffleCards();
    });
    
    // Handle card hover effects
    $('.tarot-card').on('mouseenter', function() {
        if (!$(this).hasClass('selected')) {
            $(this).addClass('card-hover');
        }
    }).on('mouseleave', function() {
        $(this).removeClass('card-hover');
    });
    
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
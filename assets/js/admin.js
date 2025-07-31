/**
 * Admin JavaScript for Three Card Tarot Plugin
 */

jQuery(document).ready(function($) {
    
    // Check if tarot_ajax object exists
    if (typeof tarot_ajax === 'undefined') {
        console.error('tarot_ajax object not found');
        return;
    }
    
    // Prevent conflicts with other plugins by ensuring our elements exist
    if ($('.daily-tarot-admin-container').length > 0) {
        // We're on the daily tarot page, ensure our dropdowns work properly
        $('#card-select, #orientation-select').on('click', function(e) {
            // Prevent event bubbling that might interfere with other plugins
            e.stopPropagation();
        });
    }
    
    // Initialize media uploader
    var mediaUploader;
    
    // Show reversed content fields (they're optional and useful even when global setting is disabled)
    function showReversedContentFields() {
        $('#reversed-content-row').show();
        $('#edit-reversed-content-row').show();
    }
    
    // Initialize reversed content field visibility
    showReversedContentFields();
    
    // Handle image upload button clicks
    $('.upload-image').on('click', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var imageInput = button.siblings('input[type="text"]');
        var imagePreview = button.siblings('div');
        
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        // Create the media uploader
        mediaUploader = wp.media({
            title: tarot_ajax.strings.select_image || 'Select Image',
            button: {
                text: tarot_ajax.strings.use_image || 'Use this image'
            },
            multiple: false
        });
        
        // When an image is selected, run a callback
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            imageInput.val(attachment.url);
            
            // Update preview
            imagePreview.html('<img src="' + attachment.url + '" alt="Preview">');
        });
        
        // Open the uploader dialog
        mediaUploader.open();
    });
    
    // Handle edit card button clicks
    $('.edit-card').on('click', function(e) {
        e.preventDefault();
        
        var cardId = $(this).data('card-id');
        var modal = $('#edit-card-modal');
        
        // Check if modal exists
        if (!modal.length) {
            console.error('Edit modal not found');
            return;
        }
        
        // Show loading state
        $(this).addClass('loading');
        
        // Get card data via AJAX
        $.ajax({
            url: tarot_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_get_card',
                card_id: cardId,
                nonce: tarot_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    var card = response.data;
                    
                    // Populate form fields
                    $('#edit-card-id').val(card.id);
                    $('#edit-card-name').val(card.card_name);
                    $('#edit-card-image').val(card.card_image);
                    
                    // Set content in WordPress editors
                    if (typeof tinymce !== 'undefined') {
                        if (tinymce.get('edit-card-content')) {
                            tinymce.get('edit-card-content').setContent(card.card_content || '');
                        }
                        if (tinymce.get('edit-card-content-reversed')) {
                            tinymce.get('edit-card-content-reversed').setContent(card.card_content_reversed || '');
                        }
                    } else {
                        // Fallback for non-TinyMCE
                        $('#edit-card-content').val(card.card_content);
                        $('#edit-card-content-reversed').val(card.card_content_reversed || '');
                    }
                    
                    $('#edit-card-position').val(card.card_position);
                    $('#edit-is-active').prop('checked', card.is_active == 1);
                    
                    // Update image preview
                    if (card.card_image) {
                        $('#edit-image-preview').html('<img src="' + card.card_image + '" alt="Preview">');
                    } else {
                        $('#edit-image-preview').empty();
                    }
                    
                    // Show modal
                    modal.show();
                    
                    // Ensure WordPress editors are properly initialized
                    if (typeof tinymce !== 'undefined') {
                        // Trigger editor initialization if needed
                        setTimeout(function() {
                            if (tinymce.get('edit-card-content')) {
                                tinymce.get('edit-card-content').focus();
                            }
                        }, 100);
                    }
                } else {
                    alert(response.data.message || 'Error loading card data');
                }
            },
            error: function() {
                alert('Error loading card data');
            },
            complete: function() {
                $('.edit-card[data-card-id="' + cardId + '"]').removeClass('loading');
            }
        });
    });
    
    // Handle delete card button clicks
    $('.delete-card').on('click', function(e) {
        e.preventDefault();
        
        var cardId = $(this).data('card-id');
        var cardItem = $(this).closest('.tarot-card-item');
        
        // Check if card item exists
        if (!cardItem.length) {
            console.error('Card item not found');
            return;
        }
        
        if (!confirm(tarot_ajax.strings.confirm_delete || 'Are you sure you want to delete this card?')) {
            return;
        }
        
        // Show loading state
        $(this).addClass('loading');
        
        // Delete card via AJAX
        $.ajax({
            url: tarot_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'tarot_delete_card',
                card_id: cardId,
                nonce: tarot_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Remove card from DOM
                    cardItem.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Check if no cards left
                        if ($('.tarot-card-item').length === 0) {
                            location.reload();
                        }
                    });
                    
                    // Show success message
                    showNotice(response.data.message || 'Card deleted successfully!', 'success');
                } else {
                    alert(response.data.message || 'Error deleting card');
                }
            },
            error: function() {
                alert('Error deleting card');
            },
            complete: function() {
                $('.delete-card[data-card-id="' + cardId + '"]').removeClass('loading');
            }
        });
    });
    
    // Handle edit card form submission
    $('#edit-card-form').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var submitButton = form.find('button[type="submit"]');
        
        // Check if form and submit button exist
        if (!form.length || !submitButton.length) {
            console.error('Edit form or submit button not found');
            return;
        }
        
        var originalText = submitButton.text();
        
        // Show loading state
        submitButton.text(tarot_ajax.strings.saving || 'Saving...').prop('disabled', true);
        
        // Get form data
        var formData = new FormData(this);
        formData.append('action', 'tarot_save_card');
        formData.append('nonce', tarot_ajax.nonce);
        
        // Submit form via AJAX
        $.ajax({
            url: tarot_ajax.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showNotice(response.data.message || 'Card saved successfully!', 'success');
                    
                    // Close modal
                    $('#edit-card-modal').hide();
                    
                    // Reload page to show updated data
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    alert(response.data.message || 'Error saving card');
                }
            },
            error: function() {
                alert('Error saving card');
            },
            complete: function() {
                submitButton.text(originalText).prop('disabled', false);
            }
        });
    });
    
    // Handle modal close
    $('.close, .cancel-edit').on('click', function() {
        $('#edit-card-modal').hide();
    });
    
    // Close modal when clicking outside
    $(window).on('click', function(e) {
        var modal = $('#edit-card-modal');
        if (e.target === modal[0]) {
            modal.hide();
        }
    });
    
    // Handle image preview update
    $('#edit-card-image').on('input', function() {
        var imageUrl = $(this).val();
        var preview = $('#edit-image-preview');
        
        if (imageUrl) {
            preview.html('<img src="' + imageUrl + '" alt="Preview">');
        } else {
            preview.empty();
        }
    });
    
    // Show notice function
    function showNotice(message, type) {
        var noticeClass = 'tarot-notice ' + (type || 'success');
        var notice = $('<div class="' + noticeClass + '">' + message + '</div>');
        
        $('.wrap h1').after(notice);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            notice.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Handle form validation
    $('#edit-card-form input[required], #edit-card-form textarea[required]').on('blur', function() {
        var field = $(this);
        var value = field.val().trim();
        
        if (!value) {
            field.addClass('error');
        } else {
            field.removeClass('error');
        }
    });
    
    // Remove error class on input
    $('#edit-card-form input, #edit-card-form textarea').on('input', function() {
        $(this).removeClass('error');
    });
    
    // Handle keyboard shortcuts
    $(document).on('keydown', function(e) {
        // ESC to close modal
        if (e.keyCode === 27) {
            $('#edit-card-modal').hide();
        }
    });
    
    // Initialize tooltips (commented out - requires jQuery UI)
    // $('[title]').tooltip();
    
    // Handle responsive design
    function handleResponsive() {
        var windowWidth = $(window).width();
        
        if (windowWidth < 768) {
            $('.tarot-cards-grid').addClass('mobile');
        } else {
            $('.tarot-cards-grid').removeClass('mobile');
        }
    }
    
    // Call on load and resize
    handleResponsive();
    $(window).on('resize', handleResponsive);
    
    // Handle card sorting (if implemented)
    // Note: Requires jQuery UI sortable plugin
    /*
    if ($.fn.sortable) {
        $('.tarot-cards-grid').sortable({
            handle: '.card-details',
            update: function(event, ui) {
                // Update card positions via AJAX
                var positions = [];
                $('.tarot-card-item').each(function(index) {
                    positions.push({
                        id: $(this).data('card-id'),
                        position: index + 1
                    });
                });
                
                // Send positions to server
                $.ajax({
                    url: tarot_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'tarot_update_positions',
                        positions: positions,
                        nonce: tarot_ajax.nonce
                    }
                });
            }
        });
    }
    */
    
    // Handle bulk actions
    $('.bulk-action-selector').on('change', function() {
        var action = $(this).val();
        var selectedCards = $('.card-checkbox:checked');
        
        if (action && selectedCards.length > 0) {
            if (confirm('Are you sure you want to perform this action on ' + selectedCards.length + ' cards?')) {
                // Perform bulk action
                var cardIds = [];
                selectedCards.each(function() {
                    cardIds.push($(this).val());
                });
                
                $.ajax({
                    url: tarot_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'tarot_bulk_action',
                        bulk_action: action,
                        card_ids: cardIds,
                        nonce: tarot_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.data.message || 'Error performing bulk action');
                        }
                    }
                });
            }
        }
    });
}); 
# Three Card Tarot Plugin - User Guide

## 🚀 Quick Start Guide

### Step 1: Install and Activate
1. Upload the plugin files to `/wp-content/plugins/tarot-three-card/`
2. Go to **WordPress Admin → Plugins**
3. Find "Three Card Tarot" and click **"Activate"**
4. The plugin will automatically create the database table and insert default cards

### Step 2: Test the Admin Interface
1. Go to **WordPress Admin → Tarot Cards**
2. You should see the main dashboard with 8 default cards
3. Test the following features:
   - **View Cards**: See all cards in a grid layout
   - **Edit Card**: Click "Edit" on any card to modify it
   - **Add New Card**: Click "Add New Card" to create a new card
   - **Settings**: Click "Settings" to configure the plugin

### Step 3: Test the Frontend
1. Create a new page or post
2. Add the shortcode: `[ac_three_tarot_card_reading]`
3. Publish the page and visit it
4. Test the card selection and reading generation

## 📋 Complete Testing Checklist

### ✅ Admin Interface Testing

#### 1. Main Dashboard
- [ ] **Access**: Go to WordPress Admin → Tarot Cards
- [ ] **Card Display**: Verify 8 default cards are shown
- [ ] **Card Information**: Check card names, images, and status
- [ ] **Actions**: Test Edit, Delete, and Add New buttons

#### 2. Add New Card
- [ ] **Form Fields**: Fill in card name, image, content, position
- [ ] **Image Upload**: Test WordPress media library integration
- [ ] **Live Preview**: Verify preview updates as you type
- [ ] **Save Card**: Test form submission and success message
- [ ] **Validation**: Test required field validation

#### 3. Edit Card
- [ ] **Modal Opening**: Click Edit on any card
- [ ] **Form Population**: Verify current data loads correctly
- [ ] **Image Preview**: Check current image displays
- [ ] **Update Card**: Test saving changes
- [ ] **Cancel**: Test modal closing without saving

#### 4. Settings Page
- [ ] **Access**: Go to Tarot Cards → Settings
- [ ] **Form Fields**: Test all setting inputs
- [ ] **Live Preview**: Verify settings preview updates
- [ ] **Save Settings**: Test settings persistence
- [ ] **Statistics**: Check card count displays correctly

### ✅ Frontend Testing

#### 1. Shortcode Display
- [ ] **Basic Shortcode**: `[ac_three_tarot_card_reading]`
- [ ] **Custom Parameters**: `[ac_three_tarot_card_reading title="My Reading" description="Select wisely"]`
- [ ] **Responsive Design**: Test on desktop, tablet, and mobile
- [ ] **Loading**: Verify cards load without errors

#### 2. Card Selection
- [ ] **Card Display**: Verify 8 cards shown face down
- [ ] **Card Interaction**: Click cards to select them
- [ ] **Selection Limit**: Verify only 3 cards can be selected
- [ ] **Visual Feedback**: Check selected cards are highlighted
- [ ] **Progress Indicator**: Verify selection progress shows

#### 3. Reading Generation
- [ ] **Get Reading Button**: Click after selecting 3 cards
- [ ] **Loading State**: Verify loading animation displays
- [ ] **Reading Display**: Check reading results appear
- [ ] **Card Images**: Verify selected cards show face up
- [ ] **Interpretation**: Read the generated interpretation

#### 4. Additional Features
- [ ] **Draw Again**: Test reset functionality
- [ ] **Share Reading**: Test social sharing buttons
- [ ] **Animations**: Verify card flip animations work
- [ ] **Error Handling**: Test with invalid selections

### ✅ Database Testing

#### 1. Table Structure
```sql
-- Check if table exists
SHOW TABLES LIKE 'wp_tarot_cards';

-- Check table structure
DESCRIBE wp_tarot_cards;

-- Check default cards
SELECT * FROM wp_tarot_cards ORDER BY card_position;
```

#### 2. Data Integrity
- [ ] **Default Cards**: Verify 8 cards inserted
- [ ] **Card Names**: Check all card names are correct
- [ ] **Card Content**: Verify interpretations are present
- [ ] **Active Status**: Confirm all cards are active

### ✅ API Testing

#### 1. REST API Endpoints
```bash
# Test cards endpoint
curl -X GET "https://your-site.com/wp-json/tarot/v1/cards"

# Test reading endpoint
curl -X POST "https://your-site.com/wp-json/tarot/v1/reading" \
  -H "Content-Type: application/json" \
  -d '{"card_ids":[1,2,3]}'
```

#### 2. AJAX Handlers
- [ ] **Save Card**: Test adding new cards via AJAX
- [ ] **Delete Card**: Test removing cards via AJAX
- [ ] **Get Reading**: Test reading generation via AJAX

## 🛠️ Troubleshooting

### Common Issues

#### 1. Plugin Not Appearing in Admin
**Solution**: 
- Check if plugin is activated in WordPress Admin → Plugins
- Verify file permissions (755 for directories, 644 for files)
- Check for PHP errors in error log

#### 2. Database Table Not Created
**Solution**:
- Deactivate and reactivate the plugin
- Check database permissions
- Run manual SQL from `database-setup.sql`

#### 3. Shortcode Not Working
**Solution**:
- Verify shortcode syntax: `[ac_three_tarot_card_reading]`
- Check if theme supports shortcodes
- Test in a different page/post

#### 4. Cards Not Loading
**Solution**:
- Check if cards exist in database
- Verify card images are accessible
- Check browser console for JavaScript errors

#### 5. AJAX Errors
**Solution**:
- Verify nonce is being sent correctly
- Check user permissions
- Test with different browsers

### Debug Mode

Enable WordPress debug mode to see detailed error messages:

```php
// Add to wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## 📊 Performance Testing

### 1. Load Testing
- Test with 100+ cards in database
- Monitor page load times
- Check memory usage

### 2. Mobile Testing
- Test on various mobile devices
- Verify touch interactions work
- Check responsive design

### 3. Browser Compatibility
- Test in Chrome, Firefox, Safari, Edge
- Verify JavaScript functionality
- Check CSS rendering

## 🔧 Customization Guide

### 1. Styling Customization
Edit `assets/css/frontend.css` to customize:
- Card appearance
- Colors and fonts
- Animations
- Layout

### 2. Card Content
- Edit card interpretations in admin
- Add new cards via admin interface
- Upload custom card images

### 3. Settings Configuration
- Adjust cards per reading (1-10)
- Set total cards display (3-20)
- Toggle animations
- Customize reading title/description

## 📈 Advanced Features

### 1. Reading History
Future enhancement: Store reading history for users

### 2. Multiple Card Sets
Future enhancement: Support different tarot decks

### 3. Export/Import
Future enhancement: Backup and restore card data

### 4. Analytics
Future enhancement: Track reading statistics

## 🎯 Success Criteria

Your plugin is ready for production when:

- [ ] Admin interface works flawlessly
- [ ] Frontend displays correctly on all devices
- [ ] Card selection and reading generation work
- [ ] Database operations are reliable
- [ ] No JavaScript errors in console
- [ ] All AJAX requests succeed
- [ ] Settings save and load correctly
- [ ] Shortcode works in any page/post

## 📞 Support

If you encounter issues:

1. **Check Error Logs**: Look for PHP/JavaScript errors
2. **Test Incrementally**: Test each feature separately
3. **Use Debug Mode**: Enable WordPress debug logging
4. **Verify Permissions**: Check file and database permissions
5. **Test Environment**: Ensure clean WordPress installation

## 🚀 Deployment Checklist

Before going live:

- [ ] Test on staging environment
- [ ] Verify all features work
- [ ] Check performance metrics
- [ ] Test on multiple devices
- [ ] Verify database backup
- [ ] Document customizations
- [ ] Prepare user documentation

---

**Happy Testing!** 🎴✨

The Three Card Tarot plugin is designed to provide a smooth, engaging experience for both administrators and users. Follow this guide to ensure everything works perfectly before going live. 
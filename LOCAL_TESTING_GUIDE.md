# Local Testing Guide - Three Card Tarot Plugin

## 🚀 Quick Setup for Local Testing

### Prerequisites
- **XAMPP/WAMP/MAMP** (or any local server)
- **WordPress** installed locally
- **PHP 7.4+** and **MySQL 5.7+**

## 📋 Step-by-Step Local Setup

### Step 1: Prepare Your Local Environment

#### If using XAMPP (Windows):
```bash
# Navigate to your XAMPP htdocs directory
cd C:\xampp\htdocs\

# Create a new WordPress site (if you don't have one)
# Or use your existing WordPress installation
```

#### If using MAMP (Mac):
```bash
# Navigate to your MAMP htdocs directory
cd /Applications/MAMP/htdocs/

# Create a new WordPress site (if you don't have one)
# Or use your existing WordPress installation
```

### Step 2: Install WordPress (if needed)

1. **Download WordPress** from wordpress.org
2. **Extract to your htdocs folder**
3. **Create a database** in phpMyAdmin:
   ```sql
   CREATE DATABASE tarot_test;
   ```
4. **Run WordPress installation** at `http://localhost/your-site`

### Step 3: Install the Plugin

1. **Create plugin directory**:
   ```bash
   # Navigate to your WordPress plugins directory
   cd wp-content/plugins/
   
   # Create the plugin folder
   mkdir tarot-three-card
   ```

2. **Copy all plugin files** to the directory:
   ```
   wp-content/plugins/tarot-three-card/
   ├── tarot-three-card.php
   ├── includes/
   ├── templates/
   ├── assets/
   ├── README.md
   ├── INSTALLATION.md
   ├── USER_GUIDE.md
   ├── test-phase3.php
   └── PHASE3_SUMMARY.md
   ```

3. **Set proper permissions**:
   ```bash
   # For Windows (if using Git Bash or similar)
   chmod -R 755 tarot-three-card/
   
   # For Mac/Linux
   chmod -R 755 tarot-three-card/
   ```

### Step 4: Activate the Plugin

1. **Go to WordPress Admin**: `http://localhost/your-site/wp-admin`
2. **Navigate to Plugins**: WordPress Admin → Plugins
3. **Find "Three Card Tarot"** in the list
4. **Click "Activate"**

### Step 5: Verify Installation

1. **Check for errors** in WordPress admin
2. **Look for "Tarot Cards"** in the admin menu
3. **Visit the admin page**: WordPress Admin → Tarot Cards

## 🧪 Running the Test Scripts

### Test Script 1: Database Verification
```bash
# Navigate to your plugin directory
cd wp-content/plugins/tarot-three-card/

# Run the database test
php test-database.php
```

**Expected Output:**
```
=== Database Test - Three Card Tarot Plugin ===

1. Testing Database Connection...
✓ Database connection successful

2. Testing Table Creation...
✓ Table wp_tarot_cards exists

3. Testing Default Cards...
✓ Found 8 default cards
✓ All cards are active
✓ Card positions are set correctly

4. Testing Database Operations...
✓ get_all_cards() returned 8 cards
✓ get_active_cards() returned 8 cards
✓ get_random_cards() returned 3 cards
✓ count_cards() returned 8 total cards

=== Database Test Complete ===
```

### Test Script 2: Phase 2 Testing
```bash
# Run the Phase 2 test
php test-phase2.php
```

**Expected Output:**
```
=== Phase 2 Test - Three Card Tarot Plugin ===

1. Testing Admin Class...
✓ Tarot_Admin class exists

2. Testing Admin Menu Registration...
✓ Admin menu hooks registered: admin_menu

3. Testing AJAX Handlers...
✓ AJAX handler 'Save card' registered
✓ AJAX handler 'Delete card' registered
✓ AJAX handler 'Get card' registered

4. Testing Settings...
✓ Plugin settings found
  - Cards per reading: 3
  - Total cards display: 8
  - Enable animations: yes

5. Testing Template Files...
✓ Template file exists: templates/admin-page.php
✓ Template file exists: templates/add-card-page.php
✓ Template file exists: templates/settings-page.php
✓ Template file exists: templates/frontend-display.php

6. Testing Asset Files...
✓ Asset file exists: assets/css/admin.css
✓ Asset file exists: assets/css/frontend.css
✓ Asset file exists: assets/js/admin.js
✓ Asset file exists: assets/js/frontend.js
✓ Asset file exists: assets/images/card-back.svg
✓ Asset file exists: assets/images/cards/placeholder.svg

7. Testing Database Operations...
✓ get_active_cards() returned 8 cards
✓ get_random_cards() returned 3 cards
✓ count_cards() returned 8 total cards

8. Testing Shortcode Registration...
✓ Shortcode 'ac_three_tarot_card_reading' is registered

9. Testing REST API Registration...
✓ REST API route 'Get cards' accessible
✓ REST API route 'Create reading' accessible

10. Testing Frontend Functionality...
✓ Tarot_Frontend class exists
✓ Shortcode produces output

11. Testing Admin Capabilities...
✓ Current user has admin capabilities

12. Testing Plugin Constants...
✓ Plugin version: 1.0.0
✓ Plugin URL: http://localhost/your-site/wp-content/plugins/tarot-three-card/
✓ Plugin path: /path/to/wp-content/plugins/tarot-three-card/

=== Phase 2 Test Complete ===
```

### Test Script 3: Phase 3 Testing
```bash
# Run the comprehensive Phase 3 test
php test-phase3.php
```

**Expected Output:**
```
=== Phase 3 Test - Three Card Tarot Plugin ===

1. Testing Plugin Activation...
✓ Plugin is activated

2. Testing Database...
✓ Database table exists: wp_tarot_cards
  - Total cards: 8
  - Active cards: 8
  - Inactive cards: 0

3. Testing Admin Interface...
✓ Tarot_Admin class exists
✓ Admin menu registered

4. Testing Shortcode...
✓ Shortcode 'ac_three_tarot_card_reading' is registered
✓ Shortcode produces output
  ✓ Main container found in output
  ✓ Card grid found in output
  ✓ Card items found in output
  ✓ Reading results section found in output

5. Testing AJAX Handlers...
✓ AJAX handler 'Save card' registered
✓ AJAX handler 'Delete card' registered
✓ AJAX handler 'Get card' registered
✓ AJAX handler 'Get reading' registered

6. Testing REST API...
✓ REST API route 'Get cards' accessible
✓ REST API route 'Create reading' accessible

7. Testing Asset Files...
✓ Admin CSS exists (2048 bytes)
✓ Frontend CSS exists (3072 bytes)
✓ Admin JS exists (1024 bytes)
✓ Frontend JS exists (2048 bytes)
✓ Card back image exists (512 bytes)
✓ Card placeholder exists (256 bytes)

8. Testing Template Files...
✓ Admin page template exists (4096 bytes)
✓ Add card template exists (2048 bytes)
✓ Settings template exists (3072 bytes)
✓ Frontend template exists (4096 bytes)

9. Testing Settings...
✓ Plugin settings found
  - Cards per reading: 3
  - Total cards display: 8
  - Enable animations: yes

10. Testing User Capabilities...
✓ Current user has admin capabilities

11. Testing Plugin Constants...
✓ Plugin version: 1.0.0
✓ Plugin URL: http://localhost/your-site/wp-content/plugins/tarot-three-card/
✓ Plugin path: /path/to/wp-content/plugins/tarot-three-card/

12. Testing Database Operations...
✓ get_active_cards() returned 8 cards
✓ get_random_cards() returned 3 cards
✓ get_all_cards() returned 8 cards
  - Sample card: The Fool

13. Testing Frontend JavaScript...
✓ jQuery usage found in JS
✓ Card selection functionality found in JS
✓ AJAX functionality found in JS
✓ Reading generation found in JS

14. Testing CSS Styling...
✓ Main container styles found in CSS
✓ Card grid styles found in CSS
✓ Card item styles found in CSS
✓ Responsive design found in CSS

=== Phase 3 Test Summary ===
Overall Status: 14/14 core components ready

=== Next Steps ===
1. ✅ Plugin structure complete
2. ✅ Database setup complete
3. ✅ Admin interface ready
4. ✅ Frontend interface ready
5. 🔄 Test in WordPress admin
6. 🔄 Add shortcode to a page
7. 🔄 Test complete reading flow
8. 🔄 Upload real card images
9. 🔄 Customize interpretations
10. 🔄 Deploy to production

=== Ready for Production Testing! ===
```

## 🎯 Manual Testing Checklist

### Admin Interface Testing

1. **Access Admin Menu**
   - Go to WordPress Admin → Tarot Cards
   - Verify you see the main dashboard

2. **View Cards**
   - Check that 8 default cards are displayed
   - Verify card names, images, and status

3. **Edit a Card**
   - Click "Edit" on any card
   - Verify modal opens with card data
   - Test saving changes

4. **Add New Card**
   - Click "Add New Card"
   - Fill in the form with test data
   - Test image upload
   - Verify live preview works
   - Save the card

5. **Settings Page**
   - Go to Tarot Cards → Settings
   - Test all form fields
   - Verify live preview updates
   - Save settings

### Frontend Testing

1. **Create Test Page**
   - Go to Pages → Add New
   - Add shortcode: `[ac_three_tarot_card_reading]`
   - Publish the page

2. **Test Card Selection**
   - Visit the published page
   - Verify 8 cards are displayed face down
   - Click to select 3 cards
   - Verify selection limit works

3. **Test Reading Generation**
   - Click "Get My Reading" after selecting 3 cards
   - Verify loading animation
   - Check reading results display
   - Test "Draw Again" functionality

4. **Test Responsive Design**
   - Test on different screen sizes
   - Verify mobile touch interactions
   - Check animations work properly

## 🛠️ Troubleshooting Common Issues

### Issue 1: Plugin Not Appearing
**Solution:**
```bash
# Check file permissions
chmod -R 755 wp-content/plugins/tarot-three-card/

# Check for PHP errors
tail -f /path/to/error.log
```

### Issue 2: Database Table Not Created
**Solution:**
```sql
-- Check if table exists
SHOW TABLES LIKE 'wp_tarot_cards';

-- If not, run manual setup
SOURCE /path/to/database-setup.sql;
```

### Issue 3: Shortcode Not Working
**Solution:**
```php
// Test shortcode manually
echo do_shortcode('[ac_three_tarot_card_reading]');
```

### Issue 4: AJAX Errors
**Solution:**
```javascript
// Check browser console for errors
// Verify nonce is being sent
console.log(tarot_ajax.nonce);
```

## 📊 Performance Testing

### Load Testing
```bash
# Test with multiple cards
# Add 50+ cards via admin interface
# Monitor page load times
# Check memory usage
```

### Browser Testing
- **Chrome**: Test all features
- **Firefox**: Verify compatibility
- **Safari**: Check animations
- **Edge**: Test functionality

### Mobile Testing
- **iPhone**: Test touch interactions
- **Android**: Verify responsive design
- **Tablet**: Check layout scaling

## 🔧 Debug Mode

Enable WordPress debug mode for detailed error reporting:

```php
// Add to wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## 📈 Success Criteria

Your local testing is successful when:

- [ ] All test scripts pass without errors
- [ ] Admin interface works flawlessly
- [ ] Frontend displays correctly
- [ ] Card selection and reading generation work
- [ ] No JavaScript errors in browser console
- [ ] All AJAX requests succeed
- [ ] Settings save and load correctly
- [ ] Shortcode works in any page/post
- [ ] Responsive design works on all devices

## 🚀 Next Steps After Local Testing

1. **Upload real tarot card images**
2. **Customize card interpretations**
3. **Test with real users**
4. **Deploy to staging environment**
5. **Deploy to production**

---

**Happy Testing!** 🎴✨

Follow this guide to thoroughly test your Three Card Tarot plugin in your local environment before deploying to production. 
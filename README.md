# Three Card Tarot - WordPress Plugin

A complete WordPress plugin for interactive tarot card readings with a beautiful, responsive interface.

## 🎴 Features

- **Interactive Card Selection**: Users can select 3 cards from 8 displayed cards
- **Beautiful Animations**: Smooth card flip and shuffle animations
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Admin Interface**: Easy card management with add, edit, and delete functionality
- **Customizable Settings**: Configure reading parameters and card back images
- **AJAX-powered**: Fast, dynamic interactions without page reloads
- **Shortcode Support**: Use `[ac_three_tarot_card_reading]` anywhere
- **Daily Tarot**: Automatic daily card selection that stays the same for the entire day

## 📋 Requirements

- WordPress 5.0+
- PHP 7.4+
- MySQL 5.7+
- jQuery (included with WordPress)

## 🚀 Installation

### Method 1: Automatic Installation
1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin in WordPress Admin → Plugins
3. The database tables and default cards will be created automatically

### Method 2: Manual Database Setup
1. Upload the plugin folder to `/wp-content/plugins/`
2. Run the SQL script in `database-setup.sql` in your database
3. Activate the plugin in WordPress Admin → Plugins

## 📖 Usage

### Shortcodes

#### Three Card Reading
Add this shortcode to any page or post:
```
[ac_three_tarot_card_reading]
```

#### Custom Parameters
```
[ac_three_tarot_card_reading title="My Custom Reading" description="Select your cards wisely"]
```

#### Daily Tarot Card
Display a daily tarot card that automatically updates each day:
```
[ac_daily_tarot]
```

#### Daily Tarot with Previous Cards
```
[ac_daily_tarot title="Today's Card" show_previous="true"]
```

### Admin Interface
- **WordPress Admin → Three Tarot Cards**: Manage all cards
- **Add New Card**: Upload images and add card interpretations
- **Settings**: Configure reading parameters and card back images

## 🎯 User Experience

1. **Card Selection**: Users see 8 cards face down
2. **Interactive Selection**: Click to select exactly 3 cards
3. **Reading Generation**: Get personalized interpretation via AJAX
4. **Draw Again**: Shuffle and get new random cards

## 🛠️ File Structure

```
tarot-three-card/
├── tarot-three-card.php          # Main plugin file
├── includes/
│   ├── class-tarot-database.php  # Database operations
│   ├── class-tarot-admin.php     # Admin interface
│   ├── class-tarot-frontend.php  # Frontend display
│   └── class-tarot-api.php       # REST API endpoints
├── templates/
│   ├── admin-page.php            # Admin dashboard
│   ├── add-card-page.php         # Add card form
│   ├── settings-page.php         # Settings page
│   └── frontend-display.php      # Public interface
├── assets/
│   ├── css/
│   │   ├── admin.css            # Admin styles
│   │   └── frontend.css         # Frontend styles
│   ├── js/
│   │   ├── admin.js             # Admin JavaScript
│   │   └── frontend.js          # Frontend JavaScript
│   └── images/
│       ├── card-back.svg        # Default card back
│       └── cards/
│           └── placeholder.svg   # Default card image
├── README.md                     # This file
├── INSTALLATION.md               # Installation guide
└── database-setup.sql            # Database setup script
```

## ⚙️ Configuration

### Settings
- **Cards per reading**: Number of cards to select (default: 3)
- **Total cards display**: Number of cards to show (default: 8)
- **Enable animations**: Toggle card animations
- **Card back image**: Custom card back image URL

### Database
- **Table**: `wp_tarot_cards`
- **Default cards**: 8 tarot cards included
- **Fields**: id, card_name, card_image, card_content, card_position, is_active

## 🔧 Customization

### Styling
Modify `assets/css/frontend.css` for custom styling:
```css
.tarot-reading-container {
    /* Your custom styles */
}
```

### JavaScript
Extend functionality in `assets/js/frontend.js`:
```javascript
// Add custom event handlers
$('.tarot-card').on('custom-event', function() {
    // Your custom code
});
```

### Templates
Override templates by copying to your theme:
```
your-theme/tarot-three-card/templates/frontend-display.php
```

## 🌐 API Endpoints

### REST API
- `GET /wp-json/tarot/v1/cards` - Get all cards
- `POST /wp-json/tarot/v1/reading` - Generate reading

### AJAX Actions
- `tarot_get_reading` - Get reading for selected cards
- `tarot_get_random_cards` - Get random cards for display
- `tarot_save_card` - Save card (admin)
- `tarot_delete_card` - Delete card (admin)

## 🎨 Features in Detail

### Card Management
- Add unlimited cards with custom images
- Edit card names, images, and interpretations
- Enable/disable cards
- Drag and drop image upload

### User Interface
- Responsive grid layout
- Smooth card flip animations
- Progress indicator for card selection
- Loading states and error handling
- Mobile-friendly touch interactions

### Reading System
- Real-time card selection
- AJAX-powered reading generation
- Timestamped readings
- Social media sharing
- "Draw again" functionality

## 🔒 Security

- **Nonce Verification**: All AJAX requests verified
- **Input Sanitization**: All user inputs sanitized
- **SQL Prepared Statements**: Database queries secured
- **Capability Checks**: Admin functions protected

## 🚀 Performance

- **Minimal Database Queries**: Optimized for speed
- **Cached Assets**: CSS and JS files cached
- **Lazy Loading**: Images load on demand
- **Responsive Images**: Optimized for all devices

## 📱 Mobile Support

- **Touch Interactions**: Optimized for mobile devices
- **Responsive Design**: Works on all screen sizes
- **Touch-friendly Buttons**: Large, accessible buttons
- **Smooth Animations**: Hardware-accelerated animations

## 🎴 Default Cards

The plugin includes 8 default tarot cards:
1. The Fool
2. The Magician
3. The High Priestess
4. The Empress
5. The Emperor
6. The Hierophant
7. The Lovers
8. The Chariot

## 🔧 Troubleshooting

### Common Issues
1. **Cards not displaying**: Check if plugin is activated
2. **Images not loading**: Verify image URLs in admin
3. **AJAX errors**: Check browser console for errors
4. **Database issues**: Run database setup script

### Debug Mode
Enable WordPress debug mode in `wp-config.php`:
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## 📄 License

This plugin is provided as-is for educational and commercial use.

## 🤝 Support

For support and feature requests, please refer to the WordPress plugin repository or contact the developer.

---

**Three Card Tarot Plugin** - Transform your WordPress site with interactive tarot readings! 🎴✨ 
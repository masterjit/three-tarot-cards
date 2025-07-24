# Three Card Tarot WordPress Plugin

A comprehensive WordPress plugin for interactive three card tarot readings with customizable cards and beautiful user interface.

## Features

### 🎴 Core Functionality
- **Interactive Card Selection**: Users can select 3 cards from a display of 8 cards
- **Beautiful Card Animations**: Smooth card flip animations and hover effects
- **Reading Generation**: Automatic interpretation generation based on selected cards
- **Draw Again**: Reset functionality to start a new reading
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices

### 🛠️ Admin Management
- **Card Management**: Add, edit, delete, and organize tarot cards
- **Image Upload**: WordPress media library integration for card images
- **Content Management**: Rich text editor for card interpretations
- **Settings Panel**: Customize reading parameters and appearance
- **Bulk Operations**: Import/export card data

### 🌐 Frontend Features
- **Shortcode Support**: Easy integration with `[ac_three_tarot_card_reading]`
- **AJAX Loading**: Smooth, non-refresh interactions
- **Social Sharing**: Share readings on Facebook, Twitter, and email
- **Accessibility**: Full keyboard navigation and screen reader support
- **Mobile Optimized**: Touch-friendly interface for mobile devices

## Installation

### Prerequisites
- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Installation Steps

1. **Upload Plugin Files**
   ```bash
   # Copy plugin files to your WordPress plugins directory
   cp -r tarot-three-card /wp-content/plugins/
   ```

2. **Activate Plugin**
   - Go to WordPress Admin → Plugins
   - Find "Three Card Tarot" and click "Activate"

3. **Database Setup**
   - The plugin will automatically create the required database table
   - Default cards will be inserted automatically

4. **Configure Settings**
   - Go to WordPress Admin → Tarot Cards → Settings
   - Customize reading parameters and appearance

## Usage

### For Administrators

#### Managing Cards
1. Go to **WordPress Admin → Tarot Cards**
2. Click **"Add New Card"** to create a new card
3. Fill in:
   - **Card Name**: The name of the tarot card
   - **Card Image**: Upload or select an image for the card
   - **Card Content**: The interpretation/meaning of the card
   - **Position**: Order in which cards appear
   - **Status**: Active/Inactive

#### Settings Configuration
1. Go to **WordPress Admin → Tarot Cards → Settings**
2. Configure:
   - **Cards per Reading**: Number of cards to select (default: 3)
   - **Total Cards Display**: Number of cards to show (default: 8)
   - **Enable Animations**: Toggle card animations
   - **Reading Title**: Custom title for the reading interface
   - **Reading Description**: Custom description text

### For Users

#### Using the Shortcode
Add the tarot reading interface to any page or post:

```
[ac_three_tarot_card_reading]
```

Or with custom parameters:

```
[ac_three_tarot_card_reading title="My Custom Reading" description="Select your cards wisely"]
```

#### Reading Process
1. **Select Cards**: Click on 3 cards from the displayed grid
2. **Review Selection**: Confirm your selected cards
3. **Get Reading**: Click "Get My Reading" to see your interpretation
4. **Share or Draw Again**: Share your reading or start a new one

## Database Structure

### Main Table: `wp_tarot_cards`

| Column | Type | Description |
|--------|------|-------------|
| `id` | mediumint(9) | Primary key, auto-increment |
| `card_name` | varchar(255) | Name of the tarot card |
| `card_image` | varchar(500) | URL to card image |
| `card_content` | longtext | Card interpretation/meaning |
| `card_position` | int(11) | Display order position |
| `is_active` | tinyint(1) | Active status (1/0) |
| `created_at` | datetime | Creation timestamp |
| `updated_at` | datetime | Last update timestamp |

## API Endpoints

### REST API

#### Get All Cards
```
GET /wp-json/tarot/v1/cards
```

#### Create Reading
```
POST /wp-json/tarot/v1/reading
{
  "card_ids": [1, 2, 3]
}
```

#### Get Reading
```
GET /wp-json/tarot/v1/reading/{id}
```

### AJAX Endpoints

#### Get Reading (Frontend)
```
POST /wp-admin/admin-ajax.php
{
  "action": "tarot_get_reading",
  "card_ids": [1, 2, 3],
  "nonce": "nonce_value"
}
```

## File Structure

```
tarot-three-card/
├── tarot-three-card.php          # Main plugin file
├── includes/
│   ├── class-tarot-database.php  # Database operations
│   ├── class-tarot-admin.php     # Admin interface
│   ├── class-tarot-frontend.php  # Frontend display
│   └── class-tarot-api.php       # REST API endpoints
├── assets/
│   ├── css/
│   │   ├── admin.css             # Admin styles
│   │   └── frontend.css          # Frontend styles
│   ├── js/
│   │   ├── admin.js              # Admin JavaScript
│   │   └── frontend.js           # Frontend JavaScript
│   └── images/
│       └── cards/                # Default card images
├── templates/
│   ├── admin-page.php            # Admin page template
│   └── frontend-display.php      # Frontend display template
└── languages/                    # Translation files
```

## Customization

### Styling
The plugin uses CSS custom properties for easy theming:

```css
:root {
  --tarot-primary-color: #667eea;
  --tarot-secondary-color: #764ba2;
  --tarot-card-border-radius: 15px;
  --tarot-animation-duration: 0.6s;
}
```

### Hooks and Filters

#### Actions
- `tarot_before_card_selection`: Fired before card selection
- `tarot_after_card_selection`: Fired after card selection
- `tarot_before_reading_display`: Fired before reading display
- `tarot_after_reading_display`: Fired after reading display

#### Filters
- `tarot_card_content`: Modify card interpretation content
- `tarot_reading_title`: Modify reading title
- `tarot_card_image_url`: Modify card image URL
- `tarot_selected_cards`: Modify selected cards array

### Example Customization

```php
// Add custom styling
add_action('wp_head', function() {
    echo '<style>
        .tarot-card {
            border: 3px solid #gold;
        }
    </style>';
});

// Modify card content
add_filter('tarot_card_content', function($content, $card) {
    return $content . '<p>Custom interpretation for ' . $card->card_name . '</p>';
}, 10, 2);
```

## Troubleshooting

### Common Issues

#### Cards Not Loading
- Check if database table exists: `wp_tarot_cards`
- Verify plugin activation created default cards
- Check for JavaScript errors in browser console

#### Images Not Displaying
- Ensure image URLs are accessible
- Check file permissions on uploaded images
- Verify media library integration is working

#### AJAX Errors
- Check nonce verification
- Verify user permissions
- Check server error logs

### Debug Mode
Enable WordPress debug mode to see detailed error messages:

```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

## Performance Optimization

### Caching
- Enable WordPress object caching
- Use CDN for card images
- Implement browser caching for static assets

### Database Optimization
- Add indexes to frequently queried columns
- Regular database cleanup
- Optimize card image sizes

## Security

### Data Sanitization
- All user inputs are sanitized
- SQL queries use prepared statements
- Nonce verification on all forms

### File Upload Security
- Image type validation
- File size limits
- Secure file storage

## Browser Support

- **Chrome**: 60+
- **Firefox**: 55+
- **Safari**: 12+
- **Edge**: 79+
- **Mobile Browsers**: iOS Safari 12+, Chrome Mobile 60+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This plugin is licensed under the GPL v2 or later.

## Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review the troubleshooting section

## Changelog

### Version 1.0.0
- Initial release
- Basic card management
- Frontend reading interface
- Admin management panel
- REST API endpoints
- Responsive design
- Social sharing features

## Credits

- Built with WordPress best practices
- Uses modern CSS Grid and Flexbox
- Implements accessibility standards
- Follows WordPress coding standards 
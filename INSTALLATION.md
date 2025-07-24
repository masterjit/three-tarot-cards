# Installation Guide - Three Card Tarot Plugin

## Prerequisites

Before installing the plugin, ensure you have:

- WordPress 5.0 or higher
- PHP 7.4 or higher  
- MySQL 5.7 or higher
- Access to your WordPress database

## Step 1: Upload Plugin Files

1. **Copy the plugin folder** to your WordPress plugins directory:
   ```bash
   # Navigate to your WordPress installation
   cd /path/to/your/wordpress/wp-content/plugins/
   
   # Copy the plugin folder
   cp -r tarot-three-card ./
   ```

2. **Verify the file structure**:
   ```
   wp-content/plugins/tarot-three-card/
   ├── tarot-three-card.php
   ├── includes/
   ├── assets/
   ├── templates/
   └── README.md
   ```

## Step 2: Database Setup

### Option A: Automatic Setup (Recommended)

1. **Activate the plugin** in WordPress Admin:
   - Go to **WordPress Admin → Plugins**
   - Find "Three Card Tarot" 
   - Click **"Activate"**

2. **The plugin will automatically**:
   - Create the `wp_tarot_cards` table
   - Insert 8 default tarot cards
   - Set up default plugin options

### Option B: Manual Database Setup

If automatic setup fails, you can manually create the database table:

1. **Access your MySQL database**:
   ```sql
   -- Connect to your database
   mysql -u root -p three_tarot_card
   ```

2. **Create the table manually**:
   ```sql
   CREATE TABLE wp_tarot_cards (
       id mediumint(9) NOT NULL AUTO_INCREMENT,
       card_name varchar(255) NOT NULL,
       card_image varchar(500) NOT NULL,
       card_content longtext NOT NULL,
       card_position int(11) DEFAULT 0,
       is_active tinyint(1) DEFAULT 1,
       created_at datetime DEFAULT CURRENT_TIMESTAMP,
       updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
       PRIMARY KEY (id),
       KEY card_position (card_position),
       KEY is_active (is_active)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```

3. **Insert default cards**:
   ```sql
   INSERT INTO wp_tarot_cards (card_name, card_image, card_content, card_position) VALUES
   ('The Fool', '/wp-content/plugins/tarot-three-card/assets/images/cards/fool.jpg', 'The Fool represents new beginnings, innocence, spontaneity, and a free spirit. This card suggests taking a leap of faith and embracing new opportunities with an open heart.', 1),
   ('The Magician', '/wp-content/plugins/tarot-three-card/assets/images/cards/magician.jpg', 'The Magician represents manifestation, resourcefulness, power, and inspired action. This card indicates that you have all the tools and resources needed to achieve your goals.', 2),
   ('The High Priestess', '/wp-content/plugins/tarot-three-card/assets/images/cards/high-priestess.jpg', 'The High Priestess represents intuition, sacred knowledge, divine feminine, and the subconscious mind. This card suggests listening to your inner voice and trusting your instincts.', 3),
   ('The Empress', '/wp-content/plugins/tarot-three-card/assets/images/cards/empress.jpg', 'The Empress represents femininity, beauty, nature, abundance, and nurturing. This card indicates growth, creativity, and the manifestation of your desires.', 4),
   ('The Emperor', '/wp-content/plugins/tarot-three-card/assets/images/cards/emperor.jpg', 'The Emperor represents authority, structure, control, and fatherhood. This card suggests taking charge of your situation and establishing order in your life.', 5),
   ('The Hierophant', '/wp-content/plugins/tarot-three-card/assets/images/cards/hierophant.jpg', 'The Hierophant represents tradition, conformity, morality, and ethics. This card suggests following established systems and seeking guidance from mentors or spiritual leaders.', 6),
   ('The Lovers', '/wp-content/plugins/tarot-three-card/assets/images/cards/lovers.jpg', 'The Lovers represent love, harmony, relationships, values alignment, and choices. This card indicates important decisions about love, partnerships, and personal values.', 7),
   ('The Chariot', '/wp-content/plugins/tarot-three-card/assets/images/cards/chariot.jpg', 'The Chariot represents control, willpower, victory, assertion, and determination. This card suggests overcoming obstacles through discipline and focused action.', 8);
   ```

## Step 3: Verify Installation

### Check Database Table

Run this SQL query to verify the table exists:

```sql
SHOW TABLES LIKE 'wp_tarot_cards';
```

### Check Default Cards

Run this SQL query to see the default cards:

```sql
SELECT id, card_name, card_position, is_active FROM wp_tarot_cards ORDER BY card_position;
```

You should see 8 cards listed.

## Step 4: Test the Plugin

### Admin Interface Test

1. **Go to WordPress Admin → Tarot Cards**
2. **Verify you can see the cards list**
3. **Test adding a new card**
4. **Test editing an existing card**

### Frontend Test

1. **Create a new page or post**
2. **Add the shortcode**: `[ac_three_tarot_card_reading]`
3. **Publish the page**
4. **Visit the page and test the card selection**

## Troubleshooting

### Database Connection Issues

If you get database connection errors:

1. **Check your database credentials** in `wp-config.php`
2. **Verify the database exists**: `three_tarot_card`
3. **Check user permissions** for the database user

### Plugin Activation Issues

If the plugin won't activate:

1. **Check PHP version**: Must be 7.4 or higher
2. **Check file permissions**: Ensure plugin files are readable
3. **Check WordPress version**: Must be 5.0 or higher
4. **Check for conflicts**: Deactivate other plugins temporarily

### Table Creation Issues

If the table isn't created:

1. **Check database user permissions**
2. **Verify database exists**
3. **Try manual table creation** (see Option B above)
4. **Check WordPress debug log** for errors

### Card Images Not Loading

If card images don't display:

1. **Upload card images** to `/wp-content/plugins/tarot-three-card/assets/images/cards/`
2. **Check file permissions** on the images directory
3. **Verify image URLs** in the database
4. **Use WordPress Media Library** to upload images

## Database Schema

The plugin creates one main table:

### `wp_tarot_cards`

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

## Next Steps

After successful installation:

1. **Customize card images** by uploading your own tarot card images
2. **Edit card interpretations** to match your preferred tarot system
3. **Configure settings** in WordPress Admin → Tarot Cards → Settings
4. **Add the shortcode** to your pages: `[ac_three_tarot_card_reading]`
5. **Test the complete functionality** from frontend to backend

## Support

If you encounter issues:

1. **Check the WordPress debug log**
2. **Verify all files are uploaded correctly**
3. **Test with a default WordPress theme**
4. **Check for plugin conflicts**

For additional help, refer to the main README.md file or create an issue in the plugin repository. 
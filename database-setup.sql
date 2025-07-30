-- Three Card Tarot Plugin Database Setup
-- Run this script in your MySQL database to create the required table and insert default cards

-- Create the tarot cards table
CREATE TABLE IF NOT EXISTS `wp_ac_three_tarot_cards` (
    `id` mediumint(9) NOT NULL AUTO_INCREMENT,
    `card_name` varchar(255) NOT NULL,
    `card_image` varchar(500) NOT NULL,
    `card_content` longtext NOT NULL,
    `card_content_reversed` longtext NOT NULL,
    `card_position` int(11) DEFAULT 0,
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `card_position` (`card_position`),
    KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Clear existing data (if any)
TRUNCATE TABLE `wp_ac_three_tarot_cards`;

-- Note: All 78 tarot cards will be automatically inserted when the plugin is activated
-- The plugin includes a comprehensive tarot deck with Major Arcana (22 cards) and Minor Arcana (56 cards)

-- Verify the setup
SELECT 'Database setup complete!' as status;
SELECT 'All 78 tarot cards will be inserted automatically on plugin activation' as note; 
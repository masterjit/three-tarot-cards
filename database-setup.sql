-- Three Card Tarot Plugin Database Setup
-- Run this script in your MySQL database to create the required table and insert default cards

-- Create the tarot cards table
CREATE TABLE IF NOT EXISTS `wp_tarot_cards` (
    `id` mediumint(9) NOT NULL AUTO_INCREMENT,
    `card_name` varchar(255) NOT NULL,
    `card_image` varchar(500) NOT NULL,
    `card_content` longtext NOT NULL,
    `card_position` int(11) DEFAULT 0,
    `is_active` tinyint(1) DEFAULT 1,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `card_position` (`card_position`),
    KEY `is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Clear existing data (if any)
TRUNCATE TABLE `wp_tarot_cards`;

-- Insert default tarot cards
INSERT INTO `wp_tarot_cards` (`card_name`, `card_image`, `card_content`, `card_position`) VALUES
('The Fool', '/wp-content/plugins/tarot-three-card/assets/images/cards/fool.jpg', 'The Fool represents new beginnings, innocence, spontaneity, and a free spirit. This card suggests taking a leap of faith and embracing new opportunities with an open heart.', 1),
('The Magician', '/wp-content/plugins/tarot-three-card/assets/images/cards/magician.jpg', 'The Magician represents manifestation, resourcefulness, power, and inspired action. This card indicates that you have all the tools and resources needed to achieve your goals.', 2),
('The High Priestess', '/wp-content/plugins/tarot-three-card/assets/images/cards/high-priestess.jpg', 'The High Priestess represents intuition, sacred knowledge, divine feminine, and the subconscious mind. This card suggests listening to your inner voice and trusting your instincts.', 3),
('The Empress', '/wp-content/plugins/tarot-three-card/assets/images/cards/empress.jpg', 'The Empress represents femininity, beauty, nature, abundance, and nurturing. This card indicates growth, creativity, and the manifestation of your desires.', 4),
('The Emperor', '/wp-content/plugins/tarot-three-card/assets/images/cards/emperor.jpg', 'The Emperor represents authority, structure, control, and fatherhood. This card suggests taking charge of your situation and establishing order in your life.', 5),
('The Hierophant', '/wp-content/plugins/tarot-three-card/assets/images/cards/hierophant.jpg', 'The Hierophant represents tradition, conformity, morality, and ethics. This card suggests following established systems and seeking guidance from mentors or spiritual leaders.', 6),
('The Lovers', '/wp-content/plugins/tarot-three-card/assets/images/cards/lovers.jpg', 'The Lovers represent love, harmony, relationships, values alignment, and choices. This card indicates important decisions about love, partnerships, and personal values.', 7),
('The Chariot', '/wp-content/plugins/tarot-three-card/assets/images/cards/chariot.jpg', 'The Chariot represents control, willpower, victory, assertion, and determination. This card suggests overcoming obstacles through discipline and focused action.', 8);

-- Verify the setup
SELECT 'Database setup complete!' as status;
SELECT COUNT(*) as total_cards FROM `wp_tarot_cards`;
SELECT `card_name`, `card_position`, `is_active` FROM `wp_tarot_cards` ORDER BY `card_position`; 
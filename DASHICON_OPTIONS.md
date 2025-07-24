# Dashicon Options for Three Card Tarot Plugin

## Current Icon
The plugin currently uses: `dashicons-admin-appearance`

## Alternative Icon Options

Here are some better dashicon options for a tarot card plugin:

### Option 1: Cards/Game Icon
```php
'dashicons-games'
```
- **Description**: A game controller icon that represents cards/games
- **Best for**: General card/game applications

### Option 2: Magic/Mystical Icon
```php
'dashicons-admin-magic'
```
- **Description**: A magic wand icon that represents mystical/tarot readings
- **Best for**: Tarot, fortune telling, mystical applications

### Option 3: Star Icon
```php
'dashicons-star-filled'
```
- **Description**: A star icon that represents fortune/divination
- **Best for**: Fortune telling, predictions, mystical readings

### Option 4: Heart Icon
```php
'dashicons-heart'
```
- **Description**: A heart icon that represents love readings
- **Best for**: Love tarot, relationship readings

### Option 5: Diamond Icon
```php
'dashicons-diamond'
```
- **Description**: A diamond icon that represents luxury/precious readings
- **Best for**: Premium tarot services

## How to Change the Icon

To change the dashicon, edit the `includes/class-tarot-admin.php` file:

```php
// Find this line in the add_menu_page() function:
'dashicons-admin-appearance',

// Replace with your preferred icon:
'dashicons-games',           // For cards/games
'dashicons-admin-magic',     // For mystical readings
'dashicons-star-filled',     // For fortune telling
'dashicons-heart',          // For love readings
'dashicons-diamond',        // For premium services
```

## Complete List of Available Dashicons

You can view all available WordPress dashicons at:
https://developer.wordpress.org/resource/dashicons/

## Recommended Icons for Tarot Plugin

1. **`dashicons-games`** - Best overall choice for card-based applications
2. **`dashicons-admin-magic`** - Perfect for mystical/fortune telling
3. **`dashicons-star-filled`** - Great for predictions and divination
4. **`dashicons-heart`** - Ideal for love/relationship readings
5. **`dashicons-diamond`** - Premium feel for professional services

## Quick Change

To quickly change to the games icon (most appropriate for cards):

```php
// In includes/class-tarot-admin.php, line ~35
'dashicons-games',
```

This will give you a game controller icon that's perfect for a tarot card plugin! 
@echo off
echo ========================================
echo Three Card Tarot Plugin - Test Runner
echo ========================================
echo.

echo Starting tests...
echo.

echo 1. Running Quick Setup...
php quick-setup.php
echo.

echo 2. Running Database Test...
php test-database.php
echo.

echo 3. Running Phase 2 Test...
php test-phase2.php
echo.

echo 4. Running Phase 3 Test...
php test-phase3.php
echo.

echo ========================================
echo All tests completed!
echo ========================================
echo.
echo Next steps:
echo 1. Go to WordPress Admin ^> Tarot Cards
echo 2. Test the admin interface
echo 3. Visit your test page
echo 4. Test the frontend card selection
echo.
echo Press any key to exit...
pause > nul 
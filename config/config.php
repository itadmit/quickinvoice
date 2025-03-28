<?php
// Start session
session_start();

// Application settings
define('APP_NAME', 'Invoice SaaS');
define('APP_URL', 'http://app.zingcrm.co.il'); // Change in production
define('APP_VERSION', '1.0.0');

// HYP API Settings
define('HYP_API_KEY', 'your_hyp_api_key_here');
define('HYP_API_URL', 'https://api.hyp.com'); // Replace with actual API URL

// Error reporting - change in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Timezone
date_default_timezone_set('Asia/Jerusalem');

// Include database configuration
require_once 'db.php';

// Include helper functions
require_once __DIR__ . '/../includes/functions.php';

// Auto-load classes
spl_autoload_register(function ($class_name) {
    $file = $_SERVER['DOCUMENT_ROOT'] . '/invoice-saas/classes/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
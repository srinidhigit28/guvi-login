<?php
/**
 * MongoDB PHP Library - Minimal Autoloader
 * For GUVI Internship Project
 */

// Load MongoDB stubs if extension not available
if (!extension_loaded('mongodb')) {
    require_once __DIR__ . '/mongodb.php';
}
?>

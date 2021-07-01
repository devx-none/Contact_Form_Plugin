<?php
/**
 * 
 * @package Contact From Plus
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb;

$wpdb->query("DROP TABLE IF EXISTS contact_data");
$wpdb->query("DROP TABLE IF EXISTS contact_fields");
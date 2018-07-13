<?php

if(!defined('WP_UNINSTALL_PLUGIN')){
    exit();
}

$option_name = 'mp_opcion';
delete_option( $option_name );

global $wpdb;

$wpdb->query( "DROP TABLE IF EXISTS{$wpdb->prefix}copia");

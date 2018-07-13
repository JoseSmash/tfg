<?php
/**
 * Created by PhpStorm.
 * User: Jose
 * Date: 23/06/2018
 * Time: 17:37
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/copia/wp-load.php';

$cat= $_POST['cat'];
$cont= (int)$_POST['cont'];
$value = (int)$_POST['value'];

global $wpdb;
$result = $wpdb->get_var("SELECT arrayy FROM `wp_status_array` WHERE id_shop_order = '$value'");
$actuales = json_decode($result);

if(!in_array($cat, $actuales)) {
    $actuales[] = $cat;
    $interest_post_json = json_encode($actuales);

    $wpdb->query($wpdb->prepare(
        "
                UPDATE wp_status_array 
                SET arrayy = %s
                WHERE id_shop_order = %d
               ",
        $interest_post_json, $value
    ));
}

$wpdb->query($wpdb->prepare(
    "
            UPDATE wp_status_button 
            SET status_button = %s
            WHERE id_button = %d
           ",
    "checked", $cont
));

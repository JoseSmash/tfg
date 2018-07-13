<?php
/**
 * Created by PhpStorm.
 * User: Jose
 * Date: 02/07/2018
 * Time: 16:54
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/copia/wp-load.php';

$cat= $_POST['cat'];
$cont= (int)$_POST['cont'];
$value = (int)$_POST['value'];

global $wpdb;
$result = $wpdb->get_var("SELECT arrayy FROM `wp_status_array` WHERE id_shop_order = '$value'");
$actuales = json_decode($result);

$new_array=array();

foreach ($actuales as $act){
    if($cat != $act){
        $new_array[]=$act;
    }
}

$interest_post_json = json_encode($new_array);

$wpdb->query($wpdb->prepare(
    "
            UPDATE wp_status_array 
            SET arrayy = %s
            WHERE id_shop_order = %d
            ",
    $interest_post_json, $value
));

$wpdb->query($wpdb->prepare(
    "
            UPDATE wp_status_button 
            SET status_button = %s
            WHERE id_button = %d
           ",
    "no_checked", $cont
));

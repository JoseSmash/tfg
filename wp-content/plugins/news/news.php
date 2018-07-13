<?php
/*
Plugin Name:  Catch Buyer
Description:  Relaciona los productos de cada pedido con una serie de entradas del blog para enviar un correo NewsLetter personalizado al cliente.
Version:      1.0
Author:       jjosesl1993
Author URI:
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  Catch Buyer
Domain Path:  /languages
*/

include('functions.php');

add_action('admin_enqueue_scripts', 'style_css');

function style_css(){
    wp_enqueue_style('style-name1', plugins_url('/css/style.css',__FILE__));
}

register_deactivation_hook( __FILE__, 'pluginUninstall' );

function pluginUninstall() {

    global $wpdb;

    $table1 = $wpdb->prefix."status_array";
    $wpdb->query("DROP TABLE IF EXISTS $table1");

    $table2 = $wpdb->prefix."status_button";
    $wpdb->query("DROP TABLE IF EXISTS $table2");

    $table3 = $wpdb->prefix."status_mailing";
    $wpdb->query("DROP TABLE IF EXISTS $table3");
}

register_activation_hook(__FILE__,'status_button_table');

function status_button_table(){
    global $wpdb;

    $table_name=$wpdb->prefix . 'status_button';

    $charset_collate=$wpdb->get_charset_collate();

    $sql= "CREATE TABLE IF NOT EXISTS $table_name(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        id_button mediumint(9) NOT NULL,
        status_button text NOT NULL,
        UNIQUE KEY id(id)
    ) $charset_collate;";

    $wpdb->query($sql);
}

register_activation_hook(__FILE__,'status_mailing_table');

function status_mailing_table(){
    global $wpdb;

    $table_name=$wpdb->prefix . 'status_mailing';

    $charset_collate=$wpdb->get_charset_collate();

    $sql= "CREATE TABLE IF NOT EXISTS $table_name(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        id_button mediumint(9) NOT NULL,
        status_button text NOT NULL,
        UNIQUE KEY id(id)
    ) $charset_collate;";

    $wpdb->query($sql);
}

register_activation_hook(__FILE__,'status_array_table');

function status_array_table(){
    global $wpdb;

    $table_name=$wpdb->prefix . 'status_array';

    $charset_collate=$wpdb->get_charset_collate();

    $sql= "CREATE TABLE IF NOT EXISTS $table_name(
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        id_shop_order mediumint(9) NOT NULL,
        arrayy text,
        UNIQUE KEY id(id)
    ) $charset_collate;";

    $wpdb->query($sql);
}

add_action('admin_menu', 'admin_page');

if( ! function_exists('admin_page')){
    function admin_page(){
        add_menu_page(
            'Catch Buyer',
            'Catch Buyer',
            'manage_options',
            'catch_buyer',
            'page_display',
            '',
            '15'
        );
    }
}

if( ! function_exists('page_display')) {
    function page_display(){
        if( current_user_can('manage_options'))
        {
            $clients = get_users(array('fields' => array('ID', 'display_name', 'user_email')));
            $cont_add_checkbox=0;

            // Devuelve ID y Nombre de los usuarios ("clientes")
            foreach ($clients as $user) {
                echo '<div class="global"><br>Cliente: ' . ($user -> display_name) . ' (ID->';
                echo ($user->ID) . ')' .'</br><br>';
                $email=$user->user_email;

                // Devuelve el estado y el ID de los pedidos de cada usuario
                $id_us=($user->ID);
                $customer_orders = get_posts( array(
                    'ID'          => wc_get_customer_order_count($id_us),
                    'numberposts' => -1,
                    'meta_key'    => '_customer_user',
                    'meta_value'  => $id_us,
                    'post_type'   => wc_get_order_types(),
                    'post_status' => array_keys( wc_get_order_statuses() ),
                ) );

                foreach ($customer_orders as $purchases) {
                    /*echo '<span>' . esc_html($purchases->post_type) . '</span>->';
                    echo '<span>' . esc_html($purchases->ID) . '</span> ';
                    echo '<span>(' . esc_html($purchases->post_status) . ')</span><br>';*/
                    echo '<div class="order">' . ($purchases->post_type) ."   ID->".($purchases->ID)."   (".($purchases->post_status).")";
                    //echo '</div>';

                    $order = wc_get_order($purchases->ID);
                    $items = $order->get_items();
                    $array_cat = array();

                    echo "<div class='products_order'>";
                    echo "Productos del pedido:";

                    foreach ($items as $item) {
                        $product_name = $item->get_name();
                        $product_id = $item->get_product_id();
                        $product_cat = wc_get_product_category_list($product_id);
                        $array_cat[] = $product_cat;

                        echo "<li>".($product_name) . ' ID->';
                        echo ($product_id) . ' (';
                        echo ($product_cat) . ')<br></li>';
                    }
                    echo "</div>";

                    //Eliminar categorias repetidas
                    $array_norepet_cat = array();
                    foreach ($array_cat as $value){
                        if(!in_array($value, $array_norepet_cat)){
                            $array_norepet_cat[]=$value;
                        }
                    }

                    //Comparación de Categorias (Productos de pedido VS Entradas)
                    $name_cat=post_cat();
                    $interest_post=array();

                    global $wpdb;
                    $consulta="select * from wp_status_array where id_shop_order=".$purchases->ID;
                    if ($wpdb->get_row($consulta)==0) {
                        $wpdb->insert(
                            "wp_status_array",
                            array('id_shop_order'=>$purchases->ID, 'arrayy'=>json_encode($interest_post))
                        );
                    }

                    echo "<div class='interest'>";
                    echo "Entradas que pueden interesar:"."<br>";

                    foreach ($name_cat as $k1=>$v1) {
                        foreach ($array_norepet_cat as $k2=>$v2){
                            list ($strA1,$strA2)=explode(">", $v1);
                            /*echo "Entradas   ". $strA2. "<br><br>";
                            var_dump(substr($v1, 2));
                            echo "<br><br>"."<br><br>";*/
                            list ($strB1,$strB2)=explode(">", $v2);
                            /*echo "Productos  ". $strB2. "<br><br>";
                            var_dump(substr($v2, 2));
                            echo "<br><br>"."<br><br>";*/

                            if($strA2==$strB2) {
                                echo "<li>"."Esto le puede interesar! "."<br>";
                                $interest_post[]=$v1;

                                /*global $wpdb;
                                $result = $wpdb->get_var("SELECT arrayy FROM `wp_status_array` WHERE id_shop_order = '$purchases->ID'");
                                $actuales = json_decode($result);

                                if (!in_array($v1, $actuales)) {
                                    $wpdb->update("wp_status_array",array('id_shop_order'=>$purchases->ID, 'arrayy'=>json_encode($interest_post)), array('id_shop_order'=>$purchases->ID ));
                                }*/

                                ?>
                                <input type="checkbox" id='<?php echo $cont_add_checkbox; ?>' name='<?php echo $v1; ?>'
                                       value='<?php echo $purchases->ID; ?>' class="chb" onclick="javascript:func(this.id, this.name, this.value);">
                                <?php
                                echo $v1;

                                global $wpdb;
                                $consulta="select * from wp_status_button where id_button=".$cont_add_checkbox;
                                if ($wpdb->get_row($consulta)==0) {
                                    $wpdb->insert(
                                        "wp_status_button",
                                        array('id_button'=>$cont_add_checkbox, 'status_button'=>"no_checked")
                                    );
                                }

                                check_status();

                                ?>
                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                <script language="javascript">
                                    function func(cont,cat, value)
                                    {
                                        var chb = document.getElementsByClassName('chb');

                                        if(chb[cont].checked)
                                        {
                                            $.post('../wp-content/plugins/news/add.php', {cont:cont, cat:cat, value:value},
                                                function(returnedData){
                                                    console.log(returnedData);
                                                });
                                        }

                                        if(!chb[cont].checked)
                                        {
                                            $.post('../wp-content/plugins/news/remove.php', {cont:cont, cat:cat, value:value},
                                                function(returnedData){
                                                    console.log(returnedData);
                                                });
                                        }
                                    }
                                </script><?php

                                $cont_add_checkbox=$cont_add_checkbox+1;

                            }
                            echo "</li>";
                        }
                    }
                    echo "<li>";

                    //Boton Añadir
                    echo "Añadir otras: ";
                    foreach (post_cat() as $new_category_to_send) {
                        if(!in_array($new_category_to_send, $interest_post)) {
                            ?>
                            <input type="checkbox" id='<?php echo $cont_add_checkbox; ?>'
                                   name='<?php echo $new_category_to_send; ?>'
                                   value='<?php echo $purchases->ID; ?>' class="chb"
                                   onclick="javascript:func(this.id, this.name, this.value);">
                            <?php
                            echo $new_category_to_send . '<br>';

                            global $wpdb;
                            $consulta = "select * from wp_status_button where id_button=" . $cont_add_checkbox;
                            if ($wpdb->get_row($consulta) == 0) {
                                $wpdb->insert(
                                    "wp_status_button",
                                    array('id_button' => $cont_add_checkbox, 'status_button' => "no_checked")
                                );
                            }

                            check_status();

                            ?>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <script language="javascript">
                                function func(cont, cat, value) {
                                    var chb = document.getElementsByClassName('chb');

                                    if (chb[cont].checked) {
                                        $.post('../wp-content/plugins/news/add.php', {
                                                cont: cont,
                                                cat: cat,
                                                value: value
                                            },
                                            function (returnedData) {
                                                console.log(returnedData);
                                            });
                                    }

                                    if (!chb[cont].checked) {
                                        $.post('../wp-content/plugins/news/remove.php', {
                                                cont: cont,
                                                cat: cat,
                                                value: value
                                            },
                                            function (returnedData) {
                                                console.log(returnedData);
                                            });
                                    }
                                }
                            </script><?php

                            $cont_add_checkbox = $cont_add_checkbox + 1;
                        }
                    }
                    echo "</li>";

                    /*echo "Estas son las entradas del envio: ";

                    global $wpdb;
                    $result = $wpdb->get_var("SELECT arrayy FROM `wp_status_array` WHERE id_shop_order = '$purchases->ID'");
                    $post_to_send = json_decode($result);

                    foreach ($post_to_send as $v2) {
                        echo ($v2)."; ";
                    }*/

                    //Boton enviar
                    echo '<form action="" method="post">';
                    echo '<input type="submit" value="Enviar" name='. $purchases->ID .' />';
                    echo '</form>';

                    global $wpdb;
                    $consulta = "select * from wp_status_mailing where id_button=" . $purchases->ID;
                    if ($wpdb->get_row($consulta) == 0) {
                        $wpdb->insert(
                            "wp_status_mailing",
                            array('id_button' => $purchases->ID, 'status_button' => "no_sent")
                        );
                    }

                    //Envio automático, una sola vez por pedido, el dia 1 del mes siguiente a la fecha del pedido
                    global $wpdb;
                    $sent = $wpdb->get_var("SELECT status_button FROM wp_status_mailing WHERE id_button = '$purchases->ID'");

                    if($sent=="no_sent"){
                        echo "Envío automático el día 1 del siguiente mes.";
                    }else{
                        echo "Envio automático ya realizado";
                    }

                    if((date(d)=="01")&&($sent=="no_sent")){
                        global $wpdb;
                        $result = $wpdb->get_var("SELECT arrayy FROM `wp_status_array` WHERE id_shop_order = '$purchases->ID'");
                        send_email($email,$result);
                        $wpdb->query($wpdb->prepare(
                            "
                                    UPDATE wp_status_mailing 
                                    SET status_button = %s
                                    WHERE id_button = %d
                                   ",
                            "sent", $purchases->ID
                        ));
                    }

                    //Comprobación del boton enviar
                    if(isset($_POST[$purchases->ID])){
                        global $wpdb;
                        $result = $wpdb->get_var("SELECT arrayy FROM `wp_status_array` WHERE id_shop_order = '$purchases->ID'");
                        send_email($email,$result);
                    }

                    echo "</div>";
                    echo '</div>';

                }

                echo "</div>";
            }

        }
    }

}


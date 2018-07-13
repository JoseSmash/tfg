<?php
/**
 * Created by PhpStorm.
 * User: Jose
 * Date: 07/05/2018
 * Time: 17:04
 */

function post_cat(){
    $cat_argtos=array(
        'orderby' => 'name',
        'order' => 'ASC'
    );
    $categorias=get_categories($cat_argtos);
    $array_cat=array();
    foreach($categorias as $categoria) {
        $args=array(
            'showposts' => -1,
            'category__in' => array($categoria->term_id),
            'caller_get_posts'=>1
        );
        $entradas=get_posts($args);

        if ($entradas) {
            $nueva='<a href="' . (get_category_link( $categoria->term_id )) . '" title="' . sprintf(__("Mostrar todas entradas en %s"), $categoria->name) . '"' . '>' . $categoria->name . '</a>';
            $array_cat[]=$nueva;
            foreach($entradas as $post) {
                setup_postdata($post);
                ?>
                <p><a href="<?php the_permalink() ?>" rel="bookmark" title="Enlace permanente a <?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
                <?php
            }
        }
    }
    return $array_cat;
}

function check_status(){
    global $wpdb;
    $checked = $wpdb->get_col("SELECT id_button FROM wp_status_button WHERE status_button = 'checked'");
    foreach ($checked as $check){
        ?>
        <script>
            jQuery("<?php echo '#'.$check ?>").attr("checked", true);
        </script>
        <?php
    }
}

function send_email($email_to, $message_post){
    $to=$email_to;
    $subject="Herbolario Triana";
    $array_deco=json_decode($message_post);

    $cabeceras = "X-Mailer:PHP/".phpversion()."\n";
    $cabeceras .= 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $cabeceras .= 'To: '.$email_to. "\r\n";

    $pos0 = substr($array_deco[0], 10);
    $end0 = strrpos($pos0, '\" title=');
    $pos0 = substr($array_deco[0], 10, $end0);

    $pos1 = substr($array_deco[1], 10);
    $end1 = strrpos($pos1, '\" title=');
    $pos1 = substr($array_deco[1], 10, $end1);

    $pos2 = substr($array_deco[2], 10);
    $end2 = strrpos($pos2, '\" title=');
    $pos2 = substr($array_deco[2], 10, $end2);

    $pos3 = substr($array_deco[3], 10);
    $end3 = strrpos($pos3, '\" title=');
    $pos3 = substr($array_deco[3], 10, $end3);

    $pos4 = substr($array_deco[4], 10);
    $end4 = strrpos($pos4, '\" title=');
    $pos4 = substr($array_deco[4], 10, $end4);

    $pos5 = substr($array_deco[5], 10);
    $end5 = strrpos($pos5, '\" title=');
    $pos5 = substr($array_deco[5], 10, $end5);

    /*$image = 'wp-content/plugins/news/images/logo.png';
    // Read image path, convert to base64 encoding
    $imageData = base64_encode(file_get_contents($image));
    // Format the image SRC:  data:{mime};base64,{data};
    $src = 'data: '.mime_content_type($image).';base64,'.$imageData;
    // Echo out a sample image
    //echo '<img src="' . $src . '">';*/

    $message ="
    <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
    <html xmlns=\"http://www.w3.org/1999/xhtml\">
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"UTF-8\" />
        <title>Herbolario Triana</title>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"/>
    </head>
    <body style=\"margin: 0; padding: 0;\">
    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
        <tr>
            <td style=\"padding: 10px 0 30px 0;\">
                <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"border: 1px solid #cccccc; border-collapse: collapse;\">
                    <tr>
                        <td align=\"center\" bgcolor=\"#228B22\" style=\"padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;\">
							<img src=\"wp-content/plugins/news/images/logo.png\" alt=\"Herbolario Triana\" width=\"300\" height=\"230\" style=\"display: block;\" />
						</td>
                    </tr>
                    <tr>
                        <td bgcolor=\"#ffffff\" style=\"padding: 40px 30px 40px 30px;\">
                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                <tr>
                                    <td style=\"color: #153643; font-family: Arial, sans-serif; font-size: 20px;\">
                                        <b>Tu herbolario de toda la vida, ahora tambien online.</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 15px; line-height: 20px;\">
                                        <a href=\"http://localhost/copia/\"> Herbolario Triana</a>
                                         es una empresa dedicada a la medicina natural y dietetica. Con nosotros encontrara los mejores productos para una vida sana y natural.
                                        Tenemos como principal objetivo entregar satisfaccion a todos los que nos visitan, por ello, ofrecemos productos garantizados y los precios mas competitivos con la mejor calidad-precio de la zona.
                                        Pidanos informacion, daremos soluciones integrales a todas sus inquietudes.
                                    </td>
                                </tr>
                                <tr>
                                    <td align=\"center\" style=\"padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 22px; line-height: 20px;\">
                                        Gracias por confiar en nosotros!
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                            <tr>
                                                <td width=\"260\" valign=\"top\">
                                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                                        <tr>
                                                        <td align='center' style=\"color: #153643; font-family: Arial, sans-serif; font-size: 15px;\">
                                                                <b>Estas entradas de nuestro blog pueden resultarte interesantes:</b>
                                                            </td
                                                        </tr>
                                                        <tr>
                                                            <td style=\"padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 15px; line-height: 20px;\">                                                               
                                                                <a href= $pos0> $pos0 </a><br>
                                                                <a href= $pos1> $pos1</a><br>
                                                                <a href= $pos2> $pos2</a><br>
                                                                <a href= $pos3> $pos3</a><br>
                                                                <a href= $pos4> $pos4</a><br>
                                                                <a href= $pos5> $pos5</a><br>                                                                                                                                                                                                             
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                            <tr>
                                                <td style=\"font-size: 0; line-height: 0;\" width=\"20\">
                                                    &nbsp;
                                                </td>
                                                <td width=\"260\" valign=\"top\">
                                                    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">                                            
                                                        <tr>
                                                            <td class=\"small\" width=\"20%\" style=\"vertical-align: top; padding-right:10px;\"><img src=\"wp-content/plugins/news/images/promociones.jpg\" /></td>
                                                            <td>
                                                                <h4>PROMOCIONES</h4>
                                                                <p class=\"\">Este mes si tu compra ha sido superior a 20e participaras automaticamente en el sorteo de un tabla hecha a tu medida para perder peso!!</p>
                                                                <a href='http://localhost/copia/2018/07/06/promociones/'>Click aqui para ver mas &raquo;</a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>                                    
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor=\"#228B22\" style=\"padding: 30px 30px 30px 30px;\">
                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
                                <tr>
                                    <td style=\"color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;\" width=\"75%\">
                                        &reg; Herbolario Triana 2018	<br/>
                                        <a href=\"#\" style=\"color: #ffffff;\"><font color=\"#ffffff\">Eliminar</font></a> tu suscripcion al Newsletter
                                    </td>
                                    <td align=\"right\" width=\"25%\">
                                        <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
                                            <tr>
                                                <td style=\"font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;\">
                                                    <a href=\"https://www.facebook.com/Herbolario-Triana-Santiveri-134281380009306/\" style=\"color: #ffffff;\">
                                                        <img src=\"wp-content/plugins/news/images/facebook.png\" alt=\"Facebook\" width=\"38\" height=\"38\" style=\"display: block;\" border=\"0\" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>
    ";
    //$headers="Hola, gracias por las compras!!";
    //$attachments=$message_post;
    //$attachments="aqui estarian los enlaces de las entradas de interes";

    mail( $to, $subject, $message, $cabeceras);
    echo '<br>'.'Mensaje enviado a '. $to .'!';
}


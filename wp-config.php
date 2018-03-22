<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'copia');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'o*o=WV,4wJ*zxuvBu)|guPQp~C[F_t,J_Ui-Ci9GB13%X8C]YF jD[^8ZrL>v|^;');
define('SECURE_AUTH_KEY', 'sL;D..K={j@P3lV^ZdA?lVTS~!1.9mkoNQ 5Vk@yelaCya(wP[M)2]w-C!rYF(W_');
define('LOGGED_IN_KEY', 'mCxdd?sd8^ T3tc<,hh@!gPO$ow:wH!|X<&HwZnzsxWx8Ik2(Z]xdw+ZwCm+D*y[');
define('NONCE_KEY', 'rSLVU0)nJ& =nUK`@(}r?$5<-R/TEap)x2[%fRx`IH_tUttaZb{HY;rV@dS.~U[D');
define('AUTH_SALT', 'vmBg?yJM1pA(4c~<|N[9tBG9@g1vYO@d/fH- *%sh9u`Y2=7Dpl_vHqj)d|^NF>)');
define('SECURE_AUTH_SALT', ')O;mo)j!p5Ll7w@1dHPHi8[gkH>8IW{utBO*{K0dX%oWc38Q-iK^:*?VKB%bX3n2');
define('LOGGED_IN_SALT', '3~~+A/c][}P}3.T7$ZqP[)ZSPHPTY]N+4g218,/c=Q$/r3*z6H1FbH_y].$Gq !q');
define('NONCE_SALT', '50rr6=gm/<XhvBddVD,HD!f#(?EE05+w-nrXz3wqnGyoJe#|&XjMCdU6K&,A{8p0');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


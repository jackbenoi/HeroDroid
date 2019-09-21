<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'herodroid_db' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'wom2jU1HI>t &`Mt?]6Vt| iPUY/$1[7#>-9]rJNxb]k)>$#|atqK(m[ijF$K;Y5' );
define( 'SECURE_AUTH_KEY',  'x,`%H_L]vRcF};n)%rfa[b.%q7x&RHGNiunVB~nvr+_I,lA!p:O # 1)J0QVv$LD' );
define( 'LOGGED_IN_KEY',    'qdc|Ij?>aoz^I|ZsOf1j?^?~;8FNe{=C~GSa>tbkueeGURcE>v`f^8}v#D!dSVbr' );
define( 'NONCE_KEY',        'sW^%G>ti7[Hj VC2O8+F3lA%_q 4zBE.|sLoCea|<pm[|k-z(n;Z?7co/G1ha|+3' );
define( 'AUTH_SALT',        'Y2ZE|/&tz`XN.?I91rS(V3xx:O(ZwI@go%8C*cn|-x+}Z:{Y(+H9T|Ch;Wt`8fYi' );
define( 'SECURE_AUTH_SALT', '>bgTWu)E[G`sm-_LB_;lV0,?NrNhjm+>.*PW**R A*3|P_-f0FlsHZ&/J]=}{?O^' );
define( 'LOGGED_IN_SALT',   'pLj*ef67{`m+aV%g?[=}yD^L$wvGnHU.F(j6#+u&q;Y]zl`t#sQGTR@#_oM(<)%&' );
define( 'NONCE_SALT',       'U<Rco$0.SrY16!^9ix:$oZo*a[>/x(.e;,;RH72j!cp)#[iJu/(!TyK7S{?xVkxi' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');

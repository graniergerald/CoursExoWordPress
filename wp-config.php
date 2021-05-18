<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'wordpressV3' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'GGRANIER' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'TRboulot=1409' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ny,f+7+1DQh:KlA1qw5Te/ ~6Su*6sNc]P2?_^11``}SYdpmaPP}@$u.Gi^R1A<:' );
define( 'SECURE_AUTH_KEY',  '5GBNGN^45oJp1zsR9yzvg7p_Y~i4|CXnqb0JvK2^a$2{sf.a7]UD?_&(Bl)mPx>R' );
define( 'LOGGED_IN_KEY',    '@IRGlVhO ?^*44B%tBK^|7bZ=R DJUgWH^Cn,;PDP4>c`KTG?pgPk$=Y85:j-i)(' );
define( 'NONCE_KEY',        '~5L v(V/64`3!*lecYgC$oG]3pT{0}o!x|tj>S&VIgMQ!9*~TMI+OA8uRIva3<(m' );
define( 'AUTH_SALT',        '25cV.;M[sW2UT# ^zj~Tz3vrPsBn]0g>y?W(f[^K{&_E Y3Pr(y$<`?]D[e:2Q2U' );
define( 'SECURE_AUTH_SALT', '>{Jt?ZL-*{`0A}RMcJ/mv*|-wb;B6k2m*1<p1Gm$l2W4h&5g$KXCzOBzwD^HKZq~' );
define( 'LOGGED_IN_SALT',   '~Dw#:X`%, ,>?tr8TxB4zwF+}~-Dfd(5raE}qxT=Cy]rd<Cpc@:bF8=r2TRQz:p<' );
define( 'NONCE_SALT',       '+H CY[>kErD}TeppHn?sQcn}mCRidl}3GBAd1yqBj6(bLO$(g,Ay}~RDcnz,`%Ut' );
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
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );

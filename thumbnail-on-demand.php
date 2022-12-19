<?php
/**
 * Thumbnail on demand
 *
 * @author    AmphiBee
 *
 * @link      https://amphibee.fr
 *
 * @copyright 2019-2022 AmphiBee
 *
 * @wordpress-plugin
 * Plugin Name:  Thumbnail On Demand
 * Plugin URI:   https://amphibee.fr
 * Description:  Generate thumbnails on demand
 * Version:      1.0
 * Author:       AmphiBee
 * Author URI:   https://amphibee.fr
 * License:      GPL-3.0-or-later
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.html
 */

// setup plugin activator and deactivator
use AmphiBee\ThumbnailOnDemand\Medias\Resizer;

include dirname(__FILE__).DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');

new Resizer();

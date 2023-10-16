<?php

/**
 * Thumbnail on demand
 *
 * @author    AmphiBee
 *
 * @link      https://amphibee.fr
 *
 * @copyright 2019-2023 AmphiBee
 *
 * @wordpress-plugin
 * Plugin Name:  Thumbnail On Demand
 * Plugin URI:   https://amphibee.fr
 * Description:  Generate thumbnails on demand
 * Version:      1.3
 * Author:       AmphiBee
 * Author URI:   https://amphibee.fr
 * License:      GPL-3.0-or-later
 * License URI:  https://www.gnu.org/licenses/gpl-3.0.html
 */

declare(strict_types=1);

use AmphiBee\ThumbnailOnDemand\Providers\ResizerEventHandlers;

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

register_activation_hook(__FILE__, 'flush_rewrite_rules');
register_deactivation_hook(__FILE__, 'flush_rewrite_rules');

new ResizerEventHandlers();

<?php
/**
 * @link http://felixwelberg.de
 * @since 1.0.0
 * @package Sis_Handball
 *
 * Plugin Name: SIS Handball
 * Plugin URI: http://felixwelberg.de
 * Description: Show statistics and data provided by sis-handball.de. Tables, scores and next games.
 * Version: 1.0.37
 * Author: Felix Welberg
 * Author URI: http://felixwelberg.de/
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: sis-handball
 * Domain Path: /languages
 */
if (!defined('WPINC')) {
    die;
}

__('Show statistics and data provided by sis-handball.de. Tables, scores and next games.', 'sis-handball');

/**
 * @since 1.0.0
 */
function activate_sis_handball()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sis-handball-activator.php';
    Sis_Handball_Activator::activate();
}
register_activation_hook(__FILE__, 'activate_sis_handball');

/**
 * @since 1.0.0
 */
function deactivate_sis_handball()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sis-handball-deactivator.php';
    Sis_Handball_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_sis_handball');

require plugin_dir_path(__FILE__) . 'includes/class-sis-handball.php';

/**
 * @since 1.0.0
 */
function run_sis_handball()
{
    $plugin = new Sis_Handball();
    $plugin->run();
}
run_sis_handball();

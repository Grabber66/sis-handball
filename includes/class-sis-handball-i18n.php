<?php

/**
 * @link http://felixwelberg.de
 * @since 1.0.0
 *
 * @package Sis_Handball
 * @subpackage Sis_Handball/includes
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_i18n
{

    /**
     * @since 1.0.0
     */
    public static function load_plugin_textdomain()
    {
        load_plugin_textdomain(
            'sis-handball', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}

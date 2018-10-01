<?php

/**
 * @link http://felixwelberg.de
 * @since 1.0.0
 *
 * @package Sis_Handball
 * @subpackage Sis_Handball/includes
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_Deactivator
{

    /**
     * @since 1.0.0
     */
    public static function deactivate()
    {
        Sis_Handball_Deactivator::remove_database();
    }

    /**
     * @since 1.0.0
     */
    private static function remove_database()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "sis_cache";

        $sql = "DROP TABLE $table_name;";
        $wpdb->query($sql);
    }
}

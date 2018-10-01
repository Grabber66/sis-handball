<?php

/**
 * @link http://felixwelberg.de
 * @since 1.0.0
 *
 * @package Sis_Handball
 * @subpackage Sis_Handball/includes
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_Activator
{

    /**
     * @since 1.0.0
     */
    public static function activate()
    {
        Sis_Handball_Activator::create_database();
    }

    /**
     * @since 1.0.0
     */
    private static function create_database()
    {
        global $wpdb;
        $table_name_1 = $wpdb->prefix . "sis_cache";
        $table_name_2 = $wpdb->prefix . "sis_snapshots";
        $table_name_3 = $wpdb->prefix . "sis_monitoring";
        $table_name_4 = $wpdb->prefix . "sis_concatenations";
        $table_name_5 = $wpdb->prefix . "sis_concatenation_conditions";
        $table_name_6 = $wpdb->prefix . "sis_string_replace";

        $sql = "CREATE TABLE $table_name_1 (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                cache_time varchar(55) NOT NULL,
                cache longtext NOT NULL,
                url longtext NOT NULL,
                type varchar(100) NOT NULL,
                PRIMARY KEY  (id)
            );
            CREATE TABLE $table_name_2 (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                snapshot_time varchar(55) NOT NULL,
                snapshot longtext NOT NULL,
                snapshot_code varchar(100) NOT NULL,
                fired_shortcode longtext NOT NULL,
                comment longtext NOT NULL,
                PRIMARY KEY  (id)
            );
            CREATE TABLE $table_name_3 (
                id int(11) NOT NULL AUTO_INCREMENT,
                monitoring_time varchar(55) NOT NULL,
                position int(3) NOT NULL,
                team longtext NOT NULL,
                gameday int(3) NOT NULL,
                url longtext NOT NULL,
                PRIMARY KEY (id)
            );
            CREATE TABLE $table_name_4 (
                id int(11) NOT NULL AUTO_INCREMENT,
                concatenation_time varchar(55) NOT NULL,
                type varchar(100) NOT NULL,
                comment longtext NOT NULL,
                PRIMARY KEY (id)
            );
            CREATE TABLE $table_name_5 (
                id int(11) NOT NULL AUTO_INCREMENT,
                concatenation_id int(22) NOT NULL,
                condition_time varchar(55) NOT NULL,
                data longtext NOT NULL,
                comment longtext NOT NULL,
                PRIMARY KEY (id)
            );
            CREATE TABLE $table_name_6 (
                id int(11) NOT NULL AUTO_INCREMENT,
                source_string longtext NOT NULL,
                replace_string longtext NOT NULL,
                PRIMARY KEY (id)
            );
        ";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

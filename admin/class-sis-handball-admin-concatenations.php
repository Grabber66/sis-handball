<?php

/**
 * Concatenation functionality
 * 
 * @link http://felixwelberg.de
 * @since 1.0.22
 * @package Sis_Handball
 * @subpackage Sis_Handball/admin
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_Admin_Concatenations
{

    /**
     * Generates new and empty concatenation
     * 
     * @since 1.0.16
     * @global type $wpdb
     * @param type $post
     * @return type
     */
    public static function create($post = array())
    {
        global $wpdb;
        $type = $post['sis_handball_concatenation_type'];
        $type = 'next_games_multi_teams'; // Beta!!!
        $comment = $post['sis_handball_concatenation_comment'];
        $wpdb->insert($wpdb->prefix . 'sis_concatenations', array('concatenation_time' => time(), 'type' => $type, 'comment' => $comment));
        return $wpdb->get_var('SELECT id FROM ' . $wpdb->prefix . 'sis_concatenations ORDER BY id DESC LIMIT 1');
    }

    /**
     * Deletes concatenation
     * 
     * @since 1.0.16
     * @global type $wpdb
     * @param type $id
     * @return type
     */
    public static function delete($id = 0)
    {
        global $wpdb;
        $wpdb->delete($wpdb->prefix . 'sis_concatenation_conditions', array('concatenation_id' => $id));
        return $wpdb->delete($wpdb->prefix . 'sis_concatenations', array('id' => $id));
    }

    /**
     * Returns array of concatenation conditions
     * 
     * @since 1.0.16
     * @global type $wpdb
     * @param type $concatenation_id
     * @return type
     */
    public static function get_conditions($concatenation_id = 0)
    {
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'sis_concatenation_conditions WHERE concatenation_id = ' . $concatenation_id);
        return $results;
    }

    /**
     * Retrieve teams from sis table
     * 
     * @since 1.0.16
     * @global type $wpdb
     * @param type $post
     * @return type
     */
    public static function create_condition($post = array())
    {
        global $wpdb;
        $atts = array();
        $atts['league'] = $post['sis_handball_concatenation_league_id'];
        $atts['type'] = 'next';
        $atts['limit'] = 1;
        $serialized_atts = serialize($atts);
        return $wpdb->insert($wpdb->prefix . 'sis_concatenation_conditions', array('concatenation_id' => $post['cid'], 'condition_time' => time(), 'data' => $serialized_atts, 'comment' => $post['sis_handball_concatenation_comment']));
    }

    /**
     * Deletes concatenation condition
     * 
     * @since 1.0.21
     * @global type $wpdb
     * @param type $post
     * @return type
     */
    public static function delete_condition($post = array())
    {
        global $wpdb;
        return $wpdb->delete($wpdb->prefix . 'sis_concatenation_conditions', array('id' => $post['condition_id']));
    }
}

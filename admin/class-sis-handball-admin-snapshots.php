<?php

/**
 * Snapshot functionality
 * 
 * @link http://felixwelberg.de
 * @since 1.0.22
 * @package Sis_Handball
 * @subpackage Sis_Handball/admin
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_Admin_Snapshot
{

    /**
     * Generates snapshot structure
     * 
     * @since 1.0.5
     * @param type $post
     * @return type
     */
    public static function prepare($post = array())
    {
        $shortcode = $post['sis_handball_snapshot_shortcode'];
        $comment = $post['sis_handball_snapshot_comment'];
        $atts = Sis_Handball_Admin::extract_shortcode_atts($shortcode, 'sishandball');
        $result = Sis_Handball_Public::shortcode_sis_handball($atts, '', 'sishandball', TRUE);
        return Sis_Handball_Admin_Snapshot::create($result, $shortcode, $comment);
    }

    /**
     * Save snapshot data
     * 
     * @since 1.0.5
     * @global type $wpdb
     * @param type $data
     * @param type $shortcode
     * @param type $comment
     * @return boolean
     */
    public static function create($data = array(), $shortcode = '', $comment = '')
    {
        global $wpdb;
        $time = time();
        $rand = rand(100, 999);
        $snapshot_code = $rand . $time;
        if ($data) {
            return $wpdb->insert($wpdb->prefix . 'sis_snapshots', array('snapshot_time' => time(), 'snapshot' => serialize($data), 'snapshot_code' => $snapshot_code, 'fired_shortcode' => stripslashes_deep($shortcode), 'comment' => $comment));
        } else {
            return FALSE;
        }
    }

    /**
     * Update snapshot data
     * 
     * @since 1.0.22
     * @global type $wpdb
     * @param type $data
     * @return type
     */
    public static function edit($data = array())
    {
        global $wpdb;
        return $wpdb->update($wpdb->prefix . 'sis_snapshots', $data['snapshot'], array('id' => $data['snapshot']['id']));
    }

    /**
     * Delete snapshot by given id
     * 
     * @since 1.0.6
     * @global type $wpdb
     * @param type $id
     * @return type
     */
    public static function delete($id = 0)
    {
        global $wpdb;
        return $wpdb->delete($wpdb->prefix . 'sis_snapshots', array('id' => $id));
    }

    /**
     * Get single snapshot data by id
     * 
     * @since 1.0.22
     * @global type $wpdb
     * @param type $id
     * @return type
     */
    public static function get($id = 0)
    {
        global $wpdb;
        return $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'sis_snapshots WHERE id = ' . $id);
    }
}

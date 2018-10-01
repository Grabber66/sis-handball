<?php

/**
 * The concatenations table
 * 
 * @link http://felixwelberg.de
 * @since 1.0.22
 * @package Sis_Handball
 * @subpackage Sis_Handball/admin
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_Admin_Table_Concatenations extends WP_List_Table
{

    /**
     * Initialize the table
     *
     * @since 1.0.22
     */
    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'sis_handball_table_concatenation',
            'plural' => 'sis_handball_table_concatenations',
            'ajax' => false
        ));
    }

    /**
     * Define columns
     * 
     * @since 1.0.22
     * @return type
     */
    public function get_columns()
    {
        return $columns = array(
            'id' => __('ID', 'sis-handball'),
            'comment' => __('Comment', 'sis-handball'),
            'shortcode' => __('Shortcode', 'sis-handball'),
            'concatenation_time' => __('Created', 'sis-handball'),
        );
    }

    /**
     * Define sortable columns
     * 
     * @since 1.0.22
     * @return type
     */
    public function get_sortable_columns()
    {
        return $sortable = array(
            'id' => array('id', true)
        );
    }

    /**
     * Default column handling
     * 
     * @since 1.0.22
     * @param type $item
     * @param type $column_name
     * @return type
     */
    public function column_default($item, $column_name)
    {

        switch ($column_name) {
            case 'id':
            case 'concatenation_time':
            case 'comment':
            case 'shortcode':
                return ucfirst($item->$column_name);
            default:
                return print_r($item, true);
        }
    }

    /**
     * Id column handling
     * 
     * @since 1.0.22
     * @param type $item
     * @return type
     */
    public function column_id($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">' . __('Edit', 'sis-handball') . '</a>', $_REQUEST['page'], 'edit', $item->id),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">' . __('Delete', 'sis-handball') . '</a>', $_REQUEST['page'], 'delete', $item->id),
        );
        return sprintf('%1$s %2$s', $item->id, $this->row_actions($actions));
    }

    /**
     * Concatenation time column handling
     * 
     * @since 1.0.22
     * @param type $item
     * @return type
     */
    public function column_concatenation_time($item)
    {
        $returner = date('d.m.Y - H:i', $item->concatenation_time);
        return sprintf('%1$s %2$s', $returner, false);
    }

    /**
     * Shortcode column handling
     * 
     * @since 1.0.22
     * @param type $item
     * @return type
     */
    public function column_shortcode($item)
    {
        $the_shortcode = '[sishandball type=&quot;concat&quot; id=&quot;' . $item->id . '&quot;]';
        $returner = $the_shortcode;
        return sprintf('%1$s %2$s', $returner, false);
    }

    /**
     * Get table data from db
     * 
     * @since 1.0.22
     * @global type $wpdb
     * @global type $_wp_column_headers
     */
    public function prepare_items()
    {
        global $wpdb, $_wp_column_headers;
        $query = 'SELECT * FROM ' . $wpdb->prefix . 'sis_concatenations';
        $orderby = !empty($_GET['orderby']) ? $_GET['orderby'] : '';
        $order = !empty($_GET['order']) ? $_GET['order'] : '';
        if (!empty($orderby) & !empty($order)) {
            $query .= ' ORDER BY ' . esc_sql($orderby) . ' ' . esc_sql($order);
        }
        $totalitems = $wpdb->query($query);
        $perpage = 10;
        $paged = !empty($_GET["paged"]) ? $_GET["paged"] : '';
        if (empty($paged) || !is_numeric($paged) || $paged <= 0) {
            $paged = 1;
        }
        $totalpages = ceil($totalitems / $perpage);
        if (!empty($paged) && !empty($perpage)) {
            $offset = ($paged - 1) * $perpage;
            $query .= ' LIMIT ' . $offset . ',' . $perpage;
        }
        $this->set_pagination_args(array(
            'total_items' => $totalitems,
            'total_pages' => $totalpages,
            'per_page' => $perpage,
        ));
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        $this->items = $wpdb->get_results($query);
    }
}

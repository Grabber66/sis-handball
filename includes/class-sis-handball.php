<?php

/**
 * @link http://felixwelberg.de
 * @since 1.0.0
 *
 * @package Sis_Handball
 * @subpackage Sis_Handball/includes
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power the plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var Sis_Handball_Loader $loader
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var string $sis_handball
     */
    protected $sis_handball;

    /**
     * The current version of the plugin.
     *
     * @since 1.0.0
     * @access protected
     * @var string $version
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->sis_handball = 'sis-handball';
        $this->version = '1.0.37';

        $this->load_dependencies();
        $this->set_locale();
        $this->set_activator();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function load_dependencies()
    {
        if (!class_exists('WP_List_Table')) {
            require_once( ABSPATH . 'wp-admin/includes/screen.php' );
            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sis-handball-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sis-handball-i18n.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sis-handball-activator.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sis-handball-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sis-handball-admin-viewhelpers.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sis-handball-admin-concatenations.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sis-handball-admin-snapshots.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sis-handball-admin-table-concatenations.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sis-handball-admin-table-snapshots.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sis-handball-public.php';
        $this->loader = new Sis_Handball_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     * 
     * @since 1.0.0
     * @access private
     */
    private function set_locale()
    {
        $plugin_i18n = new Sis_Handball_i18n();
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Define the activator for this plugin
     * 
     * @since 1.0.5
     * @access private
     */
    private function set_activator()
    {
        $plugin_activator = new Sis_Handball_Activator();
        $this->loader->add_action('plugins_loaded', $plugin_activator, 'activate');
    }

    /**
     * Register all of the hooks related to the admin area functionality of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Sis_Handball_Admin($this->get_sis_handball(), $this->get_version());
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_head', $plugin_admin, 'shortcode_generator_add_help_tab');
        $this->loader->add_action('admin_menu', $plugin_admin, 'admin_menu');
        $this->loader->add_action('wp_ajax_team_fetch', $plugin_admin, 'team_fetch');
        $this->loader->add_action('wp_ajax_delete_team_name_replace', $plugin_admin, 'ajax_delete_team_name_replace');
    }

    /**
     * Register all of the hooks related to the public-facing functionality of the plugin.
     *
     * @since 1.0.0
     * @access private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Sis_Handball_Public($this->get_sis_handball(), $this->get_version());
        $this->loader->add_action('init', $plugin_public, 'clean_cache');
        $this->loader->add_action('init', $plugin_public, 'set_wp_timezone');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        $this->loader->add_shortcode('sishandball', $plugin_public, 'shortcode_sis_handball');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality.
     *
     * @since 1.0.0
     * @return string
     */
    public function get_sis_handball()
    {
        return $this->sis_handball;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since 1.0.0
     * @return Sis_Handball_Loader
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since 1.0.0
     * @return string
     */
    public function get_version()
    {
        return $this->version;
    }
}

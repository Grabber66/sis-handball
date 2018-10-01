<?php

/**
 * Admin area viewhelpers
 * 
 * @link http://felixwelberg.de
 * @since 1.0.22
 * @package Sis_Handball
 * @subpackage Sis_Handball/admin
 * @author Felix Welberg <felix@welberg.de>
 */
class Sis_Handball_Admin_Viewhelpers
{

    /**
     * HTML structure for the settings page
     * 
     * @since 1.0.22
     * @global type $wpdb
     * @return string
     */
    public static function page_options()
    {
        global $wpdb;
        $sis_handball_default_styles_check = '';
        if (get_option('sis-handball-default-styles') == 1) {
            $sis_handball_default_styles_check = ' checked="checked"';
        }

        $sis_handball_show_cache_update_check = '';
        if (get_option('sis-handball-show-cache-update') == 1) {
            $sis_handball_show_cache_update_check = ' checked="checked"';
        }

        $sis_handball_cache_check = '';
        if (get_option('sis-handball-cache') == 1) {
            $sis_handball_cache_check = ' checked="checked"';
        }

        $sis_handball_lazyload_limit_check = '';
        if (get_option('sis-handball-lazyload-limit') == 1) {
            $sis_handball_lazyload_limit_check = ' checked="checked"';
        }

        $sis_handball_hide_errors_check = '';
        if (get_option('sis-handball-hide-errors') == 1) {
            $sis_handball_hide_errors_check = ' checked="checked"';
        }

        $sis_handball_cache_time_check_4h = '';
        $sis_handball_cache_time_check_8h = '';
        $sis_handball_cache_time_check_12h = '';
        $sis_handball_cache_time_check_1d = '';
        $sis_handball_cache_time_check_1w = '';
        if (get_option('sis-handball-cache-time') == '4h') {
            $sis_handball_cache_time_check_4h = ' selected="selected"';
        } else if (get_option('sis-handball-cache-time') == '8h') {
            $sis_handball_cache_time_check_8h = ' selected="selected"';
        } else if (get_option('sis-handball-cache-time') == '12h') {
            $sis_handball_cache_time_check_12h = ' selected="selected"';
        } else if (get_option('sis-handball-cache-time') == '1d') {
            $sis_handball_cache_time_check_1d = ' selected="selected"';
        } else if (get_option('sis-handball-cache-time') == '1w') {
            $sis_handball_cache_time_check_1w = ' selected="selected"';
        }

        $cache_count = Sis_Handball_Admin::cache_count();
        $cache_last_update = Sis_Handball_Admin::cache_last_update();
        $tabs = array(
            'tab-settings' => __('Settings', 'sis-handball'),
            'tab-cache' => __('Cache', 'sis-handball'),
            'tab-translations' => __('Translations', 'sis-handball'),
            'team-name-replace' => __('Team name replace', 'sis-handball'),
            'tab-about' => __('About', 'sis-handball')
        );

        $returner = '';
        $returner .= '
            <div class="wrap">
                <h1>' . __('SIS Handball', 'sis-handball') . ' › ' . __('Settings', 'sis-handball') . '</h1>
                ' . Sis_Handball_Admin_Viewhelpers::admin_tabs_factory($tabs, 'sis-handball-options')
        ;
        if (!isset($_GET['tab']) || $_GET['tab'] == 'tab-settings') {
            $returner .= '
                <h2 class="title">' . __('Settings', 'sis-handball') . '</h2>
                <form action="" method="post">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th><label for="sis_handball_default_styles">' . __('Activate default styles', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Activate default styles', 'sis-handball') . '</span></legend>
                                        <label for="sis_handball_default_styles"><input name="setting[sis-handball-default-styles]" type="checkbox" id="sis_handball_default_styles" value="1"' . $sis_handball_default_styles_check . '> ' . __('Activate default styles', 'sis-handball') . '</label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_cache">' . __('Activate caching', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Activate caching', 'sis-handball') . '</span></legend>
                                        <label for="sis_handball_cache"><input name="setting[sis-handball-cache]" type="checkbox" id="sis_handball_cache" value="1"' . $sis_handball_cache_check . '> ' . __('Activate caching', 'sis-handball') . '</label>
                                        <p class="description" id="sis_handball_cache_description">' . __('Caching the data makes your site much faster.', 'sis-handball') . '</p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_cache_time">' . __('Cache time', 'sis-handball') . '</label></th>
                                <td>
                                    <select name="setting[sis-handball-cache-time]" id="sis_handball_cache_time">
                                        <option value="4h"' . $sis_handball_cache_time_check_4h . '>' . __('4 hours', 'sis-handball') . '</option>
                                        <option value="8h"' . $sis_handball_cache_time_check_8h . '>' . __('8 hours', 'sis-handball') . '</option>
                                        <option value="12h"' . $sis_handball_cache_time_check_12h . '>' . __('12 hours', 'sis-handball') . '</option>
                                        <option value="1d"' . $sis_handball_cache_time_check_1d . '>' . __('1 day', 'sis-handball') . '</option>
                                        <option value="1w"' . $sis_handball_cache_time_check_1w . '>' . __('1 week', 'sis-handball') . '</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_show_cache_update">' . __('Display last cache update', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Display last cache update', 'sis-handball') . '</span></legend>
                                        <label for="sis_handball_show_cache_update"><input name="setting[sis-handball-show-cache-update]" type="checkbox" id="sis_handball_show_cache_update" value="1"' . $sis_handball_show_cache_update_check . '> ' . __('Display last cache update', 'sis-handball') . '</label>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_lazyload_limit">' . __('Lazy load limited tables', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Lazy load limited tables', 'sis-handball') . '</span></legend>
                                        <label for="sis_handball_lazyload_limit"><input name="setting[sis-handball-lazyload-limit]" type="checkbox" id="sis_handball_lazyload_limit" value="1"' . $sis_handball_lazyload_limit_check . '> ' . __('Lazy load limited tables', 'sis-handball') . '</label>
                                        <p class="description" id="sis_handball_lazyload_limit_description">' . __('Needs the default styles activated, otherwise you need to hide and show the data with the help of your own CSS!', 'sis-handball') . '</p>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_hide_errors">' . __('Ignore error messages', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Ignore error messages', 'sis-handball') . '</span></legend>
                                        <label for="sis_handball_hide_errors"><input name="setting[sis-handball-hide-errors]" type="checkbox" id="sis_handball_hide_errors" value="1"' . $sis_handball_hide_errors_check . '> ' . __('Ignore error messages', 'sis-handball') . '</label>
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    ' . get_submit_button(__('Save', 'sis-handball'), 'primary', 'save_options') . '
                </form>
            ';
        } else if ($_GET['tab'] == 'tab-cache') {
            $returner .= '
                <h2 class="title">' . __('Cache', 'sis-handball') . '</h2>
                <form action="" method="post">
                    <p><strong>' . $cache_count . '</strong> ' . __('Datasets in cache table', 'sis-handball') . ' (' . __('Last successful cache update', 'sis-handball') . ': ' . date('d.m.Y H:i', $cache_last_update) . ')<br />' . __('If changes on shortcodes do not affect the frontend view, clear the cache, it rebuilds itself.', 'sis-handball') . '</p>
                    ' . get_submit_button(__('Clear cache', 'sis-handball'), 'primary', 'empty_cache') . '
                </form>
            ';
        } else if ($_GET['tab'] == 'tab-translations') {
            $returner .= '
                <h2 class="title">' . __('Translations', 'sis-handball') . '</h2>
                <form action="" method="post">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th><label for="sis_handball_text_error_no_data">' . __('Error text no data', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Error text no data', 'sis-handball') . '</span></legend>
                                        <input name="translation[sis-handball-text-error-no-data]" type="text" id="sis_handball_text_error_no_data" value="' . get_option('sis-handball-text-error-no-data') . '" class="large-text" placeholder="' . __('Error: No data received!', 'sis-handball') . '">
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_text_error_default">' . __('Error text default', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Error text default', 'sis-handball') . '</span></legend>
                                        <input name="translation[sis-handball-text-error-default]" type="text" id="sis_handball_text_error_default" value="' . get_option('sis-handball-text-error-default') . '" class="large-text" placeholder="' . __('Error: An error occured!', 'sis-handball') . '">
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_text_show_game_location">' . __('Show game location', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Show game location', 'sis-handball') . '</span></legend>
                                        <input name="translation[sis-handball-text-show-game-location]" type="text" id="sis_handball_text_show_game_location" value="' . get_option('sis-handball-text-show-game-location') . '" class="large-text" placeholder="' . __('Show game location', 'sis-handball') . '">
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_text_show_map">' . __('Show Map', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Show Map', 'sis-handball') . '</span></legend>
                                        <input name="translation[sis-handball-text-show-map]" type="text" id="sis_handball_text_show_map" value="' . get_option('sis-handball-text-show-map') . '" class="large-text" placeholder="' . __('Show Map', 'sis-handball') . '">
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_text_show_more_singular">' . __('more element to show.', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('more element to show.', 'sis-handball') . '</span></legend>
                                        <input name="translation[sis-handball-text-show-more-singular]" type="text" id="sis_handball_text_show_more_singular" value="' . get_option('sis-handball-text-show-more-singular') . '" class="large-text" placeholder="' . __('more element to show.', 'sis-handball') . '">
                                    </fieldset>
                                </td>
                            </tr>
                            <tr>
                                <th><label for="sis_handball_text_show_more_plural">' . __('more elements to show.', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('more elements to show.', 'sis-handball') . '</span></legend>
                                        <input name="translation[sis-handball-text-show-more-plural]" type="text" id="sis_handball_text_show_more_plural" value="' . get_option('sis-handball-text-show-more-plural') . '" class="large-text" placeholder="' . __('more elements to show.', 'sis-handball') . '">
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    ' . get_submit_button(__('Save', 'sis-handball'), 'primary', 'save_translations') . '
                </form>
            ';
        } else if ($_GET['tab'] == 'team-name-replace') {
            $replace_datasets = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'sis_string_replace ORDER BY id ASC');
            $returner .= '
                <h2 class="title">' . __('Team replace', 'sis-handball') . '</h2>
                <p>' . __('Replace team names with custom strings. (HTML allowed)', 'sis-handball') . '</p>
                <h3 class="title">' . __('Existing replacements', 'sis-handball') . '</h3>
                <form action="" method="post">
                    <table class="form-table">
                        <thead>
                            <tr>
                                <th>' . __('Team name', 'sis-handball') . '</th>
                                <th></th>
                                <th>' . __('Replacement', 'sis-handball') . '</th>
                                <th>' . __('Options', 'sis-handball') . '</th>
                            </tr>
                        </thead>
                        <tbody>
            ';
            if ($replace_datasets) {
                foreach ($replace_datasets AS $replace_data_key => $replace_data) {
                    $returner .= '
                                <tr>
                                    <td>
                                        <input name="team_replace[' . $replace_data->id . '][source_string]" type="text" id="source_string_' . $replace_data->id . '" value="' . $replace_data->source_string . '" class="large-text" placeholder="' . __('Team name', 'sis-handball') . '">
                                    </td>
                                    <td style="text-align: center;">=></td>
                                    <td>
                                        <input name="team_replace[' . $replace_data->id . '][replace_string]" type="text" id="replace_string_' . $replace_data->id . '" value="' . $replace_data->replace_string . '" class="large-text" placeholder="' . __('Replacement', 'sis-handball') . '">
                                    </td>
                                    <td>
                                        <button type="button" class="sis-handball-team-name-replace-delete button button-secondary" data-replace-id="' . $replace_data->id . '">' . __('Delete', 'sis-handball') . '</button>
                                    </td>
                                </tr>
                    ';
                }
            } else {
                $returner .= '
                                <tr>
                                    <td colspan="4">
                                        ' . __('No team replacements available!', 'sis-handball') . '
                                    </td>
                                </tr>
                ';
            }
            $returner .= '
                        </tbody>
                    </table>
                    ' . get_submit_button(__('Save', 'sis-handball'), 'primary', 'save_team_replace') . '
                </form>
                <h3 class="title">' . __('Create new replacement', 'sis-handball') . '</h3>
                <form action="" method="post">
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <td>
                                    <input name="source_string" type="text" class="large-text" placeholder="' . __('Team name', 'sis-handball') . '">
                                </td>
                                <td style="text-align: center;">=></td>
                                <td>
                                    <input name="replace_string" type="text" class="large-text" placeholder="' . __('Replacement', 'sis-handball') . '">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    ' . get_submit_button(__('Save', 'sis-handball'), 'primary', 'new_team_replace') . '
                </form>
            ';
        } else if ($_GET['tab'] == 'tab-about') {
            $supporters = array('nietho', 'thodie12', 'mars93', 'diddiausde');

            $returner .= '
                <h2 class="title">' . __('About', 'sis-handball') . '</h2>
                <p>' . sprintf(__('Feel free to visit the official <a href="%s" target="_blank">support forum</a> to leave feedback and suggestions.', 'sis-handball'), 'https://wordpress.org/support/plugin/sis-handball') . '</p>
                <h2 class="title">' . __('Thanks', 'sis-handball') . '</h2>
                <p>' . __('Some great WordPress users that helped to make the plugin even better, found bugs or discussed ideas that helped to develop and update the plugin.', 'sis-handball') . '</p>
                <ul>
            ';
            foreach ($supporters AS $supporter) {
                $returner .= '<li><a href="https://wordpress.org/support/users/' . $supporter . '/" target="_blank">' . $supporter . '</a></li>';
            }
            $returner .= '
                </ul>
            ';
        }
        $returner .= '</div>';
        return $returner;
    }

    /**
     * HTML structure for the shortcode generator
     * 
     * @since 1.0.22
     * @return string
     */
    public static function page_shortcode_generator()
    {
        $returner = '';
        $returner .= '
            <div class="wrap">
                <h1>' . __('SIS Handball', 'sis-handball') . ' › ' . __('Shortcode generator', 'sis-handball') . '</h1>
                <h2 class="title">' . __('Shortcode builder', 'sis-handball') . '</h2>
                <table class="form-table">
                    <tbody>
                        <tr class="shortcode-generator">
                            <th><label for="sis_handball_shortcode_generator_type">' . __('Type', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Type', 'sis-handball') . '</span></legend>
                                    <select id="sis_handball_shortcode_generator_type" name="sis_handball_shortcode_generator_type">
                                        <option value="team">' . __('Last Games of single team', 'sis-handball') . '</option>
                                        <option value="next">' . __('Next games of single team', 'sis-handball') . '</option>
                                        <option value="standings">' . __('Standings', 'sis-handball') . '</option>
                                        <option value="stats">' . __('Statistic of single team', 'sis-handball') . '</option>
                                        <option value="chart">' . __('Diagram of positioning of single team', 'sis-handball') . '</option>
                                        <option value="games">' . __('All games in a league', 'sis-handball') . '</option>
                                        <option value="club">' . __('All games of a club', 'sis-handball') . '</option>
                                    </select>
                                    <p class="shortcode-generator teamname description" id="sis_handball_shortcode_generator_type_chart_description">' . __('Diagrams monitor the current position over the season. If the season already startet, the diagram will also start on the current gameday!', 'sis-handball') . '</p>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator">
                            <th><label for="sis_handball_shortcode_generator_league_id">' . __('League ID', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('League ID', 'sis-handball') . '</span></legend>
                                    <input id="sis_handball_shortcode_generator_league_id" name="sis_handball_shortcode_generator_league_id" class="regular-text code" placeholder="' . __('e.g.', 'sis-handball') . ' 001517000000000000000000000000000001000" /> <a href="#" target="_blank" id="sis_handball_shortcode_generator_link_checker">' . __('Check link result', 'sis-handball') . '</a>
                                    <p class="description" id="sis_handball_shortcode_generator_league_id_description">
                                        ' . __('The last part of your selected url: ', 'sis-handball') . '<br />
                                        ' . __('e.g.', 'sis-handball') . ' <span id="sis_handball_shortcode_generator_league_id_description_link"></span>
                                    </p>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator sorting">
                            <th><label for="sis_handball_shortcode_generator_sorting">' . __('Sorting', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Sorting', 'sis-handball') . '</span></legend>
                                    <select id="sis_handball_shortcode_generator_sorting" name="sis_handball_shortcode_generator_sorting">
                                        <option value="asc">' . __('Date ascending', 'sis-handball') . '</option>
                                        <option value="desc">' . __('Date descending', 'sis-handball') . '</option>
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator limit">
                            <th><label for="sis_handball_shortcode_generator_limit">' . __('Limit', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Limit', 'sis-handball') . '</span></legend>
                                    <input type="number" min="1" max="100" id="sis_handball_shortcode_generator_limit" name="sis_handball_shortcode_generator_limit" class="small-text" />
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator marked">
                            <th><label for="sis_handball_shortcode_generator_marked">' . __('Marked team', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Marked team', 'sis-handball') . '</span></legend>
                                    <button id="sis_handball_shortcode_generator_fetch_teams" class="button">' . __('Fetch teams', 'sis-handball') . '</button>
                                    <select id="sis_handball_shortcode_generator_marked" name="sis_handball_shortcode_generator_marked" data-default-option="' . __('No teams fetched!', 'sis-handball') . '"></select>
                                    <a href="#" class="sis_handball_shortcode_generator_marked_toggle_manual"><span class="hide" style="display: none;">' . __('Hide manual input', 'sis-handball') . '</span><span class="hide">' . __('Show manual input', 'sis-handball') . '</span></a>
                                    <p class="description" id="sis_handball_lazyload_limit_description">' . __('Needs the default styles activated, otherwise you need to hide and show the data with the help of your own CSS!', 'sis-handball') . '</p>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator marked-manual">
                            <th><label for="sis_handball_shortcode_generator_marked_manual">' . __('Marked team', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Marked team', 'sis-handball') . '</span></legend>
                                    <input id="sis_handball_shortcode_generator_marked_manual" name="sis_handball_shortcode_generator_marked_manual" class="regular-text code" />
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator teamname">
                            <th><label for="sis_handball_shortcode_generator_teamname">' . __('Teamname', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Teamname', 'sis-handball') . '</span></legend>
                                    <input id="sis_handball_shortcode_generator_teamname" name="sis_handball_shortcode_generator_teamname" class="regular-text code" />
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator hide-cols">
                            <th><label for="sis_handball_shortcode_generator_hide_cols">' . __('Hide columns', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset class="hide-cols-fieldset hide-cols-team hide-cols-games">
                                    <legend class="screen-reader-text"><span>' . __('Hide columns', 'sis-handball') . '</span></legend>
                                    <label for="sis_handball_shortcode_generator_hide_cols_1_1"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_1_1" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_1_1" value="1">' . __('Date', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_1_2"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_1_2" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_1_2" value="2">' . __('Time', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_1_3"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_1_3" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_1_3" value="3">' . __('Home', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_1_4"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_1_4" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_1_4" value="4">' . __('Guest', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_1_5"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_1_5" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_1_5" value="5">' . __('Goals', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_1_6"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_1_6" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_1_6" value="6">' . __('Points', 'sis-handball') . '</label>
                                </fieldset>
                                <fieldset class="hide-cols-fieldset hide-cols-standings">
                                    <legend class="screen-reader-text"><span>' . __('Hide columns', 'sis-handball') . '</span></legend>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_1"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_1" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_1" value="1">' . __('No.', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_2"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_2" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_2" value="2">' . __('Team', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_3"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_3" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_3" value="3">' . __('Games', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_4"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_4" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_4" value="4">' . __('W', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_5"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_5" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_5" value="5">' . __('T', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_6"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_6" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_6" value="6">' . __('L', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_7"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_7" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_7" value="7">' . __('Goals', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_8"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_8" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_8" value="8">' . __('D', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_2_9"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_2_9" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_2_9" value="9">' . __('Points', 'sis-handball') . '</label>
                                </fieldset>
                                <fieldset class="hide-cols-fieldset hide-cols-next">
                                    <legend class="screen-reader-text"><span>' . __('Hide columns', 'sis-handball') . '</span></legend>
                                    <label for="sis_handball_shortcode_generator_hide_cols_3_1"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_3_1" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_3_1" value="1">' . __('Date', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_3_2"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_3_2" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_3_2" value="2">' . __('Time', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_3_3"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_3_3" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_3_3" value="3">' . __('Home', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_3_4"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_3_4" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_3_4" value="4">' . __('Guest', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_3_5"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_3_5" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_3_5" value="5">' . __('Map', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_3_hide-team"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_3_hide-team" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_3_hide-team" value="hide-team">' . __('Hide marked team', 'sis-handball') . '</label>
                                </fieldset>
                                <fieldset class="hide-cols-fieldset hide-cols-stats">
                                    <legend class="screen-reader-text"><span>' . __('Hide columns', 'sis-handball') . '</span></legend>
                                    <label for="sis_handball_shortcode_generator_hide_cols_4_1"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_4_1" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_4_1" value="1">' . __('Position', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_4_2"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_4_2" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_4_2" value="2">' . __('Games made', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_4_3"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_4_3" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_4_3" value="3">' . __('Average goals made', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_4_4"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_4_4" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_4_4" value="4">' . __('Average goals got', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_4_5"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_4_5" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_4_5" value="5">' . __('W', 'sis-handball') . '</label>
                                </fieldset>
                                <fieldset class="hide-cols-fieldset hide-cols-club">
                                    <legend class="screen-reader-text"><span>' . __('Hide columns', 'sis-handball') . '</span></legend>
                                    <label for="sis_handball_shortcode_generator_hide_cols_5_1"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_5_1" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_5_1" value="1">' . __('Date', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_5_2"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_5_2" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_5_2" value="2">' . __('Home', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_5_3"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_5_3" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_5_3" value="3">' . __('Guest', 'sis-handball') . '</label>
                                    <label for="sis_handball_shortcode_generator_hide_cols_5_4"><input class="sis_handball_shortcode_generator_hide_cols_input" name="sis_handball_shortcode_generator_hide_cols_5_4" type="checkbox" id="sis_handball_shortcode_generator_hide_cols_5_4" value="4">' . __('Location', 'sis-handball') . '</label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="shortcode-generator">
                            <th><label for="sis_handball_shortcode_generator_generated_code">' . __('Generated shortcode', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Generated shortcode', 'sis-handball') . '</span></legend>
                                    <input id="sis_handball_shortcode_generator_generated_code" name="sis_handball_shortcode_generator_generated_code" class="select_value large-text code" />
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
        return $returner;
    }

    /**
     * HTML structure for snapshot overview
     * 
     * @since 1.0.22
     * @return string
     */
    public static function snapshots_overview()
    {
        $returner = '';
        $table = new Sis_Handball_Admin_Table_Snapshots();
        $table->prepare_items();
        ob_start();
        $table->display();
        $table = ob_get_clean();
        $returner .= '
            <div class="wrap">
                <h1 class="wp-heading-inline">' . __('SIS Handball', 'sis-handball') . ' › ' . __('Snapshots', 'sis-handball') . '</h1>
                <a href="admin.php?page=sis-handball-snapshots&action=new" class="page-title-action">' . __('New snapshot', 'sis-handball') . '</a>
                <hr class="wp-header-end">
                ' . $table . '
            </div>
        ';
        return $returner;
    }

    /**
     * HTML structure for new snapshot form
     * 
     * @since 1.0.22
     * @return string
     */
    public static function snapshots_new()
    {
        $returner = '';
        $returner .= '
            <div class="wrap">
                <h1>' . __('SIS Handball', 'sis-handball') . ' › ' . __('Snapshots', 'sis-handball') . '</h1>
                <div class="card">
                    <h2 class="title">' . __('About', 'sis-handball') . ' ' . __('Snapshots', 'sis-handball') . '</h2>
                    <p>' . __('Sometimes it makes sense to save the result of a shortcode for later use. If a season ends and you want to display scores from the last season, you can easily fire the shortcode for once and save the results in a snapshot.', 'sis-handball') . '</p>
                </div>
                <form action="" method="post">
                    <h2 class="title">' . __('Create snapshot', 'sis-handball') . '</h2>
                    <table class="form-table">
                        <tbody>
                        <tr class="snapshot-form">
                            <th><label for="sis_handball_snapshot_shortcode">' . __('Shortcode', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Shortcode', 'sis-handball') . '</span></legend>
                                    <input tabindex="10" id="sis_handball_snapshot_shortcode" name="sis_handball_snapshot_shortcode" class="regular-text code" autofocus/>
                                    <p class="description" id="sis_handball_snapshot_shortcode_description">' . __('Please use the shortcode generator, to generate a valid shortcode.', 'sis-handball') . ' <a href="admin.php?page=sis-handball-shortcode-generator" target="_self">' . __('Shortcode generator', 'sis-handball') . '</a></p>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="snapshot-form">
                            <th><label for="sis_handball_snapshot_comment">' . __('Comment', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Comment', 'sis-handball') . '</span></legend>
                                    <input tabindex="20" id="sis_handball_snapshot_comment" name="sis_handball_snapshot_comment" class="regular-text code" />
                                    <p class="description" id="sis_handball_snapshot_comment_description">' . __('Optional', 'sis-handball') . '</p>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
                ' . get_submit_button(__('New snapshot', 'sis-handball'), 'primary', 'save_snapshot') . '
                </form>
            </div>
        ';
        return $returner;
    }

    /**
     * HTML structure for edit snapshot form
     * 
     * @since 1.0.22
     * @return string
     */
    public static function snapshots_edit()
    {
        $returner = '';
        $snapshot = Sis_Handball_Admin_Snapshot::get($_GET['id']);
        if ($snapshot) {
            $returner .= '
                <div class="wrap">
                    <h1>' . __('SIS Handball', 'sis-handball') . ' › ' . __('Snapshots', 'sis-handball') . '</h1>
                    <form action="" method="post">
                        <h2 class="title">' . __('Edit snapshot', 'sis-handball') . '</h2>
                        <table class="form-table">
                            <tbody>
                            <tr class="snapshot-form">
                                <th><label for="sis_handball_snapshot_comment">' . __('Comment', 'sis-handball') . '</label></th>
                                <td>
                                    <fieldset>
                                        <legend class="screen-reader-text"><span>' . __('Comment', 'sis-handball') . '</span></legend>
                                        <input tabindex="20" id="sis_handball_snapshot_comment" name="snapshot[comment]" class="regular-text code" value="' . $snapshot->comment . '" />
                                        <p class="description" id="sis_handball_snapshot_comment_description">' . __('Optional', 'sis-handball') . '</p>
                                    </fieldset>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="snapshot[id]" value="' . $_GET['id'] . '" />
                    ' . get_submit_button(__('Save', 'sis-handball'), 'primary', 'edit_snapshot') . '
                    </form>
                </div>
            ';
        }
        return $returner;
    }

    /**
     * HTML structure for concatenations overview
     * 
     * @since 1.0.22
     * @return string
     */
    public static function concatenations_overview()
    {
        $returner = '';
        $table = new Sis_Handball_Admin_Table_Concatenations();
        $table->prepare_items();
        ob_start();
        $table->display();
        $table = ob_get_clean();
        $returner .= '
            <div class="wrap">
                <h1 class="wp-heading-inline">' . __('SIS Handball', 'sis-handball') . ' › ' . __('Concatenations', 'sis-handball') . '</h1>
                <a href="admin.php?page=sis-handball-concatenations&action=new" class="page-title-action">' . __('New concatenation', 'sis-handball') . '</a>
                <hr class="wp-header-end">
                ' . $table . '
            </div>
        ';
        return $returner;
    }

    /**
     * HTML structure for new concatenations process
     * 
     * @since 1.0.22
     * @param type $post
     * @return string
     */
    public static function concatenations_create($post = array())
    {
        $returner = '';
        $concatenation_id = Sis_Handball_Admin_Concatenations::create($post);
        $forward_edit_url = 'admin.php?page=sis-handball-concatenations&action=edit&id=' . $concatenation_id;
        $returner .= '
            <div class="wrap">
                <h1>' . __('SIS Handball', 'sis-handball') . ' › ' . __('Concatenations', 'sis-handball') . '</h1>
                <a href="' . $forward_edit_url . '"><button class="button button-primary">' . __('Add conditions to the concatenation', 'sis-handball') . '</button></a>
            </div>
        ';
        return $returner;
    }

    /**
     * HTML structure for new concatenations
     * 
     * @since 1.0.22
     * @return string
     */
    public static function concatenations_new()
    {
        $returner = '';
        $returner .= '
            <div class="wrap">
                <h1>' . __('SIS Handball', 'sis-handball') . ' › ' . __('Concatenations', 'sis-handball') . '</h1>
                <div class="card">
                    <h2 class="title">' . __('About', 'sis-handball') . ' ' . __('Concatenations', 'sis-handball') . '</h2>
                    <p>' . __('Concatenation allows you to add data from a single team to an concatenated shortcode, to display team-transcending data in a single view.', 'sis-handball') . '</p>
                    <p><strong>' . __('This feature is in a testing phase, you can only concatenate the next game of multiple teams to generate an overview of all next games within the whole club.!', 'sis-handball') . '</strong></p>
                </div>
                <form action="" method="post">
                    <h2 class="title">' . __('Create concatenation', 'sis-handball') . '</h2>
                    <table class="form-table">
                        <tbody>
                        <tr class="concatenation-form">
                            <th><label for="sis_handball_concatenation_type">' . __('Type', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Type', 'sis-handball') . '</span></legend>
                                    <select id="sis_handball_concatenation_type" name="sis_handball_concatenation_type">
                                        <option value="next_games_multi_teams">' . __('Next games of multiple teams', 'sis-handball') . '</option>
                                    </select>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="concatenation-form">
                            <th><label for="sis_handball_concatenation_comment">' . __('Comment', 'sis-handball') . '</label></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text"><span>' . __('Comment', 'sis-handball') . '</span></legend>
                                    <input tabindex="20" id="sis_handball_concatenation_comment" name="sis_handball_concatenation_comment" class="regular-text code" />
                                    <p class="description" id="sis_handball_concatenation_comment_description">' . __('Optional', 'sis-handball') . '</p>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
                ' . get_submit_button(__('New concatenation', 'sis-handball'), 'primary', 'create') . '
                </form>
            </div>
        ';
        return $returner;
    }

    /**
     * HTML structure for tab navigation
     * 
     * @since 1.0.22
     * @param type $tabs
     * @param type $page
     * @return string
     */
    public static function admin_tabs_factory($tabs, $page = '')
    {
        $returner = '';
        $returner .= '<h2 class="nav-tab-wrapper">';
        $current_tab = filter_input(INPUT_GET, 'tab');
        $count = 0;
        foreach ($tabs as $location => $tabname) {
            if (!isset($current_tab) && $count == 0) {
                $class = ' nav-tab-active';
            } else if ($current_tab == $location) {
                $class = ' nav-tab-active';
            } else {
                $class = '';
            }
            $returner .= '<a class="nav-tab' . $class . '" href="?page=' . $page . '&tab=' . $location . '">' . $tabname . '</a>';
            $count++;
        }
        $returner .= '</h2>';
        return $returner;
    }
}

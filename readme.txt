=== SIS Handball ===
Contributors: welly2103
Tags: sports, handball, sis, scores, team, club, goals
Requires at least: 4.6.1
Tested up to: 4.9
Requires PHP: 5.6
Stable tag: 4.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show statistics and data provided by sis-handball.de. Tables, scores and next games.

== Description ==

Show results, standings and statistics from sis-handball.de (German handball).
This plugin is developed privately and is not related to sis-handball.de.


The plugin provides the following options:

* Easy to use shortcode generator
* Display tables, past and future games as live data
* Cache data to fasten your site and minimize traffic
* Save data in generated static shortcodes, to hold standings and tables from past seasons
* Mark your own teams in both dynamic or static tables
* Mark your team if it has won in the overview of past games
* Monitoring of placement of any team and displaying a graph of changes for each gameday
* Concatenate different teams to build overviews of next games
* Show average values of single teams

= Hooks / Filters =

**sis_handball_table_data**
Manipulates the array used in table generator

**sis_handball_chart_data**
Manipulates the array used in charts

**sis_handball_concatenation_data**
Manipulates the array used in concatenations

**sis_handball_atts**
Manipulates the shortcode attributes

= Additional params =

For special requests there is an option to provide additional parameters to each shortcode.

Definition of additional parameters:

`[sishandball type="xxx" league="xxx" additional_params="foo:'bar'|foo:'bar'|foo:'bar'"]`

This option should only be used by experienced users and is not available through the shortcode generator!
See FAQ section for exact parameter definition.


== Installation ==

1. Upload to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the provided shortcode generator and paste your shortcode anywhere on your site


== Screenshots ==

1. Option overview
2. Snapshot section
3. Concatenation section
4. Table with marked team of current season
5. Past games for a single team, with the team marked if it has won
6. Next games (Variable limit of 5 set) for a single team
7. Table of season 2011/12 german handball league, saved as a static snapshot
8. The saved snapshot for the table displayed in screenshot 7
9. Monitoring diagram of single teams position in frontend
10. The shortcode generator, so you can easily add advanced shortcodes  

== Frequently Asked Questions ==

= How to use additional parameters (additional_params)? =

Additional parameters allow you to add some extra functionality to only one shortcode. Note the exact syntax of this option, otherwise it can cause errors!

`[sishandball type="xxx" league="xxx" additional_params="foo:'bar'|foo:'bar'|foo:'bar'"]`

**class**
This can contain any string as an extra class for the table output.
	
**table_head**
Only option available is **hidden**, if it is set, the table head will not be shown.

**cache**
Only option available is **no-cache**, if it is set, the shortcode data will not be cached.
This option only makes sense if the global caching option is set, otherwise it will have no impact!

**ignore-team-replacement**
Only option available is **1**, if it is set, the shortcode will ignore possible global team name replacements


== Changelog ==

= 1.0.37 =
* [Added] Game location as title for Google map link
* [Removed] "Show game location" translation, this is now replaced with the location itself

= 1.0.36 =
* [Added] $atts variable as second argument to filters sis_handball_table_data and sis_handball_concatenation_data

= 1.0.35 =
* [Added] Marked team class on row level for all games (type="games") in a league
* [Added] New filter sis_handball_atts to manipulate shortcode attributes

= 1.0.34 =
* [Added] Team name replacement
* [Added] Additional parameter to ignore team name replacement
* [Added] More frontend translation options

= 1.0.33 =
* [Added] Additional parameters option in shortcode

= 1.0.32 =
* [Fixed] Multiple limited tables will only show their next table row (JS)

= 1.0.31 =
* [Added] .pot translation file for future translations
* [Fixed] Static functions error

= 1.0.30 =
* [Fixed] Wrong URL and data handling in chart display

= 1.0.29 =
* [Added] Limit could be used in every table shortcode
* [Added] Unique CSS classes for each table

= 1.0.28 =
* [Added] Several hooks
* [Added] Display all games from all teams via club-id

= 1.0.27 =
* [Fixed] Fetching teams in shortcode generator

= 1.0.26 =
* [Added] Option to remove marked team in next games table

= 1.0.25 =
* [Fixed] Protocol error

= 1.0.24 =
* [Added] Option to remove columns from tables
* [Added] Option to add comments to concatenation conditions
* [Removed] Option to remove map link from next games table! Is obsolete due to the new remove columns options

= 1.0.23 =
* [Added] Support of new sis-handball.de website structure

= 1.0.22 =
* [Added] Cleaner BE structure, greater native WP UI
* [Added] Snapshot and concatenation overview are now sortable
* [Added] Help section for shortcode generator
* [Added] Custom error messages
* [Added] Option to globaly hide error messages
* [Added] Option to edit snapshots

= 1.0.21 =
* [Added] Option to remove conditions from concatenations
* [Fixed] Display empty entries in concatenation

= 1.0.20 =
* [Added] Option to remove map link from next games table

= 1.0.19 =
* [Fixed] Ajax request via WP ajax handler
* [Fixed] Server right problem with custom ajax file

= 1.0.18 =
* [Added] Link checker in shortcode generator
* [Added] Automatically fetch teams in shortcode generator

= 1.0.17 =
* [Fixed] Remove current function array dereferencing (Problems with PHP 5.3.x)

= 1.0.16 =
* [Added] Concatenation beta functionality
* [Added] Pagination for snapshots and concatenations
* [Added] Own page for shortcode generator

= 1.0.15 =
* [Added] New shortcode for detailed statistics of a single team

= 1.0.14 =
* [Fixed] Wrong colspan tables with show more row

= 1.0.13 =
* [Added] Display more results if next games table is limited
* [Added] More detailed link examples in shortcode generator
* [Fixed] Missing translations

= 1.0.12 =
* [Fixed] No opening tr tag if team is marked in table
* [Fixed] Removed fontawesome CDN and replaced with single icon font

= 1.0.11 =
* [Added] Error handling if source not available

= 1.0.10 =
* [Added] Select cache time

= 1.0.9 =
* [Fixed] Display last cache time with correct timezone
* [Fixed] Open Google maps app on mobile devices

= 1.0.8 =
* [Added] Option to show last cache update under all shortcodes
* [Added] Map link in next games view
* [Added] Autoclean cache

= 1.0.7 =
* [Added] Chart for placement per gameday

= 1.0.6 =
* [Added] Error handling
* [Added] Option to delete snapshots
* [Fixed] Compatibility with WP version 4.7

= 1.0.5 =
* [Added] Snapshots

= 1.0.4 =
* [Added] Display days next to all dates
* [Fixed] Drop cache tables on deactivation

= 1.0.3 =
* [Fixed] Mark winner team if it is guest team

= 1.0.2 =
* [Added] Support to mark winner team in team and game tables

= 1.0.1 =
* [Added] Support for next games view
* [Fixed] Data provider now provides more general arrays
* [Fixed] Cache for different data with same league id

= 1.0.0 =
* [Added] Initial version
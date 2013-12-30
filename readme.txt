=== Pronamic Sections ===
Contributors: pronamic, zogot
Tags: sections, tabs, pronamic tabs, pronamic sections, extra wysiwyg
Requires at least: 3.1
Tested up to: 3.8.1
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


== Description ==
Give your site the option for storing tabbed wysiwyg content. _This plugin requires modifying the template files to get the tab content. You can then show however you want_

== Installation ==
Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your 
WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

= How do I show the extra content? =

For now, you are required to modify the template files. In the future we are going to update with a shortcode and some prewritten styles to show
your tabs.

To show that content, you need to reference the only function we offer `the_pronamic_sections()`
You can give the function a specific page ID to get all the tabs for that ID, otherwise it will use the global $post ID.

= When I press move tab, nothing happens =

You can only move tabs if there is space. Example. The top tab, can not move top any further.

= Any other questions? =

Mail support@pronamic.nl

== Links ==

[GitHub](http://github.com/pronamic/wp-pronamic-sections)
[Issues](http://github.com/pronamic/wp-pronamic-sections/issues);

== Changelog ==

= 1.2.0 =
* FEATURE: New action called when updating a section: 'pronamic_section_update'. The instance of the Section is passed in.
* FEATURE: New action called at the end of a section view, to show any extra HTML you want. 'pronamic_section_admin_extra'

= 1.1.1 =
* Missing Readme notes

= 1.1.0 =
* REFACTOR: Moved the classes into the WP namespace, now Pronamic/WP/Sections instead of Pronamic/Sections
* REFACTOR: Changed inc folder to includes
* REFACTOR: Removed the 'wp-' prefix from the core plugin file

= 1.0 =
* REFACTOR: Now uses a custom post type.
* REFACTOR: Better display of the WYSIWYG areas.
* DEPRECATED: pronamic_sections is now deprecated, if you want the sections in the new class, call the_pronamic_sections( $post_id = get_the_ID() );

= 0.0.1-beta =
* Initial development
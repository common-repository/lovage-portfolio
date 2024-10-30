=== Lovage Portfolio ===
Contributors: Lovage
Tags: Portfolio
Requires at least: 5.0
Tested up to: 5.2.4
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple portfolio WordPress plugin that allows you to show your works easily.

== Description ==

Lovage Portfolio is a simple portfolio WordPress plugin that allows you to show your works easily. It works with all themes, especially can be used as a free extension with our free WordPress theme [Lovage](https://lovage.io). You can add the portfolio grid layout with the shortcode everywhere or create a page with the plugin page template.

Lovage Portfolio is developer-friendly, it includes many hooks that the developer can customize the template or post type slug. 

= Shortcode =
Just insert [lovage_portfolio] to the page content to show the portfolio grid.

Shortcode Arguments:
number: the number of posts per page. e.g, [lovage_portfolio number=6]
pagination: Show the paingation navigation or not, 1 is enable, 0 is disable. e.g, [lovage_portfolio number=6 pagination=1]
orderby: date, title, rand. e.g, [lovage_portfolio orderby='date']
order: asc, desc. e.g [lovage_portfolio order='desc']

= Use the page template = 
Create a page, and you can select 'Portfolio Grid Template' template in page attribute section.

= How to customize the page, single post and taxonomy template? =
First of all, create 'lovage-templates' in the root folder of your theme, then, create 'portfolio' subfolder in it.
Second, open the plugin folder 'lovage-portfolio' > 'templates', you can see the template files, just copy them to 'theme-folder/lovage-templates/portfolio' folder, and make changes, it will override the plugin templates.


== Installation ==

1. Upload the `lovage-portfolio` folder to your plugins directory (e.g. `/wp-content/plugins/`)
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Follow the instructions


== Changelog ==

= 1.0.3 =
* Fixed the single post template was overridden by the portfolio template.

= 1.0.2 =
* Fixed a metabox PHP bug.

= 1.0.0 =
* Initial Release

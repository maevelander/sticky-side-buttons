=== Sticky Side Buttons ===
Contributors: EnigmaWeb
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CEJ9HFWJ94BG4
Tags: sticky, buttons, contact, side, social buttons, email button, phone button, floating
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: trunk
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Flexible button creator allowing you to stick floating buttons to the side of your site.

== Description ==

This simple button creator lets you create one or more floating buttons that stick to the side of your site as the user scrolls.  

= Use it for sticking information like: = 
* Phone number
* Email address
* Social icons
* Store locations

= Configuration options include: = 
* Button position > left or right
* Rollover style > darken or lighten
* Animation style > none, slide or icons only
* Disable on mobile (optional)
* Customise button icons, text, link, and colors easily
* Show on: Front Page, Pages, Posts, Custom Post Types (checkboxes)

= Demo =

*	[Click here](http://demo.enigmaweb.com.au/) for out-of-the-box demo. You can see the buttons to the right of the screen, in 'slide' mode.


== Installation ==

1. Install & activate the plugin through the WordPress 'Plugins' dashboard.
1. Visit the new Sticky Side Buttons tab to create your buttons.

== Frequently Asked Questions ==

= My sticky side buttons are covered by some other element. What should I do? =

In the plugin settings there is a field where you can define z-index for the buttons. An element with a higher z-index is always in front of an element with a lower z-index. If you have tried a high z-index in that setting but your buttons still aren't showing, it is likely that your theme has a very high z-index specified somewhere. This is not great practise, but is sometimes done in complex themes with lots of layered design elements, and also with page builders. As a last resort you can use CSS to force override the z-index for your buttons: `#ssb-container { z-index: 9999 !important; }`

= Where can I get support for this plugin? =

If you've tried all the obvious stuff and it's still not working please request support via the forum. Remember to include a link to your site, and a full description of the issue plus the steps you've already taken to try to solve it.

= Can I contribute to this plugin? =

Absolutely! Please create a pull request on [GitHub here.](https://github.com/EnigmaWeb/sticky-side-buttons)


== Screenshots ==

1. Sticky Side Buttons in action: IN
2. Sticky Side Buttons in action: OUT
3. Sticky Side Buttons backend button creator
4. An example site using Sticky Side Buttons
5. An example site using Sticky Side Buttons
6. An example site using Sticky Side Buttons


== Changelog ==

= 2.0.0 =
* Updated to WordPress 6.4+ and PHP 7.4+ minimum requirements
* Comprehensive security improvements (CSRF protection, input sanitization, output escaping)
* Updated FontAwesome from 5.5.0 to 6.7.2 for latest icons and performance
* Improved admin interface with better error handling
* Added proper uninstall functionality
* Enhanced code organisation and WordPress coding standards compliance
* Fixed button creation and management issues
* Added proper capability checks and access controls

= 1.0.9 =
* Removes Google+ share button

= 1.0.8 =
* Upgrade to FontAwesome 5

= 1.0.7 =
* Bug fix: errors when show on frontpage is checked

= 1.0.6 =
* Support added for custom post types

= 1.0.5 =
* Bug fix: "page" text in footer

= 1.0.4 =
* Adds option to open link in new window
* Adds a 'show on' option: Pages, Posts, Front Page
* Minor bug fix for accessibility
* Adds support for translation plugins: WPML, Polylang
* Improved button hover handling on mobile

= 1.0.3 =
* Fixes z-index override issue

= 1.0.2 =
* Adds a setting so user can define custom z-index

= 1.0.1 =
* Removed unnecessary css background - works better when buttons are spaced
* Added z-index so buttons don't hide behind things (fix for revolution slider)

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0.9 =
* Removes Google+ share button

= 1.0.8 =
* Upgrade to FontAwesome 5

= 1.0.7 =
* Bug fix: errors when show on frontpage is checked

= 1.0.6 =
* Support added for custom post types

= 1.0.5 =
* Bug fix: "page" text in footer

= 1.0.4 =
* Adds option to open link in new window
* Adds a 'show on' option: Pages, Posts, Front Page
* Minor bug fix for accessibility
* Adds support for translation plugins: WPML, Polylang
* Improved button hover handling on mobile

= 1.0.3 =
* Fixes z-index override issue

= 1.0.2 =
* Adds a setting so user can define custom z-index. Thanks to AlexGStapleton.

= 1.0.1 =
* Minor update with some css tweaks

= 1.0 =
* Initial release

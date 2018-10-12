# UCF Academic Calendar Plugin #

Provides a shortcode for displaying academic calendar dates.


## Description ##

Provides a shortcode for displaying [academic calendar](http://calendar.ucf.edu/) dates. Display of dates can be adjusted by creating new layouts or overriding provided layouts using filters.


## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Update any settings necessary on the Settings > UCF Academic Calendar page.

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Academic-Calendar-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Update any settings necessary on the Settings > UCF Academic Calendar settings page.


## Changelog ##

### 1.0.3 ###
Enhancements:
* Added github plugin URI meta to is can be installed via the Github Updater Plugin.

### 1.0.2 ###
Bug Fixes:
* Updates feed function to get defaults from `get_shortcode_defaults` as these are the properly formatted options.
* Updates the check to see if events exist on the feed response to check that the index exists within the results array **and** that the `events` property exists before trying to access it.

### 1.0.1 ###
Bug Fixes:
* Updated the classic layout to only loop through feed items if at least one is available to loop through

Enhancements:
* Added the ability to specify a fallback message via the `[ucf-academic-calendar]` shortcode's content; e.g. `[ucf-academic-calendar]No results found.[/ucf-academic-calendar]`

### 1.0.0 ###
Initial release


## Upgrade Notice ##

n/a


## Installation Requirements ##

None


## Development & Contributing ##

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.

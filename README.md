# wp-multilanguage-multisite
Multilingual WordPress using a multisite network.

A way to create a multilingual WordPress site without relying on plugins.

# instructions
Install WordPress and activate the multisite option.
Create a site in the network for each translation.
Include the file metabox_language_select.php in your functions.php
Include the file post_translations.php in your theme where you want the translation flags to be shown.

The metabox_language_select file will create a metabox in wp-admin, you will use this metabox to select the translation of each page

The post_translations file will show in the frontend a link to the translated page.

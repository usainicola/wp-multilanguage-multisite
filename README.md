A way to create a multilingual WordPress site without relying on plugins.

# Instructions
1. Install WordPress and activate the multisite option.
2. Create a site in the network for each translation.
3. Include the file metabox_language_select.php in your functions.php
4. Include the file post_translations.php in your theme where you want the translation flags to be shown.

The metabox_language_select file will create a metabox in wp-admin, you will use this metabox to select the translation of each page

The post_translations file will show a link to the translated page in the frontend.

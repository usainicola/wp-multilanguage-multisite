<?php

add_filter( 'locale', function($locale) {
  if (!function_exists('get_blog_details')) return 'en';
  $locale = '';
  $path = get_blog_details(get_current_blog_id())->path;
  $path = str_replace('/', '', $path);
  $path = $path === '' ? 'en' : $path;
  $locale = $path;
  return $locale;
});
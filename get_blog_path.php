<?php

function get_blog_path() {
  $path = get_blog_details()->path;
  $path = str_replace('/', '', $path);
  return $path;
}
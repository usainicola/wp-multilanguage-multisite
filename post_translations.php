<?php
$translations = array();
$blogs = function_exists('get_sites') ? get_sites() : array();
foreach($blogs as $blog) {
  $path = strtoupper($blog -> path);
  $path = str_replace('/', '', $path);
  $path = $path == '' ? 'EN' : $path;
  $translation_id = get_post_meta( get_queried_object_id(), 'translation_'.$path, true );
  if (get_current_blog_id()==$blog -> blog_id) continue;
  if ($translation_id == 0) continue;
  switch_to_blog($blog -> blog_id);
  $translations[] = array(
    'href' => get_permalink($translation_id),
    'class' => 'flag '.$path,
    'path' => $path
  );
  restore_current_blog();
}
if (!empty($translations)) {
  echo '<div class="language">';
    echo '<div class="container">';
      echo '<ul>';
      foreach ($translations as $translation) {
        echo '<li><a href="'.$translation['href'].'" class="'.$translation['class'].'" title="View this page translated in '.$translation['path'].'">'.$translation['path'].'</a></li>';
      }
      echo '</ul>';
    echo '</div>';
  echo '</div>';
}
?>

<style type="text/css">
  .language {
    background-color: #191716;
    padding: var(--s8) 0;
    font-size: var(--s12);
  }
  .language .container {
    display: flex;
    justify-content: flex-end;
  }
  .language ul li {
    display: inline-block;
    margin: 0 var(--s4);
  }
  .language ul li.active a,
  .language ul li a:hover {
    border-bottom: var(--s2) solid white;
  }
  #navbar .language ul li a {
    text-decoration: none;
    color: white;
    background-color: rgba(0,0,0,0.22);
  }
  @media screen and (max-width: 720px) {
    .language {
      display: none;
    }
  }
</style>

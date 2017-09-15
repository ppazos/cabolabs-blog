<?php

/*
 * Creates post file and updates the post index.
 */
function create_post($title, $text, $tags, $author, $custom_name = '')
{
   
}

/*
 * Updates post file (generating a new version) and updates the post index.
 */
function update_post($title, $text, $tags, $author, $custom_name = '')
{
   
}

/*
 * Gets JSON from SESSION or loads it if not cached.
 */
function get_post_index()
{
   if (!array_key_exists('medatada', $_SESSION))
   {
      load_post_index();
   }
   
   return $_SESSION['medatada'];
}

/*
 * Loads JSON in SESSION.
 */
function load_post_index()
{
   $filename = 'conf/metadata.json';
   if (file_exists($filename))
   {
      $json = file_get_contents ( string $filename);
      $metadata = json_decode($json, true);
      $_SESSION['medatada'] = $medatada;
      return $metadata;
   }
   
   return false;
}

/*
 * Reloads JSON in SESSION.
 */
function refresh_post_index()
{
   
}

/*
 * Updates JSON with new post.
 */
function update_post_index($post)
{
   
}

?>
<?php

/*
 * === POSTS ===
 */

/*
 * Creates post file and updates the post index.
 */
function create_post($title, $text, $summary, $tags = array(), $author, $lang, $custom_name = '')
{
   $normalized_title = normalized_title($title);
   $id = uniqid();
   $file = 'posts/'. $id .'.v1'; // the first file is random.v1, on updates it will save random.v2, random.v3, etc.
   if (is_file($file))
   {
      throw new Exception('A post with the same name already exists, please provide another name or set a custom name');
      return false;
   }
   
   write_file($file, $text);
   
   update_post_index($id, $title, $text, $summary, $tags, $author, $lang, $file, $normalized_title, '');
   
   return $id;
}

/*
 * Updates post file (generating a new version) and updates the post index.
 */
function update_post($id, $title, $text, $summary, $tags = array(), $author, $lang, $custom_name = '')
{
   $normalized_title = normalized_title($title);
   
   // Need to check the current latest version to pass it to the updated_post_index
   $versions = get_post_versions($id);
   $post = get_latest_post_version($versions);
   $latest_version_num = $post['version'];
   
   $file = 'posts/'. $id .'.v'.($latest_version_num+1);
   
   write_file($file, $text);
   
   update_post_index($id, $title, $text, $summary, $tags, $author, $lang, $file, $normalized_title, '', ($latest_version_num+1));
}

/*
 * Post title to snake case and substitution of special characters.
 */
function normalized_title($title)
{
   $normalized = strtolower($title);
   $normalized = str_replace(" ", "_", $normalized);
   $normalized = filter_special_chars($normalized);
   $normalized = filter_non_letters($normalized);
   return $normalized;
}

function filter_special_chars($string)
{
   $unwanted_array = array('�'=>'S', '�'=>'s', '�'=>'Z', '�'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E',
                           '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I', '�'=>'I', '�'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U',
                           '�'=>'U', '�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'c',
                           '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i', '�'=>'i', '�'=>'o', '�'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o',
                           '�'=>'o', '�'=>'o', '�'=>'u', '�'=>'u', '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y' );
   return strtr($string, $unwanted_array);
}

function filter_non_letters( $string )
{
  $filtered = preg_replace('~[^\\pL0-9_]+~u', '', $string);
  return preg_replace('~[^-a-z0-9_]+~', '', $filtered);
}

/*
 * === METADATA / INDEXES ===
 */

/*
 * Gets JSON from SESSION or loads it if not cached.
 */
function get_post_index()
{
   if (!array_key_exists('metadata', $_SESSION))
   {
      load_post_index();
   }
   
   return $_SESSION['metadata'];
}

/*
 * Loads JSON in SESSION.
 */
function load_post_index()
{
   $index_path = 'conf/metadata2.json';
   if (is_file($index_path))
   {
      $json = file_get_contents ($index_path);
      $metadata = json_decode($json, true);
      $_SESSION['metadata'] = $metadata;
      return $metadata;
   }
   
   return false;
}


/*
 * Updates JSON with new post.
 */
function update_post_index($id, $title, $text, $summary, $tags = array(), $author, $lang, $file_path, $normalized_title, $custom_name = '', $version = 1)
{
   $index = get_post_index();
   $post_versions = get_post_versions($id);
   
   // is a new post?
   if ($post_versions === false)
   {
      // create index entry for post version object
      $post_version = array( // versions of this post
         array(            // this post
           "title"     => $title,
           "summary"   => $summary,
           "normalized_title" => $normalized_title,
           "timestamp" => time(),
           "tags"      => $tags,
           "file"      => $file_path,
           "author"    => $author,
           "lang"      => $lang,
           "version"   => $version
         )
      );
      
      $index['posts'][$id] = $post_version;
   }
   else // create a new version of an existing post
   {
      $version = array(
        "title"     => $title,
        "summary"   => $summary,
        "normalized_title" => $normalized_title,
        "timestamp" => time(),
        "tags"      => $tags,
        "file"      => $file_path,
        "author"    => $author,
        "lang"      => $lang,
        "version"   => $version
      );
      
      // add at the begining of the versions
      array_unshift($index['posts'][$id], $version);
   }
   
   // update the index file
   $json = json_encode($index);
   $index_path = 'conf/metadata2.json';
   write_file($index_path, $json);
   
   // reload index to session
   load_post_index();
}

/*
 * Given an array of post versions, returns the one with the highest timestamp.
 * The array follows the structure of one entry of the post index.
 */
function get_latest_post_version($post_versions)
{
   $index = 0;
   if (count($post_versions) > 1)
   {
      for ($i = 1; $i < count($post_versions); $i++)
      {
         if ($post_versions[$i]['timestamp'] > $post_versions[$index]['timestamp'])
         {
            $index = $i;
         }
      }
   }
   return $post_versions[$index];
}

/*
 * Given an array of post versions, returns the lowest timestamp, that is
 * the first time this post was published to show on the UI. Timestamps of
 * newer versions are update timestamps.
 */
function get_post_published_date($post_versions)
{
   $index = 0;
   if (count($post_versions) > 1)
   {
      for ($i = 1; $i < count($post_versions); $i++)
      {
         if ($post_versions[$i]['timestamp'] < $post_versions[$index]['timestamp'])
         {
            $index = $i;
         }
      }
   }
   return $post_versions[$index]['timestamp'];
}

/*
 * Gets the post versions inside an index entry by it's entry id.
 */
function get_post_versions($id)
{
   $index = get_post_index();
   /*
   foreach ($index['posts'] as $entry)
   {
      if ($entry['id'] == $id) return $entry['versions'];
   }
   */
   
   if (isset($index['posts'][$id])) return $index['posts'][$id];
   
   return false;
}

/*
 * Given one specific version of a post, returns its contents from the referenced post file.
 */
function get_post_contents($post)
{
   $post_file = $post['file'];
   if (is_file($post_file))
   {
      $html = file_get_contents ($post_file);
      return $html;
   }
   
   return false;
}

function tags_array_to_csv_string($tags = array())
{
   $csv = '';
   
   foreach ($tags as $i => $tag)
   {
      $csv .= $tag;
      if ($i < count($tags)-1) $csv .= ',';
   }
   
   return $csv;
}

/*
 * === FILES ===
 */

function createEmptyFile($path)
{
   // TODO: chekeo de que no existe el archivo.
   if (is_file($path)) throw new Exception("FileSystem::createEmptyFile - El archivo: $path ya existe.");
   if ($file = fopen($path, 'w+'))
   {
      fwrite($file, "");
      fclose($file);
      return true;
   }
   fclose($file);
   return false;
}

function write_file($filepath, $text)
{
   if ($file = fopen($filepath, 'w+'))
   {
      fwrite($file, $text);
   }
   fclose($file);
}


function getFileNames($path, $match = null, $groups = null)
{
   if (is_dir($path))
   {
      $res = array();
      $d = dir($path);
      while (false !== ($entry = $d->read()))
      {
         if (is_file($path . "/" . $entry))
         {
            //echo "FILE<br/>";
            $matches = null;
            if ($match)
            {
                //echo "MATCH<br/>";
                if (preg_match($match, $entry, $matches))
                {
                    //echo "MATCHES<br/>";
                    if (!$groups) $res[] = $entry;
                    else
                    {
                       $gentry = "";
                       foreach($groups as $i)
                       {
                        $gentry .= $matches[$i];
                       }
                       $res[] = $gentry;
                    }
                }
            }
            else // Si no paso match, le entrego derecho la entrada.
            {
               //echo "ELSE<br/>";
               $res[] = $entry;
            }
         }
      }
      $d->close();
      return $res;
   }
   else
   {
      throw new Exception("FileSystem::getFileNames - El directorio: $path no existe.");
   }
}

/**
 * USERS
 */
/*
 * Loads users JSON.
 */
function get_users()
{
   $_path = 'conf/users.json';
   if (is_file($_path))
   {
      $json = file_get_contents ($_path);
      $users = json_decode($json, true);
      return $users;
   }
   
   return false;
}

/**
 * UTILS
 */


?>
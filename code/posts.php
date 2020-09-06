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
   $file = getcwd() .'/posts/'. $id .'.v1'; // the first file is random.v1, on updates it will save random.v2, random.v3, etc.

   if (is_file($file))
   {
      throw new Exception('A post with the same name already exists, please provide another name or set a custom name');
      return false;
   }
   
   write_file($file, $text);
   
   if ($summary == '')
   {
      $summary = truncate($text);
   }

   return update_post_index($id, $title, $text, $summary, $tags, $author, $lang, $file, $normalized_title, '');
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
   
   $file = getcwd() .'/posts/'. $id .'.v'.($latest_version_num+1);
   
   write_file($file, $text);
   
   if ($summary == '')
   {
      $summary = truncate($text);
   }
   
   return update_post_index($id, $title, $text, $summary, $tags, $author, $lang, $file, $normalized_title, '', ($latest_version_num+1));
}

/*
 * Post title to snake case and substitution of special characters.
 */
function normalized_title($title)
{
   $normalized = trim($title);
   $normalized = strtolower($normalized);
   $normalized = str_replace(" ", "_", $normalized);
   $normalized = filter_special_chars($normalized);
   $normalized = filter_non_letters($normalized);

   return $normalized;
}

function filter_special_chars($string)
{
   $unwanted_array = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                           'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                           'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                           'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                           'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
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
   $index_path = getcwd() .'/conf/metadata2.json';
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
      $post_and_version = array( // versions of this post
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
      
      $index['posts'][$id] = $post_and_version;
      
      $post_version = $post_and_version[0]; // want to return only the version
   }
   else // create a new version of an existing post
   {
      $post_version = array(
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
      array_unshift($index['posts'][$id], $post_version);
   }
   
   // update the index file
   $json = json_encode($index, JSON_UNESCAPED_UNICODE);
   
   $index_path = getcwd() .'/conf/metadata2.json';
   write_file($index_path, $json);
   
   // reload index to session
   load_post_index();
   
   // injects the id in the version to be used by the caller
   $post_version['id'] = $id;
   return $post_version;
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
https://dodona.wordpress.com/2009/04/05/how-do-i-truncate-an-html-string-without-breaking-the-html-code/
@param string $text String to truncate.
@param integer $length Length of returned string, including ellipsis.
@param string $ending Ending to be appended to the trimmed string.
@param boolean $exact If false, $text will not be cut mid-word
@param boolean $considerHtml If true, HTML tags would be handled correctly
@return string Trimmed string.
*/
function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
					unset($open_tags[$pos]);
					}
				// if tag is an opening tag
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate;
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
   else
   {
      throw new Exception('Error writing file at '. $filepath);
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
   $_path = getcwd() .'/conf/users.json';
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
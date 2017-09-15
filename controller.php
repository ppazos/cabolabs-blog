<?php
session_start();
date_default_timezone_set('America/Montevideo');
$_base_dir = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
$_req_url = parse_url($_SERVER['REQUEST_URI']);
$_rel_path = substr($_req_url['path'], strlen($_base_dir));

/*
echo $_base_dir;
print_r( $_req_url );
echo $_rel_path;
*/

include('code/posts.php');

if ($_rel_path == '/')
{
   // force reload from json
   load_post_index();
   $index = get_post_index();

   include('index.php'); // GUI
}
else
{
   $parts = explode('/', $_rel_path);
   $domain = $parts[1];
   switch ($domain)
   {
      case "article": // show article
         $normalized_name_with_extension = $parts[2];
         $normalized_name = basename($normalized_name_with_extension, '.html');
         $versions = get_post_versions($normalized_name);
         $post = get_latest_post_version($versions);
         $contents = get_post_contents($post);

         include('show.php'); // GUI
         
      break;
      case "admin":
         $action = $parts[2];
         switch ($action)
         {
            case "login":
            break;
            case "logout":
            break;
            case "create":
            break;
            case "save":
            break;
            case "edit":
            break;
            case "update":
            break;
         }
      break;
   }
}

?>
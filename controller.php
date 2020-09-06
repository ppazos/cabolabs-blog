<?php
session_start();
date_default_timezone_set('America/Montevideo');
$_base_dir = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
$_req_url = parse_url($_SERVER['REQUEST_URI']);
$_rel_path = substr($_req_url['path'], strlen($_base_dir));

//print_r($_SERVER);

//echo $_base_dir;
//print_r( $_req_url );
//echo $_rel_path;
//echo getcwd();


include('code/posts.php');
include('code/password.php');

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
         $normalized_name_with_extension = $parts[2]; // normalized_name-postID.html
         $pos = strrpos($normalized_name_with_extension, "-");
         $id_and_extension = substr($normalized_name_with_extension, $pos+1); // postID.html
         $id = basename($id_and_extension, '.html'); // this is the id not the normalized name

         // TODO: 404 if not found
         $versions = get_post_versions($id);
         $post = get_latest_post_version($versions);
         $contents = get_post_contents($post);

         include('show.php'); // GUI
         exit();
      break;
      case "admin":

         if (count($parts) == 2) $parts[2] = 'login'; // default action

         $action = $parts[2];

         switch ($action)
         {
            case "login":

               if (!array_key_exists('submit', $_POST))
               {
                  // show login
                  include('login.php'); // GUI
                  exit();
               }

               if (!array_key_exists('username', $_POST) || !array_key_exists('password', $_POST))
               {
                  // missing data
                  $_SESSION['feedback'] = 'username and password are required';
                  //echo $_SERVER['HTTP_REFERER'];
                  header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);
                  exit();
               }

               $users = get_users();
               foreach ($users['users'] as $user)
               {
                  if ($user['username'] != $_POST['username'])
                  {
                     // username doesnt match
                     $_SESSION['feedback'] = 'login failed 1';
                     header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);
                     exit();
                  }


                  if (!password_verify($_POST['password'], $user['password']))
                  {
                     echo 'password_verify';
                     // password doesnt match
                     $_SESSION['feedback'] = 'login failed 2';
                     header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);
                     exit();
                  }


                  $_SESSION['auth'] = true;
                  $_SESSION['user.name'] = $user['name']; // for post create author

                  // redirect to referer if exists or index
                  // $_SERVER['HTTP_REFERER']
                  //echo $_SERVER['HTTP_REFERER'];
                  header('Location: ' . $_base_dir, true, 302);
                  //echo "location ". $_base_dir; /blog
                  exit();
               }

               // user not found
               $_SESSION['feedback'] = 'login failed 3';
               echo $_SERVER['HTTP_REFERER'];
               header('Location: ' . $_SERVER['HTTP_REFERER'], true, 302);
               exit();

            break;
            case "logout":
               unset($_SESSION['auth']);

               // redirect to index
               header('Location: /blog', true, 302);
               exit();
            break;
            case "create":

               include('create.php');

               exit();
            break;
            case "save":
               //print_r($_POST);
               /*
               Array
               (
                   [title] => dfghd
                   [content] => <p>dfghdfg</p>
                   [summary] => dfghdfh
                   [tags] => CaboLabs, Education
               )
               */

               $title   = $_POST['title'];
               $text    = $_POST['content'];
               $summary = $_POST['summary'];

               // if tags is empty, explode has one empty element, filter removes it
               // trime removes whitespaces on each tag.
               $tags    = array_map('trim', array_filter( explode(',', $_POST['tags']) ));
               $author  = $_SESSION['user.name'];
               $lang    = $_POST['lang'];

               try
               {
                  $post = create_post($title, $text, $summary, $tags, $author, $lang, $custom_name = '');
                  echo json_encode(array('message'=>'Article created', 'status'=>'ok', 'redirect'=>$_base_dir.'/article/'.$post['normalized_title'].'-'.$post['id'].'.html'));
               }
               catch (\Exception $e)
               {
                  echo json_encode(array('message'=>$e->getMessage(), 'status'=>'error'));
               }
               exit();
            break;
            case "edit":
               //print_r($_GET);

               $versions = get_post_versions($_GET['article']);
               $post = get_latest_post_version($versions);
               $contents = get_post_contents($post);

               include('edit.php');
               exit();
            break;
            case "update":

               $id      = $_POST['article'];
               $title   = $_POST['title'];
               $text    = $_POST['content'];
               $summary = $_POST['summary'];

               // if tags is empty, explode has one empty element, filter removes it
               // trime removes whitespaces on each tag.
               $tags    = array_map('trim', array_filter( explode(',', $_POST['tags']) ));
               $author  = $_SESSION['user.name'];
               $lang    = $_POST['lang'];

               try
               {
                  $post = update_post($id, $title, $text, $summary, $tags, $author, $lang, $custom_name = '');
                  echo json_encode(array('message'=>'Article updated', 'status'=>'ok', 'redirect'=>$_base_dir.'/article/'.$post['normalized_title'].'-'.$post['id'].'.html'));
               }
               catch (\Exception $e)
               {
                  echo json_encode(array('message'=>$e->getMessage(), 'status'=>'error'));
               }
               exit();
            break;
            default:
               echo "not found ". $action;
         }
      break;
      case "logout": // /logout, same as /admin/logout
         unset($_SESSION['auth']);

         // redirect to index
         header('Location: /blog', true, 302);
         exit();
      break;
   }
}

?>

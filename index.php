<?php



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blog</title>

    <!-- Bootstrap -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/clean-blog.min.css" rel="stylesheet">
    
    <style>
      #edit-menu {
         position: absolute;
         top: 100px;
         right: 20px;
      }
    </style>
  </head>
  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <a class="navbar-brand" href="index.html">CaboLabs Blog</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fa fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="/blog">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.cabolabs.com">Back to CaboLabs.com</a>
          </li>
        </ul>
      </div>
    </nav>
    
    <?php if (array_key_exists('auth', $_SESSION) && $_SESSION['auth'] === true) : ?>
    <!-- edit menu -->
    <nav id="edit-menu">
      <div class="list-group">
        <a href="#" class="list-group-item active">View</a>
        <a href="#" class="list-group-item list-group-item-action">Edit</a>
        <a href="create.php" class="list-group-item list-group-item-action">Create</a>
      </div>
    </nav>
    <?php endif; ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>CaboLabs Health Informatics</h1>
              <span class="subheading">Health Information Systems, Standards and Interoperability</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
        
          <?php
          /*
          + published date is the timestamp of version 1
          + TODO: resolve link to show: /article/normalized_title.html
          + TODO: pagination
          + TODO: entry id is used to show the post, that is the normalized_name of the first version of the post,
                  but the admin might want to change it to improve the URL for SEO, that should be possible setting
                  a custom id or permurl.
          */
          foreach ($index['posts'] as $entry)
          {
             $versions = $entry['versions'];
             $post = get_latest_post_version($versions);
             
             // $post['timestamp'] is the update timestamp if there is more than 1 version
             $published_timestamp = get_post_published_date($versions);
             $date = date("F j, Y, g:i a", $published_timestamp);
             
             echo <<<EX
                <div class="post-preview">
                  <a href="article/{$entry['id']}.html">
                    <h2 class="post-title">{$post['title']}</h2>
                    <h3 class="post-subtitle">{$post['summary']}</h3>
                  </a>
                  <p class="post-meta">Posted by <a href="#">{$post['author']}</a> on {$date}</p>
                </div>
                <hr>
EX;
          }
          ?>
        
          <!-- Pager -->
          <div class="clearfix">
            <a class="btn btn-secondary float-right" href="#">Older Posts &rarr;</a>
          </div>
        </div>
      </div>
    </div>
    
    <hr>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; Your Website 2017</p>
          </div>
        </div>
      </div>
    </footer>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/clean-blog.min.js"></script>
  </body>
</html>
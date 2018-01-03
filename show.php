<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CaboLabs - <?=$post['title']?></title>

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
    <link href="<?=$_base_dir;?>/css/clean-blog.min.css" rel="stylesheet">
    
    <style>
      #edit-menu {
         position: absolute;
         top: 100px;
         right: 20px;
         z-index: 999;
      }
      .mx-auto img {
         max-width: 100%;
      }
    </style>
  </head>
  <body>
    <?php include('nav.php'); ?>

    <?php if (array_key_exists('auth', $_SESSION) && $_SESSION['auth'] === true) : ?>
    <!-- edit menu -->
    <nav id="edit-menu">
      <div class="list-group">
        <a href="<?=$_base_dir;?>/admin/edit?article=<?=$id?>" class="list-group-item list-group-item-action">Edit</a>
        <a href="<?=$_base_dir;?>/admin/create" class="list-group-item list-group-item-action">Create</a>
      </div>
    </nav>
    <?php endif; ?>
    
    <?php
    $published_timestamp = get_post_published_date($versions);
    $date = date("F j, Y, g:i a", $published_timestamp);
    ?>
    
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?=$_base_dir;?>/img/home-bg.jpg')">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1><?=$post['title']?></h1>
              <!--<h2 class="subheading"><?=$post['summary']?></h2>-->
              <span class="meta">Posted by <a href="#"><?=$post['author']?></a> on <?=$date?></span>
            </div>
          </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
          
            <?=$contents;?>
          
          </div>
        </div>
                
        <!-- Social buttons -->
        <div class="addthis_inline_share_toolbox"></div>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a31ee93ae222cf1"></script>
        
      </div><!-- container -->
    </article>

    <?php include('footer.php'); ?>

    <!-- Bootstrap core JavaScript -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    
    <script src="<?=$_base_dir;?>/vendor/popper/popper.min.js"></script>
    <script src="<?=$_base_dir;?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=$_base_dir;?>/js/clean-blog.min.js"></script>
  </body>
</html>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <meta name="description" content="CaboLabs Health Informatics, Standards and Interoperability, professional services, project consultancy, training on standards">
    <meta name="keywords" content="cabolabs, medical informatics, health informatics, standards, interoperability, integration, hl7, dicom, openehr, cda, fhir, smart, mirth, mirth connect, consultancy, training, coaching, clinical databases, repositories, audit">
    <meta name="author" content="Pablo Pazos Gutierrez">

    <title>CaboLabs Blog - <?=$post['title']?></title>

    <link rel="shortcut icon" href="<?=$_base_dir;?>/favicon.ico">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="CaboLabs Health Informatics, Standards and Interoperability" />
    <meta property="og:description" content="Education, advisory, coaching, system integration, development, professional services" />
    <meta property="og:url" content="https://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>" />
    <meta property="og:site_name" content="CaboLabs Health Informatics, Standards and Interoperability" />
    <meta property="og:image" content="http://<?=$_SERVER['HTTP_HOST']?>/images/cabolabs_vertical_square_web_text.png" />
    <meta property="og:image:secure_url" content="https://<?=$_SERVER['HTTP_HOST']?>/images/cabolabs_vertical_square_web_text.png" />
    <meta property="og:image:width" content="310" />
    <meta property="og:image:height" content="310" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:alt" content="CaboLabs Health Informatics, Standards and Interoperability" />

    <!-- Bootstrap -->
    <link href="<?=$_base_dir;?>/css/bootstrap.min.css" rel="stylesheet">

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
         height: auto;
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

            <hr/>

          </div>
        </div>


        <!-- disqus -->
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div id="disqus_thread"></div>
            <script>

             /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
             // <?=$_SERVER['HTTP_HOST']?>

             <?php
             $protocol = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://');
             ?>

             var disqus_config = function () {
                this.page.url = '<?=$protocol?><?=$_SERVER['SERVER_NAME']?><?=$_base_dir?>/article/<?=$post['normalized_title']?>-<?=$id?>.html';
                this.page.identifier = '<?=$id?>';
             };

             (function() { // DON'T EDIT BELOW THIS LINE
             var d = document, s = d.createElement('script');
             s.src = 'https://cabolabs-blog.disqus.com/embed.js';
             s.setAttribute('data-timestamp', +new Date());
             (d.head || d.body).appendChild(s);
             })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
          </div>
        </div>

        <hr/>

        <!-- Social buttons -->
        <div class="addthis_inline_share_toolbox"></div>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a31ee93ae222cf1"></script>

      </div><!-- container -->
    </article>



    <?php include('footer.php'); ?>

    <!-- Bootstrap core JavaScript -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="<?=$_base_dir;?>/js/bootstrap.bundle.min.js"></script>
    <script src="<?=$_base_dir;?>/js/clean-blog.min.js"></script>
  </body>
</html>

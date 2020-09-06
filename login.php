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

    <title>CaboLabs Blog - Login</title>

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
    <link href="css/clean-blog.min.css" rel="stylesheet">

    <style>
      form {
         width: 100%;
      }
      form input {
         width: 100%;
      }
    </style>
  </head>
  <body>
    <?php include('nav.php'); ?>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>CaboLabs Blog</h1>
              <span class="subheading">A Blog Theme by Start Bootstrap</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <?php
        //phpinfo();
        if (array_key_exists('feedback', $_SESSION))
        {
           echo $_SESSION['feedback'];
           unset($_SESSION['feedback']);
        }
        ?>
        <form action="admin/login" method="post" id="create_form">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" value="" required="true" />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" value="" required="true" />
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>
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
            <p class="copyright text-muted">Copyright &copy; CaboLabs <?=date("Y")?></p>
          </div>
        </div>
      </div>
    </footer>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="<?=$_base_dir;?>/js/bootstrap.bundle.min.js"></script>
    <script src="js/clean-blog.min.js"></script>
  </body>
</html>

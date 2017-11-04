<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Bog</title>

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
    
    <!-- tags -->
    <link href="<?=$_base_dir;?>/vendor/jqueryui-autocomplete/jquery-ui.min.css" rel="stylesheet">
    <link href="<?=$_base_dir;?>/vendor/bootstrap-tokenfield/css/bootstrap-tokenfield.min.css" rel="stylesheet">
    <link href="<?=$_base_dir;?>/vendor/bootstrap-tokenfield/css/tokenfield-typeahead.min.css" rel="stylesheet">
    
    <style>
      #edit-menu {
         position: absolute;
         top: 100px;
         right: 20px;
      }
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
    
    <!-- edit menu -->
    <!--
    <nav id="edit-menu">
      <div class="list-group">
        <a href="index.php" class="list-group-item list-group-item-action">View</a>
        <a href="#" class="list-group-item list-group-item-action">Edit</a>
        <a href="#" class="list-group-item active">Create</a>
      </div>
    </nav>
    -->
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?=$_base_dir;?>/img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Clean Blog</h1>
              <span class="subheading">A Blog Theme by Start Bootstrap</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <form action="<?=$_base_dir;?>/admin/save" method="post" id="create_form">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="" class="form-control" required />
          </div>
          <div class="form-group">
            <label for="content">Content</label>
            <textarea id="editor" name="content" required></textarea>
          </div>
          <div class="form-group">
            <label for="summary">Summary</label>
            <textarea name="summary" class="form-control"></textarea>
          </div>
          <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" name="tags" id="tags" value="" class="form-control" />
          </div>
          <div class="form-group">
            <label>Lang</label><br/>
            <label>EN <input type="radio" name="lang" value="en" class="form-control" checked="checked" /></label>
            <label>ES <input type="radio" name="lang" value="es" class="form-control" /></label>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
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
            <p class="copyright text-muted">Copyright &copy; Your Website 2017</p>
          </div>
        </div>
      </div>
    </footer>
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="<?=$_base_dir;?>/vendor/popper/popper.min.js"></script>
    <script src="<?=$_base_dir;?>/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=$_base_dir;?>/js/clean-blog.min.js"></script>
    <script src="<?=$_base_dir;?>/vendor/tinymce/tinymce.min.js"></script>
    
    <!-- tags -->
    <script src="<?=$_base_dir;?>/vendor/jqueryui-autocomplete/jquery-ui.min.js"></script>
    <script src="<?=$_base_dir;?>/vendor/bootstrap-tokenfield/bootstrap-tokenfield.min.js"></script>
    <script>
      $(document).ready(function() {
        
        tinymce.init({
          selector:'#editor',
          height: 600,
          resize: false,
          menubar: false,
          branding: false,
          plugins: "link",
          //menubar: "insert",
          toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link",
          default_link_target: "_blank",
          link_list: [
            {title: 'CaboLabs Home', value: 'https://cabolabs.com'},
            {title: 'CaboLabs Blog', value: 'https://cabolabs.com/blog'}
          ] // https://www.tinymce.com/docs/plugins/link/
          //border: 0
        }).then(function(editors){
          //$('.mce-tinymce').css('border','0');
        });
        
        $('#tags').tokenfield({
           autocomplete: {
             source: ['openEHR','CaboLabs','EHR','EHRServer','Education','Events','CDR','SNOMED-CT','HL7','Open Source','Platforms'],
             delay: 100
           },
           //showAutocompleteOnFocus: true
         });
      });

      $("#create_form").submit(function(e) {

        var url = this.action;

        // Reset validation
        $('input').parent().removeClass('has-danger');
        $('input').removeClass('form-control-danger');

        // makes tinyMCE to save the content to the textarea for submit
        // without this, the first submit has empty text
        tinyMCE.get("editor").save();
        
        console.log( $("#create_form").serialize() );

        
        $.ajax({
          type: "POST",
          url: url,
          data: $("#create_form").serialize(),
          success: function(data, statusText, response)
          {
            console.log(data);
            // Update patient table with new patient
            /*
            $('#list_container').html(data);
            $('#create_modal').modal('hide');
            */
          },
          error: function(response, statusText)
          {
            //console.log(JSON.parse(response.responseText));
            console.log(response);
            // Display validation errors on for fields
            /*
            errors = JSON.parse(response.responseText);
            $.each(errors, function( index, error ) {
              console.log(error.defaultMessage);
              $('[name='+error.field+']').parent().addClass('has-danger'); // shows border on form-control children
              $('[name='+error.field+']').addClass('form-control-danger'); // shows icon if input

              if (error.field == 'text') $('.mce-tinymce').addClass('form-control'); // shows border
            });
            */
          }
        });
        

        e.preventDefault();
      });

      /*
       * Reset form on modal open
       */
      $('#create_modal').on('show.bs.modal', function (event) {
        $("#create_form")[0].reset();
      });
    </script>
  </body>
</html>
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

    <title>CaboLabs Blog - Edit article</title>
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

    <!-- tags -->
    <link href="<?=$_base_dir;?>/vendor/jqueryui-autocomplete/jquery-ui.min.css" rel="stylesheet">
    <link href="<?=$_base_dir;?>/vendor/bootstrap-tokenfield/css/bootstrap-tokenfield.min.css" rel="stylesheet">
    <link href="<?=$_base_dir;?>/vendor/bootstrap-tokenfield/css/tokenfield-typeahead.min.css" rel="stylesheet">

    <style>
      #edit-menu {
         position: absolute;
         top: 100px;
         right: 20px;
         z-index: 999;
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

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('<?=$_base_dir;?>/img/home-bg.jpg')">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1>Edit article</h1>
              <span class="subheading"></span>
            </div>
          </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <form action="<?=$_base_dir;?>/admin/update" method="post" id="create_form">
          <input type="hidden" name="article" value="<?=$_GET['article']?>" />
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" value="<?=$post['title']?>" class="form-control" required />
          </div>
          <div class="form-group">
            <label for="content">Content</label>
            <textarea id="editor" name="content" required><?=$contents?></textarea>
          </div>
          <div class="form-group">
            <label for="summary">Summary</label>
            <textarea name="summary" class="form-control"><?=$post['summary']?></textarea>
          </div>
          <div class="form-group">
            <label for="tags">Tags</label>
            <input type="text" name="tags" id="tags" value="<?=tags_array_to_csv_string($post['tags'])?>" class="form-control" />
          </div>
          <div class="form-group">
            <label>Language</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="lang" type="radio" id="lang_en" value="en" <?=($post['lang']=='en')?'checked="checked"':''?>>
            <label class="form-check-label" for="lang_en">
              EN
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" name="lang" type="radio" id="lang_es" value="es" <?=($post['lang']=='es')?'checked="checked"':''?>>
            <label class="form-check-label" for="lang_es">
              ES
            </label>
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>

    <?php include('footer.php'); ?>

    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="<?=$_base_dir;?>/js/bootstrap.bundle.min.js"></script>
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
          plugins: "link image media",
          //menubar: "insert",
          toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link unlink | image media | removeformat",
          default_link_target: "_blank",
          media_live_embeds: true, // https://www.tinymce.com/docs/plugins/media/
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

      // FIXME: validate like create

      $("#create_form").submit(function(e) {

        var url = this.action;

        // makes tinyMCE to save the content to the textarea for submit
        // without this, the first submit has empty text
        tinyMCE.get("editor").save();

        $.ajax({
          type: "POST",
          url: url,
          data: $("#create_form").serialize(),
          dataType: 'json',
          success: function(data, statusText, response)
          {
            //console.log(data);

            if (data['status'] == 'ok')
            {
              window.location.href = data['redirect'];
            }
            else
            {
              alert(data['message']);
            }
          },
          error: function(response, statusText)
          {
            //console.log(JSON.parse(response.responseText));
            console.log(response);
          }
        });

        e.preventDefault();
      });
    </script>
  </body>
</html>

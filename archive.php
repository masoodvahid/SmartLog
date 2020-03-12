<?php require('config.php') ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['app_name'].' '.$config['version'] ?></title>
  <link rel="icon" type="image/png" href="img/favicon.png" />
  <link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
  <link rel="stylesheet" href="css/icofont.min.css" type='text/css' media='all'> 
  <link rel="stylesheet" href="css/jquery-confirm.css"> 
  <script src="js/jquery-3.4.1.min.js"></script>    
  <script src="js/jquery-confirm.min.js"></script>
  <script>
  $(document).ready(function() { 
    
    $(".delete").click(function(){
      var filename = $(this).data("name");
      var key = $(this).data("key");
      $.alert({
          columnClass: 'small',
          theme: 'supervan',  // material, light, dark, bootstrap        
          title: "<i class='icofont-ui-delete'></i> Delete File",
          content: "Are you sure to delete "+filename+ " ?",
          buttons: {
            OK: function () {
              delete_file(filename,key)
            },
            Cancel: function(){
              // Nothing happend
            }
          }
        }); 
    })

    function delete_file(filename,key) {      
      $.ajax({        
        type: 'GET', 
        url: 'core/core.php', 
        data: { request: 'delete', file_name: filename }, 
        dataType: 'json',
        success: function(data) {
          if (data.status == true){
            $("#"+key).html(data.message);            
          }else{
            $('#'+key).append(' (ERROR : '+data.message+')');            
          }
        }
      });       
    };  

  });
  
  </script> 
</head>
<body>
    <div class="header">
      <ul>
        <li><a href='index.php'><i class="icofont-hand-drawn-alt-left"></i> Back</a></li>                   
      </ul>
    </div>
    <div><img class='logo' src='img/logo.png'></div>        
    <div id="tail">
      <ul class='file_list'>            
      <?php
        $dir = array();
        $files = array_diff(scandir($config['archiveFolder']), array('.', '..'));
        foreach ($files as $key => $file){
            echo 
            '<li>
              <ul>               
                <li>
                  <a href="core/core.php?request=download&file='.$file.'" download><i class="icofont-download download"></i></a>
                </li>
                <li>
                  <i class="icofont-ui-delete delete" data-name="'.$file.'" data-key="'.$key.'"></i>
                </li>
                <li>
                  <a href="core/core.php?request=download&file='.$file.'" download>'.$file.'</a>
                </li>
              </ul>
            </li>';
        }      
      ?>
      </ul>
    </div>    
    
</body>
</html>

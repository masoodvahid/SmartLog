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
  <script src="js/jquery.initialize.min.js"></script>   
  <script src="js/jquery-confirm.min.js"></script>
  <script src="js/jquery.md5.js"></script>
  <script src="js/smartlog.js"></script>
  <script>
  $(document).ready(function() { 
        
    lock();          

    logFileMonitor("none","1");

    $.initialize(".noisy", initializer);

    $("#clear").click(clear);
    
    $("#filter").change(filter)

    $("#mute").click(mute)

    $("#lock").click(lock)

    $("#unlock").click(unlock)

    $("#password").keypress(enter)

    $("#search").click(search_box)
    
    $("#search_input").keyup(search)
  
  });
  
  </script> 
</head>
<body>
    <div class="header">
      <ul>
        <li id="lock"><i class="icofont-ui-lock"></i> Lock</li>
        <li id="mute"><i class="icofont-volume-mute"></i> Mute</li>        
        <li id='archive'><a href='archive.php'><i class="icofont-ui-folder"></i> Archive</a></li>
        <li>
          <div id='search'><i class="icofont-search-2"></i> Search </div>
          <div class='search' style='display: none'>
            <input id='search_input'>
            <div id='search_count'>0</div>
          </div>
        </li>        
        <li class="filter">
          <select id='filter'>
            <option value='show_all' selected> Filter Results </option>
            <?php 
              foreach ($config['key'] as $key){
                echo "<option value='".$key['word']."' style='color :".$key['color']."'>$key[word]</option>"; 
              }
            ?>
          </select>
        </li>
        <li id="clear"><i class="icofont-trash"></i> Clear</li>           
      </ul>
    </div>
    <div><img class='logo' src='img/logo.png'> <?php echo date("Y/m/d H:i:s") ?> >> <span id='keeplive'></span></div>
    <div id="lockscreen" style='display: none'>
      <div class='unlocker'>
        <img class='lock_logo' src='img/logo.png'>
        <input id='username' type="text" placeholder='username'>
        <input id='password' type="password" placeholder='password'>
        <button id='unlock'><i class="icofont-ui-unlock"></i> Unlock</button>
        <span id='error'></span>
      </div>      
    </div>
    <div id="tail"></div>    
    
</body>
</html>

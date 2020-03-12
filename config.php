<?php

session_start();

/**
 * App Config
 */
$config['version'] = "1.2.3";
$config['app_name'] = 'KTL Log';


/**
 * User Managments
 */
$config['user']['admin']    = ['password' => '12345'];
$config['user']['manager']  = ['password' => '10203040'];


/**
 * Base Configuration
 */
date_default_timezone_set('ASIA/TEHRAN');
$config['sendSms']      = false;
$config['playSound']    = true;
$config['number_of_last_lines']  = 2;
$config['number_of_last_lines_in_first_run'] = 30;
$config['sync_time']    = 5000;    // MiliSeconds


/**
 * Log File URL
 */
$config['logFileURL'] = "../../../logs/mariadb.log";
$config['archiveFolder'] = '../../logs/';


/**
 * Define Key Word and colors
 * Color  : Named color and RGB color code available                --> example : Red or #cecece or #231225 
 * Sound  : ''= Default, '-'= Mute, 'soundfilename' = Custom        --> example : alarm1.mp3 (just use sounds placed in media sound folder) // Without set this value Alarm1.mp3 play // Set '-' (dash) and it means mute keywords
 * Icon   : Just Place icon markap from https://icofont.com/icons   --> example : <i class="icofont-warning"></i>
 * Limits : No limit on words definiation                           
 */
$config['key'][1] = ['word'=>'Home02_RGW05_Khoy', 'color'=>'#f00'     ,'sound'=>'',           'icon'=>'<i class="icofont-warning"></i>'];
$config['key'][2] = ['word'=>'Orumieh_Gard_Abad_NOTSET', 'color'=>'#03fff3'  ,'sound'=>'alarm2.mp3', 'icon'=>'<i class="icofont-tick-boxed"></i>'];
$config['key'][3] = ['word'=>'304', 'color'=>'yellow'   ,'sound'=>'alarm5.mp3', 'icon'=>'<i class="icofont-tick-boxed"></i>'];


/**
 * SMS service configuration
 */
$config['sms']['phoneNumber'] = '';
$config['sms']['service'] = '';
$config['sms']['username'] = '';
$config['sms']['password'] = '';


/**
 * MYSQL DB Config
 */
$config['mysql']['username'] = 'root';
$config['mysql']['password'] = '';
$config['mysql']['db'] = '';
$config['mysql']['host'] = 'localhost';


if($_GET['login']){
    $user = $_GET['login'];
    if ($config['user']["$user"]){
        echo md5($config['user']["$user"]["password"]);
    }
}

if($_GET['sync_time']){
    echo $config['sync_time'];
}
?>
<?php

require('../config.php');
require('helper.php');

if (isset($_GET['request'])) {  
    if ($_GET['request'] == 'start'){
        if (file_exists($config['logFileURL'])){            
            $core = new Helper($config); 
            if($_GET['isFirstRun'] == '1'){
                $lines = $core->tail($config['number_of_last_lines_in_first_run']);
                $output = $core->alarmer($lines,$_GET['filter']);
            }else{
                $lines = $core->tail($config['number_of_last_lines']);
                $output = $core->alarmer($lines,$_GET['filter']);
            }                        
            $response['status'] = true;
            $response['time'] = $output['time'];
            $response['message'] = $output['msg'];
        }else{
            $response['status'] = false;
            $response['message'] = 'Log file not founded. please check config file. URL : '.$config['logFileURL'];
        }
    }else if($_GET['request'] == 'delete'){
        $full_path = "../".$config['archiveFolder'].$_GET['file_name'];
        if(empty($_GET['file_name']) OR !file_exists($full_path)){
            $response['status'] = false;
            $response['message'] = 'No File recognized.';
        }else{            
            $core = new Helper($config);
            $core_response = $core->delete($_GET['file_name']);
            $response['status'] = true;
            $response['message'] = $core_response;
        }
    }else if ($_GET['request'] == 'download'){
        if(empty($_GET['file']) OR !file_exists("../".$config['archiveFolder'].$_GET['file'])){            
            header("HTTP/1.1 404 Not Found");
            exit;            
        }else{
            $full_path = "../".$config['archiveFolder'].$_GET['file'];      
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="'.$_GET['file'].'"');            
            header("Content-Type: text/plain");
            readfile($full_path);
            exit;
        }
    }else{
        $response['status'] = true;
        $response['message'] = 'Proccess Stoped';
    }
    echo json_encode($response);
} else {
    echo 'Access Denied';
}
?>
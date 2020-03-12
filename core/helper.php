<?php 
class Helper
{    
    private $config;
    
    function __construct($config) 
    {
        //$this->filename = $config['logFileURL'];
        $this->config = $config;
    }
 
    public function tail($lines = 1) 
    {
        $data = '';
        $logFile = fopen($this->config['logFileURL'], "r");
        $block = 2048;
        $logFileSize = filesize($this->config['logFileURL']);
        // echo 'FileSize ='.$logFileSize."<br>";
        $i = 1;
        for($len=0; $len<$logFileSize; $len+=$block) 
        {
            $seekSize = ($logFileSize - $len > $block) ? $block : $logFileSize - $len;
            // echo 'SeekSize ='.$seekSize."<br>";

            fseek($logFile, ($len + $seekSize) * -1, SEEK_END);
            $data = fread($logFile, $seekSize) . $data;
            
            // echo "Data =<br>".$data;
            // echo "<br> Count Lines : ".substr_count($data, "\n");            
            if(substr_count($data, "\n") >= $lines + 1) 
            {
                /* Make sure that the last line ends with a '\n' */
                if(substr($data, strlen($data)-1, 1) !== "\n") {
                    $data .= "\n";
                }
 
                preg_match("!(.*?\n){". $lines ."}$!", $data, $match);
                fclose($logFile);
                //var_dump($match);
                return $match[0];
            }            
        }
        fclose($logFile);        
        return $data; 
    }

    public function alarmer($input, $filter='none'){
        $check = false;
        $class = "noisy";
        $res['time'] = date("H:i:s"); 
        if ($_SESSION['old']['message'] == $input){
            $res['msg'] = '.';
        }else{
            foreach ($this->config['key'] as $key){
                if ($check == false AND preg_match("/{$key['word']}/i", $input)) {
                    if ($filter != 'none' and $key['word'] != $filter){
                        $class="hide";                                               
                    }
                    $res['msg'] = "<div class='log $class $key[word]' style='color: $key[color]' data-sound='$key[sound]' data-word='$key[word]' >".@$key['icon']." ".$input."</div>";                    
                    $check = true;
                }
            }
            if ($check == false){
                $filter!='none'?$class='hide':$class="";
                $res['msg'] = "<div class='log $class simple'>".$input."</div>";                
            }
        }
        $_SESSION['old']['message'] = $input;
        return $res;
    }

    public function file_list(){        
        $dir = array();
        $files = array_diff(scandir($this->config['archiveFolder']), array('.', '..'));
        foreach ($files as $key => $file){
            $dir[] = $file;
        }
        $dir = json_encode($dir);
        return $dir;
    }

    public function delete($filename){        
        unlink("../".$this->config['archiveFolder'].$filename);
        return 'File Deleted';         
    }
}

?>
<?php
$file = 'text.log';
// The new person to add to the file
$person = array(
    "John Smith",
    "Smith Lopez",     
    "Ferdinand Corleone", 
    "Harry Potter", 
    "Jamth Smith", 
    "Daniel Blansh", 
    "Fernando Gomez",
    "Marrya Carry",
    "Lorenzo Partizane",
    "Mosimmo Duty"
);
// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
while(true){
    usleep(3000000);
    file_put_contents($file, date('H:i:s').'--'.$person[rand(0,9)]."\n", FILE_APPEND | LOCK_EX);
}

?>
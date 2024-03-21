<?php

require_once __DIR__."/../src/parallel.php";

use parallel\parallel\Thread;

$thread = new Thread();

// Here you don't declare the function with a name but you pass it directly
$thread->start(function(){
    for ($i=0; $i < 5; $i++) {
        $file = __DIR__."/test$i"; 
        file_put_contents($file, "ciao$i");
        sleep(1);
        unlink($file);
    }
});

echo "Here the code go forward while another process";
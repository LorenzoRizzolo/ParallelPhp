<?php

require_once __DIR__."/../src/parallel.php";

use parallel\parallel\Thread;

$thread = new Thread();

function write(){
    for ($i=0; $i < 5; $i++) {
        $file = __DIR__."/test$i"; 
        file_put_contents($file, "ciao$i");
        sleep(1);
        unlink($file);
    }
}

echo "Started new process: ".$thread->start('write')."\n";

// Here the father process is waiting the end of child process
$thread->join();

echo "Here the code has waited the finish of process";
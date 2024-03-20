<?php

namespace parallel\parallel;

class Thread {
    private $pid;

    public function start($function) {
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('Could not fork');
        } elseif ($pid) {
            $this->pid = $pid;
        } else {
            fclose(STDOUT);
            $STDOUT = fopen('/dev/null', 'w');
            call_user_func($function);
            exit();
        }
    }

    public function join() {
        if ($this->pid) {
            pcntl_waitpid($this->pid, $status);
        }
    }
}

$thread = new Thread();

function write(){
    for ($i=0; $i < 5; $i++) { 
        file_put_contents("test$i", "ciao$i");
        sleep(1);
        unlink("test$i");
    }
}

$thread->start('write');

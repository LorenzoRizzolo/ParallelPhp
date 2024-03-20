<?php

class Thread {
    private $pids = [];
    private $threads = [];

    public function start($function, $priority = 0) {
        $this->threads[$priority][] = $function;
    }

    public function run() {
        foreach ($this->threads as $priority => $functions) {
            foreach ($functions as $function) {
                $pid = pcntl_fork();
                if ($pid == -1) {
                    die('Could not fork');
                } elseif ($pid) {
                    // Si tratta del processo genitore
                    $this->pids[] = $pid;
                } else {
                    // Si tratta del processo figlio
                    fclose(STDOUT);
                    $STDOUT = fopen('/dev/null', 'w');
                    call_user_func($function);
                    exit();
                }
            }
            // Attendiamo che tutti i processi figli di questa priorità abbiano completato l'esecuzione
            // foreach ($this->pids as $pid) {
            //     pcntl_waitpid($pid, $status);
            // }
            // Ripuliamo i pid dei processi figli che hanno terminato
            $this->pids = [];
        }
    }

    public function join() {
        // Non facciamo nulla qui per evitare di aspettare i processi figli
    }
}

$thread = new Thread();

function write(){
    for ($i=0; $i < 5; $i++) { 
        file_put_contents("test_$i", "ciao$i");
        sleep(1);
        unlink("test_$i");
    }
}

function anotherFunction(){
    for ($i=0; $i < 5; $i++) { 
        file_put_contents("test2_$i", "ciao$i");
        sleep(1);
        unlink("test2_$i");
    }
}

// Eseguiamo 'anotherFunction' prima di 'write' perché ha priorità più alta (valore più basso)
$thread->start('anotherFunction', 0);
$thread->start('write', 1);

$thread->run();

<?php

namespace parallel\parallel;

/**
 * Thred class
 * This class id used to allocate a function into another thread 
 * it permit you to lighten the processes and run them in background
 */

class Thread {

    /**
     * Process ID of the new child process
     */
    private int $pid;

    /** 
     * It starts the new child process on another thread
     * @param callable function $function is the function to allocate into the new process
     */
    public function start(callable $function, array $args = []) {
        $pid = pcntl_fork();
        if ($pid == -1) {
            error_log('Could not fork');
            exit();
        } elseif ($pid) {
            $this->pid = $pid;
        } else {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $this->startOnWin($function, $args);
            } else {
                $this->startOnUnix($function, $args);
            }
            exit();
        }
        return $pid;
    }


    /**
     * startOnUnix is used to start the process on unix system like Linux or MacOS
     */
    private function startOnUnix(callable $function) {
        // fclose(STDOUT);
        // $outputFile = '/dev/null';
        // $STDOUT = fopen($outputFile, 'w');
        // if (!$STDOUT) {
        //     error_log('Failed to open ' . $outputFile . ' for writing');
        //     exit();
        // }
        call_user_func($function);
    }

    /**
     * startOnUnix is used to start the process on Windows
     */
    private function startOnWin(callable $function) {
        // Serialize the function to pass it as an argument to the script
        $serializedFunction = serialize($function);
        // Escape the serialized function for use in the command
        $escapedFunction = escapeshellarg($serializedFunction);
        // Command to execute the script with serialized function as argument
        $command = 'php -r "include \'script.php\'; unserialize(' . $escapedFunction . ');"';
        // Execute the command
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("file", "error-output.txt", "a")
        );
        $process = proc_open($command, $descriptorspec, $pipes);
        if (is_resource($process)) {
            fclose($pipes[0]);
            fclose($pipes[1]);
            proc_close($process);
        }
    }
    
    
    /**
     * The join() method is used to synchronize the parent process with the child process
     * so that the parent process waits for the child process to complete its execution before continuing execution
     */
    public function join() {
        if ($this->pid) {
            pcntl_waitpid($this->pid, $status);
            // $status contains informations about the end of the $pid process 
            // if you put null in place of $status it will not return any value
            return $status;
        }
    }
}
?>

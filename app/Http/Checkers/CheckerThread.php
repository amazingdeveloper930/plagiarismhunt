<?php

namespace App\Http\Checkers;


class CheckerThread extends Thread {

    public $text;
    // public $status;
    public function __construct($text) {
        $this->text = $text;
    }

    public function setText($text)
    {
        $this -> text = $text;
    }


    public function run() {
        if ($this->text) {
           echo $this -> text;
        }
    }
}


?>
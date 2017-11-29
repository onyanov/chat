<?php

abstract class Controller {

    private $request;
    
    public function __construct($request) {
        $this->request = $request;
    }

    public function request() {
        return $this->request;
    }
    
}

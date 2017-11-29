<?php

class Request {

    const CONTROLLER_NAME_DEFAULT = "photo";

    const ACTION_NAME_DEFAULT = "index";

    private $controllerName;

    private $actionName;

    private $params;

    private $paramsGet;
    
    /*
    requestUri: /v2/photo/33?ghg=33
    paramsGet: Array ( [ghg] => 33 ) 
    uri: /v2/photo/33
    */
    public function __construct() {
        $requestUri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
        $uri = filter_input(INPUT_SERVER, 'SCRIPT_URL', FILTER_SANITIZE_URL);
        $uri = trim($uri, "/");
        $uriParams = explode('/', $uri);
        array_splice($uriParams, 0, 1);

        if (isset($uriParams[0])) {
            $this->controllerName = $uriParams[0];
        }

        if (isset($uriParams[1])) {
            $this->actionName = $uriParams[1];
        }

        print_r($uriParams);

        
        if (count($uriParams) > 3) {
            $this->params = array();
            for ($i = 2; $i < count($uriParams) - 1; $i += 2) {
                $this->params[$uriParams[$i]] = $uriParams[$i + 1];
            }
        }
        
        $this->paramsGet = filter_input_array(INPUT_GET, FILTER_SANITIZE_URL);
        
    }

    public function getControllerName() {
        return $this->controllerName ?: self::CONTROLLER_NAME_DEFAULT;
    }

    public function getActionName() {
        return $this->actionName ?: self::ACTION_NAME_DEFAULT;
    }

    public function params($name) {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
    }

    public function get($name) {
        if (isset($this->paramsGet[$name])) {
            return $this->paramsGet[$name];
        }
    }
}

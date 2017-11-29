<?php
require_once 'Controller.php';
require_once 'Exception/CustomException.php';
require_once 'Exception/NotFoundException.php';
require_once 'Request/Request.php';

class Application {

    private $_controller;
    private $paramsGet;
    private $uri;

    public function __construct() {
    
    }

    public function bootstrap() {
        $this->_request = new Request();

        $this->_controller = $this->buildController();
        $this->_model = $this->buildModel();
        
        return $this;
    }

    public function run() {
try {
        $action = $this->_request->getActionName();
        if (!method_exists($this->_controller, $action)) {
            throw new NotFoundException("Не найден метод $action");
        }
        call_user_func(array($this->_controller, $action));
        } catch (NotFoundException $e) {
            error_log("NotFoundException at uri " . $_SERVER['REQUEST_URI'] . " : " . $e->getTraceAsString());
            $e->show();
        }
    }

    private function buildController() {
        try {
            $controllerSname = $this->_request->getControllerName();
            $controllerName = ucfirst($controllerSname) . 'Controller';
            $controllerPath = APPLICATION_PATH . "/controllers/$controllerName.php";
            
            if (!file_exists($controllerPath)) {
                throw new NotFoundException("Контроллер $controllerSname не существует");
            }
            
            require_once $controllerPath;
            $controller = new $controllerName($this->_request);

            return $controller;            

        } catch (NotFoundException $e) {
            error_log("NotFoundException at uri " . $_SERVER['REQUEST_URI'] . " : " . $e->getTraceAsString());
            $e->show();
        }
    }


    private function buildModel() {
        try {
            $controllerSname = $this->_request->getControllerName();
            $controllerName = ucfirst($controllerSname) . 'Controller';
            $controllerPath = APPLICATION_PATH . "/controllers/$controllerName.php";
            
            if (!file_exists($controllerPath)) {
                throw new NotFoundException("Контроллер $controllerSname не существует");
            }
            
            require_once $controllerPath;
            $controller = new $controllerName($this->_request);
            $action = $this->_request->getActionName();

            if (!method_exists($controller, $action)) {
                throw new NotFoundException("Не найден метод $controllerName->$action");
            }

            call_user_func(array($controller, $action));

        } catch (NotFoundException $e) {
            error_log("NotFoundException at uri " . $_SERVER['REQUEST_URI'] . " : " . $e->getTraceAsString());
            $e->show();
        }
    }
    
}

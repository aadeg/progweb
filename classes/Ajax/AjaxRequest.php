<?php
namespace Ajax;

use \Input;
use \AuthManager;

class AjaxRequest {
    
    protected $responseCode;

    public function __construct(){
        $this->responseCode = 200;
    }

    protected function authRequired() { return true; }
    
    public function handleRequest(){
        if ($this->authRequired() && !AuthManager::isAuthenticated()){
            http_response_code(401);
            return;
        }

        $reqMethod = $_SERVER['REQUEST_METHOD'];
        if (!in_array($reqMethod, $this->getAllowedMethods())){
            http_response_code(405); // Method Not Allowed
            return;
        }

        $reqData = Input::getAll($reqMethod);
        $response = $this->onRequest($reqData);

        header('Content-Type: application/json');
        http_response_code($this->responseCode);
        echo json_encode($response);
    }

    
    protected function onRequest($data) {
        return [];
    }

    protected function error($resCode, $msg){
        $this->responseCode = $resCode;
        return ['message' => $msg];
    }

    protected function requireFields($data, $fields, &$errorMsg){
        foreach ($fields as $field){
            if (!$this->requireField($data, $field, $errorMsg))
                return false;
        }
        return true;
    }

    protected function requireField($data, $field, &$errorMsg){
        if (!isset($data[$field])){
            $errorMsg = ['message' => "Campo '$field' mancante"];
            $this->responseCode = 400;
            return false;
        }
        return true;
    }
}
?>

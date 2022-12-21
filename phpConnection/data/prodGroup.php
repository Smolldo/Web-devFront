<?php
    class ProdGroup implements JsonSerializable{
    private $code;
    private $model;
    function __construct( $code, string $model = ''){
        $this->code = $code;
        $this->model = $model;
    }
    function getCode(){
        return $this->code;
    }
    function getModel(){
        return $this->model;
    }
    public function jsonSerialize(){
        return [
            'code' => $this->code,
            'model' => $this->model
        ];
    }
    }
?>
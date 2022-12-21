<?php
    class Item implements JsonSerializable{
    private $code;
    private $modelName;
    private $model_code;
    function __construct(int $code, string $modelName = '', ProdGroup $model_code = null){
        $this->code = $code;
        $this->modelName = $modelName;
        $this->model_code = $model_code;

        
    }
    function getCode(){
        return $this->code;
    }
    function getModelName(){
        return $this->modelName;
    }
    function getModelCode(){
        return $this->model_code;
    }

    public function jsonSerialize(){
        return [
            'code' => $this->code,
            'modelName' => $this->modelName
        ];
    }
    }
?>
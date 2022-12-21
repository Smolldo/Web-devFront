<?php
    class Sailor implements JsonSerializable{
    private $code;
    private $sailorName;
    function __construct(int $code, string $sailorName = ''){
        $this->code = $code;
        $this->sailorName = $sailorName;
    }
    function getCode(){
        return $this->code;
    }
    function getSailorName(){
        return $this->sailorName;
    }
    public function jsonSerialize(){
        return [
            'code' => $this->code,
            'sailorName' => $this->sailorName
        ];
    }
    }
?>
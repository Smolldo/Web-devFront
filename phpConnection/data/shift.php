<?php
    class Shift implements JsonSerializable{
    private $code;
    private $shifts;
    public function __construct(int $code, string $shifts= ''){
        $this->code = $code;
        $this->shifts = $shifts; 
    }
    function getCode(){
        return $this->code;
    }
    function getShift(){
        return $this->shifts;
    }
    public function jsonSerialize(){
        return [
            'code' => $this->code,
            'shift' => $this->shifts
        ];
    }
    }
?>
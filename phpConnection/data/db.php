<?php
use Vtiful\Kernel\Format;
    class InstrumentDB{
     private $errText = "";
     private $conn;

     function getErrText(){
          return $this->errText;
     }

     function connect(){
          $this->errText = "";
          try{
               $srvName = "DESKTOP-5M7VMA0\SQLEXPRESS";
               $connOption = [
                    "Database" => "MusicChest",
                    "Characterset" => "UTF-8"
               ];
               $this->conn = sqlsrv_connect($srvName, $connOption);
               if($this->conn==false){
                    $this->errText = FormatErrors(sqlsrv_errors());
                    return false;
               }
               return true;
          }
          catch(Exception $e) {
               $this->errText = "Undefinded error!";
               return false;
          }
     }
     function disconnect(){
        sqlsrv_close($this->conn);
     }
     function makeQuery($sqlText, $flg_disconnect = true){
        $this->errText = "";
        $result = [];
        try{
            if($this->conn || $this->connect()){
                $sql_stmt = sqlsrv_query($this->conn, $sqlText);
                if(!$sql_stmt){
                    $this->errText = FormatErrors(sqlsrv_errors());
                    return false;
                }
                while($row = sqlsrv_fetch_array($sql_stmt,SQLSRV_FETCH_ASSOC)){
                    $result[] = $row;
                }
                sqlsrv_free_stmt($sql_stmt);
                return $result;
            }
        }
        catch(Exception $e){
            $this->errText = "Err";
            return false;
        }
     }

     function runCommand($sqlText, $flg_disconnect = true){
          try{
               if($this->conn || $this->connect()){
                    $sql_stmt = sqlsrv_query($this->conn, $sqlText);
                    if(!$sql_stmt){
                         return false;
                    }
                    sqlsrv_free_stmt($sql_stmt);
                    return true;
               }
          }
          catch(Exception $e){
               $this->errText = "Undefinded Error";
               return false;
          }
     }
     }



function FormatErrors($errors){
     echo "Error info: <br/>";

     foreach($errors as $error){
          echo "SQLSTATE: " . $error['SQLSTATE'] . "<br/>";
          echo "Code: " . $error['code'] . "<br/>";
          echo "Message: ".$error['message']. "<br/>";
     }
}
?>
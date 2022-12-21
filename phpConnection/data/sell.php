<?php
class SellRow implements JsonSerializable
{
    private $code;
    private $sell;
    private $item;
    private $amounts;


    function __construct(int $code, Sell $sell = null, Item $item = null, int $amounts = 0)
    {
        $this->code = $code;
        $this->sell = $sell;
        $this->item = $item;
        $this->amounts = $amounts;
    }
    function getItem()
    {
        return $this->item;
    }
    function getAmount()
    {
        return $this->amounts;
    }
    public function getSell()
    {
        return $this->sell;
    }
    public function setSell($sell){
        $this->sell = $sell;
    }
    public function setItem($item){
        $this->item = $item;
    }
    public function setAmount($amounts){
        $this->amounts = $amounts;
    }


    function readRowFromDB(){
        $db = new InstrumentDB();
        $sql = 'select es.code, es.sell_code, s.code scode, s.modelName sname, es.amounts 
        from SellSheet es inner join GroupItem s on es.modelName_code = s.code 
        where es.code =' . $this->code;
        $row = $db->makeQuery($sql);
        if(!$row || !$row[0]){
            var_dump($db->getErrText());
            return false;
        }
        $this->sell = new Sell($row[0]['sell_code']);
        $this->item = new Item($row[0]['scode'], $row[0]['sname']);
        $this->amounts = $row[0]['amounts'];
        return true;
    }

    function remFromDB(){
        $db = new InstrumentDB();
        $sql = 'delete from SellSheet where code = ' .$this->code;
        return $db->runCommand($sql);
    }
    function writeToDB(){
        $db = new InstrumentDB();
        $sql = 'update SellSheet set modelName_code = '.$this->getItem()->getCode().
        ', amounts = '.$this->getAmount(). '
        where code = '. $this->code;
        return $db->runCommand($sql);
    }

    function addToDb(){
        $db = new InstrumentDB();
        $sql = "insert into SellSheet(sell_code, modelName_code, amounts)
        values({$this->getSell()->getCode()}, {$this->getItem()->getCode()}, {$this->getAmount()})";
        return $db->runCommand($sql);
    }


    public function jsonSerialize(){
        return [
            'code' => $this->code,
            'item' => $this->item,
            'amounts' => $this->amounts
        ];
    }
}
    class Sell implements JsonSerializable{
    private $code;
    private $shifts;
    private $sailorName;
    private $model;
    private $sellDate;
    private $rows = [];


    function __construct(int $code, Shift $shifts = null , Sailor $sailorName = null, ProdGroup $model = null, DateTime $sellDate = null)
    {
        $this->code = $code;
    }
    function getProdGroup(){
        return $this->model;
    }
    function getShift(){
        return $this->shifts;
    }
    function getSailor(){
        return $this->sailorName;
    }
    function getSellDate(){
        return $this->sellDate->format("d.m.Y");
    }
    function getRows(){
        return $this->rows;
    }

    public function getCode(){
        return $this->code;
    }

    function readFromDB(){
        $db = new InstrumentDB();
        $sql = 'select d.code dcode, d.shifts dname, l.code lcode, l.sailorName lname, g.code gcode, g.model, e.sellEndDate
        from Sell e inner join Shift d on e.shift_code = d.code
            inner join Sailor l on e.sailor_code = l.code
            inner join ProductGroup g on e.model_code = g.model
            where e.code = '. $this->code;
        $sellHead = $db->makeQuery($sql);
        if(!$sellHead || !$sellHead[0]){
            return false;
        }
        $this->shifts = new Shift($sellHead[0]['dcode'], $sellHead[0]['dname']);
        $this-> sailorName = new Sailor($sellHead[0]['lcode'], $sellHead[0]['lname']);
        $this->model = new ProdGroup($sellHead[0]['gcode'], $sellHead[0]['model']);
        $this->sellDate = $sellHead[0]['sellEndDate'];

        $sql = 'select es.code, s.code scode, s.modelName sname, s.model_code, es.amounts
        from SellSheet es inner join GroupItem s on es.modelName_code = s.code
        where es.sell_code = ' . $this->code . '
        order by s.modelName';

        if ($sellRows = $db->makeQuery($sql)){
            foreach ($sellRows as $row) {
                $this->rows[] = new SellRow($row['code'],
            $this,
        new Item($row['scode'], $row['sname'], new ProdGroup($row['model_code'])),
    $row['amounts']
);
            }
        }
        return true;
    }

    public function getItemstoAdd(){
        $db = new InstrumentDB();
        $res = [];
        $sql = 'select code, modelName from GroupItem where code not in(select modelName_code from SellSheet where sell_code =' . $this->code .
            ')and model_code = (select model_code from Sell where code = ' . $this->code . ') order by modelName';
            if($sellRows = $db->makeQuery($sql)){
                foreach($sellRows as $row){
                $res[] = new Item($row['code'], $row['modelName']);

                }
            return $res;
            }
            else{
            return false;
            }
    }
    public function jsonSerialize(){
        return [
            'code' => $this->code,
            'shift' => $this->shifts,
            'sailorName' => $this->sailorName,
            'model' => $this->model,
            'sellDate' => $this->sellDate,
            'rows' => $this->rows
        ];
    }
    }

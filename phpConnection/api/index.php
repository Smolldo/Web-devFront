<?php
include __DIR__ . '/../data/autorun.php';

if ($_GET['action'] == 'getSell') {
    $sell = new Sell((int) $_GET['sell_code']);
    $sell->readFromDB();
    $data = ['sell' => $sell];

}
elseif($_GET['action'] == 'getSellRow'){
    $row = new SellRow((int)$_GET['sell_row_code']);
    $row->readRowFromDB();
    $data = ['sellRow' => $row];
}
elseif($_GET['action'] == 'getSellItem'){
    $sell = new Sell((int)$_GET['sell_code']);
    $data = ['item' => $sell->getItemstoAdd()];
}
elseif($_GET['action'] == 'updSellRow'){
    $row = new SellRow((int)$_POST['sell_row_code']);
    $row->readRowFromDB();
    $row->setAmount((int) $_POST['amounts']);
    $data = ['updated' => $row->writeToDB()];
}
elseif($_GET['action'] == 'remSellRow'){
    $row = new SellRow((int)$_POST['sell_row_code']);
    $data = ['deleted' => $row->remFromDB()];
}
elseif($_GET['action'] == 'insSellRow'){
    $row = new SellRow(0);
    $row->setSell(new Sell((int)$_POST['sell_code']));
    $row->setItem(new Item((int) $_POST['modelName_code']));
    $row->setAmount((int) $_POST['amounts']);
    $data = ['inserted' => $row->addToDb()];
}
else{
    $data = ['error' => 'bad request'];
}

header('Access-Control-Allow-Origin: *');
header("Content-type:application/json");
header('Accept-Language: *');

echo json_encode($data);
<?php
require 'data/autorun.php';
$sell = new Sell(1);
$sell->readFromDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
     <script src="./js/jquery-3.6.2.min.js"></script>
     <link rel="stylesheet" href="./css/style.css">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
     <script src="https://kit.fontawesome.com/078bb9fbfd.js" crossorigin="anonymous"></script>
     
     <title>MusicChest</title>
</head>
<body>
     <div class="container">
          <div class="row justify-content-around text-center header-row">
               <div class="col-12">
               <h2>Music Chest</h2>
               </div>
               <div class="col-12">
               <label>Sailor:</label>
               <span class="sailor text-success">Name</span>     
               </div>
               <div class="col-12 col-md-5 col-lg-3">
               <label>End sale date:</label>
               <span class="sellDate text-danger">Date</span>
               </div>
               <div class="col-12 col-md-5 col-lg-3">
               <label>Department work at:</label>
               <span class="shift text-danger">Shift</span>
               </div>
               <div class="col-12 col-md-5 col-lg-3">
               <label>Contributor:</label>
               <span class="model">Model</span>
               </div>
          </div>
          <table border="2" class="table text-center border-2">
               <thead  class="th-light">
               <tr>
                    <th scope="col" >Num</th>
                    <th scope="col" >ModelName</th>
                    <th scope="col" >Amounts</th>
                    <th scope="col" ><button type="button" class="btn btn-success add-row" ><i class="fa fa-plus"></i></button></th>
               </tr>
               </thead>
               <tbody>
               <tr id="table-row-prototipe" hidden sellCode="0">
                    <th scope="row">1</th>
                    <td class="modelName-0">qwe</td>
                    <td class="amount-0">wer</td>
                    <td class="text-center">
                         <button type="button" class="btn edit-row btn-info btn-success" ><i class="fas fa-pencil"></i></button>
                         <button type="button" class="btn delete-row btn-danger" ><i class="fas fa-trash"></i></button>
                    </td>
               </tr>
               </tbody>
          </table>
     </div>
     <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" >
          <div class="modal-dialog" role="document" >
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="editModalLabel" ></h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true" >&times;</span></button>
                    </div>
                    <div class="modal-body">
                         <input type="hidden" class="form-control" id="rowCode" placeholder="0">
                         <div class="form-group">
                              <label for="rowAmount">Amount</label>
                              <input type="number" class="form-control" id="rowAmount" placeholder="0">
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                         <button type="button" class="btn btn-primary" id="editModalSave" >Save</button>
                    </div>
               </div>
          </div>
     </div>
     <!--Modal2-->
     <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" >
          <div class="modal-dialog" role="document" >
               <div class="modal-content">
                    <div class="modal-header">
                         <h5 class="modal-title" id="addModalLabel" >Add row</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                              <span aria-hidden="true" ><i class="fa fa-x"></i></span>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                   <label class="input-group-text" for="inputGroupSelect01" >ModelName</label>
                              </div>
                              <select class="custom-select" id="addRowItemSelect">
                                   <option selected >Choose Instrument...</option>
                              </select>
                         </div>
                         <div class="input-group mb-3">
                              <div class="input-group-prepend">
                                   <span class="input-group-text" id="basic-addon1" >
                                        Amount
                                   </span>
                              </div>
                              <input type="number" class="form-control" id="addRowAmount" placeholder="0" aria-label="Usename" aria-hidden="true">
                         </div>
                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
                         <button type="button" class="btn btn-primary" id="addModalSave" >Add</button>
                    </div>
               </div>
          </div>
     </div>

     <script src="./js/index.js"></script>
</body>
</html>
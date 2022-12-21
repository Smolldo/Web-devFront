var sellCode = 34;

function getData(){
    $.get("/phpConnection/api/?action=getSell&sell_code=" + sellCode,({sell}) =>{
        console.log(sell);
        updateSellHead(sell);
        updeteSellTable(sell);
    })
}

function updateSellHead({model, sailorName, shift, sellDate}){
    $('.shift').html(shift.shift);
    $('.model').html(model.model);
    $('.sailor').html(sailorName.sailorName);
    $('.sellDate').html(new Date(sellDate.date).toLocaleDateString("en-EN"));
}

function updeteSellTable({rows}){
    $('table.table tbody tr').not('[hidden]').remove();
    var $rowNumb = 1;
    rows.forEach(row => {
        var newRow = $('table.table tbody tr#table-row-prototipe').clone()
            .removeAttr('id').removeAttr('hidden').attr('sellCode', row.code);
        newRow.find('[scope=row]').html($rowNumb++);
        newRow.find('.modelName-0')
            .attr('class', `modelName-${row.code}`)
            .html(row.item.modelName);
        newRow.find('.amount-0')
            .attr('class', `amount-${row.code}`)
            .html(row.amounts);   
        $('table.table tbody').append(newRow); 
    });


    $('.delete-row').click(
        (event)=>{
            var rowCode = $(event.target).closest('[sellCode]').attr('sellCode');
            deleteRow(rowCode);
        }
    );

    $('.edit-row').click(
        (event)=>{
            var rowCode = $(event.target).closest('[sellCode]').attr('sellCode');
            editRow(rowCode);
        }
    );
}

function deleteRow(rowCode){
    $.ajax({
        type: "POST",
        url: "/phpConnection/api/?action=remSellRow",
        data:{
            'sell_row_code': rowCode
        },
        succes:(result)=>{
            if(result.deleted){
                $(`tr[sellCode=${rowCode}]`).remove();
                $(`tr[sellCode]`).each(function(i, elem){
                    $(elem).find('[scope=row]').html(i);
                });
            }
        }
    });
}

function editRow(rowCode){
    $.get("/phpConnection/api/?action=getSellRow&sell_row_code=" +  rowCode, ({sellRow}) =>{
        $('#editModalLabel').html(sellRow.item.modelName);
        $('#rowCode').val(sellRow.code);
        $('#rowAmount').val(sellRow.amounts);
        $('#editModal').modal('show');
    })
}

$().ready(()=>{
    getData();
    $('.add-row').click(()=>{
        $.get("/phpConnection/api/?action=getSellItem&sell_code=" + sellCode, ({item})=>{
            $('#addRowItemSelect option[value]').remove();
            if(item){
                item.forEach((item)=>{
                    var option = new Option(item.modelName, item.code);
                    $('#addRowItemSelect').append($(option));
                });
            }
        });
        $('#addModal').modal('show');
    })
})

$('#addModalSave').click( () =>{
    $.ajax({
        type: "POST",
        url: "/phpConnection/api/?action=insSellRow",
        data:{
            'sell_code': sellCode,
            'modelName_code': $('#addRowItemSelect').val(),
            'amounts': $('#addRowAmount').val()
        },
        succes: (result) =>{
            if(result.inserted){
                getData();
            }
            $('#addModal').modal('hide');
        }
    });
});

$('#editModalSave').click(() =>{
    $.ajax({
        type: "POST",
        url: "/phpConnection/api/?action=updSellRow",
        data:{
            'sell_row_code': $('#rowCode').val(),
            'amounts': $('#rowAmount').val()
        },
        succes: (result) =>{
            if(result.updated){
                $(`#amount-${$('#rowCode').val()}`).html($('#rowAmount').val());
                $(`[sellCode=${$('#rowCode').val()}]`).val();
            }
            $('#editModal').modal('hide');
        }
    })
})

$().ready(()=>{
    getData();
});
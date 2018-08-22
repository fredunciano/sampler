<div class="span3">
    <ul class="nav nav-tabs nav-stacked">
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>
<div class="span12">
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <div class="row-fluid">
        <div class="span2">Trading Date</div>
        <div class="span10">
            <input type="text" id="datepicker" name="date" value="<?=$date?>">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10">
            <select id="participant">
                <?php
                    foreach ($participants as $p) {
                        echo '<option value="'.$p->participant.'">'.$p->participant.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10">
            <select id="unit"></select>
        </div>
    </div>
    <br>
    <div id="grid_data"></div>
    <br>
</div>
<div class="modal fade in" id="modal_wbss" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">WBSS Submitted values</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-condensed table-bordered table-hover" id="content"></table>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    getResources : function() {
        $.post('../bcq/get_resources',{participant:$('#participant').val()},
            function(data){
                if (data.total >= 1) {
                    $('#unit').html('');
                    $.each(data.value, function(i,val){
                        $('#unit').append('<option>'+val.resource_id+'</option>');
                    });
                    $.loadData();
                }   
            }
        );
    },
    loadData : function() {
        $('#result').html('&nbsp;&nbsp;&nbsp;Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')     
        $.post('../bcq/submitted_wbss_action',{date:$('#datepicker').val(),unit:$('#unit').val()},
            function(data){
                
                if (data.total >= 1) {
                    
                    $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
                    
                    $('#data').dataTable({

                        "aoColumns": [
                            { "sTitle": "Transaction ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "Buyer&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "Submitted By&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "Last&nbsp;Modified&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" }
                        ]
                    });

                    $.each(data.value, function(i,val){
                        var link = '<a href="#" id="'+val.id+'" class="wbss">'+val.transaction_id+'</a>';
                        $('#data').dataTable().fnAddData([link,val.buyer_name,val.created_by,val.date_created]);
                    })
                    
                } else {
                    $('#grid_data').html('No Data Available')
                }
            }
        );
    },
    showValues : function(id,transaction_id) {
        $.post('../bcq/transaction_id_action',{id:id},
            function(data){
                
                var html = '<tr><th>Customer: '+data.customer+'</th><th>Transaction id: '+transaction_id+'</th></tr>'
                html+='<tr><td>Hour 1</td><td>'+parseFloat(data.h1).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 2</td><td>'+parseFloat(data.h2).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 3</td><td>'+parseFloat(data.h3).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 4</td><td>'+parseFloat(data.h4).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 5</td><td>'+parseFloat(data.h5).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 6</td><td>'+parseFloat(data.h6).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 7</td><td>'+parseFloat(data.h7).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 8</td><td>'+parseFloat(data.h8).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 9</td><td>'+parseFloat(data.h9).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 10</td><td>'+parseFloat(data.h10).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 11</td><td>'+parseFloat(data.h11).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 12</td><td>'+parseFloat(data.h12).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 13</td><td>'+parseFloat(data.h13).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 14</td><td>'+parseFloat(data.h14).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 15</td><td>'+parseFloat(data.h15).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 16</td><td>'+parseFloat(data.h16).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 17</td><td>'+parseFloat(data.h17).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 18</td><td>'+parseFloat(data.h18).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 19</td><td>'+parseFloat(data.h19).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 20</td><td>'+parseFloat(data.h20).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 21</td><td>'+parseFloat(data.h21).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 22</td><td>'+parseFloat(data.h22).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 23</td><td>'+parseFloat(data.h23).toFixed(2)+'</td></tr>'
                html+='<tr><td>Hour 24</td><td>'+parseFloat(data.h24).toFixed(2)+'</td></tr>'
                $('#content').html(html)
                
            }
        );
    }
})
</script>
<script>
$('#datepicker').datepicker();
$.loadData();
$('#datepicker').change(function() {
    $(".hide").hide();
    $.loadData();
});
$.getResources();
$('#participant').change(function(){
    $.getResources();
    
});
$('#unit').change(function(){
	//$.loadUnit();
    $.loadData();
})
$('.trans_id').die().live('click',function(e){
    e.preventDefault();
    $.showValues($(this).attr('id'),$(this).html());
    /*$('#dialog-modal').html($(this).attr('id'))
    $( "#dialog-modal" ).dialog({
      height: 140,
      modal: true
    });*/
})
$('#x_excel').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.exportExcel();
});
$('#x_csv').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.exportCsv();
});

$("a.wbss").die('click').live('click',function(e){
    e.preventDefault();
    $('#modal_wbss').modal('show')
    $.showValues($(this).attr('id'),$(this).html());
})

</script>
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
    <form method="post">
    <div class="row-fluid">
        <div class="span2">URL</div>
        <div class="span10">
            <select id="url" name="url">
                <option>https://stl1.wesm.ph</option>
                <option>https://stl2.wesm.ph</option>
                <option>https://202.138.137.43</option>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10">
            <select id="participant" name="participant">
                <?php
                    foreach ($participants as $p) {
                        echo '<option value="'.$p->participant.'">'.$p->participant.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Resource ID</div>
        <div class="span10">
            <select id="resource_id" name="resource_id"></select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Buyer ID</div>
        <div class="span10">
            <select id="buyer_id" name="buyer_id"></select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10">
            <input type="text" id="datepicker" name="delivery_date" value="<?=$date?>">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Hour
            <label class="checkbox"><input type="checkbox" id="check_all" checked><span id="label_check_all">Uncheck all</span></label>
        </div>
        <div class="span7">
            <!--select multiple="multiple" id="hour" name="hour[]" class="input-small">
                <?php
                for($x=1;$x<=24;$x++){
                    echo '<option>'.$x.'</option>';
                }
                ?>
            </select-->
            <table class="table table-condensed">
            <tr>
            <?php
                for ($x=1;$x<=24;$x++) {
                    echo '<td><label class="checkbox"><input type="checkbox" class=hour name="delivery_hour[]" value="'.$x.'" checked>'.$x.'</label></td>';
                    if ($x==15) {
                        echo '</tr><tr>';
                    }
                }
            ?>
            </tr>
            </table>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span7">
            <button type="button" class="btn btn-primary" id="retrieve">Retrieve WBSS from WESM</button>
        </div>
    </div>
    </form>
    <br>
    <div id="grid_data"></div>
    <br>
</div>


<script>
$.extend({
    getResources : function() {
        $.post('../bcq/get_resources',{participant:$('#participant').val()},
            function(data){
                if (data.total >= 1) {
                    $('#resource_id').html('');
                    $.each(data.value, function(i,val){
                        $('#resource_id').append('<option>'+val.resource_id+'</option>');
                    });
                    $.getCustomers();
                    //$.loadData();
                }
            }
        );
    },
    retrieveWBSS : function() {
        $('#grid_data').html('&nbsp;&nbsp;&nbsp;Getting BCQ from WESM &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/wbss_retrieval',$('form').serialize(),
            function(data){
                //console.log(data)
                $('#grid_data').html(data)
            }
        );

    },
    /*loadData : function() {
        $('#result').html('&nbsp;&nbsp;&nbsp;Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/submitted_wbss_action',{date:$('#datepicker').val(),unit:$('#resource_id').val()},
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
    },*/
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
    },
    getCustomers : function(initial) {
        $.post('../bcq/get_wbss_buyer_id',{},
            function(data){
                if (data.total >= 1) {
                    $('#buyer_id').html('');
                    var customer_list = [];
                    $.each(data.value, function(i,val){
                        $('#buyer_id').append('<option value="'+val.wbss_name+'">'+val.wbss_name+'</option>');
                        customer_list.push(val.wbss_name);
                    });
                    return false;
                }
            }
        ).done(function() {
            if (initial) {
                $('#display_btn').trigger('click');
             }
          });
    }
})
</script>
<script>
$('#datepicker').datepicker();
//$.loadData();
$('#datepicker').change(function() {
    $(".hide").hide();
    //$.loadData();
});
$.getResources();
$('#participant').change(function(){
    $.getResources();

});
$('#resource_id').change(function(){
	//$.loadUnit();
    //$.loadData();
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

$('#check_all').change(function(e){
    e.preventDefault();
    var chk = $(this).attr('checked');
    if (chk) {
        $('#label_check_all').html('Uncheck All')
        $('.hour').attr('checked','checked')
    } else {
        $('#label_check_all').html('Check All')
        $('.hour').removeAttr('checked')
    }
})
$('#retrieve').unbind('click').bind('click', function(e){
    $.retrieveWBSS();
})

</script>

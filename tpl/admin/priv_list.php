<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>
</div>
<div class="span12">
    <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
    <div id="grid_data"></div>
    <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="add_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Privilege </a>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Privilege</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Privilege</td><td><input type="text" class="input-medium" id='priv' name="priv"></td></tr>
                <tr>
                    <td colspan="2">
                        <table class="table table-bordered">
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="market_data_checkbox" class="sub_checkbox"><b>Market Data</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox market_data_checkbox" name="modules[]" value="1_1_1" id="1_1_1">Manual Downloaders</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox market_data_checkbox" name="modules[]" value="1_1_2" id="1_1_2">File Retrievers</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox market_data_checkbox" name="modules[]" value="1_1_3" id="1_1_3">Market Data Reports</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox market_data_checkbox" name="modules[]" value="1_1_4" id="1_1_4">Data Extraction</label>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="mms_data_checkbox" class="sub_checkbox"><b>MMS Data</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox mms_data_checkbox" name="modules[]" value="2_1_1" id="2_1_1">Manual Downloaders</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox mms_data_checkbox" name="modules[]" value="2_1_2" id="2_1_2">MMS Data Reports</label>
                                    </ul>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="adhoc_report_checkbox" class="sub_checkbox"><b>Adhoc Report</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox adhoc_report_checkbox" name="modules[]" value="4_1_1" id="4_1_1">Adhoc Grid Report</label>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="trading_checkbox" class="sub_checkbox"><b>Trading</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="bids_offer"><b>Bids and Offers</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox bids_offer" name="modules[]" value="3_1_1" id="3_1_1">Realtime Bids and Offers
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox bids_offer" name="modules[]" value="3_1_2" id="3_1_2">Day Ahead Bids and Offers
                                    </label>
                                    <!--label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox bids_offer" name="modules[]" value="3_1_3" id="3_1_3">Standing Bids and Offers
                                    </label-->
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox bids_offer" name="modules[]" value="3_1_4" id="3_1_4">Submitted Bids and Offers Summary
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox bids_offer" name="modules[]" value="3_1_5" id="3_1_5">Download Templates
                                    </label>
                                    <br>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="plant"><b>Plant Availability</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox plant" name="modules[]" value="3_2_1" id="3_2_1">Day Ahead Projected Plant Capability
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox plant" name="modules[]" value="3_2_2" id="3_2_2">Week Ahead Projected Plant Capability
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox plant" name="modules[]" value="3_2_3" id="3_2_3">Realtime Plant Capability
                                    </label>
                                    <br>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="realtime"><b>Realtime Plant Monitoring</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox realtime" name="modules[]" value="3_3_1" id="3_3_1">Current Interval
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox realtime" name="modules[]" value="3_3_2" id="3_3_2">Current Interval Grid
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox realtime" name="modules[]" value="3_3_3" id="3_3_3">24H Interval
                                    </label>
                                    <br>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="buyer_nominations"><b>Buyer Nominations</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox buyer_nominations" name="modules[]" value="3_4_1" id="3_4_1">Running Nominations Report
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox buyer_nominations" name="modules[]" value="3_4_2" id="3_4_2">Month Ahead Nomination
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox buyer_nominations" name="modules[]" value="3_4_3" id="3_4_3">Week Ahead Nomination
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox buyer_nominations" name="modules[]" value="3_4_4" id="3_4_4">Day Ahead Nomination
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox buyer_nominations" name="modules[]" value="3_4_5" id="3_4_5">Override Nomination
                                    </label>
                                    <br>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="shift_reports"><b>Shift Reports</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox shift_reports" name="modules[]" value="3_5_1" id="3_5_1">Trading Shift Report
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox shift_reports" name="modules[]" value="3_5_2" id="3_5_2">Plant Shift Report
                                    </label>
                                    <br>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="dan_dap"><b>DAN / DAP Status Monitoring</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox dan_dap" name="modules[]" value="3_6_1" id="3_6_1">DAN / DAP Status Monitoring
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox dan_dap" name="modules[]" value="3_6_2" id="3_6_2">DAN / DAP Override
                                    </label>
                                    <br>
                                	<label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="meter_data"><b>Meter Data</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox meter_data" name="modules[]" value="3_12_1" id="3_12_2">Daily MQ Gen
                                    </label>
                                    <label class="checkbox">
                                        <input type="checkbox" class="main_checkbox trading_checkbox meter_data" name="modules[]" value="3_12_2" id="3_12_3">Daily MQ Templates
                                    </label>

                                    <!--
                                    <br>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox sub_sub_checkbox" id="trading_inputs"><b>Trading Inputs</b>
                                    </label>
                                    <li class="divider"></li>
                                    <label class="checkbox">
                                        <input type="checkbox" class="trading_checkbox trading_inputs" name="modules[]" value="3_7_3" id="3_7_3">Input Customer Nominations
                                    </label>
                                    -->
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="plant_checkbox" class="sub_checkbox"><b>Plant Module</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_1" id="5_1_1">Realtime Plant Monitoring</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_2" id="5_1_2">Plant Capability Templates</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_3" id="5_1_3">Day Ahead Projected Plant Capability</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_4" id="5_1_4">Week Ahead Projected Plant Capability</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_5" id="5_1_5">Realtime Plant Capability</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_6" id="5_1_6">Plant Operation Shift Report</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox plant_checkbox" name="modules[]" value="5_1_7" id="5_1_7">Start up/ Shutdown Load Profile</label>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="bcq_checkbox" class="sub_checkbox"><b>BCQ Module</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox bcq_checkbox" name="modules[]" value="6_1_1" id="6_1_1">BCQ Uploader</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox bcq_checkbox" name="modules[]" value="6_1_2" id="6_1_2">BCQ for Declaration</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox bcq_checkbox" name="modules[]" value="6_1_3" id="6_1_3">Submitted WBSS</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox bcq_checkbox" name="modules[]" value="6_1_4" id="6_1_4">BCQ Report</label>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="buyer_checkbox" class="sub_checkbox"><b>Buyer Module</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="buyer_checkbox sub_sub_checkbox" id="nominations"><b>Nominations</b></label>
                                    <li class="divider"></li>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox nominations" name="modules[]" value="7_1_1" id="7_1_1">Template Download</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox nominations" name="modules[]" value="7_1_2" id="7_1_2">Day Ahead Nominations</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox nominations" name="modules[]" value="7_1_3" id="7_1_3">Week Ahead Nominations</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox nominations" name="modules[]" value="7_1_4" id="7_1_4">Month Ahead Nominations</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox nominations" name="modules[]" value="7_1_5" id="7_1_5">Transactions</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox nominations" name="modules[]" value="7_1_6" id="7_1_6">Running Nominations Report</label>
                                    <br>
                                    <label class="checkbox"><input type="checkbox" class="buyer_checkbox sub_sub_checkbox" id="bcq"><b>BCQ</b></label>
                                    <li class="divider"></li>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox bcq" name="modules[]" value="7_2_1" id="7_2_1">BCQ Report</label>
                                    <br>
                                    <label class="checkbox"><input type="checkbox" class="buyer_checkbox sub_sub_checkbox" id="invoice"><b>Invoice</b></label>
                                    <li class="divider"></li>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox buyer_checkbox invoice" name="modules[]" value="7_3_1" id="7_3_1">Invoice</label>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="admin_checkbox" class="sub_checkbox"><b>Admin Module</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_1" id="9_1_1">Manage Users</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_2" id="9_1_2">Manage Privilege</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_3" id="9_1_3">Manage Participants</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_4" id="9_1_4">Manage Plants</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_5" id="9_1_5">Manage Resources</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_6" id="9_1_6">Manage Customers</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_7" id="9_1_7">Manage SEIN</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_8" id="9_1_8">Manage Fuel Type</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_9" id="9_1_9">Manage Region</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_10" id="9_1_10">Manage Holidays</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_11" id="9_1_11">Manage Billing Period</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_12" id="9_1_12">Manage Email List</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_13" id="9_1_13">Fuel Type Map</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox admin_checkbox" name="modules[]" value="9_1_20" id="9_1_20">Manage Billing Settings</label>
                                    
                                    <!--<label class="checkbox"><input type="checkbox" class="admin_checkbox" name="modules[]" value="9_1_21" id="9_1_21">Manage Initial Indices</label> -->
                                    </ul>
                                </td>
                            </tr>

                             <tr> <!-- Billing and Settlement -->
                                <td>
                                    <label class="checkbox">
                                        <input type="checkbox" id="billing_settlement_checkbox" class="sub_checkbox"><b>Billing & Settlement</b>
                                    </label>
                                </td>
                                <td>
                                    <ul class="nav nav-list">
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox billing_settlement_checkbox" name="modules[]" value="11_1_1" id="11_1_1">Billing & Settlement Report</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox checkbox billing_settlement_checkbox" name="modules[]" value="10_1_1" id="10_1_1">Power Bill Modules</label>
                                    <label class="checkbox"><input type="checkbox" class="main_checkbox checkbox billing_settlement_checkbox" name="modules[]" value="12_1_1" id="12_1_1">PEMC Bills</label>
                                    </ul>
                                </td>
                            </tr> 
                            
                        </table>
                    </td>
                </tr>
                <tr><td>Status  </td><td>
                    <select id="status" name="status" class="input-medium">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                </td></tr>
            </table>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    save : function(){
        $.post('<?=$base_url?>/admin/priv_update',$('form').serialize(),
        function(data){
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
            } else {
                $('#error_box').attr('class','alert alert-error');
            }
            $('#error_box').html(ret[1]);
        })
        $.list();
    },
    add : function(){
        $.post('<?=$base_url?>/admin/priv_add',$('form').serialize(),
        function(data){
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
            } else {
                $('#error_box').attr('class','alert alert-error');
            }
            $('#error_box').html(ret[1]);
        })
        $.list();
    },
    list : function(){
        $.post('<?=$base_url?>/admin/priv_list_json',{},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Privilege" },
                    { "sTitle": "Status" },
                    { "sTitle": "Last Modified" },
                    { "sTitle": "" }
                ]
            });

            $.each(data, function(i,val){
                var priv_link = '<a href="#" id="'+val.id+'" class="privilege">'+val.privilege+'</a>';
                var del_link = '<a href="#" id="'+val.privilege+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                var status = val.status=='active' ? '<span class="label label-success">'+val.status+'</span>' : '<span class="label label-important">'+val.status+'</span>';

                $('#data').dataTable().fnAddData([priv_link,status,val.modified,del_link]);
            })
        })
    }
})
</script>
<script>

$.list();

$("a.privilege").die('click').live('click',function(e){
    e.preventDefault();
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal').modal('show')
    $.post('<?=$base_url?>/admin/priv_data',{id:$(this).attr('id'),modules:$('#h'+$(this).attr('id')).val()},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.priv.id);
            $('input[id=priv]').val(data.priv.privilege);
            $('select[id=status]').val(data.priv.status);
            $('input[type=checkbox]').removeAttr('checked');
            var arr_modules = data.priv.modules_list.split('|');
            $.each(arr_modules, function(i,m){
                $('#'+m).attr('checked','checked');
            })
            //$('select[id=modules]').val(arr_modules);
            $('input[id=priv]').attr('readonly',true);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#add_button").unbind('click').bind('click',function(e){
    e.preventDefault()
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('input[id=id]').val('');
    $('input[id=priv]').val('');
    $('input[id=priv]').removeAttr('readonly');
    $('select[id=status]').val('');
    $('input[type=checkbox]').removeAttr('checked');
    $('#btn-holder').html('<button class="btn btn-primary" id="add"><i class="icon-check"></i>&nbsp;&nbsp;Save&nbsp;&nbsp;</button>')
})

$("#add").die('click').live('click',function(e){
    e.preventDefault();
    // validation
    var errors = [];
    
    if ( $.trim($('#priv').val()) === '' || $.trim($('#priv').val()) === null ) {
        errors.push('Privilege name can\'t be empty.');
    }
    if ( $('input.main_checkbox:checked').length < 1  ) {
        errors.push('Please choose atleast one privilege.');
    }
    if (errors.length > 0) {
        $("#error_box").attr('class','alert alert-info').html(errors.join('<br>'));
    } else {
        $.add();
    }
})
$("#update").die('click').live('click',function(e){
    e.preventDefault();
    // validation
    var errors = [];

    if ( $.trim($('#priv').val()) === '' || $.trim($('#priv').val()) === null ) {
        errors.push('Can\'t update data. Please reload the page.');
    }
    if ( $('input.main_checkbox:checked').length < 1  ) {
        errors.push('Please choose atleast one privilege.');
    }
    if (errors.length > 0) {
        $("#error_box").attr('class','alert alert-info').html(errors.join('<br>'));
    } else {
        $.save();
    }
})
$('.delete_button').die('click').live('click', function(e){
    e.preventDefault()
    var id = $(this).attr('name');
    var name = $(this).attr('id');
    bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
        if (result) {
            $.post('<?=$base_url?>/admin/priv_delete',{id:id},
            function(data){
                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                $.list();
            })
        }
    });
})

$('.sub_checkbox').change(function(){
    if ($(this).attr('checked')=='checked') {
        $('.'+$(this).attr('id')).attr('checked','checked')
    } else {
        $('.'+$(this).attr('id')).removeAttr('checked')
    }
})
$('.sub_sub_checkbox').change(function(){
    if ($(this).attr('checked')=='checked') {
        $('.'+$(this).attr('id')).attr('checked','checked')
    } else {
        $('.'+$(this).attr('id')).removeAttr('checked')
    }
})
</script>

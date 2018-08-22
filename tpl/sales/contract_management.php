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
        <legend><h4><?=$title?> <small>( Sales module )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2"> Year</div>
            <div class="span10"><select name="yearpicker" id="yearpicker" class="span2"></select></div>
        </div>
        <br>
        <div class="row-fluid">
            <table class="table table-bordered table-hover" cellspacing="1" id="results_list"></table>
        </div>
        <a href="#modal" role="button" class="btn btn-primary" data-toggle="modal" id="btn_add"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Contract</a>
</div>


<div class="modal fade in" id="modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Add Contract</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Year</td><td><select name="cmb_year" id="cmb_year" class="span2"></select></tr>
                <tr><td>Period</td><td><select name="cmb_period" id="cmb_period"></select></td></tr>
                <tr><td>Customer</td>
                    <td>
                        <select name="cmb_customer" id="cmb_customer">
                            <option value="">Select Customer</option>
                            <?php
                            foreach ($customers as $i=>$val) {
                                if ($customer_id === $val->id) {
                                    echo '<option value="'.$val->id.'" selected>'.$val->name.'</option>';
                                } else {
                                    echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                                }

                            }
                            ?>
                        </select>
                    </td></tr>
                <tr><td>Contracted Capacity</td><td><input id="txt_contracted_capacity" value="" type="text"></td></tr>
            </table>
        </form>
    </div>
    
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Save</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<br><br><br>
<script type="text/javascript">
    EDIT_ID = 0;
    $.extend({
        populateYearPicker : function(){
            var current_year = parseInt('<?php echo date('Y');?>',10);
            var syear = current_year -2;
            var eyear = current_year + 2;
            var selected = '';
            for (var i=syear;i<=eyear;i++) {
                if ( i === current_year) {
                    $('#yearpicker').append($('<option />').val(i).html(i).attr('selected',true));
                }else {
                    $('#yearpicker').append($('<option />').val(i).html(i));
                }
            }
        }

        ,populateList : function(){

            var yr_selected = parseInt($('#yearpicker').val(),10);
            var prv_yr = yr_selected - 1, nxt_yr = yr_selected + 1;
            var s_sdate = '', s_edate = '', e_ctr = 1;
            var end_date = '', start_date = '';

            $('#load_msg').html('Please wait...');
            $('#results_list').hide();
            $('#results_list').html('');
            $('#results_list').find("tr:gt(0)").remove();
            
            var contents = '<tr><th>Customers</th>';

            for (var c=0;c<12;c++){
                if ( c === 0 ) {
                    s_sdate = prv_yr + '-12-26';;
                }else {
                    s_sdate = yr_selected + '-' + c + '-26';
                }

                s_edate = yr_selected + '-' + e_ctr + '-25';

                start_date = Date.parse(s_sdate);
                end_date = Date.parse(s_edate);

                s_sdate = start_date.toString("d/MMM");
                s_edate = end_date.toString("d/MMM");

                contents+='<th>'+s_sdate+ '&nbsp;-&nbsp;' + s_edate + '</th>';

                e_ctr++;
            }
            contents+='</tr>';

            var totals = {};
            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/sales/contract_management_action'
                ,data: { 'action' : 'list', 'year' : yr_selected }
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    var current_server_date = '<?php echo date('Y-m-d');?>';
                    var current_date = Date.parse(current_server_date);
                    var customer_list =data.value
                        ,customer = null
                        ,customer_data = null
                        ,date_val = ''
                        ,formatted_date_val = ''
                        ,id_val = ''
                        ,disabled_class="";

                    for (customer in customer_list){

                        contents += '<tr><td>'+ customer +'</td>';
                        customer_data = customer_list[customer];
                        s_sdate = '';
                        s_edate = '';
                        e_ctr = 1;
                        for (var c=0;c<12;c++){
                            if ( c === 0 ) {
                                s_sdate = prv_yr + '-12-26';;
                            }else {
                                s_sdate = yr_selected + '-' + c + '-26';
                            }

                            s_edate = yr_selected + '-' + e_ctr + '-25';

                            start_date = Date.parse(s_sdate);
                            end_date = Date.parse(s_edate);

                            s_sdate = start_date.toString("yyyy-MM-dd");
                            date_val = '';
                            formatted_date_val = '';
                            disabled_class = '';
                            id_val = '';
                            if ( typeof customer_data[s_sdate] != 'undefined' ) {
                                date_val = customer_data[s_sdate].contracted_capacity;
                                formatted_date_val = customer_data[s_sdate].contracted_capacity;
                                if ( end_date < current_date ){
                                    disabled_class = ' class="disabled" ';
                                }
                                id_val = ' id_val="' + customer_data[s_sdate].id + '" ';

                            }
                            s_edate = end_date.toString("d-MMM");


                            // for total per period
                            var total_tmp = 0;
                            if ( date_val != 'null' && date_val != '' ) {
                                formatted_date_val = $.formatNumberCommaSeparated(parseInt(date_val,10));
                                if (typeof totals['c'+c] != 'undefined') {
                                    total_tmp = totals['c'+c] + parseInt(date_val,10);
                                }else {
                                    total_tmp = parseInt(date_val,10);
                                }
                            }else {
                                if (typeof totals['c'+c] != 'undefined') {
                                    total_tmp = totals['c'+c];
                                }
                            }
                            totals['c'+c] = total_tmp;

                            contents+='<td style="text-align: right;" '+ disabled_class +  id_val +  '>'+formatted_date_val+'</td>';
                            e_ctr++;
                        }
                        contents+='</tr>';
                    }

                    // totals row
                    contents += '<tr><td>Total</td>';
                    for (var c=0;c<12;c++){
                        var total_tmp = '';
                        if (typeof totals['c'+c] != 'undefined') {
                            total_tmp = $.formatNumberCommaSeparated(parseInt(totals['c'+c],10));
                        }else {
                            total_tmp = '';
                        }
                        contents+='<td style="text-align: right;">'+total_tmp+'</td>';
                    }
                    contents+='</tr>';

                    $('#results_list').append(contents);
                    $('#results_list').show();
                    $('#load_msg').html('');

                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });





        }

        ,populateYearModalWindow : function(){
            var current_year = parseInt('<?php echo date('Y');?>',10);
            var max_year = current_year +2;
            var selected = '';
            $('#cmb_year').append($('<option />').val("").html('Select year').attr('selected',true));
            for (var i=current_year;i<=max_year;i++) {
                if ( i === current_year) {
                    $('#cmb_year').append($('<option />').val(i).html(i));
                }else {
                    $('#cmb_year').append($('<option />').val(i).html(i));
                }
            }
        }
        ,showAddScreen : function() {

            $('#frmmodal').get(0).reset();
            $('#txt_contracted_capacity').attr('value','');
            $('#cmb_period').html('');
            $('#modal').dialog({
                 width: 400
                ,height: 250
                ,modal: true
                ,show: {
                    effect: "blind",
                    duration: 600
                }
                ,hide: {
                    effect: "explode",
                    duration: 600
                }
                ,buttons : {
                    'Submit' : function(){
                        $.submitContractedCapacity('add',$( this ));
                    }
                    ,'Cancel' : function(){
                        $( this ).dialog( "close" );
                    }
                }
            });
        }
        ,showEditScreen : function(id){

            $('#frmmodal').get(0).reset();
            $('#cmb_period').html('');

            $.ajax({
                type: "POST"
                ,url : '<?=$base_url?>/sales/contract_management_action'
                ,data: { 'action' : 'get', 'id' : id }
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    var details = data.value;
                    var start_date = details.start_date
                        ,end_date = details.end_date
                        ,customer_id = details.customer_id
                        ,contracted_capacity = details.contracted_capacity
                        ,e_date = Date.parse(end_date)
                        ,s_date = Date.parse(start_date);


                    $('#cmb_customer option[value="'+ customer_id +'"]').prop('selected', true);
                    $('#txt_contracted_capacity').attr('value',contracted_capacity);
                    $('#cmb_year option[value="'+ e_date.toString('yyyy') +'"]').prop('selected', true);
                    $('#cmb_year').trigger('change');
                    $('#cmb_period option[value="'+ s_date.toString("MM/dd/yyyy") + '-'  + e_date.toString("MM/dd/yyyy")  +'"]').prop('selected', true);


                    $('#modal').dialog({
                        width: 400
                        ,height: 250
                        ,modal: true
                        ,show: {
                            effect: "blind",
                            duration: 600
                        }
                        ,hide: {
                            effect: "explode",
                            duration: 600
                        }
                        ,buttons : {
                            'Submit' : function(){
                                $.submitContractedCapacity('update',$( this ));
                            }
                            ,'Cancel' : function(){
                                $( this ).dialog( "close" );
                            }
                        }
                    });

                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });



        }

        ,submitContractedCapacity : function(action,dialogObj){
            var validate = $.validateEntries();
            if ( validate.valid ) {
                var sdate = ''
                    ,edate = '';

                var period = $.trim($('#cmb_period').val())
                    ,period_arr = period.split('-')
                    ,sdate = Date.parse(period_arr[0]).toString("yyyy-MM-dd")
                    ,edate = Date.parse(period_arr[1]).toString("yyyy-MM-dd")
                    ,customer_id = $.trim( $('#cmb_customer').val() )
                    ,contracted_capacity = $.trim( $('#txt_contracted_capacity').val() )
                    ,status = 'active';

                var parameters = { 'action' : action, 'sdate' : sdate , 'edate' : edate, 'customer_id' : customer_id, 'contracted_capacity' : contracted_capacity, 'status' : status};
                if ( action == 'add' ) {
                    parameters['id'] = '';
                }else {
                    parameters['id'] = EDIT_ID;
                }

                $.ajax({
                    type: "POST"
                    ,url : '<?=$base_url?>/sales/contract_management_action'
                    ,data: parameters
                    ,dataType:'json'
                    ,async: false
                    ,success: function(data){
                        if ( parseInt(data.success,10) === 1 ) {
                            $.populateList();
                            dialogObj.dialog( "close" );
                        }else {
                            alert(data.message);
                        }

                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                        console.log("Error on accessing webservice data " + jqXHR.responseText );
                    }
                });


            }else {
                alert(validate.message)
            }
        }
        ,validateEntries : function(){
            var period = $.trim($('#cmb_period').val())
                ,customer = $.trim( $('#cmb_customer').val() )
                ,contracted_capacity = $.trim( $('#txt_contracted_capacity').val() )
                ,is_valid = true
                ,error_message = []
                ;

            if ( period.length < 1 ){
                is_valid = false;
                error_message.push('Period entry is mandatory.');
            }

            if ( customer.length < 1 ){
                is_valid = false;
                error_message.push('Customer entry is mandatory.');
            }

            if ( contracted_capacity.length < 1 ){
                is_valid = false;
                error_message.push('Contract capacity entry is mandatory.');
            }else {
                var contracted_capacity_val = parseInt(contracted_capacity,10);
                if ( contracted_capacity_val < 1  ) {
                    is_valid = false;
                    error_message.push('Contract capacity should be greater than zero.');
                }
            }


            return {
                'valid' : is_valid
                ,'message' : is_valid ? '' : 'Please verify the following form issues \n' + error_message.join('\n')
            }

        }
    });

    $(document).ready(function() {
        $.populateYearPicker();
        $.populateList();
        $.populateYearModalWindow();

        /*var width_ = $('div.last').css('width').replace(/px/gi, "");
        width_ = parseInt(width_,10) - 15;
        $('#results_container').css('width',width_+'px');*/

        $('#cmb_year').unbind().bind('change',function(){
            var current_server_date = '<?php echo date('Y-m-d');?>';

            if ($.trim($(this).val()).length > 0  ) {
                var yr = parseInt($(this).val(),10);
                var prv_yr = yr - 1, nxt_yr = yr + 1;
                var s_sdate = '', s_edate = '', e_ctr = 1;
                var end_date = '', start_date = '' , current_date = Date.parse(current_server_date);
                var is_append = false;
                var period_contents = '';

                for (var c=0;c<12;c++){
                    if ( c === 0 ) {
                        s_sdate = prv_yr + '-12-26';;
                    }else {
                        s_sdate = yr + '-' + c + '-26';
                    }
                    /*
                    if ( c === 11 ) {
                        s_edate = nxt_yr + '-' + e_ctr + '-25';
                    }else {
                        s_edate = yr + '-' + e_ctr + '-25';
                    }*/
                    s_edate = yr + '-' + e_ctr + '-25';

                    start_date = Date.parse(s_sdate);
                    end_date = Date.parse(s_edate);

                    s_sdate = start_date.toString("d-MMM-yyyy");
                    s_edate = end_date.toString("d-MMM-yyyy");

                    is_append = false;
                    if ( start_date > current_date ){
                        is_append = true;
                    }else {
                        if (  current_date >= start_date && current_date <= end_date ) {
                            is_append = true;
                        }
                    }
                    if ( is_append ) {
                        period_contents+='<option value="'+  start_date.toString("MM/dd/yyyy") + '-'  + end_date.toString("MM/dd/yyyy")  +'">'+s_sdate+ ' - ' + s_edate + '</th>';
                    }

                    e_ctr++;
                }

                $('#cmb_period').html(period_contents);
            }else {
                $('#cmb_period').html('');
            }
        });


        $("#txt_contracted_capacity").keydown(function(event) {
            // Allow: backspace, delete, tab, escape, and enter
            if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                // Allow: Ctrl+A
                (event.keyCode == 65 && event.ctrlKey === true) ||
                // Allow: home, end, left, right
                (event.keyCode >= 35 && event.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            else {
                // Ensure that it is a number and stop the keypress
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                    event.preventDefault();
                }
            }
        });


        $('#btn_add').unbind().bind('click',function(e){
            e.preventDefault();
            //$.showAddScreen();
        });


        $('#yearpicker').unbind().bind('change',function(){
            $.populateList();
        });

        $('table#results_list td:gt(1)').unbind().live('click',function(){
           if ( typeof $(this).attr('class') =='undefined' && typeof $(this).attr('id_val') != 'undefined' ) {
               EDIT_ID = $(this).attr('id_val');
               $.showEditScreen($(this).attr('id_val'));
           }
        });
    });
</script>

<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>
<style>
    table.table th {
        text-align: center;
        vertical-align: middle;
    }
    
    .errormsg {
        color:red;
    }
    
    a {
        cursor:pointer;
    }
</style>
<div class="span12">
    
    <section id="global">
        <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
        <form name="frm_create_contracts"  id="frm_create_contracts" enctype="multipart/form-data" method="post">
        <div class="row-fluid">
            <div class="span2">Participant :</div>
            <div class="span10">
                <select  id="participant" name="participant" class="input-xlarge">

                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Customer :</div>
            <div class="span10">
                <select id="customer" name="customer" class="input-xlarge">
                </select>
            </div>
        </div>
        <a href="javascript:void(0);" role="button" class="btn btn-primary" id="view_contracts_button"><i class="icon-list"></i>&nbsp;&nbsp;View Contracts </a>
        <a href="javascript:void(0);" role="button" class="btn btn-primary" id="create_button"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Create New Contract </a>

        <hr>
        <legend id="legend_result">Contracts </legend>
        <span class="loader" id="loader_result"></span>
        <div id="result" style="width:95%;">
        </div>
        <div id="result2" style="width:95%;">
        </div>
        </form>
    </section>
    
    
   <!-- Modal for details -->
    <div id="modalDetails" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="modalDetailsLabel">Contract Details</h3>
      </div>
      <div class="modal-body" id="modalDetailsContent">
        <p>One fine body…</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary" id="btn_terminate">Terminate</button>
      </div>
    </div>
</div>
<script type="text/javascript">
    CONTRACT_TYPES = [];
    BILLING_MONTHS = [];
    BILLING_YEARS = [];
    
    <?php foreach ($contract_types as $type){ ?>
        var obj = {};
        obj['id'] = '<?php echo $type["id"]; ?>';
        obj['label'] = '<?php echo $type["label"]; ?>';
        
        CONTRACT_TYPES.push(obj);
    <?php } ?>
        
    <?php for ($x=1;$x<=12;$x++) { ?>
        var obj = {};
        obj['id'] = '<?php echo $x; ?>';
        obj['label'] = '<?php echo date("M",  mktime(0,0,0,$x,1,date("Y"))); ?>';
        
        BILLING_MONTHS.push(obj);
    <?php } ?>    
        
    <?php for ($x=date('Y');$x>=date('Y')-2;$x--){ ?>
        var obj = {};
        obj['id'] = '<?php echo $x; ?>';
        obj['label'] = '<?php echo $x; ?>';
        
        BILLING_YEARS.push(obj);
    <?php } ?>        
</script>


<script type="text/javascript">
    var GID =null;
    $.extend({
        listParticipants: function() {
            $.post('../admin/contract_action', {'action':'list-participants'},
                    function(data) {
                        if (data.total >= 1) {
                            $.each(data.value, function(i, val) {
                                $('#participant').append('<option value="' + val.participant +'">' + val.participant + '</option>');
                            })
                        }
                        $.listCustomers();
                        return false;
                    });
        }
        
        ,listCustomers: function() {
            $.post('../admin/contract_action', {'action':'list-customers','participant': $('#participant').val()},
            function(data) {
                if (data.total >= 1) {
                    $('#customer').html('');
                    $.each(data.value, function(i, val) {
                        $('#customer').append('<option value="' + val.id + '">' + val.name + '</option>');
                    })
                    
                } else {
                    $('#customer').html('<option>No Customer Data</option>')
                }

                $.viewContracts();
                return false;
            });
        }
        ,populateListContractsByCustomer : function(yr,customer){
            $('#tbl_view_contracts').find("tr:gt(1)").remove();
            $.ajax({
                type: "POST"
                ,url : '../admin/contract_action'
                ,data: {'action':'list-customers-contracts','year' :yr, 'customer':customer}
                ,dataType:'json'
                ,async: true
                ,success: function(data){
                    var tbl_contents = "";
                    var data_list = data.value;
                    var obj = null;
                    var is_terminated = '', date_terminated = '', terminated_string="";
                    var total_records = 0;
                    for (var r=0;r<data_list.length;r++){
                        total_records++;
                        obj = data_list[r];
                        is_terminated = parseInt(obj.terminated,10) === 1 ? 'Yes' : 'No';
                        date_terminated = parseInt(obj.terminated,10) === 1 ? obj.date_terminated : '';
                        var terminated_string = parseInt(obj.terminated,10) === 0 ? '<span class="label label-success">'+is_terminated+'</span>' : '<span class="label label-important">'+is_terminated+'</span>';
                
                        tbl_contents+='<tr group_uid="'+obj.group_uid+'" contract_type="'+obj.contract_type+'" month="'+obj.billing_month+'" year="'+obj.billing_year+'">';
                        tbl_contents+='<td><a data-toggle="modal"  > '+obj.customer_name+'</a></td>';
                        tbl_contents+='<td>'+obj.contract_type_desc+'</td>';
                        tbl_contents+='<td>'+obj.billing_period+'</td>';
                        tbl_contents+='<td>'+obj.date_created_date+'</td>';
                        tbl_contents+='<td>'+terminated_string+'&nbsp;</td>';
                        tbl_contents+='<td>'+date_terminated+'&nbsp;</td>';
                        tbl_contents+='</tr>';
                    }
                    
                    
                    if (total_records > 0) {
                        $('#tbl_view_contracts').hide().append(tbl_contents).show('slow');
                    }else {
                        tbl_contents+='<tr class="info"><td colspan=7 class="info">No records found.</td></tr';
                        $('#tbl_view_contracts').append(tbl_contents);
                    }
                    
                    $('#tbl_view_contracts a').unbind().bind('click',function(){
                        var group_uid = $(this).parent().parent().attr('group_uid'); 
                        var contract_type = $(this).parent().parent().attr('contract_type'); 
                        $.viewContractDetail(group_uid,contract_type,$(this).parent().parent().attr('month'),$(this).parent().parent().attr('year'));
                    });
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        } // eof
        
        ,viewContractDetail : function(group_uid,contract_type,billing_month,billing_year){
            contract_type = parseInt(contract_type,10);
            $('#modalDetailsContent').html('Please wait....');
            $('#modalDetails').modal('show');
            GID = group_uid;
            var is_terminated = null;
            var contents = '';
            $.ajax({
                type: "POST"
                ,url : '../admin/contract_action'
                ,data: {'action':'list-contracts','group_uid' :group_uid,'billing_month' :billing_month, 'billing_year':billing_year }
                ,dataType:'json'
                ,async: true
                ,success: function(data){
                    
                    switch (contract_type){
                        // FIXED QUANTITY VIEW
                        case 1: 
                          var data_ = data.value.list;
                          is_terminated = data_.terminated;
                          contents+='<table  class="table table-bordered table-striped" width="100%">';
                          contents+= '<tr><th style="text-align:left;">Contracted Capacity : </th>';
                          contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(data_.contracted_capacity,5) +'&nbsp;</td></tr>';
                          contents+= '<tr><th  style="text-align:left;">Min :</th>';
                          contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(data_.min,5) +'&nbsp;</td></tr>';
                          contents+= '<tr><th  style="text-align:left; padding:10px;">Max :</th>';
                          contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(data_.max,5) +'&nbsp;</td></tr>';
                          contents+='</table>';
                          break;
                          
                        /// Per Interval per Billing Period  
                        case 2:
                          var data_ = data.value.list, interval_data = null;      
                          is_terminated = null;
                          contents+='<table   class="table table-bordered table-striped" width="100%">';
                          contents+= '<tr><th rowspan=2 width="10%">Interval</th><th rowspan=2 width="10%">Contracted Capacity</th><th colspan=2>Min Contracted Energy</th><th colspan=2>Max Contract Energy</th>';
                          contents+= '<tr><th width="10%">Reg</th><th width="10%">Sun&Hol</th><th width="10%">Reg</th><th width="10%">Sun&Hol</th>';
                          contents+= '</tr>'
                          for (var i=1;i<=24;i++) {
                            interval_data = data_[i];
                            if (is_terminated === null) {
                                is_terminated = interval_data.terminated;
                            }
                            contents+= '<tr>';
                            contents+= '<td style="text-align:center;">'+i+'</td>';
                            contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_data.contracted_capacity,5) +'&nbsp;</td>';
                            contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_data.min,5) +'&nbsp;</td>';
                            contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_data.hol_min,5) +'&nbsp;</td>';
                            contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_data.max,5) +'&nbsp;</td>';
                            contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_data.hol_max,5) +'&nbsp;</td>';
                            contents+= '</tr>'
                                
                          }
                          contents+='</table>';
                          break;
                        case 3:
                          var data_ = data.value.list, interval_data = null, interval_date_data = null;   
                          var start = new Date(data.value.billing_sdate);
                          var end = new Date(data.value.billing_edate);
                          var loop_date = '';    
                          var newDate = null;
                          is_terminated = null;
                          contents= '<table width="100%"   class="table table-bordered table-striped">';
                          contents+= '<tr><th  rowspan=3 width="10%">Interval</th>';
                          
                          var subheader = "";
                          var subsubheader = "";
                          while(start <= end){
                                loop_date = start.toString('yyyy-MM-dd');
                                contents+= '<th colspan="5">'+loop_date + '</th>';
                                subheader+= '<th rowspan="2">Contracted Capacity</th> ';
                                subheader+= '<th colspan="2">Min Contracted Energy</th> ';
                                subheader+= '<th colspan="2">Max Contract Energy</th> ';
                                
                                subsubheader+='<th>Reg</th><th>Sun&Hol</th><th>Reg</th><th>Sun&Hol</th>';
                                
                                newDate = start.setDate(start.getDate() + 1);
                                start = new Date(newDate);
                          }
                          contents+='</tr><tr>'+subheader+'</tr><tr>'+subsubheader+'</tr>';
                    
                          for (var i=1;i<=24;i++) {
                            contents+= '<tr>';
                            contents+= '<td style="text-align:center;">'+i+'</td>';
                            
                            start = new Date(data.value.billing_sdate);
                            while(start <= end){
                                loop_date = start.toString('yyyy-MM-dd');
                                interval_date_data = data_[loop_date][i];
                                
                                if (is_terminated === null) {
                                    is_terminated = interval_date_data.terminated;
                                }
                                contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_date_data.contracted_capacity,5) +'&nbsp;</td>';
                                contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_date_data.min,5) +'&nbsp;</td>';
                                contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_date_data.hol_min,5) +'&nbsp;</td>';
                                contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_date_data.max,5) +'&nbsp;</td>';
                                contents+= '<td>'+ $.formatNumberToSpecificDecimalPlaces(interval_date_data.hol_max,5) +'&nbsp;</td>';
                                newDate = start.setDate(start.getDate() + 1);
                                start = new Date(newDate);
                          }
                            
                            
                            contents+= '</tr>'
                                
                          }
                          contents+='</table>';
                    
                          break;
                    }
                    $('#modalDetailsContent').html(contents);
                    if (is_terminated === 0){
                        $('#btn_terminate').show();
                    }else {
                        $('#btn_terminate').hide();
                    }
                    
                    
                    
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
            
            
            
            
        }
        ,terminateContract : function(group_uid){
            $.ajax({
                type: "POST"
                ,url : '../admin/contract_action'
                ,data: {'action':'terminate','group_uid' :group_uid}
                ,dataType:'json'
                ,async: true
                ,success: function(data){
                    $('#modalDetails').modal('toggle');
                    $.populateListContractsByCustomer($('#year').val(),$('#customer').val());
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        } // eeof terminateContract
        ,viewContracts : function(){
            var customer_sel = $('#customer').val();
            var customer_name = $( "#customer option:selected" ).text();

            $('#legend_result').html('Contracts of ' + customer_name.toUpperCase());
            $('#loader_result').html('');
            $('#result').html('');
            $("#result").removeClass('alert');
            $("#result").removeClass('alert-info');
            $("#result").removeClass('alert-error');
            if (customer_sel === 'No Customer Data' ){
                $("#result").addClass('alert alert-error');
                $("#result").html('Invalid customer selection');
            }else{
                var tbl_contents = "<table id='tbl_view_contracts' class='table table-bordered table-striped'>";
                tbl_contents+='<tr>';
                tbl_contents+='<td style="width:150px;">Year :</td>';
                tbl_contents+='<td colspan="5"><select id="year"  name="year" class="input-small">';

                for (var c=0;c<BILLING_YEARS.length;c++){
                    var obj = BILLING_YEARS[c];
                    tbl_contents+='<option value="'+ obj['id'] +'">'+obj['label']+'</option>';
                }

                tbl_contents+='</select></td>';
                tbl_contents+='</tr>';
                tbl_contents+='<tr><th>Customer</th><th>Contract Type</th><th>Billing Period</th><th>Date Created</th><th>Is Terminated?</th><th>Date Terminated?</th></tr>';
                tbl_contents+='</table>';    
                $("#result").html(tbl_contents);
                $('#year option:eq(0)').prop('selected', true); 
                $.populateListContractsByCustomer(parseInt('<?php echo date("Y");?>',10),customer_sel);
            }
        } // eof viewContracts
        
        ,create : function(){
            var customer_sel = $('#customer').val();
            var customer_name = $( "#customer option:selected" ).text();
            $('#legend_result').html('Create New Contract for ' + customer_name.toUpperCase());
            $('#loader_result').html('');
            $('#result').html('');
            $("#result").removeClass('alert');
            $("#result").removeClass('alert-info');
            $("#result").removeClass('alert-error');
            if (customer_sel === 'No Customer Data' ){
                $("#result").addClass('alert alert-error');
                $("#result").html('Invalid customer selection');
            }else{
                var html_create = '<div class="row-fluid">';
                html_create+= '<div class="span2">Contract Type :</div>';
                html_create+= '<div class="span10">';
                html_create+= '<select  id="contract_type" name="contract_type" class="span4" style="margin-left:10px;">';
                for (var c=0;c<CONTRACT_TYPES.length;c++){
                    var type = CONTRACT_TYPES[c];
                    html_create+='<option value="'+ type['id'] +'">'+type['label']+'</option>';
                }
                html_create+= ' </select></div></div>';
                
                // for billing period
                html_create+= '<div class="row-fluid">';
                html_create+= '<div class="span2">Billing Period :</div>';
                //html_create+= '<div class="span10">';
                html_create+= '<div class="span10 input-append">';
                html_create+= '<select  id="billing_month" name="billing_month" class="span2" style="margin-left:10px;">';
                for (var c=0;c<BILLING_MONTHS.length;c++){
                    var obj = BILLING_MONTHS[c];
                    html_create+='<option value="'+ obj['id'] +'">'+obj['label']+'</option>';
                }
                html_create+= ' </select> &nbsp;';
                        
                html_create+= '<select  id="billing_year" name="billing_year" class="span2" style="margin-left:10px;">';
                for (var c=0;c<BILLING_YEARS.length;c++){
                    var obj = BILLING_YEARS[c];
                    html_create+='<option value="'+ obj['id'] +'">'+obj['label']+'</option>';
                }
                html_create+= ' </select>&nbsp;';
                
                html_create+= '<button id="validate_create" class="btn ">Validate</button>';
                html_create+='</div></div>';
                $("#result").html(html_create);
            }
        } // eof create
        
        ,validateCreate : function(){
            
            var customer_sel = $('#customer').val();
            $("#result2").html("");
            $("#result2").addClass('alert-info');
            $("#result2").addClass('alert-error');
            var parameters = {};
            if (customer_sel !== 'No Customer Data' ){
                parameters['action'] = 'validate';
                parameters['customer_id'] = customer_sel;
                parameters['billing_month'] = $('#billing_month').val();
                parameters['billing_year'] = $('#billing_year').val();
                
                $('#loader_result').html('Please wait...');
                $('#result_create_contents').remove();
                $.post('../admin/contract_action', parameters,
                    function(data) {
                        var is_success = parseInt(data.success,10);
                        if (is_success === 1) {
                            
                            $.populateCreateScreen(data);
                            $('#loader_result').html('');
                            $('div.alert-error').remove();
                        }else {
                            $('#loader_result').html('');
                            $("#result2").html('<div class="alert alert-error" style="width:100%;">'+data.message+'</div>');
                            return false;
                        }
                        
                    });
            }
        } // eof validateCreate
        ,populateCreateScreen : function(data){
            var contract_type = parseInt($('#contract_type').val(),10);
            var is_valid_contract_type = false;
            var html_create_contents = '<div id="result_create_contents">';
            
            html_create_contents += '<br/><h6>Populate Values :</h6>';
            html_create_contents+= '<hr/>';
            html_create_contents+= '<div class="row-fluid">';
            html_create_contents+= '<div class="span2">Thru File Upload</div>';
            html_create_contents+= '<div class="span10">';
            html_create_contents+= '<div class="fileupload fileupload-new span6" data-provides="fileupload">';
            html_create_contents+= '<div class="input-append">';
            html_create_contents+= '<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>';
            html_create_contents+= '<span class="btn btn-file"><span class="fileupload-new">Select file</span>';
            html_create_contents+= '<span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />';
            html_create_contents+= '</span>';
            html_create_contents+= '<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>'
            html_create_contents+= '<input type="button" value="Upload" id="upload_btn" class="btn fileupload-exists btn-primary" />';
            html_create_contents+= '</div>'
            html_create_contents+= '</div></div></div><br/>';
                
                
            switch (contract_type){
                case 1: // fixed quantity
                  is_valid_contract_type = true;
                  html_create_contents+= '<div id="result_entries_error"></div><div class="row-fluid">';
                  html_create_contents+= '<div class="span2">Contracted Capacity : </div>';
                  html_create_contents+= '<div class="span10"><input type="text" autocomplete="off" name="contracted_capacity" value=""/></div>';
                  html_create_contents+= '</div>';
                  
                  html_create_contents+= '<div class="row-fluid">';
                  html_create_contents+= '<div class="span2">Min : </div>';
                  html_create_contents+= '<div class="span10"><input type="text" autocomplete="off" name="min" value=""/></div>';
                  html_create_contents+= '</div>';
                  
                  html_create_contents+= '<div class="row-fluid">';
                  html_create_contents+= '<div class="span2">Max :</div>';
                  html_create_contents+= '<div class="span10"><input type="text" autocomplete="off" name="max" value=""/></div>';
                  html_create_contents+= '</div>';
                  break;
                case 2:
                  is_valid_contract_type = true;
                  html_create_contents+= '<div id="result_entries_error"></div>';
                  html_create_contents+= '<div class="row-fluid">';
                  html_create_contents+= '<div class="span2">Populate Text Box</div>';
                  html_create_contents+= '<div class="span4 input-prepend input-append">';
                  html_create_contents+= '<span class="add-on">&nbsp;Interval&nbsp;</span><input type="text" style="width:50px"  class="input-mini" id="txt_interval" value="1-24" />';
                  html_create_contents+= '<span class="add-on">&nbsp;Contracted Capacity&nbsp;</span><input type="text" value="10000" id="txt_pop_contracted_capacity" class="input-mini">';
                  html_create_contents+= '<span class="add-on">&nbsp;Min&nbsp;</span><input type="text" value="1" id="txt_pop_min" class="input-mini">';
                  html_create_contents+= '<span class="add-on">&nbsp;Max&nbsp;</span><input type="text" value="100" id="txt_pop_max" class="input-mini">';
                  html_create_contents+= '<button id="btn_populate_apply" type="button" class="btn">Populate</button>';
                  html_create_contents+= '<button id="btn_populate_clear" type="button" class="btn">Clear</button>';
                  html_create_contents+= '</div>';
                  html_create_contents+= '</div>';
                  
                  // contents
                  html_create_contents+= '<div class="row-fluid">';
                  html_create_contents+= '<table width="100%" class="table table-bordered table-striped"><thead>';
                  html_create_contents+= '<tr><th rowspan=2 width="10%">Interval</th><th rowspan=2 width="10%">Contracted Capacity</th><th colspan=2>Min Contracted Energy</th><th colspan=2>Max Contract Energy</th>';
                  html_create_contents+= '<tr><th width="10%">Reg</th><th width="10%">Sun&Hol</th><th width="10%">Reg</th><th width="10%">Sun&Hol</th>';
                  html_create_contents+= '</tr></thead>';
                  
                  for (var r=1;r<=24;r++){
                      html_create_contents+= '<tr class="item">';
                      html_create_contents+= '<td style="text-align:center;">'+r+'</td>';
                      html_create_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="contracted_capacity" name="contracted_capacity_'+r+'" id="contracted_capacity_'+r+'" value=""/></td>';
                      html_create_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="min" name="min_'+r+'" id="min_'+r+'" value=""/></td>';
                      html_create_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="hol_min" name="hol_min_'+r+'" id="hol_min_'+r+'" value=""/></td>';
                      html_create_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="max" name="max_'+r+'" id="max_'+r+'" value=""/></td>';
                      html_create_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="hol_max" name="hol_max_'+r+'" id="hol_max_'+r+'" value=""/></td>';
                      html_create_contents+= '<td width="20%" style="display:none" kind="errors">&nbsp;</td>';
                      html_create_contents+= '</tr>'
                  }
                  html_create_contents+= '</table>';
                  html_create_contents+= '</div>';
                  break;
                case 3:
                    var start = null;
                    var end = null;
                    var loop_date = '';    
                    var newDate = null;
                    is_valid_contract_type = true;
                    
                    html_create_contents+= '<div id="result_entries_error"></div>';
                    html_create_contents+= '<div class="row-fluid">';
                    html_create_contents+= '<div class="span2">Populate Text Box</div>';
                    html_create_contents+= '<div class="span4 input-prepend input-append">';
                    html_create_contents+= '<span class="add-on">&nbsp;Interval&nbsp;</span><input type="text" style="width:50px"  class="input-mini" id="txt_interval" value="1-24" />';
                    html_create_contents+= '<span class="add-on">&nbsp;Contracted Capacity&nbsp;</span><input type="text" value="10000" id="txt_pop_contracted_capacity" class="input-mini">';
                    html_create_contents+= '<span class="add-on">&nbsp;Min&nbsp;</span><input type="text" value="1" id="txt_pop_min" class="input-mini">';
                    html_create_contents+= '<span class="add-on">&nbsp;Max&nbsp;</span><input type="text" value="100" id="txt_pop_max" class="input-mini">';
                    html_create_contents+= '</div>';
                    html_create_contents+= '</div>';
                    
                    html_create_contents+= '<div class="row-fluid">';
                    html_create_contents+= '<div class="span2">&nbsp;</div>';
                    html_create_contents+= '<div class="span4 input-prepend input-append">';
                    
                    html_create_contents+= '<span class="add-on">&nbsp;Apply to All dates <input type="checkbox" id="chk_all_dates" value="0">&nbsp;';
                    html_create_contents+= '<select id="cmb_pop_dates" class="input">';
                    
                    var tabs_links = '<ul class="nav nav-tabs" id="myTab">';
                    var tabs_contents = '<div class="tab-content">';
                    var start = new Date(data.value.billing_sdate);
                    var end = new Date(data.value.billing_edate);
                    var loop_date = '';    
                    var newDate = null;
                    var c = 1;
                    var active = "";
                    var loop_date_str = "";
                    while(start <= end){
                        loop_date = start.toString('yyyy-MM-dd');
                        loop_date_str = start.toString('d-MMM-yyyy');
                        html_create_contents += '<option value="'+ loop_date +'">'+loop_date+'</option>';
                         
                        if (c===1) {
                             active = 'active';
                         } else {
                             active = '';
                         }
                         
                        tabs_links += '<li class="'+active+'"><a data-target="#tabs-'+loop_date+'" data-toggle="tab">'+loop_date_str+'</a></li>';
                       
                        
                        
                        tabs_contents+='<div class="tab-pane '+active+'" id="tabs-'+loop_date+'">';
                        
                        tabs_contents+= '<table width="100%"  class="table table-bordered table-striped"><thead><tr><th colspan="7" style="background-color:#f4f4f4;">'+loop_date_str+'</th></tr>';
                        tabs_contents+= '<tr><th rowspan=2 width="10%">Interval</th><th rowspan=2 width="10%">Contracted Capacity</th><th colspan=2>Min Contracted Energy</th><th colspan=2>Max Contract Energy</th>';
                        tabs_contents+= '<tr><th width="10%">Reg</th><th width="10%">Sun&Hol</th><th width="10%">Reg</th><th width="10%">Sun&Hol</th>';
                        tabs_contents+= '</tr></thead>';
                  
                        for (var r=1;r<=24;r++){
                            tabs_contents+= '<tr class="item">';
                            tabs_contents+= '<td style="text-align:center;">'+r+'</td>';
                            tabs_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="contracted_capacity" name="contracted_capacity_'+r+'_'+loop_date+'" id="contracted_capacity_'+r+'_'+loop_date+'" value=""/></td>';
                            tabs_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="min" name="min_'+r+'_'+loop_date+'" id="min_'+r+'_'+loop_date+'" value=""/></td>';
                            tabs_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="hol_min" name="hol_min_'+r+'_'+loop_date+'" id="hol_min_'+r+'_'+loop_date+'" value=""/></td>';
                            tabs_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="max" name="max_'+r+'_'+loop_date+'" id="max_'+r+'_'+loop_date+'" value=""/></td>';
                            tabs_contents+= '<td ><input style="width:90%" type="text" autocomplete="off" kind="hol_max" name="hol_max_'+r+'_'+loop_date+'" id="hol_max_'+r+'_'+loop_date+'" value=""/></td>';
                            tabs_contents+= '<td width="20%" style="display:none" kind="errors">&nbsp;</td>';
                            tabs_contents+= '</tr>'
                        }
                        tabs_contents+= '</table>';
                        tabs_contents += '</div>';
                        
                        
                        newDate = start.setDate(start.getDate() + 1);
                        start = new Date(newDate);
                        c++;
                    }
                    tabs_links+='</ul>';
                    
                    html_create_contents+= '</select></span>'
                    html_create_contents+= '<button id="btn_populate_apply" type="button" class="btn">Populate</button>';
                    html_create_contents+= '<button id="btn_populate_clear" type="button" class="btn">Clear</button>';
                    html_create_contents+= '</div>';
                    html_create_contents+= '</div>';
                    
                    
                    html_create_contents +='<div>';
                    html_create_contents += tabs_links + tabs_contents + '</div>';
                    html_create_contents +='</div>';
                  break;
            }
            
            if (is_valid_contract_type) {
                html_create_contents+='<a href="javascript:void(0);" role="button" class="btn btn-primary" id="btn_submit"><i class="icon-plus"></i>Submit</a>';
                html_create_contents+= '</div>';
                $('#result').append(html_create_contents);
                
                if (contract_type === 3) {
                    //$('#myTab').tab('show');
                }
                
            }
        } // eof populateCreateScreen
        
        //############### saving
        ,validateEntries : function(cur) {
            var contracted_capacity = null,min = null, max = null, hol_min = null, hol_max = null;
            var is_valid_contract_type = false, is_valid_max = false, is_valid_min = false, is_valid_hol_max = false, is_valid_hol_min = false;
            var total_errors = 0;
            var html_error = "";
            var n_max = 0, n_min = 0, n_hol_max= 0, n_hol_min=0;
            var is_valid_row = false;
            
            contracted_capacity = $.trim(cur.find("input[kind=contracted_capacity]").val());
            min = $.trim(cur.find("input[kind=min]").val());
            max = $.trim(cur.find("input[kind=max]").val());
            hol_min = $.trim(cur.find("input[kind=hol_min]").val());
            hol_max = $.trim(cur.find("input[kind=hol_max]").val());
            is_valid_contract_type = false;
            is_valid_max = false;
            is_valid_min = false;
            is_valid_hol_max = false;
            is_valid_hol_min = false;
            is_valid_row = false;
            html_error = "";
            
            
            /// contracted capacity 
            if (contracted_capacity.length >= 1) {
                if ( isNaN(parseFloat(contracted_capacity))  ) {
                    html_error = '<span class="errormsg">Invalid contracted capacity</span><br/>';
                }else {
                    is_valid_contract_type = true;
                }
            }else {
                html_error = '<span class="errormsg">Contracted capacity entry is empty</span><br/>';
            }

            if (!is_valid_contract_type){
                total_errors++;
            }


            /// max
            if (max.length >= 1) {
              if ( isNaN(parseFloat(max))  ) {
                  html_error+= '<span class="errormsg">Invalid Regular Max</span><br/>';
              }else {
                  is_valid_max = true;
              }
            }else {
                html_error+= '<span class="errormsg">Regular Max entry is empty</span><br/>';
            }
            if (!is_valid_max){
                total_errors++;
            }
            


            // min
            if (min.length >= 1) {
                if ( isNaN(parseFloat(min))  ) {
                    html_error+= '<span class="errormsg">Invalid Regular Min</span><br/>';
                }else {
                    is_valid_min = true;
                }
            }else {
                html_error+= '<span class="errormsg">Regular Min entry is empty</span><br/>';
            }
            if (!is_valid_min){
                total_errors++;
            }
 
            /// hol max
            if (hol_max.length >= 1) {
              if ( isNaN(parseFloat(hol_max))  ) {
                  html_error+= '<span class="errormsg">Invalid Sun&Hol Max</span><br/>';
              }else {
                  is_valid_hol_max = true;
              }
            }else {
                html_error+= '<span class="errormsg">Sun&Hol Max entry is empty</span><br/>';
            }
            if (!is_valid_hol_max){
                total_errors++;
            }
            
            


            // hol min
            if (hol_min.length >= 1) {
                if ( isNaN(parseFloat(hol_min))  ) {
                    html_error+= '<span class="errormsg">Invalid Sun&Hol Min</span><br/>';
                }else {
                    is_valid_hol_min = true;
                }
            }else {
                html_error+= '<span class="errormsg">Sun&Hol Min entry is empty</span><br/>';
            }
            if (!is_valid_hol_min){
                total_errors++;
            }
            
            if (is_valid_contract_type && is_valid_max && is_valid_min && is_valid_hol_max && is_valid_hol_min ) {
              n_max = parseFloat(max);
              n_min = parseFloat(min);
              if (n_min<= n_max) {
                  n_hol_max = parseFloat(hol_max);
                  n_hol_min = parseFloat(hol_min);
                  if (n_hol_min<= n_hol_max) {
                        is_valid_row = true;
                    }else {
                        is_valid_row = false;
                        total_errors++;
                        html_error+= '<span class="errormsg">Invalid values for Sunday&Hol Min and Max</span><br/>';
                    }
              }else {
                  total_errors++;
                  is_valid_row = false;
                  html_error+= '<span class="errormsg">Invalid values for Regular Min and Max</span><br/>';
              }

          }else {
              is_valid_row = false;
          }

          if (!is_valid_row) {
              cur.find("td[kind=errors]").html(html_error);
          }else{
            cur.find("td[kind=errors]").html('');
          }
         
          return total_errors;
        }
        ,submit : function(){
            var contract_type = parseInt($('#contract_type').val(),10);
            var is_valid_contract_type = false;
            var error_message_arr = [];
            
            switch (contract_type){
                case 1: // fixed quantity
                  var is_valid_contracted_capacity = false;
                  var is_valid_max = false, is_valid_min = false, is_valid_hol_max = false, is_valid_hol_min = false;
                  var min = null, max = null, hol_min = null, hol_max = null;
                  is_valid_contract_type = false;  
                  
                  var contracted_capacity = $.trim($('input[name=contracted_capacity]').val());
                  if (contracted_capacity.length >= 1) {
                      if ( isNaN(parseFloat(contracted_capacity))  ) {
                          error_message_arr.push('Invalid contracted capacity');
                      }else {
                          is_valid_contract_type = true;
                      }
                  }else {
                      error_message_arr.push('Contracted capacity entry is empty');
                  }
                  
                  
                  // 2. max
                  var max = $.trim($('input[name=max]').val());
                  if (max.length >= 1) {
                      if ( isNaN(parseFloat(max))  ) {
                          error_message_arr.push('Invalid Max');
                      }else {
                          is_valid_max = true;
                      }
                  }else {
                      error_message_arr.push('Max entry is empty');
                  }
                  
                  
                  // 3. min
                  var min = $.trim($('input[name=min]').val());
                  if (min.length >= 1) {
                      if ( isNaN(parseFloat(min))  ) {
                          error_message_arr.push('Invalid Min');
                      }else {
                          is_valid_min = true;
                      }
                  }else {
                      error_message_arr.push('Min entry is empty');
                  }
                  
                  
                  if (is_valid_contract_type && is_valid_max && is_valid_min ) {
                      var n_max = parseFloat(max);
                      var n_min = parseFloat(min);
                      
                      if (n_min<= n_max) {
                          is_valid_contract_type = true;
                      }else {
                          is_valid_contract_type = false;
                          $("#result_entries_error").removeClass('alert');
                          $("#result_entries_error").removeClass('alert-info');
                          $("#result_entries_error").removeClass('alert-error');

                          var err_msg = '<h4>Please see below errors.</h4><br/>Invalid values for Min and Max</div>' ;
                          $('#result_entries_error').html(err_msg).addClass('alert alert-block');
                          
                      }
                      
                  }else {
                      is_valid_contract_type = false;
                      $("#result_entries_error").removeClass('alert');
                      $("#result_entries_error").removeClass('alert-info');
                      $("#result_entries_error").removeClass('alert-error');
                      
                      var err_msg = '<h4>Please see below errors.</h4><br/>' + error_message_arr.join('<br/>') + '</div>' ;
                      $('#result_entries_error').html(err_msg).addClass('alert alert-block');
                      //alert();
                  }
                  
                  if (is_valid_contract_type) {
                    $('#loader_result').html('Please wait, submitting data...');  
                    $.post('<?=$base_url?>/admin/contract_submit',$('form').serialize(),
                        function(data){
                            if (parseInt(data.success) >= 1) {
                                $('#result_create_contents').remove();
                                $('#loader_result').html('');
                            }else {
                                $('#loader_result').html('With errors');  
                            }
                        });
                  }
                  
                  break;
                case 2:
                  var ctr = 0; 
                  var cur_errors =0; total_errors =0, cur = null;
                  var is_valid_row = false;
                  $("tr.item").each(function() {
                        cur = $(this);
                        ctr++;
                        cur_errors = $.validateEntries(cur);
                        total_errors+=cur_errors;
                  });
                  if (total_errors >= 1) {
                    $('table.table').find("td[kind=errors]").show();
                  }else {
                    $('#loader_result').html('Please wait, submitting data...');  
                    $.post('<?=$base_url?>/admin/contract_submit',$('form').serialize(),
                        function(data){
                            if (parseInt(data.success) >= 1) {
                                $('#result_create_contents').remove();
                                $('#loader_result').html('');
                            }else {
                                $('#loader_result').html('With errors');  
                            }
                        });
                  }
                  
                  break;
                case 3:
                  var cur_table = null, cur = null, total_errors = 0;
                  
                  $("div[type=tabs_date]").each(function() {
                        cur_table = $(this).find('table.grid');
                        $(cur_table).find("tr.item").each(function() {
                            cur = $(this);cur_errors = $.validateEntries(cur);
                            total_errors+=cur_errors;
                      });
                  });
                  
                   if (total_errors >= 1) {
                    $('table.grid').find("td[kind=errors]").show();
                  }else {
                    $('table.grid').find("td[kind=errors]").hide();
                    $('#loader_result').html('Please wait, submitting data...');  
                    $.post('<?=$base_url?>/admin/contract_submit',$('form').serialize(),
                        function(data){
                            if (parseInt(data.success) >= 1) {
                                $('#result_create_contents').remove();
                                $('#loader_result').html('');
                            }else {
                                $('#loader_result').html('With errors');  
                            }
                        });
                  }
                  break;
            }
            
            
        } // eof submit
        
        ,applyPopulate : function(){
            var contract_type = parseInt($('#contract_type').val(),10);
            if (contract_type === 2  || contract_type === 3 ) {
                var interval  = $.trim($('#txt_interval').val());
                var contracted_capacity = $.trim($('#txt_pop_contracted_capacity').val());
                var min 	= $.trim($('#txt_pop_min').val());
                var max 	= $.trim($('#txt_pop_max').val());
                var is_all_dates = $('#chk_all_dates').attr('checked') === 'checked' ? 1 : 0;
                var dte_suffix = "";
                if (!is_all_dates) {
                   dte_suffix = $('#cmb_pop_dates').val();

                }
                if (interval.length > 0 && contracted_capacity.length > 0 && min.length > 0 && max.length > 0) {
                    if ( !isNaN(parseFloat(contracted_capacity)) && !isNaN(parseFloat(max)) && !isNaN(parseFloat(min)) ) {
                        var n_min = parseFloat(min);
                        var n_max = parseFloat(max);
                        if (n_min <= n_max) {
                            var hour = interval.split('-');
                            var start = hour[0]/1;
                            var end = hour[1]/1;
                            if (!end) end = start;

                            for(x=start;x<=end;x++){
                                if (contract_type === 2  ) {
                                    $('#contracted_capacity_'+ x).val(contracted_capacity);
                                    $('#max_'+ x).val(max);
                                    $('#min_'+ x).val(min); 
                                    $('#hol_max_'+ x).val(max);
                                    $('#hol_min_'+ x).val(min); 
                                }else {
                                    $('input[name*=contracted_capacity_'+ x+'_'+ dte_suffix+']').val(contracted_capacity);
                                    $('input[name*=max_'+ x+'_'+ dte_suffix+']').val(max);
                                    $('input[name*=min_'+ x+'_'+ dte_suffix+']').val(min);
                                    $('input[name*=hol_max_'+ x+'_'+ dte_suffix+']').val(max);
                                    $('input[name*=hol_min_'+ x+'_'+ dte_suffix+']').val(min);
                                }

                            }
                        }else {
                            alert('Invalid Min/Max entries');
                        }
                    }else {
                        alert('Invalid populate entries');
                    }
                }else {
                        alert('Invalid populate entries');
                }
            } 
        } // eof apply populate
        ,clearPopulate : function(){
            var contract_type = parseInt($('#contract_type').val(),10);
            var is_all_dates = $('#chk_all_dates').attr('checked') === 'checked' ? 1 : 0;
            var dte_suffix = "";
            if (!is_all_dates) {
               dte_suffix = $('#cmb_pop_dates').val();
            }
            if (contract_type === 2 || contract_type === 3 ) {
                var interval  = $.trim($('#txt_interval').val());
                if (interval.length > 0 ) {
                    var hour = interval.split('-');
                    var start = hour[0]/1;
                    var end = hour[1]/1;
                    if (!end) end = start;

                    for(var x=start;x<=end;x++){
                        if ( contract_type === 2 ) {
                            $('#contracted_capacity_'+ x).val('');
                            $('#max_'+ x).val('');
                            $('#min_'+ x).val(''); 
                            $('#hol_max_'+ x).val('');
                            $('#hol_min_'+ x).val(''); 
                        }else {
                            $('input[name*=contracted_capacity_'+ x+'_'+ dte_suffix+']').val('');
                            $('input[name*=max_'+ x+'_'+ dte_suffix+']').val('');
                            $('input[name*=min_'+ x+'_'+ dte_suffix+']').val('');
                            $('input[name*=hol_max_'+ x+'_'+ dte_suffix+']').val('');
                            $('input[name*=hol_min_'+ x+'_'+ dte_suffix+']').val('');
                        }

                    }
                }else {
                    alert('Invalid clear entries');
                }

            }
        } // eof clearpopulate
    });
    
    
$.listParticipants();
$('#participant').unbind('change').bind('change', function(e) {
    e.preventDefault();
    $.listCustomers();
});

$('#create_button').unbind('click').bind('click', function(e) {
    e.preventDefault();
    $.create();
});

$('#validate_create').unbind('click').live('click', function(e) {
    e.preventDefault();
    $.validateCreate();
});

$('#btn_submit').unbind().live('click',function(){
    $.submit();
});


$('#btn_populate_apply').unbind().live('click',function(e){
    e.preventDefault();
    $.applyPopulate();
});
    

$('#btn_populate_clear').unbind().live('click',function(e){
	e.preventDefault();
        $.clearPopulate();
 });

$('#chk_all_dates').unbind().live('click',function(){
    var is_checked = $(this).attr('checked') === 'checked' ? 1 : 0;
    if (is_checked) {
        $('#cmb_pop_dates').attr('disabled',true);
    }else {
        $('#cmb_pop_dates').removeAttr('disabled');
    }
});

$('#upload_btn').unbind('click').live('click',function(e){
    e.preventDefault();
    var path = '<?=$base_url?>/admin/contract_upload?action=upload&contract_type='+$('#contract_type').val();
    
    // validate entries if with valid plant, customer, seil
    var contract_type = $.trim($('#contract_type').val())
        ,file_upload= $.trim($('input[name=filebrowser]').val())
        ,error_message = '';

    if (contract_type.length <= 0) {
        error_message = 'Invalid contract type';
    }else if ( file_upload.length <= 0 ) {
        error_message = 'Invalid file';
    }
    
    if ( error_message.length > 0 ) {
        alert(error_message);
        return false;
    }else {
        $('#upload-msg').html('Uploading file... Please wait...');
        var options = {target:'',
            url:path,
            data: {action:'upload','contract_type':$('#contract_type').val()},
            beforeSubmit: function() {
                $('#upload-msg').html('&nbsp;Uploading file... Please wait...')
            },
            success: function(data) {
              $('#result_create_contents').remove();
              $('#loader_result').html('');
            }};
        $('form').ajaxSubmit(options);
    }
});

$('#year').unbind().live('change',function(e){
	e.preventDefault();
        $.populateListContractsByCustomer($('#year').val(),$('#customer').val());
 });
$('#view_contracts_button').unbind().live('click',function(e){
	e.preventDefault();
        $.viewContracts();
 });
 
 $('#btn_terminate').unbind().live('click',function(e){
	e.preventDefault();
         $.terminateContract(GID);
 });
</script>
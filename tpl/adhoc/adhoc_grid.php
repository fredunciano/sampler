<!---<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>    
</div>--->
<div >
    <legend><h4 id="page_title"><?=$title?><small>&nbsp;</small></h4></legend>
    <div id="loader"></div>
    
    <div>
        
        <div style="float:right;"><button type="button" class="btn" id="btn_get_saved_values">Get Saved Values</button></div>
        <br><br>
       <div id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">1. Select table fields</a>
                    </h4>
                    
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="tblfields_panel" style="float:left;width:40%">
                            <ul id="tbl_fields_selection" class="table-list" style="display: block;">
                            </ul>
                            
                        </div>
                        
                        <div class="tblfields_panel" style="float:right;width: 57%;">
                            <div name="container_btn_clearall" style="float:right;padding: 4px; border:0px none; display:none;" ><button type="button" name="btn_clear_all" class="btn btn-info">Clear All</button></div>
                            <table class="table table-striped table-condensed" id="selected_table_fields_list">
                                <tr>
                                    <th width="35%">Table</th>
                                    <th width="35%">Field</th>
                                    <th width="35%">Actions</th>
                                </tr>
                            </table>
                            <div name="container_btn_clearall" style="float:right;padding: 4px; border:0px none;display:none;" ><button type="button" name="btn_clear_all" class="btn btn-info">Clear All</button></div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">2. Filters</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-striped table-condensed" id="tbl_filters">
                            <tr>
                                <td width="7%">&nbsp;</td>
                                <td width="35%"> 
                                    <input type="text" name="table_field" class="input" style="width:80%" readonly="true" />
                                    <button type="button" class="btn btn-mini btn-inverse" name="btn_get_table_fields_selections">...</button>
                                </td>
                                
                                <td width="10%"> 
                                    <select class="input-mini" name="operator"  style="width:98%">
                                    <option value="=">=</option>
                                    <option value="!=">!=</option>
                                    <option value=">">></option>
                                    <option value=">=">>=</option>
                                    <option value="<"><</option>
                                    <option value="<="><=</option>
                                  </select>
                                </td>
                                
                                 <td width="12%"> 
                                     <select class="input-small" name="value_type"  style="width:98%">
                                    <option value="value">Value</option>
                                    <option value="field">Table Field</option>
                                  </select>
                                </td>
                                
                                <td width="30%"> 
                                    <input type="text" name="value" class="input" style="width:85%" />
                                    <button type="button" class="btn btn-mini btn-inverse" name="btn_get_table_fields_selections_val" style="float:right;margin-top: 5px;">...</button>
                                </td>
                            </tr>
                        </table>
                        <div style="text-align:right;">
                            <button type="button" class="btn btn-info" id="btn_add_more_filters">Add More Filters</button>
                             <button type="button" class="btn btn-info" id="btn_clear_filters">Clear All</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">3. Export output to file</a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="alert alert-warning" id="alert_output">
                            Please select table fields first
                        </div>
                        <div id="buttons_output" style="padding:10px;display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <br><br><br><br>
</div>


<div id="modal_list_table_fields" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <div>Filter <input type="text" class="input" id="list_table_fields_filter"></div>
  </div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto;">
      <table id="modal_tbl_table_fields" class="table table-condensed table-striped">
          <tr>
              <th>Table</th>
              <th>Field</th>
          </tr>
      </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<div id="modal_list_saved_values" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  </div>
    <div id="loader_modal_list_saved_values"></div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto;">
      <table id="table_saved_values_list" class="table table-condensed table-striped">
      </table>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<div id="modal_form_save" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Save Adhoc Report?</h4>
  </div>
    <div id="loader_modal_form_save"></div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto;">
       <form id="form_save_report">
        <table width="100%">
            <tr>
                <td style="min-width: 80px; font-weight: bold;">Report Name</td>
                <td><input type="text" value="" id="txt_report_name" style="width: 120px;"></td>
            </tr>
            
            <tr>
                <td style="min-width: 80px; font-weight: bold;">Description</td>
                <td><input type="text" value="" id="txt_report_description" style="width: 90%;"></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" id="chk_share_grid_report">&nbsp;Share grid</td>
            </tr>
        </table>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary" id="btn_save_report" aria-hidden="true">Save</button>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>


<div id="modal_report_list" class="modal hide fade custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Adhoc Report List</h4>
  </div>
    <div id="loader_modal_report_list"></div>
    <div class="modal-body" style="max-height:300px;overflow-y:auto;">
      <div id="grid_data"></div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<style>
    .panel {
        border : 1px solid #f4f4f4;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    
    .panel-default > .panel-heading {
        background-image: linear-gradient(to bottom, #f5f5f5 0px, #e8e8e8 100%);
        background-repeat: repeat-x;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        padding: 10px 15px;
    }
    
    
    h4.panel-title a {
        color:#0088cc;
        font-size: 13px;
    }
    
    .panel-body {
        padding:4px;
    }
    
    .tblfields_panel {
        width:48%;
        border:1px solid #F0F0F0;
        border-radius: 2px;
        margin-bottom:6px;
        max-height: 300px;
        overflow-y: auto;
    }
    
    
    ul.table-list {
        list-style: none outside none;
        padding: 2px;
        margin:0px;
    }
    
    .table-field-list {
        background: none repeat scroll 0 0 #EAEDEF;
        border-radius: 3px 3px 3px 3px;
        color: #292929;
        margin: 6px;
        padding: 4px;
        list-style: none;
    }
    .table-list>li {
        margin-bottom: 4px;
        margin-left: 2px;
        padding: 6px;
        background: none repeat scroll 0 0 #C3DEFA;
        border-radius: 3px 3px 3px 3px;

    }


    .table-list>li a {
        color : #000000;
        text-decoration: none;
        margin: 10px;
        font-size: 11px;
    }

    
    .table-list>li:hover {
        background: none repeat scroll 0 0 #C1FFCF;
        border-radius: 3px 3px 3px 3px;
    }

    a:hover {
        text-decoration: underline;
    }
    
    .tblrow_hover { background-color:#E3F7E7; }
    
    
    body .custom-modal {
    /* new custom width */
    width: 750px;
    /* must be half of the width, minus scrollbar on the left (30px) */
    margin-left: -375px;
}
</style>    

<link rel="stylesheet" href="<?=$base_url?>/css/bootstrap-combobox.css" />
<script src='<?=$base_url?>/js/bootstrap-combobox.js'></script>
<script type="text/javascript">
    ADHOC_GRID = {
        selected_fields : {}
        ,mode : ''
        ,id : 0
        ,table_fields : {}
    };
    USERLOGGED = '<?php echo base64_decode($_SESSION['userid']);?>';
    ADHOC_FIELD_OBJ = null;
    
    $.fn.extend({
        moveRow: function (oldPosition, newPosition) {
            return this.each(function () {
                var row = $(this).find('tr').eq(oldPosition).detach();
                if (newPosition == $(this).find('tr').length) {
                    $(this).find('tr').eq(newPosition - 1).after(row);
                }
                else {
                    $(this).find('tr').eq(newPosition).before(row);
                }
            });
        }
    });

    $.extend({
        populateTableList : function(){
            $("#loader").html('Initializing module&nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
            $.ajax({
                type: "POST"
                ,url : '../adhoc/lookup_list'
                ,data: {}
                ,dataType:'json'
                ,async: true
                ,success: function(returnData){
                    $('#table-list').html("").hide();
                    var table_list = returnData.value
                        ,table_html = ""
                        ,table_name_descriptive =  ''
                        ,allow_dump_all_data = 0
                        ,fields = []
                        ,table_name = '';
                    for ( var a_ctr=0;a_ctr<table_list.length;a_ctr++ ) {
                        table_name = table_list[a_ctr].tbl_name;
                        table_name_descriptive = table_list[a_ctr].tbl_desciptive_name;
                        allow_dump_all_data = table_list[a_ctr].allow_dump_all_data;
                        fields = table_list[a_ctr].fields;

                        table_html+= '<li id="li_'+ table_name +'" style="padding:2px;">';
                        table_html+= '<a class="table-name" id="'+ table_name +'">'+ table_name_descriptive.toProperCase()
                            + '&nbsp;&nbsp;<img src="../images/plus.gif" name="add-all-fields" style="cursor:pointer;" id="add_'+ table_name +'" />'+'</a>';

                        var fields_html = '<ul style="display: none;" class="table-field-list" id="field_list_'+ table_name +'">';
                        for (var i=0;i<fields.length;i++){
                            var obj = fields[i]
                                ,datatype = obj.type.split('(')[0];

                            fields_html+= '<li id="'+ table_name +'_'+ obj.field +'" dtype="'+ datatype  +'" field="'+ obj.field +'" tbl="'+table_name+'">';
                            fields_html+= '<a href="#" name="table-field">'+ obj.field +'</a>';
                            fields_html+= '</li>';
                        }
                        fields_html+='</ul>'
                        table_html+= fields_html + '</li>';

                        ADHOC_GRID.table_fields[table_name] = { 'descriptive_name' : table_name_descriptive , 'fields' :  fields ,'allow_dump_all_data' : allow_dump_all_data};
                    }

                    $('#tbl_fields_selection').html(table_html).fadeIn(1000);
                    $("#loader").html('');


                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                }
            });
        }
        ,createGridElmEvents : function(){
            $('a.table-name').die('click');
            $('a.table-name').live('click',function(){
                var tbl = $(this).attr('id') ;
                var is_already_displayed = $('#field_list_'+tbl).css('display') === 'block' ? true : false;
                $('ul.table-field-list').hide();
                if (is_already_displayed) {
                    $('#field_list_'+tbl).show().fadeOut(1200);
                }   else {
                    $('#field_list_'+tbl).fadeIn(1200);
                }
            });


            $('img[name="add-all-fields"]').die('click');
            $('img[name="add-all-fields"]').live('click',function(e){
                e.stopPropagation();
                var tbl = $(this).attr('id') ;
                tbl = tbl.replace(/add_/gi, "");
                var field_list = [];
                $('#field_list_'+tbl + ' li').each(function(index) {
                    var field_name = $(this).attr('field') ;
                    var field_datatype = $(this).attr('dtype') ;
                    field_list.push({'field' : field_name, 'data_type' : field_datatype});
                });
                $.addFieldsToSelectedList(tbl, field_list);
                $.updateTableFieldSelections();
                $.updateQueryOutput();
            });


            $('a[name="table-field"]').die('click');
            $('a[name="table-field"]').live('click',function(e){
                e.stopPropagation();
                var li_obj = $(this).parent() ;
                $.addFieldsToSelectedList(li_obj.attr('tbl'), [{ 'field' : li_obj.attr('field'), 'data_type' : li_obj.attr('dtype')  }]);
                $.updateTableFieldSelections();
                $.updateQueryOutput();
            });

            $('img[name="row-move-up"]').die('click');
            $('img[name="row-move-up"]').live('click',function(){
                var row = $(this).parent().parent();
                var row_index = $(this).parent().parent()[0].rowIndex;
                var total_rows = $('#selected_table_fields_list tr').length-1;
                if ( row_index > 1 ){
                    var new_position = row_index-1;
                    $('#selected_table_fields_list').moveRow(row_index, new_position);
                }
            });

            $('img[name="row-delete"]').die('click').live('click',function(){
                var row = $(this).parent().parent()
                    ,row_index = $(this).parent().parent()[0].rowIndex
                    ,id = row.attr('id')
                    ,tbl_name = row.attr('tbl')
                    ,fld_name = row.attr('fldname');
                delete ADHOC_GRID['selected_fields'][tbl_name][fld_name];
                $(this).parent().parent().remove();
                $.updateTableFieldSelections();
                $.updateQueryOutput();
            });

           
           
           $('button[name=btn_get_table_fields_selections]').unbind().live('click',function(){
               $('#list_table_fields_filter').val('');
               var fld = $(this).parent().parent().find('input[name=table_field]');
               ADHOC_FIELD_OBJ = fld;
               $('#modal_list_table_fields').modal('show');
           });
           
           
           $('button[name=btn_get_table_fields_selections_val]').unbind().live('click',function(){
               $('#list_table_fields_filter').val('');
               var fld = $(this).parent().parent().find('input[name=value]');
               var value_type = $(this).parent().parent().find('select[name=value_type]').val();
               var table_field = $.trim($(this).parent().parent().find('input[name=table_field]').val());
               
               ADHOC_FIELD_OBJ = fld;
               if (value_type === 'value') {
                    $('#modal_list_saved_values').modal('show');
                    
                    $('#table_saved_values_list').html('');
                    
                    var table_field_arr = table_field.split('.');
                    
                    if (table_field_arr.length === 2) {
                        $('#loader_modal_list_saved_values').html('Please wait...');
                        var table_name = table_field_arr[0];
                        var field_name = table_field_arr[1];
                        
                        $.ajax({
                            type: "POST"
                            ,url:'../adhoc/list_distinct_table_field_values'
                            ,data: {'table' : table_name, 'field' : field_name }
                            ,dataType:'json'
                            ,async: true
                            ,success: function(data){
                                $('#loader_modal_list_saved_values').html('');
                                var value_list = data.value;
                                var value_html = '';
                                for (var i=0;i<value_list.length;i++){
                                    value_html += '<tr id="'+value_list[i]+'"><td>'+value_list[i]+'</td></tr>';
                                }
                               $('#table_saved_values_list').html(value_html);
                               
                               $('#table_saved_values_list tr').hover(function() {
                                    $(this).addClass('tblrow_hover');
                                }, function() {
                                    $(this).removeClass('tblrow_hover');
                                });
                            }
                        });
                    }else {
                        $('#loader_modal_list_saved_values').html('<br>Please select table field first');
                    }
                    
                    
               }else {
                   $('#modal_list_table_fields').modal('show');
               }
               
               
           });
           
           
           
           $('select[name=value_type]').unbind().live('change',function(){
               
               var val_fld = $(this).parent().parent().find('input[name=value]');
               var val_btn_get_fields = $(this).parent().parent().find('button[name=btn_get_table_fields_selections_val]');
               var selected_value = $.trim($(this).val().toLowerCase());
               
               val_fld.val('');
               if (selected_value === 'field') {
                   val_fld.attr('readonly',true);
               }else {
                   val_fld.removeAttr('readonly');
               }
           });
           
           $('#btn_clear_filters').unbind().bind('click',function(){
               $("#tbl_filters tr:gt(0)").remove();
           });
           
           
           $('#btn_add_more_filters').unbind().bind('click',function(){
               var append_html = '<tr>';
               append_html+=' <td width="9%">';
               append_html+='<img name="lnk_remove_filter_row" src="../images/table-delete-icon.png" style="cursor:pointer;" /><select class="input-mini" name="logical_operator"  style="width:70%;margin-left:2px;">';
               append_html+='<option value="and">and</option>';
               append_html+='<option value="or">or</option>';
               append_html+='</select>';
               append_html+='</td>';           
               append_html+='<td width="35%">';
               append_html+='<input type="text" name="table_field" class="input" style="width:80%" readonly="true" />';
               append_html+='<button type="button" class="btn btn-mini btn-inverse" name="btn_get_table_fields_selections" style="margin-left: 4px;">...</button>';
               append_html+='</td>';
               append_html+='<td width="10%">';
               append_html+='<select class="input-mini" name="operator"  style="width:98%">';
               append_html+='<option value="=">=</option>';
               append_html+='<option value="!=">!=</option>';
               append_html+='<option value=">">></option>';
               append_html+='<option value=">=">>=</option>';
               append_html+='<option value="<"><</option>';
               append_html+='<option value="<="><=</option>';
               append_html+='</select>';
               append_html+='</td>';
               append_html+='<td width="12%">';
               append_html+='<select class="input-small" name="value_type"  style="width:98%">';
               append_html+='<option value="value">Value</option>';
               append_html+='<option value="field">Table Field</option>';
               append_html+='</select>';
               append_html+='</td>';
               append_html+='<td width="30%">';
               append_html+='<input type="text" name="value" class="input" style="width:85%" />';
               append_html+='<button type="button" class="btn btn-mini btn-inverse" name="btn_get_table_fields_selections_val" style="float:right;margin-top: 5px;">...</button>';
               append_html+='</td></tr>';
               
               $('#tbl_filters').append(append_html);
           });
           
           
           
           $('img[name=lnk_remove_filter_row]').unbind().live('click',function(){
               $(this).parent().parent().remove()
           });
           
           
           $('#modal_tbl_table_fields tr:gt(0)').unbind().live('click',function(){
               var val_fld = $(this).attr('id');
               ADHOC_FIELD_OBJ.val(val_fld);
               $('#modal_list_table_fields').modal('hide');
           });
           
            $('#table_saved_values_list tr').unbind().live('click',function(){
               var val_fld = $(this).attr('id');
               ADHOC_FIELD_OBJ.val(val_fld);
               $('#modal_list_saved_values').modal('hide');
           });
            
            
           $('#btn_export_output').unbind().live('click',function(){
               $.csvExportOutput();
           });
           
           
           $('#btn_save_report').unbind().live('click',function(){
               $.saveReport();
           });
           
           $('a.delete_button').unbind().live('click',function(){
               var row_id = $(this).attr('id');
               $.ajax({
                    type: "POST"
                    ,url:'../adhoc/adhoc_grid_action'
                    ,data: {'type': 'delete', 'id' : row_id}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(returnData){
                        $('#loader_modal_report_list').removeAttr('class').html('Please wait, loading list.').addClass('alert').addClass('alert-info').show();
                        $.listSaveReport();

                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                    }
                });
           });
           
           $('a.row_report').unbind().live('click',function(){
               $.clearAll();
               var row_id = $(this).attr('id');
               $.ajax({
                    type: "POST"
                    ,url:'../adhoc/adhoc_grid_action'
                    ,data: {'type': 'get', 'id' : row_id}
                    ,dataType:'json'
                    ,async: true
                    ,success: function(returnData){
                        var data = returnData.value;
                        if (returnData.total > 1) {
                            ADHOC_GRID['id'] = data.id;
                            ADHOC_GRID['current_row'] = data;
                            $('#page_title').html('Update ADHOC REPORT : ' + data.name);
                            
                            var filters = data.filters;
                            filters = filters.replace(/ and /g, "| and ");
                            filters = filters.replace(/ or /g, "| or ");
                            var row_filters = filters.split('|')
                            var row_fields = data.fields.split(',');
                            for (var f=0;f<row_fields.length;f++){
                                var tblfld = row_fields[f].split('.');
                                $.addFieldsToSelectedList(tblfld[0], [{ 'field' : tblfld[1], 'data_type' : 'string'  }]);
                            }
                            
                            
                            for (var g=0;g<row_filters.length;g++ ){
                                
                                if (g > 0 ) {
                                    $('#btn_add_more_filters').trigger('click');
                                }
                                
                                var filter = row_filters[g];
                                filter = filter.replace(/ and /, " and | ");
                                filter = filter.replace(/ or /, " or | ");
                                filter = filter.replace(/ = /g, "| = | ");
                                filter = filter.replace(/ != /g, "| |= | ");
                                filter = filter.replace(/ > /g, "| > | ");
                                filter = filter.replace(/ >= /g, "| >= | ");
                                filter = filter.replace(/ < /g, "| < | ");
                                filter = filter.replace(/ <= /g, "| <= | ");
                                
                                var filter_arr = filter.split('|');
                                
                                if (filter_arr.length === 4) {
                                    $('#tbl_filters tr:eq('+g+') select[name=logical_operator] option[value="'+$.trim(filter_arr[0])+'"]').attr("selected", "selected");
                                    $('#tbl_filters tr:eq('+g+') input[name=table_field]').val($.trim(filter_arr[1]));
                                    $('#tbl_filters tr:eq('+g+') select[name=operator] option[value="'+$.trim(filter_arr[2])+'"]').attr("selected", "selected");
                                    
                                    var value = $.trim(filter_arr[3]);
                                    var value_type = 'value';
                                    if (value.indexOf("'") === -1) {
                                        value_type = 'field';
                                    }else {
                                        value = value.replace(/'/g, "");
                                    }
                                    value =  $.trim(value);
                                    $('#tbl_filters tr:eq('+g+') select[name=value_type] option[value="'+value_type+'"]').attr("selected", "selected");
                                    $('#tbl_filters tr:eq('+g+') input[name=value]').val(value);
                                }else if (filter_arr.length === 3) {
                                    $('#tbl_filters tr:eq('+g+') input[name=table_field]').val($.trim(filter_arr[0]));
                                    $('#tbl_filters tr:eq('+g+') select[name=operator] option[value="'+$.trim(filter_arr[1])+'"]').attr("selected", "selected");
                                    
                                    var value = $.trim(filter_arr[2]);
                                    var value_type = 'value';
                                    if (value.indexOf("'") === -1) {
                                        value_type = 'field';
                                    }else {
                                        value = value.replace(/'/g, "");
                                    }
                                    value =  $.trim(value);
                                    $('#tbl_filters tr:eq('+g+') select[name=value_type] option[value="'+value_type+'"]').attr("selected", "selected");
                                    $('#tbl_filters tr:eq('+g+') input[name=value]').val(value); 
                                }
                                
                            }
                            $.updateTableFieldSelections();
                            $.updateQueryOutput();
                            
                            $('#buttons_output').append('<div style="float:right"><button id="btn_cancel_editing" type="button" class="btn btn-primary">Cancel Edit</button></div>')
                            $('#modal_report_list').modal('hide');
                        }else {
                            alert('Invalid id');
                        }
                    }
                    ,error: function(jqXHR, textStatus, errorThrown){
                    }
                });
           });
           
           
           $('#btn_get_saved_values').unbind().bind('click',function(){
               $('#modal_report_list').modal('show');
               $('#loader_modal_report_list').removeAttr('class').html('Please wait, loading list.').addClass('alert').addClass('alert-info').show();
               $.listSaveReport();
           });
           
           
           $('button[name=btn_clear_all]').unbind().bind('click',function(){
                ADHOC_GRID['selected_fields'] = {};
                $("#selected_table_fields_list tr:gt(0)").remove();
                $.updateTableFieldSelections();
                $.updateQueryOutput();
                
                $('input[name=table_field]').val('');
                $('input[name=value]').val('');
           });
           
           $('#btn_cancel_editing').unbind().live('click',function(){
               $.clearAll(); 
           })
        }  // eof fld events
        
        ,listSaveReport : function(){
            $.post('<?=$base_url?>/adhoc/adhoc_grid_list',
                function(data){
                    var data = $.parseJSON(data);  

                    $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
                    $('#data').dataTable({

                        "aoColumns": [
                            { "sTitle": "Report Name" },
                            { "sTitle": "Description" },
                            { "sTitle": "Shared By" },
                            { "sTitle": "Date Created" },
                            { "sTitle": "&nbsp;" },
                        ]
                        ,"bLengthChange": false

                    });

                    $.each(data, function(i,val){
                        var shared_by = "";
                        var link = '<a href="#" id="'+val.id+'" class="row_report">'+val.name+'</a>';
                        var del_link = '<a href="#" id="'+val.id+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';
                        if ( parseInt(val.shared,10) === 1 ){
                            if (parseInt(val.created,10) !== parseInt(USERLOGGED,10) ) {
                                shared_by = val.created_user;
                                 del_link = '';
                            }
                            
                            
                        }

                        
                        $('#data').dataTable().fnAddData([link,val.description,shared_by,val.date_created,del_link]);
                    });


                    $('#loader_modal_report_list').removeAttr('class').html('').hide();



                }); 
        }
        , saveReport : function(){
            $('#loader_modal_form_save').removeAttr('class').html('').hide();
            
            // validate if required fields are not empty
            var report_name = $.trim($('#txt_report_name').val()); 
            var report_description = $.trim($('#txt_report_description').val());
            var shared = $('#chk_share_grid_report').attr('checked') ? 1 : 0;
            
            
            if (report_name.length > 0 && report_description.length > 0 ){
                var tables_fields = [], tables = [], filters = [];
                var table_fields_selected = '';
                var selected_fields = ADHOC_GRID['selected_fields'];
                var table_key = '', table_fields = null, field_obj = null, table_field = null;
                var is_with_field_selection = false;

                // get all the fields selection and from tables
                for (table_key in selected_fields) {
                    table_fields = selected_fields[table_key];
                    for (field_obj in table_fields){
                        table_field = table_key + '.' + field_obj;
                        tables_fields.push(table_field);
                    }
                    tables.push(table_key);
                }


                // get the necessary filters 
                $("#tbl_filters tr").each(function(i, tr) {
                    var logical_operator = $.trim($(this).find('select[name="logical_operator"]').val()),
                        table_field = $.trim($(this).find('input[name="table_field"]').val()),
                        operator= $.trim($(this).find('select[name="operator"]').val()),
                        value_type = $.trim($(this).find('select[name="value_type"]').val()),
                        value = $.trim($(this).find('input[name="value"]').val()),
                        filter_row = "";

                    if (table_field.length > 1) {

                        if (logical_operator.length > 0) {
                            filter_row = ' ' + logical_operator + ' ';
                        }
                        filter_row+= ' ' +  table_field + ' ' + operator ;
                        if (value_type === 'value') {
                            filter_row+= " '" + value + "' ";
                        }else {
                            filter_row+= ' ' + value + ' ';
                        }
                        filters.push(filter_row);
                    }


                });

                var where_sql = '';
                if (filters.length > 0) {
                    where_sql = filters.join(" ");
                }
                
                
                if (tables.length > 0 && tables_fields.length > 0 ) {
                    var parameters = {
                         'name' : report_name
                        ,'description' : report_description
                        , 'shared' : shared
                        , 'fields_sql' : tables_fields.join(',')
                        , 'filters' : where_sql
                    };
                    
                    if (ADHOC_GRID.id === 0) {
                        parameters['type'] = 'add' ;
                    }else {
                        parameters['type'] = 'edit' ;
                        parameters['id'] = ADHOC_GRID.id ;
                    }
                    

                    $('#loader_modal_form_save').addClass('alert').addClass('alert-info').html('Please wait ...').show();
                    $.ajax({
                        type: "POST"
                        ,url:'../adhoc/adhoc_grid_action'
                        ,data: parameters
                        ,dataType:'json'
                        ,async: true
                        ,success: function(returnData){
                            $('#txt_report_name').val(''); 
                            $('#txt_report_description').val('');
                            $('#chk_share_grid_report').attr('checked',false);
                            $('#loader_modal_form_save').removeAttr('class').html('').hide();
                            $.clearAll();
                            $('#modal_form_save').modal('hide');

                        }
                        ,error: function(jqXHR, textStatus, errorThrown){
                            $("#div-loader").html('');
                            $('#loader_modal_form_save').addClass('alert').addClass('alert-info').html("Error on saving custom grid " + jqXHR.responseText ).show();
                        }
                    });
                    
                    
                    
                    
                }else {
                    $('#loader_modal_form_save').addClass('alert').addClass('alert-error').html('Invalid table fields selection').show();
                }
                
                
            }else {
                $('#loader_modal_form_save').addClass('alert').addClass('alert-error').html('Report name and description are required fields').show();
            }
            
        }
        ,clearAll : function(){
            $('#page_title').html('Create Adhoc Grid')
            ADHOC_GRID['selected_fields'] = {};
            ADHOC_GRID['id'] = 0;
            ADHOC_GRID['current_row'] = null;
            $("#selected_table_fields_list tr:gt(0)").remove();
            $('#tbl_filters tr:gt(0)').remove();
            $('input[name=table_field]').val('');
            $("select[name=operator] option:first").attr('selected','selected');
            $("select[name=value_type] option:first").attr('selected','selected');
            $('input[name=value]').val('');
            $("#modal_tbl_table_fields").find("tr:gt(0)").remove();
            $('#table_saved_values_list').html('');
            $('#alert_output').addClass('alert').addClass('alert-error').html('Please select table field first').show();
            $('#buttons_output').html('').hide();
            $('div[name=container_btn_clearall]').hide();

        }
        ,addFieldsToSelectedList : function(table_name, field_list){
            for (var i=0;i<field_list.length;i++){
                var field = field_list[i]
                    ,field_name = field.field
                    ,data_type = field.data_type
                    ,add_row = false;

                if ( typeof ADHOC_GRID['selected_fields'][table_name] === 'undefined' ) {
                    ADHOC_GRID['selected_fields'][table_name] = {};
                    add_row = true;
                } else {
                    if ( typeof ADHOC_GRID['selected_fields'][table_name][field_name] === 'undefined'  ) {
                        add_row = true;
                    }
                }
                if ( add_row ) {
                    ADHOC_GRID['selected_fields'][table_name][field_name] = data_type;
                    //var table_name_descriptive =  table_name.replace(/_/gi, " ");
                    var table_name_descriptive =  ADHOC_GRID.table_fields[table_name].descriptive_name;
                    var row = '<tr id="key_'+ table_name+'_'+ field_name +'" tbl="'+ table_name +'" fldname="'+ field_name +'">'
                        +'<td style="min-width: 140px; text-align: left;">'+ table_name_descriptive.toProperCase() +'</td>'
                        +'<td style="min-width: 130px; text-align: left;">'+ field_name +'</td>'
                        +'<td style="min-width: 60px"><img src="../images/bullet_arrow_up.png" name="row-move-up" style="cursor:pointer;"/>&nbsp;' +
                        '<img src="../images/bullet_arrow_down.png" style="cursor:pointer;"  name="row-move-down" />&nbsp;' +
                        '<img src="../images/bullet_delete.png" style="cursor:pointer;"  name="row-delete" /></td>'
                        +'</tr>';
                    $('#selected_table_fields_list').append(row);
                }
            }

            var total_selected = $("#selected_table_fields_list tr:gt(0)").length;
            if ( total_selected > 0 ) {
                $('#clear_all_selected').show();
            }else {
                $('#clear_all_selected').hide();
            }
            
            
            
            $('#list_table_fields_filter').unbind().live('keyup',function(){
                var filter = $.trim($('#list_table_fields_filter').val());
                if (filter.length <= 0) {
                    $("#modal_tbl_table_fields tr:gt(0)").show();
                }else {
                    $("#modal_tbl_table_fields tr:gt(0)").hide();
                    $('#modal_tbl_table_fields [id*='+filter+']').show('fast');
                }

            });
            
            
            $('#btn_save_form').unbind().live('click',function(){
                
                if (ADHOC_GRID['id'] != 0) {
                    var data = ADHOC_GRID['current_row'];
                    $('#txt_report_name').val(data.name);
                    $('#txt_report_description').val(data.description);
                    var shared = parseInt(data.shared,10);
                    if (shared === 1) {
                        $('#chk_share_grid_report').attr('checked',true);
                    }else {
                        $('#chk_share_grid_report').attr('checked',false);
                    }
                    
                }else {
                    $('#txt_report_name').val(''); 
                    $('#txt_report_description').val('');
                    $('#chk_share_grid_report').attr('checked',false);
                    $('#loader_modal_form_save').removeAttr('class').html('').hide();
                }
                
                $('#modal_form_save').modal('show');
            })
            
        } // eof
        
        ,updateTableFieldSelections : function(fld){
            var table_fields_selected = '';
            var selected_fields = ADHOC_GRID['selected_fields'];
            var table_key = '', table_fields = null, field_obj = null, table_field = null;
            var total_table_fields = 0;
            for (table_key in selected_fields) {
                table_fields = selected_fields[table_key];
                for (field_obj in table_fields){
                    table_field = table_key + '.' + field_obj;
                    table_fields_selected += '<tr id="'+table_field+'"><td>'+ table_key  +'</td><td>'+ field_obj  +'</td></tr>';
                    total_table_fields++;
                }
            }
            
            
            
            $("#modal_tbl_table_fields").find("tr:gt(0)").remove();
            $('#modal_tbl_table_fields').append(table_fields_selected);
            
            
            $('#modal_tbl_table_fields tr').hover(function() {
                $(this).addClass('tblrow_hover');
            }, function() {
                $(this).removeClass('tblrow_hover');
            });
            
            // update the clear all container
            if (total_table_fields > 0) {
                $('div[name=container_btn_clearall]').show();
            }else {
                $('div[name=container_btn_clearall]').hide();
            }
            
        }
        
        ,updateQueryOutput : function(){
            var table_fields_selected = '';
            var selected_fields = ADHOC_GRID['selected_fields'];
            var table_key = '', table_fields = null, field_obj = null, table_field = null;
            var is_with_field_selection = false;
            for (table_key in selected_fields) {
                table_fields = selected_fields[table_key];
                for (field_obj in table_fields){
                    is_with_field_selection = true;
                    break;
                }
                
                if (is_with_field_selection) {
                    break;
                }
            }
            if (is_with_field_selection) {
                $('#alert_output').removeAttr('class').html('').hide();
                var btns = '<button type="button" class="btn btn-primary" id="btn_export_output">Generate Output to CSV</button>';
                    btns += '&nbsp;<button type="button" class="btn btn-primary" id="btn_save_form">Save</button>';
                    
                $('#buttons_output').html(btns).show();
            }else {
                $('#alert_output').addClass('alert').addClass('alert-error').html('Please select table field first').show();
                $('#buttons_output').html('').hide();
            }
        } // eof
        ,csvExportOutput : function(){
            var tables_fields = [], tables = [], filters = [];
            var table_fields_selected = '';
            var selected_fields = ADHOC_GRID['selected_fields'];
            var table_key = '', table_fields = null, field_obj = null, table_field = null;
            var is_with_field_selection = false;
            
            // get all the fields selection and from tables
            for (table_key in selected_fields) {
                table_fields = selected_fields[table_key];
                for (field_obj in table_fields){
                    table_field = table_key + '.' + field_obj;
                    tables_fields.push(table_field);
                }
                tables.push(table_key);
            }
            
            
            // get the necessary filters 
            $("#tbl_filters tr").each(function(i, tr) {
                var logical_operator = $.trim($(this).find('select[name="logical_operator"]').val()),
                    table_field = $.trim($(this).find('input[name="table_field"]').val()),
                    operator= $.trim($(this).find('select[name="operator"]').val()),
                    value_type = $.trim($(this).find('select[name="value_type"]').val()),
                    value = $.trim($(this).find('input[name="value"]').val()),
                    filter_row = "";
                    
                if (table_field.length > 1) {
                    
                    if (logical_operator.length > 0) {
                        filter_row = ' ' + logical_operator + ' ';
                    }
                    filter_row+= ' ' +  table_field + ' ' + operator ;
                    if (value_type === 'value') {
                        filter_row+= " '" + value + "' ";
                    }else {
                        filter_row+= ' ' + value + ' ';
                    }
                    filters.push(filter_row);
                }
               
               
            });
            
            var where_sql = '';
            if (filters.length > 0) {
                where_sql = ' WHERE ' + filters.join(" ");
            }
            
            if (tables.length > 0 && tables_fields.length > 0) {
                var total_records = 0;
                $.ajax({
                    type: "POST"
                    ,url:'../adhoc/adhoc_grid_action'
                    ,data: {'type':'count-list' , 'tables_sql' : tables.join(", "), 'where_sql' : where_sql  }
                    ,dataType:'json'
                    ,async: true
                    ,success: function(data){
                        var total_records = data.value.total_records;
                        if ( total_records > 25000 ) {
                            alert('Please use the Data extraction module to export large data to csv file.\nOtherwise, please add additional filters.')
                        }else {
                            if (tables.length > 0 && tables_fields.length > 0 ) {

                                var parameters = "tables_sql="+tables.join(", ");
                                parameters+= '&fields_sql='+tables_fields.join(", ");
                                parameters+= '&where_sql='+where_sql;
                                parameters+= '&export_type=CSV';
                                parameters+= '&export_all=1';
                                $.downloadV2('../adhoc/file_adhoc_grid_result_query',parameters);
                            }
                        }
                    }
                });
            }else {
                alert('Invalid Table Fields selection.Cannot proceed')
            }
            
            
        }
    });
    
    
    $(document).ready(function() {
        $.populateTableList();
        $.createGridElmEvents();
        
        
    });
</script>
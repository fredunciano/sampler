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
    <form id="frm1" method='post' name='frm1' enctype="multipart/form-data">
    <div class="row-fluid">
        <div class="span2">File</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    <!--a href="#" class="btn fileupload-exists btn-primary" data-dismiss="fileupload" id="submit_file">Upload</a-->
                    <input type="submit" value="Upload" class="btn fileupload-exists btn-primary" />
                </div>
            </div>
        </div>
    </div>
    </form>
    <div class="row-fluid">
        <div class="span2">Plant</div>
        <div class="span10">
            <select id="plant">
                <?php

                foreach($plants as $p){
                    echo '<option value='.$p->plant_name.'>'.$p->plant_name.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10">
            <select id="resource">
                <?php
                foreach ($resources as $r) {
                    echo '<option value='.$r['resource_id'].'>'.$r['resource_id'].'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span3 input-append"><input type="text" id="datepicker" class="input-small" value="<?=date('m/d/Y',strtotime($date_allowed))?>"><button class="btn btn-primary" id="submit_filter">Retrieve</button></div>
    </div>
    <br>
    <legend><h5>Populate Fields</h5></legend>
    <div class="row-fluid">
        <div class="span2">Populate Text Box</div>
        <div class="span3">
            <input type="text" value="1-24" id="interval" class="input-mini">&nbsp;
            <input type="text" value="300" id="txt_mw" class="input-mini"><span class="add-on">&nbsp;MW</span>
        </div>
        <div class="span3">
                <span>Remarks</span>
                <select id="sel_remarks" class="input-medium" style="height:30px">
                    <option value="">Select Outage Type</option>
                    <?php
                    foreach ( $remarks as $id=>$r ) {
                        echo '<option value="'.$id.'">'.$r.'</option>';
                    }
                    ?>
                </select>
        </div>
        <div class="span3">
            <button id="apply" type="button" class="btn btn-primary">Populate</button>
            <!--button id="clear" type="button" class="btn">Clear</button-->
        </div>
    </div>

    <br>
    <div class="row-fluid" id="result"></div>
    <br><br><br>
</div>
<style>
    .editor{
        height:70px;
    }
</style>
<script>
$.extend({
    loadUnitDropDown: function(){
        $.post('../plant/resource_dropdown',{plant:$('#plant').val()},
            function(data){
                html = '';
                $.each(data.value, function(i,val){
                    html+='<option value="'+val.resource_id+'">'+val.resource_id+'</option>';
                })
                $('#resource').html(html);
                return false;
            });
    },
    insertData : function(){
        $('#alert_msg').html('Loading...');
        $.post('../plant/dap_plant_cap_action',$('#frm_data').serialize(),
        function(data){
            $('#alert_msg').html(data);
        });
        return false;
    },
    loadFields : function(data){
        data = $.parseJSON(data);

        var html = '';
        var start = '';
        var end = '';
        html+='<form id="frm_data" method="post">';
        html+='<input type="hidden" name="resource_id" value="'+$('#resource').val()+'">';
        html+='<input type="hidden" name="date" value="'+$('#datepicker').val()+'">';
        //html+='<div style="padding:5px">Delivery Date : '+$('#datepicker').val()+'</div>'
        html+='<p class="text-center text-info">Delivery Date : <b id="date">'+$('#datepicker').val()+'</b></p>';
        html+='<table id="plant_input" class="table table-striped">'
        html+='<tr><th>Interval</th><th>Unit</th><th>Remarks</th><th>Description</th><th>Source</th></tr>';
        for ( x=1;x<=24;x++ ) {
            start = x*100+1-100;
            end = x*100;
            xstart  = $.strPad(start,4);
            xend    = $.strPad(end,4);

            html+='<tr>';
            html+='<td><b>'+x+'&nbsp;('+xstart+'-'+xend+'H)</b></td>';
            html+='<td width="100px"><input type=text class="input-mini" id="txt_unit_'+x+'" name="txt_unit_'+x+'" ><span class="add-on">&nbsp;MW</span></td>';
            html+='<td><select id="remarks_'+x+'" name="remarks_'+x+'" class="input-medium">'+
                '<option value="ok">Available</option>'+
                '<option value="so">Scheduled Outage</option>'+
                '</select></td>';
            html+='<td><textarea class="editor" id="desc_'+x+'" name="desc_'+x+'"></textarea></td>';
            html+='<td style="width:50px"><span id="source_'+x+'"></span></td>';
            html+='</tr>';
        }
        html+='</table>';
        html+='<button id="submit_data" class="btn btn-primary">Submit Plant Availability</button>';
        html+='&nbsp;&nbsp;&nbsp;<span id="alert_msg"></span>';
        html+='</form>';
        $('#result').html(html);
    },
    loadData : function(){

        $.post('../plant/dap_plant_cap_load',{resource_id:$('#resource').val(),date:$('#datepicker').val(),type:'DAP'},
        function(data){
            data = $.parseJSON(data);

            /*var html = '';
            var start = '';
            var end = '';
            html+='<form id="frm_data">';
            html+='<input type="hidden" name="resource_id" value="'+$('#resource').val()+'">';
            html+='<input type="hidden" name="date" value="'+$('#datepicker').val()+'">';
            //html+='<div style="padding:5px">Delivery Date : '+$('#datepicker').val()+'</div>'
            html+='<p class="text-center text-info">Delivery Date : <b id="date">'+$('#datepicker').val()+'</b></p>';
            html+='<table id="plant_input" class="table table-striped">'
            html+='<tr><th>Interval</th><th>Unit</th><th>Remarks</th><th>Description</th><th>Source</th></tr>';
            for ( x=1;x<=24;x++ ) {
                start = x*100+1-100;
                end = x*100;
                xstart  = $.strPad(start,4);
                xend    = $.strPad(end,4);

                html+='<tr>';
                html+='<td><b>'+x+'&nbsp;('+xstart+'-'+xend+'H)</b></td>';
                html+='<td width="100px"><input type=text class="input-mini" id="txt_unit_'+x+'" name="txt_unit_'+x+'" ><span class="add-on">&nbsp;MW</span></td>';
                html+='<td><select id="remarks_'+x+'" name="remarks_'+x+'" class="input-medium">'+
                    '<option value="ok">Available</option>'+
                    '<option value="so">Scheduled Outage</option>'+
                    '</select></td>';
                html+='<td><textarea class="editor" id="desc_'+x+'" name="desc_'+x+'"></textarea></td>';
                html+='<td style="width:50px"><span id="source_'+x+'"></span></td>';
                html+='</tr>';
            }
            html+='</table>';
            html+='<button id="submit_data" class="btn btn-primary">Submit Plant Availability</button>';
            html+='&nbsp;&nbsp;&nbsp;<span id="alert_msg"></span>';
            html+='</form>';
            $('#result').html(html);*/

            for ( x=1;x<=24;x++ ) {

                var mw          = (data[x] !== undefined) ? data[x].mw : '';
                var remarks     = (data[x] !== undefined) ? data[x].remarks : '';
                var description = (data[x] !== undefined) ? data[x].description : '';
                var type        = (data[x] !== undefined) ? data[x].type : '';
                var status      = data.status

                $('#txt_unit_'+x).val(mw);
                $('#remarks_'+x).val(remarks);
                $('#desc_'+x).val(description);
                $('#source_'+x).html(type)

                if (status == 'disabled') {
                    $('#txt_unit_'+x).attr('disabled',status);
                    $('#remarks_'+x).attr('disabled',status);
                    $('#desc_'+x).attr('disabled',status);
                    $('#submit_data').attr('disabled',status);
                    $('#apply').attr('disabled',status);
                } else {
                    $('#txt_unit_'+x).removeAttr('disabled');
                    $('#remarks_'+x).removeAttr('disabled');
                    $('#desc_'+x).removeAttr('disabled');
                    $('#submit_data').removeAttr('disabled');
                    $('#apply').removeAttr('disabled');
                }

            }

        });

    },
    defaultLoad : function(){
        if ($('#plant').val() == 'BAKUN') {
            $('#txt_mw').val(75)
        }

        if ($('#plant').val() == '1590EC') {
            $('#txt_mw').val(200)
        }
    }



});
</script>
<script>

$.loadFields();
$.loadData();
$.defaultLoad();

$('#plant').change(function(){
    $.loadUnitDropDown();
    $.defaultLoad();
})

$('#submit_filter').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadFields();
    $.loadData();
});

$('#apply').unbind('click').bind('click',function(e){
	e.preventDefault();
	interval 	= $('#interval').val();
	mw 			= $('#txt_mw').val();
	rem 		= $('#sel_remarks').val();
	hour = interval.split('-');
	start = parseInt(hour[0]);
	end = parseInt(hour[1]);
	if (!end) end = start;

    for(x=start;x<=end;x++){
        $('#txt_unit_'+x).val(mw);
        $('#remarks_'+x).val(rem);
    }

});

$('#frm1').submit(function(e){
    e.preventDefault();
    var path = '../plant/parse_dap_plant_avail';

    var options = {target:'#result',
        url:path,
        data: {date:$("#datepicker").val()},
        beforeSubmit: function() {
            $('#result').html('Loading...')
        },
        success: function(data) {
            data = $.parseJSON(data);
            $.loadFields();
            var obj = data.value;

            for (x=1;x<=24;x++) {
                $('#txt_unit_'+x).val(obj.unit[x]);
                $('#remarks_'+x).val(obj.remarks[x]);
                $('#desc_'+x).html(obj.description[x]);
            }
            //$('#txt_unit_1').val(100);
            //$('#result').html('')

        }};
    $('#frm1').ajaxSubmit(options);
});

$('#submit_data').die('click').live('click',function(e){
    e.preventDefault();
    $.insertData();
});

</script>

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
        <div class="span5">
            <div class="span4"><input type="text" id="datepicker" class="input-small" value="<?=$date?>"> - </div>
            <div class="input-append"><input type="text" id="end_date" class="input-small" readonly>
            <button class="btn btn-primary" id="submit_filter">Retrieve</button></div>
        </div>
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
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"><button class="btn" id="checkall"><i class="icon-ok"></i>&nbsp;<span id="btn_text">Uncheck All</span></button></div>
        <div class="span10" id="week_date_selection"></div>
    </div>
    <br>
    <div class="row-fluid" id="result"></div>
    <div class="row-fluid" id="week-plant-cap"></div>
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
        $.post('../plant/wap_plant_cap_action',$('#frm_data').serialize(),
        function(data){
            $('#alert_msg').html(data);
        });
        return false;
    },
    loadFields : function(){

        var weekday_sel = '';
        var tmpdate = '';

        start_date = Date.parse( $("#datepicker").val() );
        end_date   = Date.parse( $("#datepicker").val() );
        end_date   = end_date.add(6).days();

        var loop_date = start_date.clone();

        $('#week-plant-cap').html("");
        var x = 0;
        var tab_title = '';
        var tab_content = '';
        tab_title+='<ul class="nav nav-tabs">';
        tab_content+='<form id="frm_data" method="post">';
        tab_content+='<div class="tab-content">';

        tab_content+='<input type="hidden" name="resource_id" value="'+$('#resource').val()+'">';
        tab_content+='<input type="hidden" name="date" value="'+$('#datepicker').val()+'">';

        while (loop_date<=end_date){
            x++;
            if (x==1) {
                 active = 'active';
             } else {
                 active = '';
             }
            loop_date_string = loop_date.toString("d-MMM yyyy");
            tab_title+='<li class="'+active+'"><a href="#c'+x+'" data-toggle="tab">'+loop_date_string+'</a></li>';
            tab_content+='<div class="tab-pane '+active+'" id="c'+x+'">'+
                         '<p class="text-center text-info">Delivery Date : <b>'+loop_date_string+'</b></p>'+
                         '<table class="table table-striped">'+
                         '<tr>'+
                         '<th>Interval</th>'+
                         '<th>Unit</th>'+
                         '<th>Remarks</th>'+
                         '<th>Description</th>'+
                         '<th>Source</th>'+
                         '</tr>'

                for ( x1=1;x1<=24;x1++ ) {
                    start = x1*100+1-100;
                    end = x1*100;
                    xstart  = $.strPad(start,4);
                    xend    = $.strPad(end,4);

                    tab_content+='<tr>';
                    tab_content+='<td>'+x1+'&nbsp;('+xstart+'-'+xend+'H)</td>';
                    tab_content+='<td width="100px"><input type=text class="input-mini" id="txt_unit_'+x+'_'+x1+'" name="txt_unit_'+x+'_'+x1+'"> MW</td>'
                    tab_content+='<td><select id="remarks_'+x+'_'+x1+'" name="remarks_'+x+'_'+x1+'" class="input-medium">'+
                        '<option value="ok">Available</option>'+
                        '<option value="so">Scheduled Outage</option>'+
                        '</select></td>'
                    tab_content+='<td><textarea class="editor" id="desc_'+x+'_'+x1+'" name="desc_'+x+'_'+x1+'"></textarea></td>'
                    tab_content+='<td style="width:50px"><span id="source_'+x+'_'+x1+'"></span></td>';
                    tab_content+='</tr>';
                }
            tab_content+='</table></div>';


            weekday_sel += '<label class="checkbox inline"><input type="checkbox" checked name="chk_wday" class="chk-sidebyside" date="'+ tmpdate  +'" value="wday'+ x +'" /> ' + loop_date_string + '&nbsp;</label>';

            loop_date = loop_date.add(1).days();
        }

        tab_content+='</div>';
        tab_content+='</form>';
        tab_title+= '</ul>';
        tab_content+='<button id="submit_data" class="btn btn-primary">Submit Week Ahead Plant Availability</button>';
        tab_content+='&nbsp;&nbsp;&nbsp;<span id="alert_msg"></span>';

        $('#week_date_selection').html(weekday_sel);
        $('#week-plant-cap').html(tab_title+tab_content);

    },
    loadData : function(){

        $.post('../plant/wap_plant_cap_load',{resource_id:$('#resource').val(),date:$('#datepicker').val(),type:'WAP'},
        function(data){
            data = $.parseJSON(data);

            /*var weekday_sel = '';
            var tmpdate = '';

            start_date = Date.parse( $("#datepicker").val() );
            end_date   = Date.parse( $("#datepicker").val() );
            end_date   = end_date.add(6).days();

            var loop_date = start_date.clone();

            $('#week-plant-cap').html("");
            var x = 0;
            var tab_title = '';
            var tab_content = '';
            tab_title+='<ul class="nav nav-tabs">';
            tab_content+='<form id="frm_data">';
            tab_content+='<div class="tab-content">';

            tab_content+='<input type="hidden" name="resource_id" value="'+$('#resource').val()+'">';
            tab_content+='<input type="hidden" name="date" value="'+$('#datepicker').val()+'">';

            while (loop_date<=end_date){
                x++;
                if (x==1) {
                     active = 'active';
                 } else {
                     active = '';
                 }
                loop_date_string = loop_date.toString("d-MMM yyyy");
                tab_title+='<li class="'+active+'"><a href="#c'+x+'" data-toggle="tab">'+loop_date_string+'</a></li>';
                tab_content+='<div class="tab-pane '+active+'" id="c'+x+'">'+
                             '<p class="text-center text-info">Delivery Date : <b>'+loop_date_string+'</b></p>'+
                             '<table class="table table-striped">'+
                             '<tr>'+
                             '<th>Interval</th>'+
                             '<th>Unit</th>'+
                             '<th>Remarks</th>'+
                             '<th>Description</th>'+
                             '<th>Source</th>'+
                             '</tr>'

                    for ( x1=1;x1<=24;x1++ ) {
                        start = x1*100+1-100;
                        end = x1*100;
                        xstart  = $.strPad(start,4);
                        xend    = $.strPad(end,4);

                        tab_content+='<tr>';
                        tab_content+='<td>'+x1+'&nbsp;('+xstart+'-'+xend+'H)</td>';
                        tab_content+='<td width="100px"><input type=text class="input-mini" id="txt_unit_'+x+'_'+x1+'" name="txt_unit_'+x+'_'+x1+'"> MW</td>'
                        tab_content+='<td><select id="remarks_'+x+'_'+x1+'" name="remarks_'+x+'_'+x1+'" class="input-medium">'+
                            '<option value="ok">Available</option>'+
                            '<option value="so">Scheduled Outage</option>'+
                            '</select></td>'
                        tab_content+='<td><textarea class="editor" id="desc_'+x+'_'+x1+'" name="desc_'+x+'_'+x1+'"></textarea></td>'
                        tab_content+='<td style="width:50px"><span id="source_'+x+'"></span></td>';
                        tab_content+='</tr>';
                    }
                tab_content+='</table></div>';


                weekday_sel += '<label class="checkbox inline"><input type="checkbox" checked name="chk_wday" class="chk-sidebyside" date="'+ tmpdate  +'" value="wday'+ x +'" /> ' + loop_date_string + '&nbsp;</label>';

                loop_date = loop_date.add(1).days();
            }

            tab_content+='</div>';
            tab_content+='</form>';
            tab_title+= '</ul>';
            tab_content+='<button id="submit_data" class="btn btn-primary">Submit Week Ahead Plant Availability</button>';
            tab_content+='&nbsp;&nbsp;&nbsp;<span id="alert_msg"></span>';

            $('#week_date_selection').html(weekday_sel);
            $('#week-plant-cap').html(tab_title+tab_content);*/

            var status = data.status;

            for (x=1;x<=8;x++) {

                rdate = new Date($('#datepicker').val()).add({days: x-1}).toString("yyyyMMdd");

                for ( x1=1;x1<=24;x1++ ) {

                    if (data[rdate] !== undefined) {

                        var mw          = (data[rdate][x1] !== undefined) ? data[rdate][x1].mw : '';
                        var remarks     = (data[rdate][x1] !== undefined) ? data[rdate][x1].remarks : '';
                        var description = (data[rdate][x1] !== undefined) ? data[rdate][x1].description : '';
                        var type        = (data[rdate][x1] !== undefined) ? data[rdate][x1].type : '';
                    }

                    $('#txt_unit_'+x+'_'+x1).val(mw);
                    $('#remarks_'+x+'_'+x1).val(remarks);
                    $('#desc_'+x+'_'+x1).val(description);
                    $('#source_'+x+'_'+x1).html(type)

                    if (status == 'disabled') {
                        $('#txt_unit_'+x+'_'+x1).attr('disabled',status);
                        $('#remarks_'+x+'_'+x1).attr('disabled',status);
                        $('#desc_'+x+'_'+x1).attr('disabled',status);
                        $('#submit_data').attr('disabled',status);
                        $('#apply').attr('disabled',status);
                    } else {
                        $('#txt_unit_'+x+'_'+x1).removeAttr('disabled');
                        $('#remarks_'+x+'_'+x1).removeAttr('disabled');
                        $('#desc_'+x+'_'+x1).removeAttr('disabled');
                        $('#submit_data').removeAttr('disabled');
                        $('#apply').removeAttr('disabled');
                    }

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

//var sdate = new Date().add({days: 2,hours: 15}).toString("M/d/yyyy");
var edate = new Date($('#datepicker').val()).add({days: 7}).toString("M/d/yyyy");
var date = Date.parse($('#datepicker').val()).toString("MM_dd_yyyy");
$.defaultLoad();

$('#datepicker').datepicker({
    daysOfWeekDisabled:[0,2,3,4,5,6]
})

//$('#datepicker').val(sdate);
$('#end_date').val(edate);
$.loadFields();
$.loadData();

$('#plant').change(function(){
    $.loadUnitDropDown();
    $.defaultLoad();
})

$('#datepicker').change(function(){
    var edate = new Date($('#datepicker').val()).add({days: 7}).toString("M/d/yyyy");
    $('#end_date').val(edate);
});

$('#submit_filter').unbind('click').bind('click',function(e){
    e.preventDefault();
    //$.loadFields();
    $.loadData();
});

$('#apply').unbind('click').bind('click',function(e){
	e.preventDefault();

    if ( $('input[name="chk_wday"]:checked').length > 0 ) {


        $('input[name="chk_wday"]:checked').each(function(){
            var chk_value =$(this).attr('value');
            var index = chk_value.replace(/wday/gi, "mw_");
            var identfier_index = chk_value.replace(/wday/gi, "");

            var interval 	= $('#interval').val();
            var mw 			= $('#txt_mw').val();
            var rem 		= $('#sel_remarks').val();
            var hour = interval.split('-');
            var start = parseInt(hour[0]);
            var  end = parseInt(hour[1]);
            if (!end) end = start;

            for(var x1=start;x1<=end;x1++){
                $('#txt_unit_'+identfier_index+'_'+x1).val(mw);
                $('#remarks_'+identfier_index+'_'+x1).val(rem);
            }

        });
    } else {
        alert('Please select at least one week date checkbox.');
    }
    /*
	interval 	= $('#interval').val();
	mw 			= $('#txt_mw').val();
	rem 		= $('#sel_remarks').val();
	hour = interval.split('-');
	start = parseInt(hour[0]);
	end = parseInt(hour[1]);
	if (!end) end = start;

    for (x=1;x<=8;x++) {
        for(x1=start;x1<=end;x1++){
            $('#txt_unit_'+x+'_'+x1).val(mw);
            $('#remarks_'+x+'_'+x1).val(rem);
        }
    } */

});

$('#frm1').submit(function(e){
    e.preventDefault();
    var path = '../plant/parse_wap_plant_avail';

    var options = {target:'#result',
        url:path,
        data: {sdate:$("#datepicker").val(),edate:$('#end_date').val()},
        beforeSubmit: function() {
            $('#result').html('Loading...')
        },
        success: function(data) {
            data = $.parseJSON(data);
            $.loadFields();
            var obj = data.value;

            for(x=1;x<=8;x++) {
                for (x1=1;x1<=24;x1++) {

                    $('#txt_unit_'+x+'_'+x1).val(obj[x].unit[x1]);
                    $('#remarks_'+x+'_'+x1).val(obj[x].remarks[x1]);
                    $('#desc_'+x+'_'+x1).html(obj[x].description[x1]);
                }
            }
            //$('#txt_unit_1').val(100);
            $('#result').html('')

        }};
    $('form').ajaxSubmit(options);

});

$('#submit_data').die('click').live('click',function(e){
    e.preventDefault();
    $.insertData();
});

$('#checkall').toggle(
    function() {
        $('input[type="checkbox"]').attr('checked',false);
        $('#btn_text').text('Check All')
    },
    function() {
        $('input[type="checkbox"]').attr('checked',true);
        $('#btn_text').text('Uncheck All')
    }
);
</script>

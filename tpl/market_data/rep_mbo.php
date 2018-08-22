<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/datatables.css">
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
    <section id="global">
        <form method="post">
        <legend><h4><?=$title?> <small>( Market Data Reports )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Report</div>
            <div class="span7">
               <select id="report_type" name="report_type">
                    <option value="RTD">Real Time Ex-Ante (RTD)</option>
                    <option value="RTX">Real Time Ex-Post (RTX)</option>
                </select>
                <select id="energy_type" name="energy_type" class="input-small">
                    <option value="GEN">GEN</option>
                    <option value="LD">LD</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Region</div>
            <div class="span7">
                <select id="region" name="region" class="input-medium">
                <?php
                foreach ( $regions as $r ) {
                    echo '<option value="'.$r->region.'">'.ucwords(strtolower($r->region)).'</option>';
                }
                ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Resource</div>
            <div class="span7">
                <input type="text" name="resource_id" id="resource_id" class="input-xlarge" 
                       data-mode="multiple" data-provide="typeahead" 
                       data-source="[&quot;Catsd&quot;,&quot;Dogs&quot;,&quot;Mass Hysteria&quot;]" >
                <a href="#modal_resource" role="button" data-toggle="modal" id="show_resources"><i class="icon-th"></i></a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Hour
                <label class="checkbox"><input type="checkbox" id="check_all" checked><span id="label_check_all">Uncheck all</span></label>
            </div>
            <div class="span7">
                <table class="table table-condensed">
                <tr>
                <?php
                    for ($x=1;$x<=24;$x++) {
                        echo '<td><label class="checkbox"><input type="checkbox" class=hour name="hour[]" value="'.$x.'" checked>'.$x.'</label></td>';
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
            <div class="span2">Date</div>
            <div class="span7 input-append input-prepend">
                <input type="text" id="sdate" name="sdate" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span>
                <input type="text" id="edate" name="edate" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Download</a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px">
            
        </div>    
        <!--
		<div style="margin-left:20px; margin-top:10px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn btn-success">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn btn-success">Export to CSV</button>
        </div>-->
        </form>
    </section>
    <br><br><br><br>
</div>
<div class="modal fade in" id="modal_resource" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose Resource ID</h4>
    </div>
    <div class="modal-body">
     <button id="checkallresource" class="btn"><i class="icon-ok"></i><span id="btn_text">Check All</span></button>
        <table id="list-table-res" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
    	<button id="get_rid" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    loadData : function () {
        $("#grid_data").html('');
        $("#result").attr('class','alert alert-info');
        $("#result").html('Checking Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $('#export_btns_container').hide();
        var par = $("form").serialize();
	    $.post('../market_data/rep_mbo_action',par,
            function(data){
                if (data.total > 0) {
                    $("#result").html('Download <a id="export_csv" style="cursor:pointer;">'+data.filename+'</a>');

                    $('#export_csv').bind('click',function(){
                        $.exportData('csv');
                    });
                } else {
                    $("#result").html(data.message);
                }
            });
    }
    ,exportData : function(){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/market_data/file_rep_mbo'
        
        var hour_val = [];
                
        $('.hour').each(function(){
            if ($(this).attr('checked')) {
                hour_val.push($(this).val());
            }
        })

        
        var parameters = "sdate=" + $('#sdate').val();
        parameters+= "&edate=" + $('#edate').val();
        parameters+= "&hour=" + hour_val;
        parameters+= "&report_type=" + $('#report_type').val();
        parameters+= "&energy_type=" + $('#energy_type').val();
        parameters+= "&region=" + $('#region').val();
        parameters+= '&resource_id='+$('#resource_id').val();
        parameters+= '&export_type=CSV';

        $.download(url,parameters);
    }
})
</script>
<script>
$('#sdate, #edate').datepicker();

$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
   
   $('#checkallresource #btn_text').text('Check All');
    $.post('../market_data/rep_show_resource',{report:$('#report_type').val(),region:$('#region').val(),
        type:$('#energy_type').val(),table:'mbo',sdate:$('#sdate').val(),edate:$('#edate').val()},
        function(data){
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id='+val+'><label class="checkbox"><input type="checkbox" id="r_id" name="r_id" value="'+val+'">'+val+'</label></td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                })
                html+='</tr>';
                $('#list-table-res').html(html)
                $('#list-table-res td').css('cursor','pointer');
            } else {
                $('#list-table-res').html('No Data Available');
            }
        });
});

$('#get_rid').click(function(){
	$('#resource_id').val('');
	var arr_res_id = Array();
    $("input[name=r_id]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#resource_id').val( arr_res_id.join( ","));
});

/*
$('#btn_export_csv').unbind('click').bind('click',function(){
    $.exportData('CSV');
});

$('#btn_export_xls').unbind('click').bind('click',function(){
    $.exportData('XLS');
});
*/
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
});


$('#checkallresource').on('click', function () {
    if ($('#checkallresource #btn_text').text() == "Check All") {
        $('#list-table-res input[type="checkbox"]').attr('checked',true);
        $('#checkallresource #btn_text').text('Uncheck All');
    } else {
        $('#list-table-res input[type="checkbox"]').attr('checked',false);
        $('#checkallresource #btn_text').text('Check All');
    }
});

</script>
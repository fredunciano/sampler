<style>
    #grid_data th {
        text-align:center !important;
    }
    #grid_data td {
        text-align: right !important;
    }

</style>
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
    <section id="global">
        <legend><h4><?=$title?> <small>( MMS Data Reports )</small></h4></legend>
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
            <div class="span2">Date</div>
            <div class="span10 input-append input-prepend">
                <input type="text" name="sdate" id="sdate" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span>
                <input type="text" name="edate" id="edate" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <a class="btn btn-success btn-download" href="#" id="download_rtd_schedules"><i class="icon-arrow-down icon-white"></i>Download RTD Schedules</a>
                <select id="cert" class="input-medium" style="margin:5px;">
                <?php
                    foreach($participants as $p){
                        echo '<option value="'.$p->id.'">'.$p->participant.'</option>';
                    }
                ?>
                </select>
                <br><br>
                <span id="download_rtd_status"></span>
            </div>
        </div>
        <hr>
        <input type="hidden" id="hour" value="<?=$current_interval?>">
        <input type="hidden" id="date" value="<?=date('Ymd')?>">
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px;overflow-x:scroll"></div><br \>
        <div id="grid_btn"></div>
    </section>
    <br><br><br><br>
</div>
<div class="modal fade in" id="modal_resource" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Resource ID</h4>
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
    loadData: function(){
        $('#grid').html('');
        $('#result').show('fast')
        $("#result").attr('class','alert alert-info');
        $('#grid_data').hide();
        if($('#sdate').val() > $('#edate').val()){
            $("#result").html('<span style="padding:10px">Start date is greater than end date</span>');
            return false;
        }
        if (!$('#resource_id').val()) {
            $("#result").html('<span style="padding:10px">Please Choose a resource id</span>');
            return false;
        }
        
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../mms_data/rep_rtd_schedules_action',{sdate:$('#sdate').val(),
            edate:$('#edate').val(),resource_id:$('#resource_id').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                    $('#grid_data').show();
                }
            });
            return false;
    },
    createGraph: function(data, title){
        RTD.chart = new Highcharts.Chart({
            chart: {
                    renderTo: 'result',
                    type: 'spline',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    exporting: 'enabled',
                    buttons : 'exporting.buttons',
                    height:250
            },
            title: {
                text: title
            },
            xAxis: [{
                categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                             'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                tickPixelInterval:50,
                gridLineWidth: 1
            }],
            yAxis: [{
                labels: {
                    formatter: function() {
                        return this.value +'mw';
                    },
                    style: {
                        color: '#4572A7'
                    }
                },
                title: {
                    text: 'MW',
                    style: {
                        color: '#4572A7'
                    }
                }
            }],
            tooltip: {
                shared: true

            },
            series: 
                data
        });
        return false;
    },
    createTables: function (data) {
        var series=[];
        var obj = {};
        var content;

        var total_html;
        var total_mw={};
        var mw=[];
        var total_mw_html;
        $.each(data.value, function(i, val) {
            
            var mw_content='';
            content+='<tr class="mw"><td style="text-align:left !important"><b>'+i+'</b></td>';
            
            for (x=1;x<=24;x++) {
                if (typeof val[x] !== 'undefined') {
                    mw_content+= '<td>'+$.formatNumberCommaSeparated(val[x].mw.toFixed(2))+'</td>';

                    if ( total_mw[x] ) {
                        total_mw[x] = val[x].mw + total_mw[x];
                    } else {
                        total_mw[x] = val[x].mw	
                    }
                } else {
                    total_mw[x] = 0
                    mw_content+= '<td>0</td>';
                }
            }

            /*$.each(val, function(index,data){
                    mw_content+= '<td>'+data.mw.toFixed(2)+'</td>';
                    if ( total_mw[index] ) {
                            total_mw[index] = data.mw + total_mw[index];
                    } else {
                            total_mw[index] = data.mw	
                    }

            });*/

            content+=mw_content;
            content+='</tr>';

        })

        var html = '<tr><th>Resource&nbsp;ID</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
        var total = '<tr><th><b>Total</b></th>';

        $.each(total_mw,function(i, val){
            total_mw_html+= '<td><b>'+$.formatNumberCommaSeparated(val.toFixed(2))+'</b></td>';	
        })
        
        total+=total_mw_html;
        
        $('#grid_data').html('<table id="grid" class="table table-bordered table-condensed"></table>');
        
        $("#grid").html(html)
        $("#grid").append(content)
        if (data.total > 1) {
            $("#grid").append(total)
        }
        $('#grid_btn').html('&nbsp;<button id="btn_export_csv" class="btn btn-success">Export CSV</button>&nbsp;<button id="btn_export_xls" class="btn btn-success">Export XLS</button>');
        $('#grid_btn').append('');
    },
    formatData: function (data){
        var mw_data=[];
        var obj = {};
        var resource_id;
        
        $.each(data.value, function(i, val) {
            
            var name = i;
            var data = [];
            
            for (x=1;x<=24;x++) {
                if (val[x] == undefined) {
                    data.push(null)
                } else {
                    data.push(val[x].mw)
                }
            }
            
            resource_id = i;
            mw_data.push({name:i,data:data,id:i})
            
        })
        
        $.createGraph(mw_data, 'Realtime Dispatch Schedules');
        $.createTables(data);
        
        return false;
    },
    loadRTD : function () {
        $('#grid').html('');
        $('#result').show('fast')
        $("#result").attr('class','alert alert-info');
        $('#grid_data').hide();
        
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../mms_data/rep_rtd_schedules_show_data_by_participant',{sdate:$('#sdate').val(),
            edate:$('#edate').val(),cert:$('#cert option:selected').text()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                    $('#grid_data').show();
                }
            });
        return false;
    }
})
</script>
<script>
RTD = {
    chart : null,
    series : []
};    
$('#sdate, #edate').datepicker();    
$.loadData();
$('a.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});
$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
   
    $.post('../mms_data/rep_show_own_resource',{},
        function(data){
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id='+val.resource_id+'><label class="checkbox"><input type="checkbox" id="r_id" name="r_id[]" value="'+val.resource_id+'">'+val.resource_id+'</label></td>';
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

$('#btn_export_csv').die('click').live('click',function(){
    var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_rtd_schedules'
    var parameters = "sdate=" + $('#sdate').val();
    parameters+= "&edate=" + $('#edate').val();
    parameters+= '&resource_id='+$('#resource_id').val();
    parameters+= '&type=CSV';
    $.download(url,parameters);
});

$('#btn_export_xls').die('click').live('click',function(){
    var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_rtd_schedules'
    var parameters = "sdate=" + $('#sdate').val();
    parameters+= "&edate=" + $('#edate').val();
    parameters+= '&resource_id='+$('#resource_id').val();
    parameters+= '&type=XLS';
    $.download(url,parameters);
});
$('#get_rid').click(function(){
	$('#resource_id').val('');
	var arr_res_id = Array();
    $("input[type=checkbox]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#resource_id').val( arr_res_id.join( ","));
});
$('#checkallresource').toggle(
    function() {
        $('#list-table-res input[type="checkbox"]').attr('checked',true);
        $('#checkallresource #btn_text').text('Uncheck All')
    },
    function() {
        $('#list-table-res input[type="checkbox"]').attr('checked',false);
        $('#checkallresource #btn_text').text('Check All')
    }
);
   
$('#download_rtd_schedules').unbind('click').bind('click', function(e){
    e.preventDefault();
    
    if ($(this).attr('disabled')) {
        return false;
    }
    $('.btn').attr('disabled','disabled');
    $('#download_rtd_status').html('Status : Downloading Prices&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
    $.post('../mms_data/man_dl_rtd_schedules_action',{date:$('#date').val(),cert:$('#cert').val(),hour:$('#hour').val()},
        function(data){
            $('#download_rtd_status').html(data)
            $('.btn').removeAttr('disabled');
            $.loadRTD();
        });
})
</script>
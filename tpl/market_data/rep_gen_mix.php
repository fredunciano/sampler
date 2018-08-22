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
        <legend><h4><?=$title?> <small>( Market Data Reports )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Report Type</div>
            <div class="span7">
                <select id="report_type">
                    <option value="RTD">Real Time Ex-Ante (RTD)</option>
                    <option value="RTX">Real Time Ex-Post (RTX)</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Region</div>
            <div class="span7">
                <select id="region" class="input-medium">
                    <option value="SYSTEM">System</option>
                    <?php
                    foreach ( $regions as $r ) {
                        echo '<option value="'.$r->region.'">'.ucwords(strtolower($r->region)).'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Group</div>
            <div class="span7">
                <select id="group" class="input-medium">
                    <option value="fuel">Fuel Type</option>
                    <option value="participant">Participant</option>
                    <option value="owner">Owner</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span7 input-append input-prepend">
                <input type="text" id="sdate" name="date" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span>
                <input type="text" id="edate" name="date" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container"></div>    
		<div style="margin-left:20px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn btn-success">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn btn-success">Export to CSV</button>
        </div>	
    </section>
    <br><br><br><br>
</div>


<script>
$.extend({
    loadData: function(){
        
        $("#grid_data").html('')
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $('#export_btns_container').hide();
        
        $.post('../market_data/rep_gen_mix_action',{sdate:$('#sdate').val(),edate:$('#edate').val(),
            report_type:$('#report_type').val(),region:$('#region').val(),
            group:$('#group').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").html(data.message);
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                    $.createGrid(data);
                    $('#export_btns_container').show();
                }
                
                return false;
            });
    },
    createGrid: function (data){
        var obj_data = {};
        
        $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" id="gen_mix_data">');
        $('#gen_mix_data').dataTable({
            "bFilter" : false,
            "bLengthChange": false,
            "bInfo": false,
            "bPaginate": false,
            "aoColumns": [
                { "sTitle": "Group" },
                { "sTitle": "Percentage (%)" },
                { "sTitle": "Value" }
            ],
        });
        for (i=0;i<data.value.length;i++){
            obj_data = data.value[i]
            if (obj_data.group !== null && obj_data.group) {
                obj_data.percentage = obj_data.percentage !== null ? $.formatNumberToSpecificDecimalPlaces(obj_data.percentage,2) + "%" : obj_data.percentage;
                obj_data.value = obj_data.value !== null ? $.formatNumberToSpecificDecimalPlaces(obj_data.value,2) : obj_data.value;    
                $('#gen_mix_data').dataTable().fnAddData([obj_data.group, obj_data.percentage,obj_data.value]);
            }
        }
        $("#gen_mix_data thead tr th").css("text-align", "center");
        $("#gen_mix_data tbody tr td:nth-child(2)").css("text-align", "right");
        $("#gen_mix_data tbody tr td:nth-child(3)").css("text-align", "right");
    },
    createGraph: function(series_data,title){
        var chart = new Highcharts.Chart({
            chart: {
                    renderTo: 'result',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    exporting: 'enabled',
                    buttons : 'exporting.buttons',
                    height: 500
                    },
                    exporting : {
                        filename: 'gen_mix_'+$('#report_type').val()+'_'+$('#region').val()+'_'+$('#group').val()+'_'+$('#sdate').val()+'_'+$('#edate').val()
                    },
                    title: {
                            text: title,
                            //x: -20 //center
                    },
                    tooltip: {
                            formatter: function() {
                            return '<b>'+ this.point.name +'</b>: <br>'+ 
                                $.formatNumberToSpecificDecimalPlaces(this.point.x,2)+ ' MWh<br>' + 
                                 $.formatNumberToSpecificDecimalPlaces(this.y,2)+' %';
                            }
                    },
                    plotOptions: {
                            pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        formatter: function() {
                                                    return '<b>'+ this.point.name +'</b>: ' + $.formatNumberToSpecificDecimalPlaces(this.point.x,2) + ' MWh (<b>'+ $.formatNumberToSpecificDecimalPlaces(this.y,2) + ' %</b>)';
                                                        
                                            }
                                    },
                                    showInLegend: true
                            }
                    },
                    series: [{
                            type: 'pie',
                            name: title,
                            data: 
                                    series_data
                    }]
        });

        return false;
    },
    formatData: function (data){
        var series=[];
        obj_data = {};
        for (i=1;i<data.value.length;i++){
            obj_data = data.value[i]
            series.push({'name': obj_data.group,'y':obj_data.percentage,'x':obj_data.value})
        }
        
        $.createGraph(series, 'Generation Mix');
        
        return false;
    }
    ,exportData : function(type){
        var url = '../market_data/file_rep_gen_mix'
        
        var parameters = "sdate=" + $('#sdate').val();
        parameters+= "&edate=" + $('#edate').val();
        parameters+= '&report_type='+$('#report_type').val();
        parameters+= '&region='+$('#region').val();
        parameters+= '&group='+$('#group').val();
        parameters+= '&type='+type;
        $.download(url,parameters);
    }
})
</script>
<script>

$('#sdate, #edate').datepicker();

$.loadData();    
$('a.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

$('#btn_export_csv').die('click').live('click',function(){
    $.exportData('CSV');
});

$('#btn_export_xls').die('click').live('click',function(){
    $.exportData('XLS');
});


</script>


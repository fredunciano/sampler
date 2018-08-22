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
            <div class="span2">Date</div>
            <div class="span7 input-append input-prepend">
                <input type="text" id="sdate" name="sdate" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span>
                <input type="text" id="edate" name="edate" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px"></div>    
		<div style="margin-left:20px; margin-top:10px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn">Export to CSV</button>
        </div>
        </form>
    </section>
</div>

<script>
$.extend({
    loadData: function(){
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_hourly_avg_total_dem_price_action',{sdate:$('#sdate').val(),
            edate:$('#edate').val(),report_type:$('#report_type').val(),region:$('#region').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").html(data.message);
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                }
                
                return false;
            });
    },
    createGraph: function(categories,series,mw){
        chart = new Highcharts.Chart({
		chart: {
			renderTo: 'result',
			type: 'column',
                        exporting: 'enabled',
         		buttons : 'exporting.buttons'
		},
		title: {
			text: 'Hourly Average Total System Demand Profile'
		},
		xAxis: {
			categories: categories,
            gridLineWidth: 1
		},
		yAxis: {
            tickInterval: 1000,
			min: 0,
			title: {
				text: 'MWh'
			}
		},
		plotOptions: {
			column: {
				pointPadding: 0.1,
                                groupPadding: 0.1,
				borderWidth: 0
			}
		},
			series: 
                            series
	});

        return false;
    },
    formatData: function (data){
        if ( data.total >= 1 ) {
            var categories = [];
            var sel = [];
            var ytd = [];
            var series = [];
            $.each(data.value,function(i,d){
                
                categories.push(i);
                sel.push(parseFloat(d.selection,2))
                ytd.push(parseFloat(d.ytd,2))
            });
            
            series.push({'name':$('#sdate').val()+' - '+$('#edate').val(),'data':sel});    
            series.push({'name':'Avg YTD','data':ytd});    
                
            
            $.createGraph(categories,series);
        } else {
            $("#result").html('No records to display');
            return false;
        }
    }
})
</script>
<script>
$('#sdate, #edate').datepicker();    
$.loadData();    
$('.btn').unbind('click').bind('click',function(){
    $.loadData();
});
</script>
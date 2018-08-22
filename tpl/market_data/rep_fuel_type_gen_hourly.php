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
                <?php
                foreach ( $regions as $r ) {
                    echo '<option value="'.$r->region.'">'.ucwords(strtolower($r->region)).'</option>';
                }
                ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Fuel Type</div>
            <div class="span7">
                <select id="fuel_type" class="input-medium">
                    <?php
                    foreach ( $fueltype as $ft ) {
                        echo '<option value="'.$ft->type.'">'.ucwords(strtolower($ft->type)).'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span7 input-append input-prepend">
                <input type="text" id="datepicker" name="date" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container"></div>    
		<div style="margin-left:20px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn">Export to CSV</button>
        </div>	
    </section>
</div>

<script>
$.extend({
    loadData: function(){
        
        $("#grid_data").html('')
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_fuel_type_gen_hourly_action',{date:$('#datepicker').val(),
            report_type:$('#report_type').val(),region:$('#region').val(),
            fuel_type:$('#fuel_type').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                }
                
                return false;
            });
    },
    createGraph: function(categories,series){
        chart = new Highcharts.Chart({
		chart: {
			renderTo: 'result',
			type: 'spline',
            exporting: 'enabled',
            buttons : 'exporting.buttons',
            height: 300
		},
		title: {
			text: 'Fuel Type Generation'
		},
		subtitle: {
			text: 'Hourly Actual Production Profile'
		},
		xAxis: {
			categories: categories,
            tickPixelInterval:50,
            gridLineWidth: 1
		},
		yAxis: {
            tickInterval: 100,
			min: 0,
			title: {
				text: 'MWh'
			}
		},
		legend: {
			backgroundColor: '#FFFFFF',
			shadow: true
		},
                tooltip: {
                        shared: true
                },
		plotOptions: {
			column: {
				pointPadding: 0.1,
                                groupPadding: 0,
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
            var series = [];
            $.each(data.value,function(res,d){
                var data1 = [];
                $.each(d,function(h,val){
                    categories.push(h)
                    data1.push(parseFloat(val.mw));
                })
                series.push({'name':res,'data':data1});
            });
            $.createGraph(categories,series);
        } else {
            $("#result").html('No records to display');
            return false;
        }
    }
})
</script>
<script>
$('#datepicker').datepicker();
$.loadData();    
$('.btn').unbind('click').bind('click',function(){
    $.loadData();
});
</script>
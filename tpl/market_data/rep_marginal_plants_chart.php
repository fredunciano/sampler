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
                <input type="text" id="datepicker" name="date" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                
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
    <br><br><br><br>
</div>

<script>
$.extend({
    loadData: function(){
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $("#result").attr('class','alert alert-info');
        $.post('../market_data/rep_mrgl_plants_chart_action',{date:$('#datepicker').val(),
            report_type:$('#report_type').val(),region:$('#region').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $("#result").removeClass('alert alert-info');
                    $.formatData(data);
                }
                
                return false;
            });
    },
    createGraph: function(series,tasks, title){
        var chart = new Highcharts.Chart({
                chart: {
                        renderTo: 'result',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        exporting: 'enabled',
                        buttons : 'exporting.buttons'
                },
                title: {
                        text: title
                },
                legend: {
                        enabled : false
                },
                xAxis: {
                    type: 'datetime',
                    dateTimeLabelFormats: {
                        hour: '%H'
                    },
                    max: Date.UTC(0, 0, 0, 23),
                    min: Date.UTC(0, 0, 0, 0),
                    tickPixelInterval:50,
                    gridLineWidth: 1
                },
                yAxis: {
                tickInterval: 1,
                labels: {
                    formatter: function() {
                        var cnt = tasks[0].c
                        var val = this.value
                        if ( val >= 0 && val <= cnt) {
                                var i = Number(this.value);
                                return tasks[i].name;
                        }
                    }
                },
                startOnTick: false,
                endOnTick: false,
                title: {
                    text: 'Resource ID'
                },
                    minPadding: 0.2,
                        maxPadding: 0.2
                },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ tasks[this.y].name + '</b><br/>' +
                            Highcharts.dateFormat('%H:%M', this.point.options.from)  +
                            ' - ' + Highcharts.dateFormat('%H:%M', this.point.options.to) +
                            '<br> ' + this.point.options.price; 
                    }
                },
                plotOptions: {
                    line: {
                        lineWidth: 9,
                        marker: {
                            enabled: false
                        },
                        dataLabels: {
                            enabled: true,
                            align: 'left',
                            formatter: function() {
                                return this.point.options && this.point.options.label;
                            }
                        }
                    }
                },
                series: series
        });
        return false;
    },
    formatData: function (data){
        // Define tasks
        var tasks = [];
        var cnt = data.total - 1;
        $.each( data.value, function(i, val){
            var intervals = [];
            $.each ( val , function (i1, hour){
                    intervals.push({'from': Date.UTC(0, 0, 0, Number(i1) - 1),
                    'to': Date.UTC(0, 0, 0, i1),'price':parseFloat(hour.mcp)})
            })

            if (i) {
                tasks.push({'name':i,'intervals':intervals,'c':cnt})	
            }

            //return false;
        })

        // re-structure the tasks into line seriesvar series = [];
        var series = [];
        $.each(tasks.reverse(), function(i, task) {
            var item = {
                name: task.name,
                data: []
            };
            $.each(task.intervals, function(j, interval) {
                item.data.push({
                    x: interval.from,
                    y: i,
                    label: interval.label,
                    from: interval.from,
                    to: interval.to,
                    price : interval.price
                }, {
                    x: interval.to,
                    y: i,
                    from: interval.from,
                    to: interval.to,
                    price : interval.price
                });

                // add a null value between intervals
                if (task.intervals[j + 1]) {
                    item.data.push(
                        [(interval.to + task.intervals[j + 1].from) / 2, null]
                    );
                }

            });

        series.push(item);
        });
        
        $.createGraph(series,tasks, 'Marginal Plants');

        return false;
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
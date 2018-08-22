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
                <select id="region" name="region">
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
            <div class="span7 input-append">
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
</div>

<script>
$.extend({
    loadData: function(){
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_hourly_actual_prod_profile_action',{date:$('#datepicker').val(),
            report_type:$('#report_type').val(),region:$('#region').val()},
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
    createGraph: function(series,tasks, title){
        var chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'result',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    exporting: 'enabled',
                    buttons : 'exporting.buttons',
                    height:1000
                },
                title: {
                        text: 'Hourly Actual Production Profile by Plant'
                },
                legend: {
                        enabled : false
                },
                xAxis: {
                    type: 'datetime',
                    max: Date.UTC(0, 0, 0, 24),
                    min: Date.UTC(0, 0, 0, 0),
                    gridLineWidth: 1,
                    tickPixelInterval:50
                },
                yAxis: {
                    tickInterval: 1,
                    offset: 5,
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
                    }
                    
                },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ tasks[this.y].name + '</b><br/>' +
                            Highcharts.dateFormat('%H:%M', this.point.options.from)  +
                            ' - ' + Highcharts.dateFormat('%H:%M', this.point.options.to) +
                            '<br><b>Price:</b> ' + this.point.options.label + 
                            '<br><b>MW:</b> ' + this.point.options.mw; 
                    }
                },
                plotOptions: {
                    line: {
                        lineWidth: 9,
                        marker: {
                            enabled: false
                        },
                        dataLabels: {
                            enabled: false
                        }
                    }
                },
                series: series
        });

        return false;
    },
    formatData: function (data){
        if ( data.total >= 1 ) {
            var tasks = [];
            var cnt = Number(data.total) - 1;
            $.each( data.value, function(i, val){
                var intervals = [];
                $.each ( val , function (i1, hour){
                    if (hour.mw > 0) {
                        intervals.push({'from': Date.UTC(0, 0, 0, Number(i1) - 1),
                            'to': Date.UTC(0, 0, 0, i1),'label':parseFloat(hour.price)
                            ,'mw':parseFloat(hour.mw)})
                    }
                })
                if (i) {
                    tasks.push({'name':i,'intervals':intervals,'c':cnt})	
                }
            })
            
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
                        mw: interval.mw,
                        from: interval.from,
                        to: interval.to
                    }, {
                        x: interval.to,
                        y: i,
                        label: interval.label,
                        mw: interval.mw,
                        from: interval.from,
                        to: interval.to
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

            $.createGraph(series,tasks);
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
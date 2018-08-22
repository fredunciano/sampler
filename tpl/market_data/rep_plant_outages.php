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
            <div class="span2">Equipment</div>
            <div class="span7">
                <select id="equipment" class="input-small">
                    <option value="">All</option>
                    <option>LN</option>
                    <option>UN</option>
                    <option>X2</option>
                    <option>L1</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Year</div>
            <div class="span7">
                <select id="year" class="input-small">
                <?php
                    for($x=date('Y');$x>=(date('Y')-2);$x--){
                        echo '<option>'.$x.'</option>';
                    }
                ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script src="../js/highcharts.js"></script>
<script src="../js/modules/exporting.js"></script>
<script>
var year
$.extend({
    loadData: function(){
        year = $('#year').val()
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_plant_outages_action',{year:year,
            equipment:$('#equipment').val()},
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
    createGraph: function(series,tasks, title,height){
        var chart = new Highcharts.Chart({
                chart: {
                        renderTo: 'result',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        exporting: 'enabled',
                        buttons : 'exporting.buttons',
                        height:height
                },
                exporting : {
                    filename: $('#equipment').val()+'_'+$('#year').val(),
                },
                title: {
                        text: title
                },
                legend: {
                        enabled : false
                },
                xAxis: {
                    type: 'datetime',
                    max: Date.UTC(year, 11, 31),
                    min: Date.UTC(year, 0, 1),
                    tickPixelInterval:70,
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
                    minPadding: 0,
                    maxPadding: 0
                },
                tooltip: {
                    formatter: function() {
                        return '<b>'+ tasks[this.y].name + '</b><br/>' +
                            Highcharts.dateFormat('%b %e, %Y (%H:%M)', this.point.options.from)  +
                            ' - ' + Highcharts.dateFormat('%b %e, %Y (%H:%M)', this.point.options.to) +
                            '<br> ' + this.point.options.remarks; 
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
        //alert(data)
        //return false;
        // Define tasks
        var tasks = [];
        var height = 100;
        var cnt = data.total - 1;
        $.each( data.value, function(i, val){
            var intervals = [];
            intervals.push({'from': Date.UTC(val.start_y, val.start_m, val.start_d,val.start_h,val.start_i),
                'to': Date.UTC(val.end_y, val.end_m, val.end_d,val.end_h,val.end_i),remarks:val.remarks})
            //$.each ( val , function (i1, hour){
            //        intervals.push({'from': Date.UTC(0, 0, 0, Number(i1) - 1),
            //        'to': Date.UTC(0, 0, 0, i1),'price':parseFloat(hour.mcp)})
            //})

            if (i) {
                tasks.push({'name':i,'intervals':intervals,'c':cnt})
                height+=15;
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
                    //label: interval.label,
                    from: interval.from,
                    to: interval.to,
                    remarks : interval.remarks
                }, {
                    x: interval.to,
                    y: i,
                    from: interval.from,
                    to: interval.to,
                    remarks : interval.remarks
                });

                // add a null value between intervals
                /*if (task.intervals[j + 1]) {
                    item.data.push(
                        [(interval.to + task.intervals[j + 1].from) / 2, null]
                    );
                }*/

            });
        
        series.push(item);
        });
        
        $.createGraph(series,tasks, 'Plant Outages',height);

        return false;
}
})
</script>
<script>
$.loadData();
$('a.btn').unbind('click').bind('click',function(){
    $.loadData();
});
</script>
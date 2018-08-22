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
            <div class="span2">Date</div>
            <div class="span7 input-append">
                <input type="text" id="datepicker" name="date" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" id="show_data" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
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
		<div style="margin-left:20px; margin-top:10px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn">Export to CSV</button>
        </div>
        </form>
    </section>
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
    loadData: function(){
        $("#grid_data").html('')
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_dispatch_gen_action',{date:$('#datepicker').val(),
            report:$('#report_type').val(),region:$('#region').val(),type:$('#energy_type').val(),
            resource_id:$('#resource_id').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">' + data.message + '</span>');
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                }
            });
            return false;
    },
    createGraph: function(categories,series,price){
        chart = new Highcharts.Chart({
		chart: {
			renderTo: 'result',
			type: 'spline',
            exporting: 'enabled',
            buttons : 'exporting.buttons',
            height:300
		},
		title: {
			text: 'Dispatch Generation'
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
            tickInterval: 20,
			min: 0,
			title: {
				text: 'MWh'
			}
		},
		legend: {
			//layout: 'vertical',
			backgroundColor: '#FFFFFF',
			//align: 'right',
			verticalAlign: 'bottom'
			//x: 0,
			//y: 20,
			//floating: true,
			//shadow: true
		},
                tooltip: {
                        //shared: true
                        formatter: function(){
                            return ''+this.x+'<br>'
                                    +'MW: '+this.y+'<br>'
                                    +'Price: '+price[this.x]+'<br>'
                                    +'Resource: '+this.series.name;
                        }
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
        var categories = [];
        var series = [];
        var price = [0];
        $.each(data.value,function(res,d){
            var data1 = [];
            $.each(d,function(h,val){
                categories.push(h)
                data1.push(parseFloat(val.mw));
                price.push(val.price)
            })
            series.push({'name':res,'data':data1,'marker':{'symbol':'circle'}});
        });
        $.createGraph(categories,series,price);
    }
})
</script>
<script>
$('#datepicker').datepicker();
$('#show_data').unbind('click').bind('click',function(){
    $.loadData();
});

$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
   
    $('#checkallresource #btn_text').text('Check All');
    $.post('../market_data/rep_show_resource',{report:$('#report_type').val(),region:$('#region').val(),
        type:$('#energy_type').val(),table:'mps',sdate:$('#datepicker').val()},
        function(data){
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id='+val+'><label class="checkbox"><input type="checkbox" id="r_id" name="r_id[]" value="'+val+'">'+val+'</label></td>';
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
    $("input[type=checkbox]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#resource_id').val( arr_res_id.join( ","));
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
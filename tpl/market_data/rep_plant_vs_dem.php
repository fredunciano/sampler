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
            <div class="span2">Type</div>
            <div class="span7">
               <select id="energy_type" class="input-small">
                    <option>GEN</option>
                    <option>LD</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">LWAP source</div>
            <div class="span7">
                <select id="source" class="input-medium">
                    <option>corrected</option>
                    <option>uncorrected</option>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Resource ID 1</div>
            <div class="span7">
                <input type="text" name="resource_id1" id="resource_id1" class="input-medium" 
                       data-mode="multiple" data-provide="typeahead" 
                       data-source="[&quot;Catsd&quot;,&quot;Dogs&quot;,&quot;Mass Hysteria&quot;]" >
                <a href="#modal_resource1" role="button" data-toggle="modal" id="show_resources1"><i class="icon-th"></i></a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Resource ID 2</div>
            <div class="span7">
                <input type="text" name="resource_id2" id="resource_id2" class="input-medium" 
                       data-mode="multiple" data-provide="typeahead" 
                       data-source="[&quot;Catsd&quot;,&quot;Dogs&quot;,&quot;Mass Hysteria&quot;]" >
                <a href="#modal_resource2" role="button" data-toggle="modal" id="show_resources2"><i class="icon-th"></i></a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span7 input-append">
                <input type="text" id="datepicker" name="date" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
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

<div class="modal fade in" id="modal_resource1" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Resource ID</h4>
    </div>
    <div class="modal-body">
        <table id="list-table-res1" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<div class="modal fade in" id="modal_resource2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Resource ID</h4>
    </div>
    <div class="modal-body">
        <table id="list-table-res2" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
var lwap;
var sys_dem;
var prices;
$.extend({
    loadData: function(){
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_plant_vs_dem_action',{date:$('#datepicker').val(),
            report:$('#report_type').val(),region:$('#region').val(),source:$('#source').val(),
            resource_id1:$('#resource_id1').val(),resource_id2:$('#resource_id2').val(),
            type:$('#energy_type').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $("#result").removeClass('alert');
                    lwap    = data
                    sys_dem = data
                    prices  = data 
                    
                    $.formatData();
                }
            });
            return false;
    },
    createGraph: function(categories,series){
        chart = new Highcharts.Chart({
		chart: {
			renderTo: 'result',
			type: 'spline',
            exporting: 'enabled',
            buttons : 'exporting.buttons',
            height:300
		},
		title: {
			text: 'Plants vs System Demand'
		},
		xAxis: {
			categories: categories,
            gridLineWidth: 1
		},
		yAxis: [
        {
            min: 0,
            title: {
                text: 'Demand'
            },
            opposite: true
		},{
            title: {
                text: 'Prices'
            }
        }],
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
                        shared: true
                        /*formatter: function(){
                            return ''+this.x+'<br>'
                                    +'MW: '+this.y+'<br>'
                                    +'Price: '+price[this.x];
                        }*/
                },
		plotOptions: {
			/*column: {
				pointPadding: 0.1,
                                groupPadding: 0,
				borderWidth: 0
			}*/
		},
			series: 
                            series
	});

        return false;
    },
    formatData: function (){
        var categories = [];
            var series = [];
            var price = [0];
            var demand = [];
            var lwaprice = [];
            $.each(prices.price,function(res,d){
                var price = [];
                $.each(d,function(h,val){
                    categories.push(h)
                    price.push(parseFloat(val,2));
                })
                series.push({'name':res + ' Price','data':price,yAxis:1,marker:{symbol:'circle'}});
            });
            $.each(sys_dem.report,function(h,val){
                demand.push(parseFloat(val,2));
            });
            series.push({'name':'System Demand','data':demand});
            $.each(lwap.lwap,function(h,val){
                lwaprice.push(parseFloat(val,2));
            });
            series.push({'name':'LWAP','data':lwaprice,dashStyle:'shortdot',yAxis:1});
            
            $.createGraph(categories,series);
    }
    
})
</script>
<script>
$('#datepicker').datepicker();    
$(".btn").unbind('click').bind('click',function(){
    $.loadData();
});

$("#show_resources1").unbind('click').bind('click',function(e){
    e.preventDefault();
   
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
                    html+='<td id='+val+'>'+val+'</td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                    var str_res_id='';
                    $('#'+val).die('click').live('click',function(e){
                        e.preventDefault();
                        $('#modal_resource1').modal('hide')
                        $('#resource_id1').val($(this).attr('id'))
                    })
                })
                html+='</tr>';
                $('#list-table-res1').html(html)
                $('#list-table-res1 td').css('cursor','pointer');
            } else {
                $('#list-table-res1').html('No Data Available');
            }
        });
});
$("#show_resources2").unbind('click').bind('click',function(e){
    e.preventDefault();
   
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
                    html+='<td id='+val+'>'+val+'</td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                    var str_res_id='';
                    $('#'+val).die('click').live('click',function(e){
                        e.preventDefault();
                        $('#modal_resource2').modal('hide')
                        $('#resource_id2').val($(this).attr('id'))
                    })
                })
                html+='</tr>';
                $('#list-table-res2').html(html)
                $('#list-table-res2 td').css('cursor','pointer');
            } else {
                $('#list-table-res2').html('No Data Available');
            }
            
        });
});

</script>
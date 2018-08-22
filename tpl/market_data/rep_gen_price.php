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
                <input type="text" name="resource_id" id="resource_id" class="input-medium" 
                       data-mode="multiple" data-provide="typeahead" 
                       data-source="[&quot;Catsd&quot;,&quot;Dogs&quot;,&quot;Mass Hysteria&quot;]" >
                <a href="#modal_resource" role="button" data-toggle="modal" id="show_resources"><i class="icon-th"></i></a>
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

<div class="modal fade in" id="modal_resource" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Resource ID</h4>
    </div>
    <div class="modal-body">
        <table id="list-table-res" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    loadData: function(){
        $('#resource_id').removeClass();
        if (!$('#resource_id').val()) {
            $("#result").html('<span style="padding:10px">Please Choose a resource id</span>').addClass('alert alert-info');
            return false;
        }
        $("#result").attr('class','alert alert-info');
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../market_data/rep_gen_price_action',{date:$('#datepicker').val(),
            report:$('#report_type').val(),region:$('#region').val(),
            resource_id:$('#resource_id').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    $("#result").removeClass('alert');
                    $.formatData(data);
                }
            });
            return false;
    },
    createGraph : function (categories,series,price,dispatch,pmin,pmax,variance) {
        chart = new Highcharts.Chart({
		chart: {
			renderTo: 'result',
			type: 'spline',
            exporting: 'enabled',
            buttons : 'exporting.buttons'
		},
		title: {
			text: 'Generation Report by Price'
		},
		xAxis: {
            min: 1,
			categories: categories
		},
		yAxis: {
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
                        shared: true,
                        formatter: function(){
                            return ''+this.x+'<br>'
                                    +'Price: '+price[this.x]+'<br>'
                                    +'Dispatch: '+dispatch[this.x]+'<br>'
                                    +'Pmin: '+pmin[this.x]+'<br>'
                                    +'Pmax: '+pmax[this.x]+'<br>'
                                    +'Variance: '+variance[this.x]+'<br>'
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
    },
    formatData: function (data){
        var categories = [0];
        var series = [];
        var price = [0];
        var res = '';
        var dispatch = [null];
        var pmin = [null];
        var pmax = [null];
        var variance = [null];
        var p1 = [null];
        var p2 = [null];
        var p3 = [null];
        var p4 = [null];
        var p5 = [null];

        $.each(data.value,function(h,val){
            categories.push(h)
            val.pmin = val.pmin == null ? 0 : val.pmin ;
            val.pmax = val.pmax == null ? 0 : val.pmax ;
            dispatch.push(parseFloat(val.mw));
            pmin.push(parseFloat(val.pmin));
            pmax.push(parseFloat(val.pmax));
            price.push(parseFloat(val.price));
            variance.push(val.pmax - val.mw);
            if (val.price < 2000) {
                p1.push(parseFloat(val.pmax))
            }else{
                p1.push(null)
            }
            if (val.price < 2500 && val.price > 2000) {
                p2.push(parseFloat(val.pmax))
            }else{
                p2.push(null)
            }
            if (val.price < 3000 && val.price > 2500) {
                p3.push(parseFloat(val.pmax))
            }else{
                p3.push(null)
            }
            if (val.price < 3500 && val.price > 3000) {
                p4.push(parseFloat(val.pmax))
            }else{
                p4.push(null)
            }
            if (val.price > 3500) {
                p5.push(parseFloat(val.pmax))
            }else{
                p5.push(null)
            }
            res = val.resource;
        })

        series.push({'name':'< P2000','data':p1,'type': 'area','lineWidth':0,'connectNulls':true,'marker':{enabled:false},'tooltip':{enabled:false}});
        series.push({'name':'< P2500','data':p2,'type': 'area','lineWidth':0,'connectNulls':true,'marker':{enabled:false},'tooltip':{enabled:false}});
        series.push({'name':'< P3000','data':p3,'type': 'area','lineWidth':0,'connectNulls':true,'marker':{enabled:false},'tooltip':{enabled:false}});
        series.push({'name':'< P3500','data':p4,'type': 'area','lineWidth':0,'connectNulls':true,'marker':{enabled:false},'tooltip':{enabled:false}});
        series.push({'name':'> P3500','data':p5,'type': 'area','lineWidth':0,'connectNulls':true,'marker':{enabled:false},'tooltip':{enabled:false}});
        series.push({'name':res+'_dispatch','data':dispatch,'marker':{symbol:'circle'}});
        series.push({'name':res+'_pmin','data':pmin,'marker':{symbol:'circle'}});
        series.push({'name':res+'_pmax','data':pmax,'marker':{symbol:'circle'}});

        $.createGraph(categories,series,price,dispatch,pmin,pmax,variance);
    }
})
</script>
<script>
$('#datepicker').datepicker();
$.loadData();    
$('.btn').unbind('click').bind('click',function(){
    $.loadData();
});

$("#show_resources").unbind('click').bind('click',function(e){
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
                        $('#modal_resource').modal('hide')
                        $('#resource_id').val($(this).attr('id'))
                    })
                })
                html+='</tr>';
                $('#list-table-res').html(html)
                $('#list-table-res td').css('cursor','pointer');
            } else {
                $('#list-table-res').html('No Data Available');
            }
        });
});
</script>
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
            <div class="span2">Region</div>
            <div class="span7">
                <select id="region" class="input-medium">
                    <?php
                    foreach ($region as $r) {
                        echo '<option>'.$r->region.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Type</div>
            <div class="span7">
                <select id="type" class="input-small">
                    <option value="GEN">GEN</option>
                    <option value="LD">LOAD</option>
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
            <div class="span7">
                <input type="text" name="sdate" id="sdate" value="<?=$sdate?>" class="input-medium">
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2">Price Cap</div>
            <div class="span10 input-append input-prepend">
                <input type="text" name="price_cap" id="price_cap" class="numeric input-medium" />
                <button type="button" class="btn btn-primary" id="show_data"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</button>
                <!--
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>--->
            </div>
        </div>
        
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px"></div>
         <div id="export_buttons"></div>
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
<style>
    #grid th {
        text-align: center;
        background-color: #F7F7F7;
        min-width: 70px;
    }
    
    #grid td:first-child {
        text-align: center;
    }
    #grid td, #grid .total th {
        text-align: right;
    }
</style>
<script>
$.extend({
    loadData: function(){
        $('#grid').html('');
        $('#result').show('fast')
        $("#result").attr('class','alert alert-info');
        $('#grid_data').hide();
        $('#export_buttons').html('');
        
        if (!$('#resource_id').val()) {
            $("#result").html('<span style="padding:10px">Please Choose a resource id</span>');
            return false;
        }
        
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../mms_data/rep_rtd_lmp_action',{sdate:$('#sdate').val(),
            edate:$('#sdate').val(),resource_id:$('#resource_id').val()},
            function(data){
                //console.log(data)
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
    createGraph: function(data, rtd, rtx,title){
        var data1 = data.concat(rtd);
        var series_data = data1.concat(rtx);
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
            yAxis:  [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return $.formatNumberToSpecificDecimalPlaces(this.value) +'MW';
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
    
            }, { // Secondary yAxis
                gridLineWidth: 0,
                title: {
                    text: 'Price',
                    style: {
                        color: '#4572A7'
                    }
                },
                labels: {
                    formatter: function() {
                        return $.formatNumberToSpecificDecimalPlaces(this.value) +' ';
                    },
                    style: {
                        color: '#4572A7'
                    }
                }
                ,opposite: true
    
            }]
            
            ,tooltip: {
                shared: true
                ,formatter: function() {
                    var s = '<b>'+ this.x +'</b>';
                    var color = '';
                    var y_val = '';
                    var y_suffix = '';
                    $.each(this.points, function(i, point) {
                        color = point.series.color;
                        y_val = point.y;
                        y_suffix = point.point.config.type === 'MW' ? ' MW ' : '';
                        if (typeof point.point.config.real_data != 'undefined' ) {
                            y_val = point.point.config.real_data;
                        }
                        y_val = $.formatNumberToSpecificDecimalPlaces(y_val);
                        s += '<br/><span style="color:'+color+'">'+ point.series.name +': '+
                            y_val +y_suffix + '</span>';
                    });

                    return s;
                }
            },
            series: series_data
        });
        return false;
    },
    createTables: function (rtd,lmp, data_total,date_indexes,max_hr) {
        var series=[];
        var obj = {};
        var content='';

        var total_html;
        var total_mw={};
        var total_rtd ={};
        var total_rtx ={};
        var mw=[];
        var total_mw_html;
        var resources_list = $('#resource_id').val().split(',');
        
        var resource_id = "";
        var rtd_val = '', rtx_val = '', mw_val = '';
        var rtd_obj = null, lmp_obj = null;
        for (var r=0;r<resources_list.length;r++){
            resource_id = resources_list[r];
            
            content+='<tr><td>'+resource_id+'</td>';
            
            for (var x=1;x<=24;x++) {
                rtd_val = '';
                rtx_val = '';
                mw_val = '&nbsp;';
                var rtd = 0;
                var rtx = 0;
                
                if ( typeof rtd[resource_id] !== 'undefined'  ) {
                    rtd_obj = rtd[resource_id];
                    if (typeof rtd_obj[x] !== 'undefined') {
                        mw_val= $.formatNumberToSpecificDecimalPlaces(rtd_obj[x].mw);
                        
                        if ( total_mw[x] ) {
                            total_mw[x] = rtd_obj[x].mw + total_mw[x];
                        } else {
                            total_mw[x] = rtd_obj[x].mw	
                        }
                    } else {
                         total_mw[x] = 0;
                    }
                }else {
                     total_mw[x] = 0;
                }    
                content+= '<td>'+ mw_val +'</td>';
                
                
                // #### LMP
                if ( typeof lmp[resource_id] !== 'undefined'  ) {
                    lmp_obj = lmp[resource_id];
                    if (typeof lmp_obj[x] !== 'undefined') {
                        rtd_val= $.formatNumberToSpecificDecimalPlaces(lmp_obj[x].rtd_price);
                        rtx_val= $.formatNumberToSpecificDecimalPlaces(lmp_obj[x].rtx_price);
                        
                        rtd = parseFloat(lmp_obj[x].rtd_price);
                        rtx = parseFloat(lmp_obj[x].rtx_price);
                    }
                }   
                
                if ( typeof total_rtd[x] != 'undefined' ) {
                    total_rtd[x] = total_rtd[x] + rtd;
                } else {
                    total_rtd[x] = rtd	
                }


                if ( typeof total_rtx[x] != 'undefined' ) {
                    total_rtx[x] = total_rtx[x] + rtx;
                } else {
                    total_rtx[x] = rtx;	
                }
                content+= '<td>'+ rtd_val +'</td>';
                content+= '<td>'+ rtx_val +'</td>';
            }
            
            content+='</tr>';
        }
        
       
        var html = '<tr><th rowspan=2 style="vertical-align:middle;">Resource&nbsp;ID</th>';
        for(var hr=1;hr<=24;hr++){
            html+= '<th colspan=3 >H'+hr+'</th>';
        }
        html+= '</tr>';
        
        // sub
        html += '<tr>';
        for(var hr=1;hr<=24;hr++){
            html+= '<th>MW</th><th >RTD</th><th>RTX</th>';
        }
        html+= '</tr>';
        
        var total = '<tr class="total"><th><b>Total</b></th>';
        
        /*
        $.each(total_mw,function(i, val){
            total_mw_html+= '<th>'+val.toFixed(2)+'</th>'+ '<th></th><th></th>';	
        })*/
        for(var hr=1;hr<=24;hr++){
            var mw = total_mw[hr];
            var rtd = total_rtd[hr];
            var rtx = total_rtx[hr];
            
            total_mw_html+= '<th>'+$.formatNumberToSpecificDecimalPlaces(mw,2)+'</th>';
            total_mw_html+= '<th>'+$.formatNumberToSpecificDecimalPlaces(rtd,2)+'</th>';
            total_mw_html+= '<th>'+$.formatNumberToSpecificDecimalPlaces(rtx,2)+'</th>';
        }
        
        
        total+=total_mw_html;
        
        $('#grid_data').html('<table id="grid" class="table table-bordered table-condensed"></table>');
        
        $("#grid").html(html)
        $("#grid").append(content)
        if (data_total > 1) {
            $("#grid").append(total)
        }
        $('#export_buttons').append('&nbsp;<button id="btn_export_csv" class="btn btn-success">Export CSV</button>');
        $('#export_buttons').append('&nbsp;<button id="btn_export_xls" class="btn btn-success">Export XLS</button>');
        
        $('#grid_data').css('width',$('#global').width()).css('overflow','auto');
    },
    formatData: function (data){
        var price_cap_tmp = $.trim($('#price_cap').val());
        var is_with_price_cap = price_cap_tmp.length > 0 ? true : false;
        var price_cap = parseInt(price_cap_tmp,10);
        
        var mw_data=[];
        var obj = {};
        var resource_id;
        var rtd_value = data.value.rtd;
        var lmp_value = data.value.lmp;
        var rtd_data=[];
        var rtx_data=[];
        var resource_id_cnt = 0;
        var lmp_rtd_chart_data = {};
        var lmp_rtx_chart_data = {};
        var tmp_rtd = "", new_rtd = "";
        var tmp_rtx = "" , new_rtx = "";
        var max_hr = 0; 
        var date_indexes = [];
        $.each(rtd_value, function(i, val) {
            var name = i;
            var data = [];
            $.each(val, function(index,d){
                data.push({y:d.mw , 'type' : 'MW' });
            });
            resource_id = i;
            mw_data.push({name:i + ' (MW)',data:data,id:'mw_'+i});
        });
        
        
        $.each(lmp_value, function(res_id, val1) {
            var name = res_id;
            $.each(val1, function(hr,hr_data){
                rtd_data.push(['RTD',val1[hr].rtd_price]);
                rtx_data.push(['RTX',val1[hr].rtx_price]);
                max_hr = hr;
                // RTD
                if (typeof lmp_rtd_chart_data[res_id] != 'undefined') {
                    if(typeof lmp_rtd_chart_data[res_id]['hr_'+hr] != 'undefined') {
                        tmp_rtd = parseFloat(lmp_rtd_chart_data[res_id]['hr_'+hr]);
                        new_rtd = tmp_rtd  + ( hr_data.rtd_price != null ? parseFloat(hr_data.rtd_price) : 0 );
                    }else {
                        new_rtd =  hr_data.rtd_price;
                    }
                }else {
                    lmp_rtd_chart_data[res_id] = {};
                    new_rtd =  hr_data.rtd_price;
                }

                lmp_rtd_chart_data[res_id]['hr_'+hr] = new_rtd;


                // RTX
                if (typeof lmp_rtx_chart_data[res_id] != 'undefined') {
                    if(typeof lmp_rtx_chart_data[res_id]['hr_'+hr] != 'undefined') {
                        tmp_rtx = parseFloat(lmp_rtx_chart_data[res_id]['hr_'+hr]);
                        new_rtx = tmp_rtx  + ( hr_data.rtx_price != null ? parseFloat(hr_data.rtx_price) : 0 );
                    }else {
                        new_rtx =  hr_data.rtx_price;
                    }
                }else {
                    lmp_rtx_chart_data[res_id] = {};
                    new_rtx =  hr_data.rtx_price;
                }

                lmp_rtx_chart_data[res_id]['hr_'+hr] = new_rtx;
            });
            resource_id = res_id;
            resource_id_cnt++;
        });
        var rtd_data = [];
        var rtx_data = [];
        var res_rtd_data = null ,res_rtx_data = null, tmp_rtd = 0, rtd_val = 0, disp_rtd_val = 0, rtx_val = 0, disp_rtx_val = 0;
        max_hr = parseInt(max_hr,10);
        for (var res_id in lmp_rtd_chart_data){
            res_rtd_data = [];
            res_rtx_data = [];
            for (var h=1;h<=max_hr;h++){
                //res_rtd_data.push(lmp_rtd_chart_data[res_id]['hr_'+h]);
                rtd_val = parseFloat(lmp_rtd_chart_data[res_id]['hr_'+h]);
                disp_rtd_val = rtd_val;
                if (is_with_price_cap) {
                    if (rtd_val > price_cap) {
                        disp_rtd_val = price_cap;
                    }else{
                        disp_rtd_val = rtd_val;
                    }
                }
                
                rtx_val = parseFloat(lmp_rtx_chart_data[res_id]['hr_'+h]);
                disp_rtx_val = rtx_val;
                if (is_with_price_cap) {
                    if (rtx_val > price_cap) {
                        disp_rtx_val = price_cap;
                    }else{
                        disp_rtx_val = rtx_val;
                    }
                }
                
                res_rtd_data.push({y:disp_rtd_val, real_data : rtd_val , 'type' : 'RTD' });
                res_rtx_data.push({y:disp_rtx_val, real_data : rtx_val , 'type' : 'RTX' });
            }
            rtd_data.push({name:res_id + ' (RTD)',data:res_rtd_data,id:'rtd_'+res_id , 'yAxis': 1});
            rtx_data.push({name:res_id + ' (RTX)',data:res_rtx_data,id:'rtx_'+res_id, 'yAxis': 1});
        }
        
        $.createGraph(mw_data,rtd_data,rtx_data, 'RTD LMP');
        $.createTables(rtd_value,lmp_value,data.total,date_indexes,max_hr);
        
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
$('#show_data').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});
$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
   
    $.post('../mms_data/rep_show_resource',{region:$('#region').val(),type:$('#type').val()},
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

$('#btn_export_csv').die('click').live('click',function(){
    var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_rtd_lmp'
    var parameters = "sdate=" + $('#sdate').val();
    parameters+= "&edate=" + $('#sdate').val();
    parameters+= '&resource_id='+$('#resource_id').val();
    parameters+= '&type=CSV';
    $.download(url,parameters);
});

$('#btn_export_xls').die('click').live('click',function(){
    var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_rtd_lmp'
    var parameters = "sdate=" + $('#sdate').val();
    parameters+= "&edate=" + $('#sdate').val();
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

$("input.numeric").numeric()
</script>
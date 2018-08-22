<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/datatables.css">
<style>
    ul#list_pricerange , ul#list_hour{
        width:100%;
        margin-bottom:20px;
        overflow:hidden;
        margin-left: 0px;
      }
      ul#list_pricerange li, ul#list_hour li{
        line-height:1.5em;
        float:left;
        display:inline;
      }
      
      ul#list_pricerange li{
        width:25%;
      }
      
      ul#list_hour li{
        width:10%;
      }
</style>
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
            <div class="span2">Date</div>
            <div class="span7">
               <input type="text" id="delivery_date" name="delivery_date" value="<?=$date?>" class="input-small">
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2">Price Range</div>
            <div class="span9">
                <ul id="list_pricerange">
                    <li><label class="checkbox inline"><input type="checkbox" min="-120000" max="0" value="-120000|0" name="price_range_chk">0 and Below</label></li>
                    <?php
                        $min = 0;
                        $max = 1000;
                        for($min=0;$min<=10000;$min+=1000){
                            $label = $min . ' to ' . $max;
                            echo '<li><label class="checkbox inline"><input type="checkbox" value="'.$min . '|' . $max.'" min="'.$min.'" max="'.$max.'" name="price_range_chk">'.$label.'</label></li>';
                            $max+=1000;
                        }
                        ?>
                    <li><label class="checkbox inline"><input type="checkbox" value="12000|999999999" min="12000" max="9999999" name="price_range_chk">12000 and Above</label></li>
                </ul>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2">Hour</div>
            <div class="span9">
                <ul id="list_hour">
                    <?php
                        for($hr=1;$hr<=24;$hr++){
                            echo '<li><label class="checkbox inline"><input type="checkbox" value="'.$hr.'"  name="hr_chk">'.$hr.'</label></li>';
                        }
                        ?>
                </ul>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2">&nbsp;</div>
            <div class="span9">
                <a class="btn btn-primary" id="display_btn" href="#"><i class="icon-signal icon-white "></i>&nbsp;Display</a>
                <a class="btn btn-primary" id="export_btn" href="#"><i class="icon-download-alt icon-white"></i>&nbsp;Export to XLSX</a>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                
            </div>
        </div>
        <hr>
        <div id="result"></div>
		
        </form>
    </section>
    <br><br><br><br>
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
    	<button id="get_rid" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    loadData : function () {
        $("#result").attr('class','alert alert-info').html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $('#display_btn').attr('disabled',true);
        $('#export_btn').attr('disabled',true);
        
        /** VALIDATION **/
        var errors = [];
        var delivery_date = $.trim($('#delivery_date').val());
        if (delivery_date.length <= 0) {
            errors.push('Please select valid date');
        }
        
        var price_ranges = $("input[name=price_range_chk]:checkbox:checked").map(function(){
            return $(this).val();
          }).get();
          
        if (price_ranges.length > 5) {
            errors.push('You can only select maximum of 5 items for Price Range');
        }else if (price_ranges.length <= 0){
            errors.push('Please select at least one Price Range item');
        }
        
        var hours = $("input[name=hr_chk]:checkbox:checked").map(function(){
            return $(this).val();
          }).get();
          
        if (hours.length > 5) {
            errors.push('You can only select maximum of 5 items for Hours');
        }else if (hours.length <= 0){
            errors.push('Please select at least one Hour item');
        }
        
        if (errors.length > 0) {
            $("#result").attr('class','alert alert-warning').html(errors.join('<br>'));
            $('#display_btn').attr('disabled',false);
            $('#export_btn').attr('disabled',true);
        }else {
            $('#display_btn').attr('disabled',false)
            $('#export_btn').attr('disabled',false);
            $.post('../market_data/rep_mbo_price_range_action',{'date' : delivery_date, 'price_range' : price_ranges.join(',') , 'hour' : hours.join(',') },
            function(data){
                var total = parseInt(data.total,10);
                var list = data.value;
                var range = null, series_data = null, min = null, max = null;
                var price = null, mw = null, data_arr = null ;
                var with_valid_plot_values = 0, fixed_mw = 0;
                var x_categories = $("input[name=price_range_chk]:checkbox:checked").map(function(){
                    return $(this).parent().text();
                  }).get();
                  
                 
                  
                var price_ranges = $("input[name=price_range_chk]:checkbox:checked").map(function(){
                    return $(this).val();
                  }).get();
                
                
                // reset chart
                MBO_CHART = {};
                $('#result').html('').attr('class','');
                
                if (total <= 0 ) {
                    $("#result").attr('class','alert alert-info').html('No available records');
                }else {
                    $.each(list, function (hour, hour_resources_data){
                        series_data = [];
                        $.each(hour_resources_data, function(resource, val) {
                            
                            for (var i=1;i<=11;i++){
                                price = val['price'+i] != null ? parseFloat(val['price'+i]) : null;
                                mw = val['quantity'+i] != null ? parseFloat(val['quantity'+i]) : null;
                                fixed_mw = mw === 0 ? 0.5 : mw;
                                
                                data_arr = [];
                                with_valid_plot_values = 0;
                                for (var pr=0;pr<price_ranges.length;pr++){
                                    range = price_ranges[pr].split('|');
                                    min =  parseFloat(range[0]);
                                    max =  parseFloat(range[1]);
                                    
                                    if (price > min && price < max) {
                                        data_arr.push({y:mw , 'price' : price, 'mw' : mw });
                                        with_valid_plot_values++;
                                    }else {
                                        data_arr.push(null);
                                    }

                                }
                                if (with_valid_plot_values > 0) {
                                    series_data.push({name:resource + ' (Price'+i+')',data:data_arr,id:'mbo_'+resource+'_'+hour+'_i_'+i});
                                }
                                
                            }
                        });
                        
                        /// create chart container
                        $('#result').append('<div id="chart_'+hour+'"></div><br>');
                        $.createChart('chart_'+hour,series_data,hour,x_categories);
                    });
                }
                
                $('#display_btn').attr('disabled',false);
                $('#export_btn').attr('disabled',false);
            });
            
        }
            
    }
    ,createChart : function(chartElm,series_data,hour,xcategories) {
        console.log(xcategories)
        MBO_CHART[hour] = new Highcharts.Chart({
            chart: {
                    renderTo: chartElm,
                    type: 'column',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    height:400,
                    borderColor: '#CCCCCC',
                    borderWidth: 1
            },
            exporting: {
                filename: 'mbo_price_range_hr_' + hour
            },
            title: {
                text: 'Hour ' + hour
               ,align : 'left' 
            },
            subtitle: {
                text: 'Price Range : ' + xcategories.join(', ')
                ,align : 'left' 
            },
            xAxis: [{
                categories: xcategories,
                tickPixelInterval:50,
                gridLineWidth: 1
            }],
            yAxis:  [{ // Primary yAxis
                labels: {
                    formatter: function() {
                        return $.formatNumberToSpecificDecimalPlaces(this.value,0) +' ';
                    },
                    style: {
                        color: '#4572A7'
                    }
                },
                title: {
                    text: 'MEGAWATT',
                    style: {
                        color: '#4572A7'
                    }
                }
                //,tickInterval: 50
                ,gridLineWidth : 0
                
            }]
            ,plotOptions: {
                column: {
                    minPointLength: 5
                    }
            }
            ,tooltip: {
                shared: false
               ,formatter: function() {
                    var s = '<b>'+ this.x +'</b>';
                    s+= '<br>' + this.series.name + ' : ' + this.point.mw + 'MW : Php ' + $.formatNumberToSpecificDecimalPlaces(this.point.price,2); 
                    return s;
                }
            },
            series: series_data
            
        });
        console.log(series_data)
        return false;
    }
    ,exportData : function(){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/market_data/file_rep_mbo_price_range'
        
        /** VALIDATION **/
        var errors = [];
        var delivery_date = $.trim($('#delivery_date').val());
        if (delivery_date.length <= 0) {
            errors.push('Please select valid date');
        }
        
        var price_ranges = $("input[name=price_range_chk]:checkbox:checked").map(function(){
            return $(this).val();
          }).get();
          
        if (price_ranges.length > 5) {
            errors.push('You can only select maximum of 5 items for Price Range');
        }else if (price_ranges.length <= 0){
            errors.push('Please select at least one Price Range item');
        }
        
        var hours = $("input[name=hr_chk]:checkbox:checked").map(function(){
            return $(this).val();
          }).get();
          
        if (hours.length > 5) {
            errors.push('You can only select maximum of 5 items for Hours');
        }else if (hours.length <= 0){
            errors.push('Please select at least one Hour item');
        }
        
        if (errors.length <= 0) {
            
            var price_range_labels = $("input[name=price_range_chk]:checkbox:checked").map(function(){
                return $(this).parent().text();
              }).get();

            var parameters = "date=" + delivery_date;
            parameters+= "&price_range=" + price_ranges.join(',');
            parameters+= "&price_range_labels=" + price_range_labels.join(',');
            parameters+= "&hour=" + hours.join(',');
            $.download(url,parameters);
        }
        

        
        
    }
})
</script>
<script>
var MBO_CHART = {};    
$('#delivery_date').datepicker();
$.loadData();    

$('#display_btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

$('#export_btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.exportData();
});



</script>
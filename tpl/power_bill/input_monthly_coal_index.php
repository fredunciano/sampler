<style>
.table th, .table td {
    vertical-align: middle;
}

div#results .table th {
    text-align: center;
    background-color: #F7F4F4;
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
    
    <section id="global" >
        
       
            <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
            <div class="row-fluid">
                <div class="span1">Month </div>
                    <div class="span7">
                        <select name="month" class="input-medium" id="month">
                            <?php
                                $months = array('January','February','March','April','May','June','July','August','September','October','November','December');
                                $cur_month = intval(date('m'));
                                $month_indx = 1;
                                foreach ($months as $month) {
                                   $selected = $month_indx=== $cur_month ? ' selected="true" ': '';
                                   echo '<option value="'.$month_indx.'" '.$selected.'>'.$month.'</option>';
                                   $month_indx++;
                                }
                            ?>
                        </select>   
                        &nbsp;&nbsp;&nbsp;
                        Year&nbsp;&nbsp;&nbsp;
                        <select name="year" class="input-medium" id="year">
                            <?php
                                $current_year = intval(date('Y'));
                                $s_year = $current_year - 10;
                                $e_year = $current_year + 5;
                                for($yr=$s_year;$yr<=$e_year;$yr++){
                                    $selected = $yr=== $current_year ? ' selected="true" ': '';
                                    echo '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
                                }
                            ?>
                        </select>
                        
                    </div>
            </div>
            <br>
            <div id="loader"></div>
            <table class="table table-striped table-condensed">
                
                <tr>
                    <td>Global Coal Price</td>
                    <td><input type="text" name="global_coal_price" id="global_coal_price" class="input-medium numeric" value=""> USD/MT</td>
                    <td>&nbsp;</td>
                    <td>PT Pertamina</td>
                    <td><input type="text" name="pt_pertamina" id="pt_pertamina" class="input-medium numeric" value=""> USD/Liter</td>
                </tr>
                
            </table>
            <div class="row-fluid">
                <div class="span7"><button type="button" id="btn_save" class="btn btn-primary"><i class="icon-file"></i>&nbsp;Save</button>&nbsp</div>
            </div>
            <br>
            <br>
           
            
    </section>
    <section>
        <div class="row-fluid">
                <div class="span2">Year Range  </div>
                    <div class="span7">
                        <select name="report_syear" class="input-small" id="report_syear">
                            <?php
                                for($yr=$min_year;$yr<=$max_year;$yr++){
                                    $selected = $yr=== $min_year ? ' selected="true" ': '';
                                    echo '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
                                }
                            ?>
                        </select>   
                        &nbsp;&nbsp;&nbsp;
                        to &nbsp;&nbsp;&nbsp;
                        <select name="report_eyear" class="input-small" id="report_eyear">
                            <?php
                                for($yr=$min_year;$yr<=$max_year;$yr++){
                                    $selected = $yr=== $max_year ? ' selected="true" ': '';
                                    echo '<option value="'.$yr.'" '.$selected.'>'.$yr.'</option>';
                                }
                            ?>
                        </select>
                       
                    </div>
            </div>
            <div id="results_loader"></div>
            <div id="results" style="display:none;">
                <div role="tabpanel">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      <li role="presentation" class="active"><a href="#old" aria-controls="old" role="tab" data-toggle="tab">Old</a></li>
                      <li role="presentation"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">New</a></li>
                      
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="old" style="max-height: 350px; overflow-y:auto;">
                          <table class="table table-bordered table-condensed table-striped" id="tbl_coal_index_price_old">
                            <tr>
                                <th colspan="5">Coal Index Price (Old)</th>
                            </tr>

                            <tr>
                                <th rowspan="2">Month</th>
                                <th colspan="2">Global Coal</th>
                                <th colspan="2">PT Pertamina</th>
                            </tr>
                            <tr>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                            </tr>
                             <tr>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                            </tr>
                            </table>
                            <br>

                            <div id="coal_price_list_old">

                            </div>
                      
                      </div>
                      <div role="tabpanel" class="tab-pane" id="new" style="max-height: 350px; overflow-y:auto;">
                          <table class="table table-bordered table-condensed table-striped" id="tbl_coal_index_price_new">
                            <tr>
                                <th colspan="5">Coal Index Price (New)</th>
                            </tr>

                            <tr>
                                <th rowspan="2">Month</th>
                                <th colspan="2">Global Coal</th>
                                <th colspan="2">PT Pertamina</th>
                            </tr>
                            <tr>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                            </tr>
                             <tr>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                                <th>Monthly</th>
                                <th>Quarterly</th>
                            </tr>
                            </table>
                            <br>

                            <div id="coal_price_list_new">

                            </div>
                      </div>
                    </div>
                    
                  </div>
                
                
                    
                
            </div>
            <br>    
        <div class="row-fluid">
            <div class="span7"><button type="button" id="btn_export_report" class="btn btn-success"><i class="icon-download"></i>&nbsp;Export to Excel</button>&nbsp</div>
        </div>
        <br>
    </section>
    
    
</div>

<script type="text/javascript">
    $.extend({
       getData : function(){
           var parameters = {};
           parameters['year'] = $('#year').val();
           parameters['month'] = $('#month').val();
            $('#loader').html('Please wait <img src="../images/ajax-loader.gif" />').removeAttr('class');
            $.post('<?=$base_url?>/power_bill/input_monthly_coal_index_prices_get',parameters,
            function(ret){
                var data = ret.value;
                $('#global_coal_price').val($.formatNumberToSpecificDecimalPlaces(data.global_coal_price,5));
                $('#pt_pertamina').val($.formatNumberToSpecificDecimalPlaces(data.pt_pertamina,5));
                
                $('#results').hide();
                $.listReport();
                $('#loader').html('').removeAttr('class');
            });    
            
            
       } //
       ,saveData : function(){
           var parameters = {};
           parameters['year'] = $('#year').val();
           parameters['month'] = $('#month').val();
           
           var global_coal_price = $.trim($('#global_coal_price').val());
           var pt_pertamina = $.trim($('#pt_pertamina').val());
           parameters['global_coal_price'] = global_coal_price;
           parameters['pt_pertamina'] = pt_pertamina;
           var error_messages = [];
           
           if (global_coal_price.length <= 0) {
               error_messages.push('Global Coal Price');
           }
           
           if (pt_pertamina.length <= 0) {
               error_messages.push('PT Pertamina');
           }
           
           if (error_messages.length > 0) {
               $('#loader').html('The following field(s) are required<br>' + error_messages.join('<br>')).addClass('alert').addClass('alert-error');
           }else {
               $('#loader').html('Please wait <img src="../images/ajax-loader.gif" />').removeAttr('class');
               $.post('<?=$base_url?>/power_bill/input_monthly_coal_index_prices_save',parameters,
                function(data){
                   $('#loader').html(data.message).addClass('alert').addClass('alert-info');
                   $("#tbl_coal_index_price_old tr:gt(2)").remove();
                   $("#tbl_coal_index_price_new tr:gt(2)").remove();
                   $.listReport();
                }); 
           }
       } //
       ,listReport : function(){
           var parameters = {};
           parameters['report_syear'] = $('#report_syear').val();
           parameters['report_eyear']= $('#report_eyear').val();
           
            $("#tbl_coal_index_price_old tr:gt(2)").remove();
            $("#tbl_coal_index_price_new tr:gt(2)").remove();
            $('#results_loader').html('Please wait, getting report data .... <img src="../images/ajax-loader.gif" />').addClass('alert').addClass('alert-info');
            $.post('<?=$base_url?>/power_bill/input_monthly_coal_index_prices_report',parameters,
            function(ret){
                 var data = ret.value;
                 var data_avg = ret.quarterly_avg_data;
                 var syear = parseInt(ret.syear,10);
                 var smonth = parseInt(ret.smonth,10);
                 var eyear = parseInt(ret.eyear,10);
                 var emonth = parseInt(ret.emonth,10);
                 var mn = 0, e_mn = 12;
                 $('#results').show();
                 
                 // build global coal price quarterly average
                 
                 var pad = "00" , global_coal_price = '', pt_pertamina = '';
                 var avg_global_coal_price = '', avg_pt_pertamina = '';
                 var contents = '', mn_s = '', str ='';
                 var is_with_row_data = false;
                 for (var yr=syear;yr<=eyear;yr++){
                     mn =1;
                     e_mn = 12;
                     
                     if ( yr === syear ) {
                         mn = smonth;
                     } else if (yr === eyear){
                         e_mn = emonth;
                     }
                     
                     for (var m=mn;m<=e_mn;m++){
                         is_with_row_data = false;
                         global_coal_price = '';
                         pt_pertamina = '';
                         avg_global_coal_price = '';
                         avg_pt_pertamina = '';
                         if ( typeof data[yr] != 'undefined' ) {
                            if ( typeof data[yr][m] != 'undefined' ) {
                                global_coal_price = data[yr][m]['global_coal_price'];
                                pt_pertamina = data[yr][m]['pt_pertamina'];
                                is_with_row_data = true;
                            }  
                         }
                         
                         if ( typeof data_avg[yr] != 'undefined' ) {
                            if ( typeof data_avg[yr][m] != 'undefined' ) {
                                avg_global_coal_price = data_avg[yr][m]['global_coal_price'];
                                avg_pt_pertamina = data_avg[yr][m]['pt_pertamina'];
                            }  
                         }
                         
                         if (is_with_row_data) {
                             str = ''+m;
                            mn_s =  pad.substring(0, pad.length - str.length) + str;
                            contents +='<tr><td style="text-align:center;">'+yr+'.'+mn_s+'</td>';
                            contents +='<td style="text-align:right;">'+global_coal_price+'</td>';
                            contents +='<td style="text-align:right;">'+avg_global_coal_price+'</td>';
                            contents +='<td style="text-align:right;">'+pt_pertamina+'</td>';
                            contents +='<td style="text-align:right;">'+avg_pt_pertamina+'</td></tr>';
                         }
                         
                     }
                 }
                 $("#tbl_coal_index_price_old").append(contents);
                 $("#tbl_coal_index_price_new").append(contents);
                 
                 
                 // popuate coal price list per tab
                 var types = ['old','new'];
                 for(var t=0;t<types.length;t++){
                    var type = types[t];
                    var ends = ['th','st','nd','rd','th','th','th','th','th','th'];
                    var coal_price = ret.coal_price_index_list[type];
                    var base_price = ret.base_prices;
                    $('#coal_price_list_'+type).html('');
                    var coal_price_list = '';
                    var coal_price_data, report_details = '';
                    var coal_row = '', transpo_row = '';
                    var lst = null , table_header = '', is_used_based_price = 0;
                    for (var i=0;i<coal_price.length;i++){
                       coal_price_data = coal_price[i];
                        var number = parseInt(coal_price_data.quarter,10);
                        var year = parseInt(coal_price_data.year,10);
                        if ((number %100) >= 11 && (number%100) <= 13)
                           var abbreviation = number + 'th';
                        else
                           var abbreviation = number + ends[number % 10];
                       is_used_based_price = parseInt(coal_price_data.is_used_based_price,10);
                       table_header = year + ' ' + abbreviation + ' Quarter ';
                       if ( is_used_based_price === 1) {
                           table_header = year + ' ' + abbreviation + ' Quarter ( New Base Price)';
                       }

                       report_details = $.parseJSON(coal_price_data.report_details);
                       coal_price_list+='<table class="table table-bordered table-condensed table-striped">';
                       coal_price_list+='<tr><th colspan="5" style="text-align:left;">'+table_header+'</th></tr>';
                       coal_price_list+='<tr>';
                       coal_price_list+='<th></th>';
                       coal_row = '<tr><td>Coal</td>';
                       transpo_row = '<tr><td>Transpo</td>';
                       var key_ctr = 0;
                       for (var key in report_details) {
                           coal_price_list+='<th>'+key+'</th>';
                           lst = report_details[key]
                           coal_row += '<td>'+lst[0]+'</td>';
                           transpo_row += '<td>'+lst[1]+'</td>';
                           key_ctr++;
                       }
                       coal_price_list+='<th>'+abbreviation+' Quarter Price</th>';

                       coal_price_list+='</tr>';
                       coal_row += '<td>'+$.formatNumberToSpecificDecimalPlaces(coal_price_data.coal_price,2)+'</td>';
                       transpo_row += '<td>'+$.formatNumberToSpecificDecimalPlaces(coal_price_data.transpo_price,2)+'</td>';
                       coal_row+='</tr>';
                       transpo_row +='</tr>';
                       coal_price_list +=coal_row+transpo_row;
                       coal_price_list+='</table><br>';

                    }
                    $('#coal_price_list_'+type).html(coal_price_list);
                 }
                 $('#results_loader').html('').removeAttr('class');
            });    
            
       } //
       ,downloadReport: function(){
            var parameters = "report_syear=" + $('#report_syear').val();
                parameters+= "&report_eyear=" + $('#report_eyear').val();
                var url = 'http://' + location.host + '<?=$base_url?>' + '/power_bill/file_input_monthly_coal_index_prices_report'
                $.download(url,parameters);
       }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
     $('.numeric').autoNumeric('init',{
        mDec: '5'
      ,vMin : -9999999999      
    });
    
    
    $('#year').unbind().bind('change',function(){
        $.getData();
    });
    
    $('#month').unbind().bind('change',function(){
        $.getData();
    });
    
    $('#report_syear,#report_eyear').unbind().bind('change',function(){
        $.listReport();
    });
    
    $('#btn_save').unbind().bind('click',function(){
        $.saveData();
    });
    
    $('#btn_export_report').unbind().bind('click',function(){
        $.downloadReport();
    });
    
    $.getData();
});
 

</script>
    

     




<style>
.table th, .table td {
    vertical-align: middle;
}

table.tbl_pscx {
    border: 1px solid #F9F9F9;
    border-radius: 4px;
}
table.tbl_psc th {
    text-align: center;
    background-color: #F7F4F4;
}

div.formula {
    background-color: #EAF3F7;
    padding:10px;
    font-size:11px;
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
                <div class="span2">Billing Period </div>
                <div class="span3 input-append input-prepend">
                    <input type="text" id="sdate" name="date" value="<?=$def_sdate?>" class="input-small"><span class="add-on">to</span>
                    <input type="text" id="edate" name="date" value="<?=$def_edate?>" class="input-small">
                </div>
                <div class='span4' style="margin-top: 5px;">
                    <span class="error-note" id="date_range_error"></span>
                </div>
            </div>


            <div class="row-fluid">
                <div class="span2">Old Rate </div>
                <div class="span4">
                <input type="text" name="psc_rate_old" id="psc_rate_old" class="input-medium numeric" value=""> Php/kWh
                </div>
            </div>

            
            <div class="row-fluid">
                <div class="span2">New Rate </div>
                <div class="span4">
                <input type="text" name="psc_rate_new" id="psc_rate_new" class="input-medium numeric" value=""> Php/kWh
                </div>
            </div>
            
             <div class="row-fluid">
                <div class="span2"></div>
                <div class="span7"><button type="button" id="btn_save" class="btn btn-primary"><i class="icon-file"></i>&nbsp;Save</button>&nbsp</div>
            </div>
            <br>
            <div id="result"></div>            
    </section>
    
    
</div>

<script type="text/javascript">
    $.extend({
       getData : function(){
           
           // hide form elements first while getting data from the backend
           $('#result').html('Please wait, we are getting information for the selected billing period <img src="../images/ajax-loader.gif" />').removeAttr('class').addClass('alert alert-info');
           var parameters = {};
           parameters['sdate'] = $('#sdate').val();
           parameters['edate'] = $('#edate').val();
           parameters['type'] = $('#type').val();
           
           $('#psc_rate_old').val('');
           $('#psc_rate_new').val('');
            $.post('<?=$base_url?>/power_bill/input_psc_rates_get',parameters,
            function(ret){
                var data = ret.value;
                var messages = ret.message;
                var success = ret.success;

                if (success === 1) {
                    $('#psc_rate_old').val(data.psc_rate_old);
                    $('#psc_rate_new').val(data.psc_rate_new);
                    $('#result').html('').removeAttr('class');
                }else {
                    $('#result').html('No available data').removeAttr('class').addClass('alert alert-info');
           
                }
                
               
            });  
            
            
       } //
       
       ,saveData : function(){
           var parameters = $('form').serialize();
           parameters+= '&sdate=' + $('#sdate').val();
           parameters+= '&edate=' + $('#edate').val();
           parameters+= '&type=' + $('#type').val();
           parameters+= '&psc_rate_new=' + $('#psc_rate_new').val();
           parameters+= '&psc_rate_old=' + $('#psc_rate_old').val();
           

           var psc_rate_new = $.trim($('#psc_rate_new').val());
           var psc_rate_old = $.trim($('#psc_rate_old').val());

           if ( psc_rate_new.length > 1 &&  psc_rate_old.length > 1) {
                $('#result').html('Please wait <img src="../images/ajax-loader.gif" />').removeAttr('class').addClass('alert alert-info');
                $.post('<?=$base_url?>/power_bill/input_psc_rates_save',parameters,
                 function(data){
                    $('#result').html(data.message).addClass('alert').addClass('alert-info');
                 }); 
           }else {
                $('#result').html('All fields are required').addClass('alert').addClass('alert-error');
           }

            
           
              
       } //
       ,validateDateRange : function(sdate_obj,edate_obj){
            var f_date = $.trim(sdate_obj.val());
            var e_date = $.trim(edate_obj.val());
            var is_valid = true;
            if ( f_date.length <= 0 || e_date.length <= 0 ) {
                is_valid = false;
            } else if (f_date.length > 0 || e_date.length > 0){
                var f_date_dte_obj = new Date(f_date);
                var e_date_dte_obj = new Date(e_date);
                if (e_date_dte_obj < f_date_dte_obj ) {
                     is_valid = false;
                }else {
                     is_valid = true;
                }
            }else {
                is_valid = false;
            }
            
            if (is_valid) {
                $('#date_range_error').html('');
            }else {
                $('#date_range_error').html('Invalid date range');
            }
            return is_valid;
        }
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#sdate,#edate').datepicker();
    
    $('#sdate').on('changeDate', function(ev) {
        var msg = '';
        var sdate = Date.parse($('#sdate').val());
        var sday = parseInt(Date.parse($('#sdate').val()).toString('dd'),10);
        if (sday < 26) {
            var n_year = sdate.toString('yyyy');
            var n_month = sdate.toString('MM');
             msg = 'Billing period should start every 26th of the month';
        }else {
            var n_date = sdate.addMonths(1);
            var n_year = n_date.toString('yyyy');
            var n_month = n_date.toString('MM');
        }
        var suggested_endate = Date.parse(n_year +'-'+n_month+'-25').toString('MM/dd/yyyy');
        $('#edate').val(suggested_endate);
        $('#date_range_error').html(msg);
        $.getData();
     });
    
    $('#edate').on('changeDate', function(ev) {
           $.validateDateRange( $('#sdate'),$('#edate') );
           $.getData();
    });  
    
    $('#btn_save').unbind().live('click',function(){
        $.saveData();
    });
    
     $('.numeric').autoNumeric('init',{
        mDec: '5'
      ,vMin : -9999999999      
    });
    
    $.getData();
});
 

</script>
    

     




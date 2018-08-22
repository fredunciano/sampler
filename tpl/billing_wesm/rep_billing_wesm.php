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
        <legend><h4><?=$title?> <small>( Billing & Settlements )</small></h4></legend>
        <div id="error_message"></div>
        
        <div class="row-fluid">
            <div class="span2">Billing Period: </div>
            <div class="span3 input-prepend input-append input-daterange" id = "datepicker">
                <span class="add-on" style="padding:5px">From</span>
                <input type="text" id="sdate" name="date" value="<?=$def_billing_sdate?>" class="input-small"><span class="add-on" style="padding:5px;padding-left:10px;padding-right:10px;"><i class="icon-calendar"></i></span>
                <span class="add-on" style="padding:5px">To</span>
                <input type="text" id="edate" name="date" value="<?=$def_billing_edate?>" class="input-small"><span class="add-on" style="padding:5px"><i class="icon-calendar"></i></span>
            </div>
            <div class='span2' style="margin-top: 5px;">
                <span class="error-note" id="date_range_error"></span>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span2">Source: </div>
            <div class="span7">
                <select id="source" name="source" style = "width: 227px;">
                    <option disabled="disabled" selected="selected" hidden>Please select source ...</option>
                    <option value="prelim">Prelim</option>
                    <option value="final">Final</option>
                    <option value="adjustment">Final with Adjustment</option>
                </select>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2">Report Field:
                <label class="checkbox"><input type="checkbox" id="check_all" ><span id="label_check_all">Check all</span></label>
            </div>
            <div class="span7">
                <table class="table table-condensed" id = "test">
                <tr class = "tr_field">
                <?php
                    $total_len = count($resources);
                    $x= 1;
                    foreach ($resources as $row) {
                        $colspan = "";
                        $y = $x%4;
                        if ($x === $total_len ) {
                            #$colspan = " colspan='4' ";
                        }
                        echo '<td '.$colspan.'><label class="checkbox"><input type="checkbox" class = "fields" name="field" value="'.$row['resource_id'].'" >'.$row['resource_id'].'</label></td>';
                        if ($y==0) {
                            echo '</tr><tr>';
                        }
                        $x++;
                    }
                    echo '<td '.$colspan.'><label class="checkbox"><input type="checkbox" class = "fields" id = "total_field" value="TOTAL" >TOTAL</label></td>';
                ?>
                </tr>
                </table>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7">
                <button class="btn btn-primary" type="button" id="btn_generate_report"><i class="icon-align-right icon-white"></i>&nbsp;Generate Report</button>
            </div>
        </div>
        <hr>
        <div id="result"></div>
    </section>
</div>

<script type="text/javascript">

$.extend({
    downloadFile : function(sdate,edate,source,fields,type){
        
            var parameters = "sdate=" + sdate;
            parameters+= "&edate=" + edate;
            parameters+= "&source=" + source;
            parameters+= "&fields=" + fields;
            parameters+= "&total=" + $('#total_field').is(":checked")
            parameters+= "&type=" + type
            var url = 'http://' + location.host + '<?=$base_url?>' + '/billing_wesm/file_billing_template_report';
            
            $.download(url,parameters);
    }
}) // eof extend
    
$('datepicker').datepicker({ // Datepicker validation
        startDate: '-12m',
        endDate: '+12m'
})

$(document).ready(function(){

        // set form input events 
        $('#check_all').change(function(e){
            var chk = $(this).attr('checked');
            if (chk) {
                $('#label_check_all').html('Uncheck All')
                $('input[class="fields"]').attr('checked','checked');
            } else {
                $('#label_check_all').html('Check All')
                $('input[class="fields"]').removeAttr('checked');
            }
        }); // eof form input event
        
        
        $('#btn_generate_report').unbind().bind('click',function(){ // Generate Button

            var sdate   = $.trim($('#sdate').val());
            var edate   = $.trim($('#edate').val());
            var source  = $.trim($('#source').val());
            var fields  = $("input[name=field]:checked").map(function() { return this.value;}).get().join(",");
            
            var sday     = $('#sdate').datepicker('getDate').getDate();  
            var smonth   = $('#sdate').datepicker('getDate').getMonth() + 1;  
            var syear    = $('#sdate').datepicker('getDate').getFullYear();
            
            var eday     = $('#edate').datepicker('getDate').getDate();  
            var emonth   = $('#edate').datepicker('getDate').getMonth() + 1;  
            var eyear    = $('#edate').datepicker('getDate').getFullYear();

            var errors  = [];

            $('#error_message').html('').removeAttr('class');

            if ( $.monthDiff(new Date(syear, smonth, sday),new Date(eyear, emonth, eday)) >= 2 ){
                errors.push('<li>Please select maximum of 2 billing period</li>');
            }

            if (source == 'Please select source ...' ) {
                errors.push('<li>Please choose a Source</li>');
            }           
            
            if (fields.length <= 0 ) {
                errors.push('<li>Please choose at least one Report Field</li>');     
            }

            if (errors.length > 0) { // If error display
                $('#result').removeAttr('class').html('');
                $('#error_message').html('Cannot proceed because of the following :'+'<ul>'+ errors.join('') + '</ul>').addClass('alert').addClass('alert-error');
            }else {
                
                source = source == 'adjustment' ? 'final' : source;

                var param = "sdate=" + sdate
                    param+= "&edate=" + edate
                    param+= "&source=" + source
                    param+= "&fields=" + fields
                    param+= "&type=" + $.trim($('#source').val())
                            
                $('#result').removeAttr('class').html('Please wait... &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />').addClass('alert').addClass('alert-info');

                $.post('<?=$base_url?>/billing_wesm/rep_billing_wesm_action',param,
                    function(data){
                        
                        if ( data.total <= 0 ) {
                            $('#result').removeAttr('class').html('No available records.').addClass('alert').addClass('alert-info');
                        }else {
                            var link = data.value, link_html ='';
                           
                            link_html += '<li>Successfully Generated <a style="cursor:pointer" sdate="'+ link.sdate +'" edate="'+ link.edate +'" source="'+ link.source +'" resources="'+ link.fields +'" type="'+ link.type +'">'+ link.filename +'</a></li>';
                            
                            $('#result').removeAttr('class').html('<ul style="list-style:none;margin:0px;">'+link_html+'</ul>').addClass('alert').addClass('alert-success');
                            
                            $('#result a').unbind().bind('click',function(){
                                $.downloadFile($(this).attr('sdate'),$(this).attr('edate'),$(this).attr('source'),$(this).attr('resources'),$(this).attr('type'));
                            });
                        }
                });  
            } // eof else
            
        }); // eof Generate Button
        
}); // eof document ready

</script>
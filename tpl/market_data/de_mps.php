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
        <form method="post">
        <legend><h4><?=$title?> <small>( Data Extraction )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Resource ID</div>
            <div class="span10">
                <select id="resource_id" name="resource_id">
                        <?php
                        foreach ($resource_arr as $resource_id) {

                            echo '<option value="'.$resource_id.'">'.$resource_id.'</option>';
                        }
                        ?>
                    </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Report Options</div>
            <div class="span10">
                <select name="report">
                    <option value="RTD">Real Time Ex-Ante</option>
                    <option value="RTX">Real Time Ex-Post</option>
                </select>
                <!--select name="type" class="input-medium">
                    <option value="GEN">Generation</option>
                    <option value="LD">Load</option>
                    <option value="R">Reserve</option>
                </select>
                <select name="region" class="input-medium">
                    <option value="LUZON">Luzon</option>
                    <option value="VISAYAS">Visayas</option>
                </select-->
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date Options</div>
            <div class="span10">
                <label class="radio inline">
                    <input type="radio" name="date_option" value="latest" id="latest" checked>Latest
                </label>
                <label class="radio inline">
                    <input type="radio" name="date_option" value="range_from" id="date_range">Date Range
                </label>
                <div id="date_range_container" style="display:none;margin:10px" class="input-append input-prepend">
                    <span class="add-on">from</span><input type="text" name="date_from" class="datetext"><span class="add-on">to</span><input type="text" name="date_to" class="datetext">
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Hour Options</div>
            <div class="span10">
                <label class="radio inline">
                    <input type="radio" name="hour_option" value="all" id="all" checked>All
                </label>
                <label class="radio inline">
                    <input type="radio" name="hour_option" value="hour_range" id="hour_range">Hour Range
                </label>
                <label class="radio inline">
                    <input type="radio" name="hour_option" value="specific" id="specific">Specific
                </label>
                <div id="hour_range_container" style="display:none;padding:10px">
                    <span class="add-on">from</span>
                    <select name="hour_range_from" class="select_small">
                        <?php
                            for ($x=1;$x<=24;$x++) {
                                echo '<option value="'.$x.'">'.$x.'</option>';
                            }
                        ?>
                    </select>
                    <span class="add-on">to</span>
                    <select name="hour_range_to" class="select_small">
                        <?php
                            for ($x=1;$x<=24;$x++) {
                                echo '<option value="'.$x.'">'.$x.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div id="specific_container" style="display:none;padding:5px">
                    <input type="hidden" name="specific_hour" id="specific_hour" value="">
                    <table class="table table-condensed">
                        <tr>
                        <?php
                            for ($x=1;$x<=24;$x++) {
                                echo '<td><label class="checkbox"><input type="checkbox" name="specific_hr" value="'.$x.'">'.$x.'</label></td>';
                                if ($x==15) {
                                    echo '</tr><tr>';
                                }
                            }
                        ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        

        <hr>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <a class="btn btn-primary" href="#" id="download"><i class="icon-arrow-down icon-white"></i>&nbsp;Download</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
        </form>
    </section>    
</div>
<script>
$.extend({

    extractData : function(){

        // validation
        var errors = [];
        var date_option  = $('input[name=date_option]:checked').val();
        if (date_option === "range_from") {
            var sdate = $.trim($('input[name=date_from]').val());
            var edate = $.trim($('input[name=date_to]').val());

            if ( sdate.length <= 0  ) {
                errors.push('Please select valid start date');
            }
            if ( edate.length <= 0  ) {
                errors.push('Please select valid end date');
            } 

            if ( sdate.length > 0 && edate.length > 0  ) {
                var sdate_obj = Date.parse(sdate);
                var edate_obj = Date.parse(edate);
                if (edate_obj < sdate_obj) {
                    errors.push('Invalid date range');
                }
            }
        }


        var hour_option  = $('input[name=hour_option]:checked').val();
        if (hour_option === "hour_range") {
            var s_hour = parseInt($.trim($('select[name=hour_range_from]').val()),10);
            var e_hour = parseInt($.trim($('select[name=hour_range_to]').val()),10);

            if (e_hour < s_hour) {
                errors.push('Invalid hour range');
            }
        }

        if (hour_option === "specific") {
            var specific_hrs = $.trim($("input[name=specific_hr]:checked").map(function() { return this.value;}).get().join(","));

            if (specific_hrs.length <= 0) {
                errors.push('Please select at least one specific hour');
            }
        }

        if (errors.length > 0) {
            $("#result").attr('class','alert alert-info').html(errors.join('<br>'));
        }else {
            var specific_hr = $.trim($("input[name=specific_hr]:checked").map(function() { return this.value;}).get().join(","));
            $('#specific_hour').val(specific_hr);
            $("#result").attr('class','alert alert-info');
            $("#result").html('Please wait while data is being extracted &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
            $.post('../market_data/data_extraction_mps_generate_link',$('form').serialize(),

            function(data){

                $("#result").html(data);
                return false;

            });
        }
        
    }
    ,exportReport:function(){
        $.download('../market_data/file_data_extraction_mps',$('form').serialize());
    }

})
</script>
<script>
$('input[name=date_from],input[name=date_to]').datepicker();
$('#date_range').change(function(){
    $('#date_range_container').css('display','block');
})
$('#latest').change(function(){
    $('#date_range_container').css('display','none');
})
$('#all').change(function(){
    $('#hour_range_container').css('display','none');
    $('#specific_container').css('display','none');
})
$('#hour_range').change(function(){
    $('#hour_range_container').css('display','block');
    $('#specific_container').css('display','none');
})
$('#specific').change(function(){
    $('#hour_range_container').css('display','none');
    $('#specific_container').css('display','block');
})
$('#download').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.extractData();
});

$('#export_mps_csv').live('click',function(){
    $.exportReport();
})
</script>

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
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>

    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10">
            <select id="participant"  class="input-large">
                <?php
                    foreach ($participants as $p) {
                        echo '<option value="'.$p->participant.'">'.$p->participant.'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Resources</div>
        <div class="span10">
            <select id="unit" class="input-large"></select>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span2">Group</div>
        <div class="span10">
            <select id="group" class="input-large"></select>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span2">Customer</div>
        <div class="span10">
            <select id="customer"  class="input-large"></select>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span2">Billing Period</div>
        <div class="span10">
            <select name="month" id="month" class="input-small">
                <?php
                $billing_start = $def_date_man_start;
                $billing_start = date_parse($billing_start);
                for($x=1;$x<=12;$x++){
                    $time_tmp = mktime (0, 0, 0, $x+1 , 0, 0);
                    $month = date('F',$time_tmp);
                    $sel = (($billing_start['month']) == $x) ? 'selected=selected' : '';
                    echo '<option value="'.$x.'" '.$sel.' >'.$month .'</option>';
                }
                ?>
            </select>
            <select name="year" id="year" class="input-small">
                <?php
                for($x=2006;$x<=date('Y')+5;$x++){
                    $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                    echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                }
                ?>
            </select>
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
    <br>
</div>
<style>
    #result th {
        text-align: center;
        background-color: #F7F7F7;
        min-width: 70px;
    }

    #result td:first-child {
        text-align: center;
    }
    #result td, #result .total th {
        text-align: right;
    }
</style>
<script>
$.extend({
    getResources : function(auto_load_customer) {

        $.post('../bcq/get_resources',{participant:$('#participant').val()},
            function(data){
                if (data.total >= 1) {
                    $('#unit').html('');
                    $.each(data.value, function(i,val){
                        $('#unit').append('<option>'+val.resource_id+'</option>');
                    });
                    return false;
                }


            }
        ).done(function() {
            if (auto_load_customer) {
                $.getGroups(true);
             }
          });
    },
    getGroups : function(initial) {
        $.post('../bcq/get_groups_per_plant_id',{participant:$('#participant').val(),resource:$('#unit').val()},
            function(data){
                if (data.total >= 1) {
                    $('#group').html('');
                    var group_list = [];
                    var total = 0;
                    $.each(data.value, function(i,val){
                        if(val.group !== null && val.group !== ''){
                            $('#group').append('<option value="'+val.group+'">'+val.group+'</option>');
                            group_list.push(val.group);
                            total++;
                        }
                    });
                    if (total > 0) {
                        $('#group').prepend('<option value="'+group_list.join(',')+'">All Groups</option>');
                    }
                    return false;
                }
            }
        ).done(function() {
            if (initial) {
                $.getCustomers(true);
             }
          });
    },
    getCustomers : function(initial) {
        $.post('../bcq/get_customers',{participant:$('#participant').val(),resource:$('#unit').val(), 'group' : $('#group').val()},
            function(data){
                if (data.total >= 1) {
                    $('#customer').html('');
                    var customer_list = [];
                    var total = 0;
                    $.each(data.value, function(i,val){
                        $('#customer').append('<option value="'+val.customer+'">'+val.customer+'</option>');
                        customer_list.push(val.customer);
                        total++;
                    });
                    if (total > 0) {
                        $('#customer').prepend('<option value="'+customer_list.join(',')+'">Aggregate</option>');
                    }
                    return false;
                }
            }
        ).done(function() {
            if (initial) {
                $('#display_btn').trigger('click');
             }
          });
    },
    loadData : function() {
        $("#result").attr('class','alert alert-info').html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $('#display_btn').attr('disabled',true);
        $('#export_btn').attr('disabled',true);

        /** VALIDATION **/
        var errors = [];
        var participant = $.trim($('#participant').val());
        if (participant.length <= 0) {
            errors.push('Please select valid Participant');
        }

        var unit = $.trim($('#unit').val());
        if (unit.length <= 0) {
            errors.push('Please select valid Resource');
        }

        var customer = $.trim($('#customer').val());
        if (customer.length <= 0) {
            errors.push('Please select valid Customer');
        }

        var month = $.trim($('#month').val());
        if (month.length <= 0) {
            errors.push('Please select valid Billing Month');
        }

        var year = $.trim($('#year').val());
        if (year.length <= 0) {
            errors.push('Please select valid Billing Year');
        }

        if (errors.length > 0) {
            $("#result").attr('class','alert alert-warning').html(errors.join('<br>'));
            $('#display_btn').attr('disabled',false);
            $('#export_btn').attr('disabled',true);
        }else {
            $('#display_btn').attr('disabled',false)
            $('#export_btn').attr('disabled',true);
            var parameters = {'month' : month, 'year' : year, 'customer' : customer,resource:$('#unit').val()};
            $.post('../bcq/bcq_report_per_generator_action',parameters,
            function(data){
                var total = parseInt(data.total,10);
                var list = data.value;
                var sdate = data.billing_sdate;
                var edate = data.billing_edate;

                $('#result').html('').attr('class','');
                if (total <= 0 ) {
                    $('#display_btn').attr('disabled',false);
                    $("#result").attr('class','alert alert-info').html('No available records');
                }else {
                    $('#display_btn').attr('disabled',false);
                    $('#export_btn').attr('disabled',false);
                    $("#result").attr('class','alert alert-info').html('Please while we populate data.');
                    var start = new Date(sdate);
                    var end = new Date(edate);
                    var contents = '';
                    var hr_contents = '';
                    var date = '';
                    var start = new Date(sdate);
                    var end = new Date(edate);
                    var date_key = "";
                    var date_obj = null;
                    var total_per_date = {};
                    var akel = 0;
                    $.each(list, function(hr,hr_date_data){
                        start = new Date(sdate);
                        end = new Date(edate);
                        hr_contents = '<tr><td>'+hr+'</td>';
                        while(start <= end){
                            date_key = start.toString("yyyy-MM-dd");
                            if (typeof hr_date_data[date_key] != 'undefined') {
                                date_obj = hr_date_data[date_key];
                                var val = parseFloat(date_obj.declaration);

                                hr_contents+= '<td>'+$.formatNumberToSpecificDecimalPlaces(val,2)+'</td>';

                                if ( typeof total_per_date[date_key] != 'undefined' ) {
                                    var tmp = parseFloat(total_per_date[date_key]);
                                    total_per_date[date_key] = tmp + val;
                                }else {
                                    total_per_date[date_key] = val;
                                }
                            }else {
                                hr_contents+= '<td>&nbsp;</td>';
                            }



                            var newDate = start.setDate(start.getDate() + 1);
                            start = new Date(newDate);
                         }
                         contents+=hr_contents;

                    });

                    // table header
                    var hdr = '<tr><th>Interval</th>';
                    start = new Date(sdate);
                    end = new Date(edate);
                    while(start <= end){
                        date_key = start.toString("yyyy-MM-dd");
                        hdr+='<th>'+date_key+'</th>'
                        var newDate = start.setDate(start.getDate() + 1);
                        start = new Date(newDate);
                     }
                    hdr+='</tr>';

                    // total header
                    var total_hdr = '<tr><th>Interval</th>';
                    var total = 0;
                    start = new Date(sdate);
                    end = new Date(edate);
                    while(start <= end){
                        date_key = start.toString("yyyy-MM-dd");
                        total = 0;
                        if (typeof total_per_date[date_key] != 'undefined') {
                            total = parseFloat(total_per_date[date_key]);
                        }
                        total_hdr+='<th style="text-align:right;">'+$.formatNumberToSpecificDecimalPlaces(total,2)+'</th>'
                        var newDate = start.setDate(start.getDate() + 1);
                        start = new Date(newDate);
                     }
                    total_hdr+='</tr>';
                    $('#result').html('').removeAttr('class','');
                    $('#result').html('<table id="grid" class="table table-bordered table-striped table-condensed">'+hdr+contents+total_hdr+'</table>');
                    $('#result').css('width',$('#global').width()).css('overflow','auto');
                }


            });
        }

    }
    ,exportToFile : function() {
        /** VALIDATION **/
        var errors = [];
        var participant = $.trim($('#participant').val());
        if (participant.length <= 0) {
            errors.push('Please select valid Participant');
        }

        var unit = $.trim($('#unit').val());
        if (unit.length <= 0) {
            errors.push('Please select valid Resource');
        }

        var customer = $.trim($('#customer').val());
        if (customer.length <= 0) {
            errors.push('Please select valid Customer');
        }

        var month = $.trim($('#month').val());
        if (month.length <= 0) {
            errors.push('Please select valid Billing Month');
        }

        var year = $.trim($('#year').val());
        if (year.length <= 0) {
            errors.push('Please select valid Billing Year');
        }

        if (errors.length > 0) {
            $("#result").attr('class','alert alert-warning').html(errors.join('<br>'));
            $('#display_btn').attr('disabled',false);
            $('#export_btn').attr('disabled',true);
        }else {
            var url = 'http://' + location.host + '<?=$base_url?>' + '/bcq/file_bcq_report_per_generator'
            var parameters = "month=" + $('#month').val();
            parameters+= "&year=" + $('#year').val();
            parameters+= '&customer='+$('#customer').val();
            parameters+= '&resource='+$('#unit').val();
            $.download(url,parameters);
        }

    }
})
</script>
<script>
//$.loadData();
$.getResources(true);
$('#participant').change(function(){
    $.getResources(true);
});

$('#unit').change(function(){
    $.getGroups();
});

$('#group').change(function(){
    $.getCustomers();
});

$('#display_btn').unbind().bind('click',function(){
   $.loadData();
});

$('#export_btn').die('click').live('click',function(){
    $.exportToFile();
});
</script>

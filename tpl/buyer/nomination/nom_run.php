<style>
td.text-right, th.text-right { text-align: right;}
th.text-center, td.text-center { text-align: center; }
</style>
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
        <div class="span2">Type</div>
        <div class="span10">
            <select id="nom_type" class="input-small">
                <option id="t_dan">DAN</option>
                <option id="t_wan">WAN</option>
                <option id="t_man">MAN</option>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10"><select id="participant"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Billing Period</div>
        <div class="span10">
            <select name="month" class="input-small" id="month" >
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
            <select name="year" class="input-small" id="year">
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
        <div class="span2"></div>
        <div class="span10">
            <button id="btn_display_records" type="button" class="btn btn-primary">Display</button>
        </div>
    </div>
    <br>
    <div class="row-fluid" id="result"></div>
    <br><br>
</div>

<script type="text/javascript">
$.extend({
    loadData : function () {
     $("#result_loader").html('Please wait  &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
     var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
            var mn = parseInt($('#month').attr('value'),10)-1;
            var end_date = new Date(yr,mn,25);
            var start_date = new Date(yr,mn,26);

            mdate = start_date.add( {months: -1 });
            var loop_date = start_date.clone();
            var hor_date = start_date.clone();
            mdate = mdate.toString("d-MMM-yyyy");
            var trading_date = mdate
            ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
            ,list_html = '';


     var parameters =  {'action':'list', 'date' : cur_selected_date , 'type' : $('#nom_type').val()};
     $.post('../buyer/nom_run_action',parameters,
     function(data){
        data = $.parseJSON(data)
        var html = '<table class="table table-bordered table-condensed table-striped"><tr><th class="theader text-center">Interval</th>';
        while (loop_date<=end_date){
            loop_date_string = loop_date.toString("d-MMM-yyyy");
            html+='<th class="theader text-center">'+loop_date_string+'</th>'
            loop_date = loop_date.add(1).days();
        }
        html+='<th class="theader text-center">Total</th></tr>';
        var totalver = 0,
            total    = 0,
            totalhor = 0;

        $.each(data,function(hour,date){
            html +='<tr><th class="theader text-center">'+hour+'</th>';
            $.each(date,function(i,val){
                if (val == ''){
                    val = 0;
                }
            html+='<td class="theader text-right" >'+$.formatNumberToSpecificDecimalPlaces(val,2)+'</td>';
            totalver+=parseFloat(val);
            total+=parseFloat(val);
            })

            html+='<td class="theader text-right">'+$.formatNumberToSpecificDecimalPlaces(totalver,2)+'</td></tr>';
            totalver = 0;		 			
        })
        html+='<th class="theader text-center">Total</td>';
        while (hor_date<=end_date){
            hor_date_string = hor_date.toString("yyyy-MM-dd");
            $.each(data,function(hour,date){

                totalhor+=parseFloat(date[hor_date_string])	
            })
            hor_date = hor_date.add(1).days();
            if (isNaN(totalhor)){
                totalhor = 0;
            }
            html+='<td class="theader text-right">'+$.formatNumberToSpecificDecimalPlaces(totalhor,2)+'</td>';
            totalhor = 0;
        }		 		
        html+='<td class="theader text-right">'+$.formatNumberToSpecificDecimalPlaces(total,2)+'</td></table>';
        $("#result_loader").html('');

        $("#result").html(html);
     });
    },
    listParticipants : function()
    {
        $.post('../buyer/listParticipants',
        function(data){
            var data = data.split("|")
            $.each(data, function(i,val){
                $('#participant').append('<option>'+val+'</option>')
            })
            $.showContractedCapacity();
        });
    }
});
</script>
<script>
$.listParticipants();
$.loadData();
$('#btn_display_records').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});
</script>
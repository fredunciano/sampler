<style>
    #grid_data th {
        text-align:center !important;
    }
    #grid_data td {
        text-align: right !important;
    }
    #grid_data td:first-child {
        text-align: left !important;
    }
    #grid_data td:nth-child(2) {
        text-align: center !important;
    }
    #grid_data td:nth-child(3) {
        text-align: left !important;
    }


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
    <section id="global">
        <legend><h4><?=$title?> <small>( MMS Data Reports )</small></h4></legend>
        
        <form method="post">
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
            <div class="span2">Hour <br><button id="checkall" class="btn"><i class="icon-ok"></i><span id="btn_text">Uncheck All</span></button></div>
            <div class="span7" id="hour_container">&nbsp;&nbsp;
                <?php
                for($x=1;$x<=24;$x++){
                    echo '
                          <label class="checkbox inline">
                              <input type="checkbox" id="h'.$x.'" name="h'.$x.'" checked>'.$x.'
                          </label>  
                         ';
                }
                ?>
            </div>
        </div><br>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10 input-append input-prepend">
                <input type="text" name="sdate" id="sdate" value="<?=$sdate?>" class="datetext"><span class="add-on">to</span>
                <input type="text" name="edate" id="edate" value="<?=$edate?>" class="datetext">
                <a class="btn btn-primary" href="#" id="show-data"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
                <a class="btn btn-warning" href="#" id="get-latest-bids"><i class="icon-arrow-down icon-white"></i>&nbsp;Get latest Bid from MMS</a>
            </div>
        </div>
        </form>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span7"></div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px"></div>
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
    	
        <table id="list-table-res" class="table table-condensed table-bordered table-striped">
        	
        </table>
    </div>
    <div class="modal-footer">
    	<button id="get_rid" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<script>
$.extend({
    getBids: function(){
        $('#grid_data').html('');
        $("#result").attr('class','alert alert-info');
        
        $("#result").html('Downloading Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../mms_data/rep_latest_bids',{},
            function(data){
                $("#result").html(data);
            });
            return false;
    },
    loadData: function(){
        $('#grid').html('');
        $("#result").attr('class','alert alert-info');
        
        if (!$('#resource_id').val()) {
            $("#result").html('<span style="padding:10px">Please Choose a resource id</span>');
            return false;
        }
        if ($('#hour_container [type="checkbox"]:checked').length <= 0) {
            $("#result").html('<span style="padding:10px">Please Select hour</span>');
            return false;
        }
        
        $("#result").html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        
        var par = $("form").serialize();
        
        $.post('../mms_data/rep_rtem_bids_action',par,
            function(data){
                $("#result").html('');
                //$("#result").html(data);
                //return false;
                if (data.total < 1){
                    $("#result").html('<span style="padding:10px">No Data to Display</span>');
                    $('#export_btns_container').hide();
                } else {
                    $("#result").removeClass('alert');
                    //$.formatData(data);
                    $.createTables(data);
                    $('#export_btns_container').show();
                }
            });
            return false;
    },
    createTables: function (data) {
        $('#result').html('');
        $('#grid').html('');
        $("#result").removeClass('alert');
        //$('#result').append('<table id="grid"></table>');
        var content = '';
        
        $.each(data.value, function(res, val) {
            $.each(val, function(d, date){
                $.each(date, function(i,intervals){
                    var interval1 = (intervals.price1 !== null) ? $.formatNumberCommaSeparated(intervals.price1.toFixed(2)) : '';
                    var interval2 = (intervals.price2 !== null) ? $.formatNumberCommaSeparated(intervals.price2.toFixed(2)) : '';
                    var interval3 = (intervals.price3 !== null) ? $.formatNumberCommaSeparated(intervals.price3.toFixed(2)) : '';
                    var interval4 = (intervals.price4 !== null) ? $.formatNumberCommaSeparated(intervals.price4.toFixed(2)) : '';
                    var interval5 = (intervals.price5 !== null) ? $.formatNumberCommaSeparated(intervals.price5.toFixed(2)) : '';
                    var interval6 = (intervals.price6 !== null) ? $.formatNumberCommaSeparated(intervals.price6.toFixed(2)) : '';
                    var interval7 = (intervals.price7 !== null) ? $.formatNumberCommaSeparated(intervals.price7.toFixed(2)) : '';
                    var interval8 = (intervals.price8 !== null) ? $.formatNumberCommaSeparated(intervals.price8.toFixed(2)) : '';
                    var interval9 = (intervals.price9 !== null) ? $.formatNumberCommaSeparated(intervals.price9.toFixed(2)) : '';
                    var interval10 = (intervals.price10 !== null) ? $.formatNumberCommaSeparated(intervals.price10.toFixed(2)) : '';
                    var interval11 = (intervals.price11 !== null) ? $.formatNumberCommaSeparated(intervals.price11.toFixed(2)) : '';

                    var intervals_qty1 = (intervals.qty1 !== null) ? $.formatNumberCommaSeparated(intervals.qty1.toFixed(2)) : '';
                    var intervals_qty2 = (intervals.qty2 !== null) ? $.formatNumberCommaSeparated(intervals.qty2.toFixed(2)) : '';
                    var intervals_qty3 = (intervals.qty3 !== null) ? $.formatNumberCommaSeparated(intervals.qty3.toFixed(2)) : '';
                    var intervals_qty4 = (intervals.qty4 !== null) ? $.formatNumberCommaSeparated(intervals.qty4.toFixed(2)) : '';
                    var intervals_qty5 = (intervals.qty5 !== null) ? $.formatNumberCommaSeparated(intervals.qty5.toFixed(2)) : '';
                    var intervals_qty6 = (intervals.qty6 !== null) ? $.formatNumberCommaSeparated(intervals.qty6.toFixed(2)) : '';
                    var intervals_qty7 = (intervals.qty7 !== null) ? $.formatNumberCommaSeparated(intervals.qty7.toFixed(2)) : '';
                    var intervals_qty8 = (intervals.qty8 !== null) ? $.formatNumberCommaSeparated(intervals.qty8.toFixed(2)) : '';
                    var intervals_qty9 = (intervals.qty9 !== null) ? $.formatNumberCommaSeparated(intervals.qty9.toFixed(2)) : '';
                    var intervals_qty10 = (intervals.qty10 !== null) ? $.formatNumberCommaSeparated(intervals.qty10.toFixed(2)) : '';
                    var intervals_qty11 = (intervals.qty11 !== null) ? $.formatNumberCommaSeparated(intervals.qty11.toFixed(2)) : '';
                    
                    var intervals_rr_up1 = (intervals.rr_up1 !== null) ? $.formatNumberCommaSeparated(intervals.rr_up1.toFixed(2)) : '';
                    var intervals_rr_up2 = (intervals.rr_up2 !== null) ? $.formatNumberCommaSeparated(intervals.rr_up2.toFixed(2)) : '';
                    var intervals_rr_up3 = (intervals.rr_up3 !== null) ? $.formatNumberCommaSeparated(intervals.rr_up3.toFixed(2)) : '';
                    var intervals_rr_up4 = (intervals.rr_up4 !== null) ? $.formatNumberCommaSeparated(intervals.rr_up4.toFixed(2)) : '';
                    var intervals_rr_up5 = (intervals.rr_up5 !== null) ? $.formatNumberCommaSeparated(intervals.rr_up5.toFixed(2)) : '';
                    var intervals_rr_up6 = (intervals.rr_up6 !== null) ? $.formatNumberCommaSeparated(intervals.rr_up6.toFixed(2)): '';

                    var intervals_rr_down1 = (intervals.rr_down1 !== null) ? $.formatNumberCommaSeparated(intervals.rr_down1.toFixed(2)) : '';
                    var intervals_rr_down2 = (intervals.rr_down2 !== null) ? $.formatNumberCommaSeparated(intervals.rr_down2.toFixed(2)) : '';
                    var intervals_rr_down3 = (intervals.rr_down3 !== null) ? $.formatNumberCommaSeparated(intervals.rr_down3.toFixed(2)) : '';
                    var intervals_rr_down4 = (intervals.rr_down4 !== null) ? $.formatNumberCommaSeparated(intervals.rr_down4.toFixed(2)) : '';
                    var intervals_rr_down5 = (intervals.rr_down5 !== null) ? $.formatNumberCommaSeparated(intervals.rr_down5.toFixed(2)) : '';
                    var intervals_rr_down6 = (intervals.rr_down6 !== null) ? $.formatNumberCommaSeparated(intervals.rr_down6.toFixed(2)) : '';

                    var intervals_rr_bp1 = (intervals.rr_bp1 !== null) ? $.formatNumberCommaSeparated(intervals.rr_bp1.toFixed(2)) : '';
                    var intervals_rr_bp2 = (intervals.rr_bp2 !== null) ? $.formatNumberCommaSeparated(intervals.rr_bp2.toFixed(2)) : '';
                    var intervals_rr_bp3 = (intervals.rr_bp3 !== null) ? $.formatNumberCommaSeparated(intervals.rr_bp3.toFixed(2)) : '';
                    var intervals_rr_bp4 = (intervals.rr_bp4 !== null) ? $.formatNumberCommaSeparated(intervals.rr_bp4.toFixed(2)) : '';
                    var intervals_rr_bp5 = (intervals.rr_bp5 !== null) ? $.formatNumberCommaSeparated(intervals.rr_bp5.toFixed(2)) : '';
                    var intervals_rr_bp6 = (intervals.rr_bp6 !== null) ? $.formatNumberCommaSeparated(intervals.rr_bp6.toFixed(2)) : '';

                    content+='<tr><td>'+d+'</td><td>'+i+'</td><td>'+res+'</td>';

                    content+='<td>'+interval1+'</td><td>'+intervals_qty1+'</td>';
                    content+='<td>'+interval2+'</td><td>'+intervals_qty2+'</td>';
                    content+='<td>'+interval3+'</td><td>'+intervals_qty3+'</td>';
                    content+='<td>'+interval4+'</td><td>'+intervals_qty4+'</td>';
                    content+='<td>'+interval5+'</td><td>'+intervals_qty5+'</td>';
                    content+='<td>'+interval6+'</td><td>'+intervals_qty6+'</td>';
                    content+='<td>'+interval7+'</td><td>'+intervals_qty7+'</td>';
                    content+='<td>'+interval8+'</td><td>'+intervals_qty8+'</td>';
                    content+='<td>'+interval9+'</td><td>'+intervals_qty9+'</td>';
                    content+='<td>'+interval10+'</td><td>'+intervals_qty10+'</td>';
                    content+='<td>'+interval11+'</td><td>'+intervals_qty11+'</td>';
                    content+='<td>'+intervals_rr_up1+'</td><td>'+intervals_rr_down1+'</td><td>'+intervals_rr_bp1+'</td>';
                    content+='<td>'+intervals_rr_up2+'</td><td>'+intervals_rr_down2+'</td><td>'+intervals_rr_bp2+'</td>';
                    content+='<td>'+intervals_rr_up3+'</td><td>'+intervals_rr_down3+'</td><td>'+intervals_rr_bp3+'</td>';
                    content+='<td>'+intervals_rr_up4+'</td><td>'+intervals_rr_down4+'</td><td>'+intervals_rr_bp4+'</td>';
                    content+='<td>'+intervals_rr_up5+'</td><td>'+intervals_rr_down5+'</td><td>'+intervals_rr_bp5+'</td>';
                    content+='<td>'+intervals_rr_up6+'</td><td>'+intervals_rr_down6+'</td><td>'+intervals_rr_bp6+'</td>';
                    content+='<td>'+intervals.reason+'</td>';
                    content+='</tr>';
                })
            }) 
        })

        var html='<tr><th>&nbsp;&nbsp;&nbsp;&nbsp;Del&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;'+
                 '</th><th>Del&nbsp;Hour</th><th>Res&nbsp;ID</th>'+
                 '<th>P1</th><th>Q1</th><th>P2</th><th>Q2</th><th>P3</th><th>Q3</th>'+
                 '<th>P4</th><th>Q4</th><th>P5</th><th>Q5</th><th>P6</th><th>Q6</th>'+
                 '<th>P7</th><th>Q7</th><th>P8</th><th>Q8</th><th>P9</th><th>P9</th>'+
                 '<th>P10</th><th>Q10</th><th>P11</th><th>Q11</th>'+
                 '<td>rr_up1</td><td>rr_down1</td><td>rr_breakpoint1</td>'+
                 '<td>rr_up2</td><td>rr_down2</td><td>rr_breakpoint2</td>'+
                 '<td>rr_up3</td><td>rr_down3</td><td>rr_breakpoint3</td>'+
                 '<td>rr_up4</td><td>rr_down4</td><td>rr_breakpoint4</td>'+
                 '<td>rr_up5</td><td>rr_down5</td><td>rr_breakpoint5</td>'+
                 '<td>rr_up6</td><td>rr_down6</td><td>rr_breakpoint6</td>'+
                 '<td>reason&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                 +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                 +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                 +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                 +'</td></tr>';
        html+=content;
        
        $('#grid_data').html('<table id="grid" class="table table-bordered table-condensed table-striped"></table>');
        
        $('#grid').html(html);
        
        $('#grid_data').append('&nbsp;<button id="btn_export_csv" class="btn btn-success">Export CSV</button>');
        $('#grid_data').append('&nbsp;<button id="btn_export_xls" class="btn btn-success">Export XLS</button>');
    }

    ,exportData : function(type){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_rtem_bids'
        var parameters = "sdate=" + $('#sdate').val();
        parameters+= "&edate=" + $('#edate').val();
        parameters+= "&resource_id=" + $('#resource_id').val();

        for (var i=1;i<=24;i++){
            if ( typeof $('#h'+ i +':checked').val() != 'undefined' ) {
                parameters+= '&h'+ i +'=on';
            }
        }
        parameters+= '&type='+type;
        $.download(url,parameters);
    }
})
</script>
<script>
$('#sdate, #edate').datepicker();    
$.loadData();
$('#show-data').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

$('#get-latest-bids').unbind('click').bind('click',function(e){
    e.preventDefault()
    $.getBids();
});

$("#but_clear").unbind('click').bind('click',function(e){
    e.preventDefault();
    $("input[type=checkbox]").each(function(index){
        $(this).attr('checked',false)
    })
    return false;
})
$("#but_checkall").unbind('click').bind('click',function(e){
    e.preventDefault();
    $("input[type=checkbox]").each(function(index){
        $(this).attr('checked','')
    })
    return false;
})

$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
   
    $.post('../mms_data/rep_show_own_resource',{},
        function(data){
            if (data.total >= 1) { 
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;	
                    html+='<td id="r_id"><label class="checkbox"><input type="checkbox" name="r_id[]" value="'+val.resource_id+'">'+val.resource_id+'</label></td>';
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
    $.exportData('CSV');
});

$('#btn_export_xls').die('click').live('click',function(){
    $.exportData('XLS');
});

$('#checkall').toggle(
    function() {
        $('input[type="checkbox"]').attr('checked',false);
        $('#btn_text').text('Check All')
    },
    function() {
        $('input[type="checkbox"]').attr('checked',true);
        $('#btn_text').text('Uncheck All')
    }
);
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
$('#get_rid').click(function(){
	$('#resource_id').val('');
	var arr_res_id = Array();
    $("#r_id input[type=checkbox]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#resource_id').val( arr_res_id.join( ","));
});
</script>
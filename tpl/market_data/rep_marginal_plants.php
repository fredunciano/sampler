<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/datatables.css">
<style>
    .right-align {
        text-align:right !important;
    }
    .center-align {
        text-align:center !important;
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
            <div class="span2">Report</div>
            <div class="span7">
                <select id="report" name="report_type">
                    <option value="RTD">Real Time Ex-Ante (RTD)</option>
                    <option value="RTX">Real Time Ex-Post (RTX)</option>
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
            <div class="span2">Date</div>
            <div class="span7 input-append">
                <input type="text" id="datepicker" name="date" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px"></div>    
		<div style="margin-left:20px; margin-top:10px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn btn-success">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn btn-success">Export to CSV</button>
        </div>
        </form>
    </section>
    <br><br><br><br>
</div>

<script>
$.extend({
    loadData : function () {
        $("#grid_data").html('');
        $("#result").attr('class','alert alert-info');
        $("#result").html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $('#export_btns_container').hide();
        
	    $.post('../market_data/rep_mrgl_plants_action',{date:$('#datepicker').val(),
            region:$('#region').val(),report:$('#report').val()},
            function(data){
                //$('#result').html(data);
                //return false;
                var html='';
                $("#result").html('');
                if (data.total < 1){
                    
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    $('#export_btns_container').hide();
                    
                } else {
                    
                    $("#result").removeClass('alert alert-info');
                    $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed table-hover" id="mp_data">');
                    $('#mp_data').dataTable({

                        "aoColumns": [
                            { "sTitle": "Interval","sClass" : "center-align" },
                            { "sTitle": "Marginal Plants" },
                            { "sTitle": "Price","sClass" : "right-align" }
                        ]
                    });
                    
                    $.each(data.value,function(i,val){
                        $('#mp_data').dataTable().fnAddData([val.hour,val.mp,$.formatNumberToSpecificDecimalPlaces(val.mcp,4)]);
                    });
                    
                    $('#export_btns_container').show();
                    $("#mp_data thead tr th").css("text-align", "center");
                    $("#mp_data tbody tr td:nth-child(1)").css("text-align", "center");
                    $("#mp_data tbody tr td:nth-child(3)").css("text-align", "right");
                    
                }
                return false;
            });
    }
    ,exportData : function(type){
        var url = '../market_data/file_rep_mrgl_plants'
        var parameters = "date=" + $('#datepicker').val();
        parameters+= "&region=" + $('#region').val();
        parameters+= '&report='+$('#report').val();
        parameters+= '&type='+type;
        $.download(url,parameters);
    }
})
</script>
<script>
$('#datepicker').datepicker();
$.loadData();    
$('a.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

$("#but_clear").unbind('click').bind('click',function(){
    $("input[type=checkbox]").each(function(index){
        $(this).attr('checked',false)
    })
    return false;
})
$("#but_checkall").unbind('click').bind('click',function(){
    $("input[type=checkbox]").each(function(index){
        $(this).attr('checked','')
    })
    return false;
})

$('#btn_export_csv').unbind('click').bind('click',function(){
    $.exportData('CSV');
});

$('#btn_export_xls').unbind('click').bind('click',function(){
    $.exportData('XLS');
});
</script>
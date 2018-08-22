<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/datatables.css">
<style>
th.dt-center, td.dt-center { text-align: center; }
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
               <select id="report_type" name="report_type">
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
            <div class="span2">Hour</div>
            <div class="span7">
                <select multiple="multiple" id="hour" name="hour[]" class="input-small">
                    <?php
                    for($x=1;$x<=24;$x++){
                        echo '<option>'.$x.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span7 input-append input-prepend">
                <input type="text" id="sdate" name="sdate" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span>
                <input type="text" id="edate" name="edate" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px">
            
        </div>    
		<div style="margin-left:20px; margin-top:10px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn">Export to XLS</button>
            <button id="btn_export_csv" type="button" class="btn">Export to CSV</button>
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
        var par = $("form").serialize();
	$.post('../market_data/rep_mrgl_plant_count_action',par,
            function(data){
                //$('#result').html(data);
                //return false;
                var html='';
                $("#result").html('');
                if (data.total < 1){
                    $("#result").html(data.message);
                } else {
                    var ctr = 0;
                    $("#result").removeClass('alert alert-info');
                    $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed table-hover" id="mp_count_data">');
                    var odata = [];
                    var temp_data = [];

                    $.each(data.value,function(i,val){
                        temp_data = [val.hour,val.count,val.resource_id];
                        odata.push(temp_data);
                    });

                    $('#mp_count_data').dataTable({
                        "aaData": odata,
                        "aoColumns": [
                            { "sTitle": "Interval", "sClass": "dt-center"  },
                            { "sTitle": "Count", "sClass": "dt-center"  },
                            { "sTitle": "Resource" }
                        ]
                    });

                    $("#mp_count_data thead tr th").css("text-align", "center");
                    
                }
                return false;
            });
    }
})
</script>
<script>
$('#sdate, #edate').datepicker();    
$.loadData();    
$('.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

</script>
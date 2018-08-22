<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/datatables.css">
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
            <div class="span2">Source</div>
            <div class="span7">
                <select id="source" name="source" class="input-medium">
                    <option value="1">LWAP</option>
                    <option value="2">Corrected LWAP</option>
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
        <div id="grid_data" class="container" style="margin-top:10px;overflow:scroll;width:1024px;height:300px">

        </div>
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
        var par = $("form").serialize();
        $.post('../market_data/rep_lwap_action',par,
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").html(data.message);
                    return false;
                } else {
                    $("#result").removeClass('alert');
                    $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="dem_lwap_data">');
                    $('#dem_lwap_data').dataTable({

                        "aoColumns": [
                            { "sTitle": "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDate&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" },
                            { "sTitle": "Type" },
                            { "sTitle": "H1" },
                            { "sTitle": "H2" },
                            { "sTitle": "H3" },
                            { "sTitle": "H4" },
                            { "sTitle": "H5" },
                            { "sTitle": "H6" },
                            { "sTitle": "H7" },
                            { "sTitle": "H8" },
                            { "sTitle": "H9" },
                            { "sTitle": "H10" },
                            { "sTitle": "H11" },
                            { "sTitle": "H12" },
                            { "sTitle": "H13" },
                            { "sTitle": "H14" },
                            { "sTitle": "H15" },
                            { "sTitle": "H16" },
                            { "sTitle": "H17" },
                            { "sTitle": "H18" },
                            { "sTitle": "H19" },
                            { "sTitle": "H20" },
                            { "sTitle": "H21" },
                            { "sTitle": "H22" },
                            { "sTitle": "H23" },
                            { "sTitle": "H24" }
                        ]
                    });

                    $.each(data.value, function (date, val1){

                        var rtd = date + '|RTD|';
                        var rtx = date + '|RTX|';
                        var dap = date + '|DAP|';

                        for(var i=1;i<=24;i++){
                            var val = val1[i];
                            if (typeof val != 'undefined') {
                                rtd+= $.formatNumberToSpecificDecimalPlaces(val.rtd,4)+'|';
                                rtx+=$.formatNumberToSpecificDecimalPlaces(val.rtx,4)+'|';
                                dap+=$.formatNumberToSpecificDecimalPlaces(val.dap,4)+'|';
                            }else {
                                rtd+= '|';
                                rtx+='|';
                                dap+='|';
                            }
                        }
                        /*
                        $.each(val1, function (hour, val){
                            rtd+= val.rtd+',';
                            rtx+=val.rtx+',';
                            dap+=val.dap+',';
                        })*/

                        rtd_arr = rtd.split('|');
                        rtx_arr = rtx.split('|');
                        dap_arr = dap.split('|');
                        console.log(rtd_arr)
                        $('#dem_lwap_data').dataTable().fnAddData(rtd_arr);
                        $('#dem_lwap_data').dataTable().fnAddData(rtx_arr);
                        $('#dem_lwap_data').dataTable().fnAddData(dap_arr);
                    })
                    $('#export_btns_container').show();
                    $("#dem_lwap_data thead tr th").css("text-align", "center");
                    $("#dem_lwap_data tbody tr td").css("text-align", "right");
                    $("#dem_lwap_data tbody tr td:nth-child(1)").css("text-align", "center");
                    $("#dem_lwap_data tbody tr td:nth-child(2)").css("text-align", "center");

                }
                return false;
            });
    }
    ,exportData : function(export_type){
        var url = '../market_data/file_rep_lwap'
        var parameters = "sdate=" + $('#sdate').val();
        parameters+= "&edate=" + $('#edate').val();
        parameters+= "&source=" + $('#source').val();
        parameters+= "&region=" + $('#region').val();
        parameters+= '&export_type='+export_type;
        $.download(url,parameters);
    }
})
</script>
<script>
$('#sdate').datepicker();
$('#edate').datepicker();
$.loadData();

$('a.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});

$('#btn_export_csv').unbind('click').bind('click',function(){
    $.exportData('CSV');
});

$('#btn_export_xls').unbind('click').bind('click',function(){
    $.exportData('XLS');
});

</script>

<style>
    #grid tr th {
        text-align: center;
    }

    #grid tr td {
        text-align: right;
    }

    #grid tr td:nth-child(1) {
        text-align: left;
    }

    #grid tr td.resources_ids {
        text-align: left;
    }

    #grid tr td.resources_types {
        text-align: left;
    }

    #grid tr td.resources_average {
        text-align: center;
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
        <div class="row-fluid">
            <div class="span2">Region</div>
            <div class="span7">
                <select id="region" class="input-medium">
                    <?php
                    foreach ($region as $r) {
                        echo '<option>'.$r->region.'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Type</div>
            <div class="span7">
                <select id="type" class="input-small">
                    <option value="GEN">GEN</option>
                    <option value="LD">LOAD</option>
                </select>
            </div>
        </div>
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
            <div class="span2">Date</div>
            <div class="span10 input-append input-prepend">
                <input type="text" name="sdate" id="sdate" value="<?=$sdate?>" class="input-small"><span class="add-on">to</span>
                <input type="text" name="edate" id="edate" value="<?=$edate?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <a class="btn btn-success btn-download" href="#" id="download_rtd_prices"><i class="icon-arrow-down icon-white"></i>Download RTD Prices</a>
                <a class="btn btn-success btn-download" href="#" id="download_rtx_prices"><i class="icon-arrow-down icon-white"></i>Download RTX Prices</a>
                <br><br>
                <span id="download_lmp_status"></span>
            </div>
        </div>
        <hr>
        <input type="hidden" id="rtd_hour" value="<?=$current_interval?>">
        <input type="hidden" id="rtx_hour" value="<?=($current_interval-1)?>">
        <input type="hidden" id="date" value="<?=date('Ymd')?>">
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top:10px;"></div>
    </section>
    <br><br><br><br>
</div>
<div class="modal fade in" id="modal_resource" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Choose a Resource ID</h4>
    </div>
    <div class="modal-body">
        <table id="list-table-res" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
    	<button id="get_rid" class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    loadData: function(){
        $('#grid').html('')
        $("#result").attr('class','alert alert-info');
        $('#result').show('fast')
        $('#grid_data').hide();

        // validation
        var errors = [];

        var sdate = $.trim($('input[name=sdate]').val());
        var edate = $.trim($('input[name=edate]').val());

        if ( sdate.length <= 0  ) {
            errors.push('Please select valid start date');
        }
        if ( edate.length <= 0  ) {
            errors.push('Please select valid end date');
        } 

        if (!$('#resource_id').val()) {
            errors.push('Please Choose a resource id');
        }

        if ( sdate.length > 0 && edate.length > 0  ) {
            var sdate_obj = Date.parse(sdate);
            var edate_obj = Date.parse(edate);
            if (edate_obj < sdate_obj) {
                errors.push('Invalid date range');
            }
        }
        if (errors.length > 0) {
            $("#grid_data").html('');
            $("#result").attr('style','padding:10px').html(errors.join('<br>'));
        } else {
            $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
            $.post('../mms_data/rep_lmp_action',{sdate:$('#sdate').val(),edate:$('#edate').val(),
                resource_id:$('#resource_id').val()},
                function(data){
                    $("#result").html('');
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                    } else {
                        $("#result").removeClass('alert alert-info');
                        $.formatData(data);
                        $('#grid_data').show();
                    }
                });
                return false;
        }
    },
    createGraph: function(rtd_data, rtx_data, title, resource_id){
        RTD.chart = new Highcharts.Chart({
            chart: {
                renderTo: 'result',
                type: 'spline',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                exporting: 'enabled',
                buttons : 'exporting.buttons',
                height:250
            },
            title: {
                text: title
            },
            subtitle: {
                text: resource_id
            },
            xAxis: [{
                categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                             'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24']
            }],
            yAxis: [{
                labels: {
                    formatter: function() {
                            return this.value ;
                    },
                    style: {
                            color: '#4572A7'
                    }
                },
                title: {
                    text: 'Price',
                    style: {
                            color: '#4572A7'
                    }
                }
            }],
            tooltip: {
                    shared: true
            },
            series:
                    [{
                    id:'rtd',
                    name: 'RTD',
                    type: 'spline',
                    color: '#76C12F',
                    data:
                            rtd_data
            },{
                    id:'rtx',
                    name: 'RTX',
                    color: '#949B9C',
                    type: 'spline',
                    //yAxis: 1,
                    data:
                            rtx_data
            }]

        });

        return false;
    },
    createTables: function (data) {
        var series=[];
        var obj = {};
        var content;
        var total_html;
        var total_rtd={};
        var total_rtx={};
        var total_rtd_html;
        var total_rtx_html;
        var total_rtd_cnt=[];
        var total_rtx_cnt=[];
        var x = 0;

        $.each(data.value, function(i, val) {
            x++;
            var bg = (x%2) ? '#DEECFF' : '#F7FBFF';
            $.each(val, function(i1, val2) {
                var rtd_content;
                var rtx_content;
                content+='<tr class="rtd" style="background-color:'+bg+'"><td>'+i+'</td><td rowspan="2" style="vertical-align:middle"><b>'+i1+'</b></td><td class="resources_types">RTD</td>';
                for(x=1;x<=24;x++) {

                    if (typeof val2[x] !== 'undefined') {
                        rtd_price_int = val2[x].rtd_price;
                        rtx_price_int = val2[x].rtx_price;
                    } else {
                        rtd_price_int = 0;
                        rtx_price_int = 0;
                    }

                    //rtd_price = $.formatNumber(rtd_price_int, options);
                    //rtx_price = $.formatNumber(rtx_price_int, options);

                    rtd_price = rtd_price_int
                    rtx_price = rtx_price_int

                    rtd_content+= '<td>'+$.formatNumberToSpecificDecimalPlaces(rtd_price,2)+'</td>';
                    if ( total_rtd[x] ) {
                            total_rtd[x] = rtd_price_int + total_rtd[x];
                            total_rtd_cnt[x]++;
                    } else {
                            total_rtd[x] = rtd_price_int;
                            total_rtd_cnt[x] = 1;
                    }

                    if ( total_rtx[x] ) {
                            total_rtx[x] = rtx_price_int + total_rtx[x];
                            total_rtx_cnt[x]++;
                    } else {
                            total_rtx[x] = rtx_price_int
                            total_rtx_cnt[x] = 1;
                    }
                    rtx_content+= '<td>'+$.formatNumberToSpecificDecimalPlaces(rtx_price,2)+'</td>';
                }

                content+=rtd_content;
                content+='</tr><tr class="rtx" style="background-color:'+bg+'"><td>'+i+'</td><td class="resources_types">RTX</td>';
                content+=rtx_content;
                content+='</tr>';
            })
        })

        var html = '<tr><th>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspDate&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th><th>Resource ID</th><th>Type</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
        var total = '<tr class="rtd"><td class="resources_average" rowspan="2" colspan="2" style="vertical-align:middle"><b>Average</b></td><td class="resources_ids">RTD</td>';

        $.each(total_rtd,function(i, val){
            var avg = val / total_rtd_cnt[i]
            total_rtd_html+= '<td>'+avg.toFixed(2)+'</td>';
        })

        $.each(total_rtx,function(i, val){
            var avg = val / total_rtx_cnt[i]
            //avg.toFixed(2);
            total_rtx_html+= '<td>'+avg.toFixed(2)+'</td>';
        })
        total+=total_rtd_html;
        total+='</tr><tr class="rtx"><td>RTX</td>';
        total+=total_rtx_html;
        total+='</tr>';

        $('#grid_data').html('<div style="overflow:auto;margin-bottom:3px;width:1024px;max-height:300px;"><table id="grid" class="table table-bordered table-condensed"></table></div>');

        $("#grid").html(html)
        $("#grid").append(content)

        $('#grid_data').append('&nbsp;<button id="btn_export_csv" class="btn btn-success">Export CSV</button>');
        $('#grid_data').append('&nbsp;<button id="btn_export_xls" class="btn btn-success">Export XLS</button>');

        var resource = $("#resource_id").val().split(',');
        var res_cnt = 0;
        $.each(resource, function(i,val){
            if (val) {
                res_cnt++;
            }
        })
        if (res_cnt >= 2 || !res_cnt || data.total > 1) {
            $("#grid").append(total)
        }
    },
    formatData: function (data){
        var rtd_data=[];
        var rtx_data=[];
        var obj = {};
        var resource_id;
        var resource_id_cnt = 0;

        $.each(data.value, function(i, val) {
            $.each(val, function(i1, val1) {
                var name = i1;
                $.each(val1, function(index,d){
                    rtd_data.push(['RTD',val1[index].rtd_price])
                    rtx_data.push(['RTX',val1[index].rtx_price])
                });
                resource_id = i1;
                resource_id_cnt++;
            })
        })

        $.createGraph(rtd_data, rtx_data, 'Locational Marginal Prices' ,resource_id);
        $.createTables(data);
        if (resource_id_cnt > 1){
            $('#result').hide('fast')
        } else {
            $('#result').show('fast')
        }
        return false;
    }
})
</script>
<script>
RTD = {
    chart : null,
    series : []
};
$('#sdate, #edate').datepicker();
$.loadData();
$('a.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});
$("#show_resources").unbind('click').bind('click',function(e){
    e.preventDefault();
    $('#list-table-res').html('Please wait...')
    $.post('../mms_data/rep_show_resource',{region:$('#region').val(),type:$('#type').val()},
        function(data){
            if (data.total >= 1) {
                var resource;
                var html;
                var x=0;
                html = '<tr>';
                $.each(data.value, function(i, val) {
                    x++;
                    html+='<td id='+val+'><label class="checkbox"><input type="checkbox" id="r_id" name="r_id[]" value="'+val+'">'+val+'</label></td>';
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
    var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_lmp'
    var parameters = "sdate=" + $('#sdate').val();
    parameters+= "&edate=" + $('#edate').val();
    parameters+= '&resource_id='+$('#resource_id').val();
    parameters+= '&type=CSV';
    $.download(url,parameters);
});


$('#btn_export_xls').die('click').live('click',function(){
    var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_lmp'
    var parameters = "sdate=" + $('#sdate').val();
    parameters+= "&edate=" + $('#edate').val();
    parameters+= '&resource_id='+$('#resource_id').val();
    parameters+= '&type=XLS';
    $.download(url,parameters);
});
$('#get_rid').click(function(){
	$('#resource_id').val('');
	var arr_res_id = Array();
    $("input[type=checkbox]:checked").each(function() {
       arr_res_id.push($(this).val());
    });
   	$('#resource_id').val( arr_res_id.join( ","));
});

$('#download_rtd_prices').unbind('click').bind('click', function(e){
    e.preventDefault();

    if ($(this).attr('disabled')) {
        return false;
    }
    $('.btn').attr('disabled','disabled');
    $('#download_lmp_status').html('Status : Downloading Prices&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
    $.post('../mms_data/man_dl_rtd_prices_action',{date:$('#date').val(),hour:$('#rtd_hour').val()},
        function(data){
            $('#download_lmp_status').html(data)
            $('.btn').removeAttr('disabled');
        });
})

$('#download_rtx_prices').unbind('click').bind('click', function(e){
    e.preventDefault();

    if ($(this).attr('disabled')) {
        return false;
    }
    $('.btn').attr('disabled','disabled');
    $('#download_lmp_status').html('Status : Downloading Prices&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
    $.post('../mms_data/man_dl_rtx_prices_action',{date:$('#date').val(),hour:$('#rtx_hour').val()},
        function(data){
            $('#download_lmp_status').html(data)
            $('.btn').removeAttr('disabled');
        });
})
</script>

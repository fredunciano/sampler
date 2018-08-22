<style>
    #dap_manager_tb tr th {
        text-align: center;
    }

    #dap_manager_tb tr td {
        text-align: right;
    }

    #dap_manager_tb tr td:nth-child(1) {
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
                <input type="text" name="resource_id" id="resource_id" class="input-medium" 
                       data-mode="multiple" data-provide="typeahead" 
                       data-source="[&quot;Catsd&quot;,&quot;Dogs&quot;,&quot;Mass Hysteria&quot;]" >
                <a href="#modal_resource" role="button" data-toggle="modal" id="show_resources"><i class="icon-th"></i></a>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="span10 input-append">
                <input type="text" name="date" id="datepicker" value="<?=$date?>" class="input-small">
                <a class="btn btn-primary" href="#"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
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
        <table id="list-table-res" class="table table-condensed table-bordered table-striped"></table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<div id="list-resources" style="display:none;padding:0">
<table id="list-table-res"></table>
</div>
<script>
$.extend({
    loadData: function(){
        $('#grid').html('')
        $('#result').show('fast')
        $("#result").attr('class','alert alert-info');
        
        if (!$('#resource_id').val()) {
            $("#result").html('<span style="padding:10px">Please Choose a resource id</span>');
            return false;
        }
        
        $("#result").html('Creating Chart &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../mms_data/rep_dap_manager_action',{date:$('#datepicker').val(),
                resource_id:$('#resource_id').val()},
            function(data){
                $("#result").html('');
                if (data.total < 1){
                    $("#result").append('<span style="padding:10px">No Data to Display</span>');
                } else {
                    if (data.total < 1){
                        $("#result").append('<span style="padding:10px">No Data to Display</span>');
                        $('#export_btns_container').hide();
                    } else {
                        $("#result").removeClass('alert');
                        //$.formatData(data);
                        $('#export_btns_container').show();
                        
                        var date = $('#datepicker').val()
                        var curr_date = new Date(Date.parse(date))  
                        var date_d1 = curr_date.setDate(curr_date.getDate()-1)
                        date_d1 = curr_date.setMonth(curr_date.getMonth()+1)
                        date_d1 = new Date(date_d1)  
                        var day = ('0' + date_d1.getDate()).slice(-2)
                        var month = ('0' + date_d1.getMonth()).slice(-2)
                        date_d1 = month + '-' + day + '-' + date_d1.getFullYear()


                        $("#result").removeClass('alert alert-info');
                        $('#result').html('<table id="dap_manager_tb" class="table table-bordered table-condensed"></table>');

                        var deldate_h = '<tr><th>Delivery&nbsp;Date</th>';
                        for(x=1;x<=9;x++){
                            deldate_h+='<th colspan="2">'+date.replace(/\//g, '-')+'</th>';
                        }

                        deldate_h+='</tr>';

                        var interval_h = '<tr><th>Interval</th>';

                        for(x=1;x<=9;x++){
                            interval_h+='<th>Price</th><th>SCHD</th>';
                        }
                        interval_h+='</tr>';

                        var dateposted_h = '';
                        var content_h ='';

                        $.each(data.value, function(i,val){

                            content_h+='<tr><td>'+i+'</td>'
                            dateposted_h = '<tr><th>Date&nbsp;Posted</th>';
                            $.each(val, function(i2,c){
                                content_h+='<td>'+$.formatNumberToSpecificDecimalPlaces(c.price,2)+'</td><td>'+$.formatNumberToSpecificDecimalPlaces(c.mw,2)+'</td>';
                                dateposted_h+='<th colspan="2">'+i2+'</th>';
                            })
                            dateposted_h+='</tr>';
                            content_h+='</tr>'

                        })


                        $('#dap_manager_tb').append(deldate_h)
                        $('#dap_manager_tb').append(dateposted_h)
                        $('#dap_manager_tb').append(interval_h)
                        $('#dap_manager_tb').append(content_h)
                        /*if (data.total < 1){
                            $("#result").append('<span style="padding:10px">No Data to Display</span>');
                            $('#export_btns_container').hide();
                        } else {
                            $.formatData(data);
                            $('#export_btns_container').show();
                        }*/
                    }
                    
                    $('#result').append('&nbsp;<button id="btn_export_csv" class="btn btn-success">Export CSV</button>');
                    $('#result').append('&nbsp;<button id="btn_export_xls" class="btn btn-success">Export XLS</button>');
                }
                
                
            });
            return false;
    },
    createGraph: function(price_data, mw_data, title, resource_id){
        chart = new Highcharts.Chart({
            chart: {
                    renderTo: 'result',
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
                    categories: ['0','H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
                                'H13', 'H14', 'H15', 'H16', 'H17', 'H18', 'H19', 'H20', 'H21', 'H22', 'H23', 'H24'],
                    tickPixelInterval:50,
                    gridLineWidth: 1
            }],
            yAxis: [{
                    labels: {
                            formatter: function() {
                                    return this.value +'mw';
                            },
                            style: {
                                    color: '#4572A7'
                            }
                    },
                    title: {
                            text: 'MW',
                            style: {
                                    color: '#4572A7'
                            }
                    }
            }, { 
                    gridLineWidth: 0,
                    title: {
                            text: 'Price',
                            style: {
                                    color: '#76C12F'
                            }
                    },
                    labels: {
                            formatter: function() {
                                    return this.value;
                            },
                            style: {
                                    color: '#76C12F'
                            }
                    },
                    opposite: true

            }],
            tooltip: {
                    shared: true

            },
            series: [{
                    name: 'MW',
                    type: 'spline',
                    color: '#4572A7',
                    data: 
                            mw_data
            }, {
                    name: 'Price',
                    color: '#76C12F',
                    type: 'spline',
                    yAxis: 1,
                    data: 
                            price_data
            }]
        });

        return false;
    },
    createTables: function (data) {
        var series=[];
        var obj = {};
        var content;

        var total_price={};
        var total_mw={};
        var total_price_html;
        var total_mw_html;
        var total_price_cnt=[];
        var total_mw_cnt=[];
        var source_time;
        $.each(data.value, function(i, val) {
            var price_content='';
            var mw_content='';

            content+='<tr><td rowspan=2 style="vertical-align:middle"><b>'+i+'</b></td><td>PR</td>';
            $.each(val, function(index,data){
                source_time = data.date_posted;
                price_content+= '<td>'+data.price+'</td>';
                if ( total_price[index] ) {
                        total_price[index] = data.price + total_price[index];
                        total_price_cnt[index]++;
                } else {
                        total_price[index] = data.price;
                        total_price_cnt[index] = 1;	
                }

                mw_content+= '<td>'+data.mw+'</td>';
                if ( total_mw[index] ) {
                        total_mw[index] = data.mw + total_mw[index];
                        total_mw_cnt[index]++;
                } else {
                        total_mw[index] = data.mw
                        total_mw_cnt[index] = 1;
                }
            });

            content+=price_content;
            content+='</tr><tr class="mw"><td>SCHD</td>';
            content+=mw_content;
            content+='</tr>';

        })
        var html = '<tr><th><b>Date Posted</b></th>'+
                    '<th colspan=25><b>'+source_time+'</b></th></tr>';
        html+= '<tr><th>Resource ID</th><th>Type</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
        var total = '<tr class="price"><td rowspan=2 style="vertical-align:middle"><b>Average</b></td><td>PR</td>';

        $.each(total_price,function(i, val){
            var avg = val / total_price_cnt[i]
            total_price_html+= '<td>'+avg.toFixed(2)+'</td>';	
        })

        $.each(total_mw,function(i, val){
            //var avg = val / total_mw_cnt[i]
            total_mw_html+= '<td>'+val+'</td>';	
        })

        total+=total_price_html;
        total+='</tr><tr><td>SCHD</td>';
        total+=total_mw_html;
        
        $('#grid_data').html('<table id="grid" class="table table-bordered table-condensed"></table>');
        
        $("#grid").html(html)
        $("#grid").append(content)
        if (data.total > 1) {
            $("#grid").append(total)
        }
        $('#grid_data').append('&nbsp;<button id="btn_export_csv" class="btn btn-success">Export CSV</button>');
        $('#grid_data').append('&nbsp;<button id="btn_export_xls" class="btn btn-success">Export XLS</button>');
    },
    formatData: function (data){
        var price_data=[];
        var mw_data=[];
        var obj = {};
        var resource_id;
        var resource_id_cnt = 0;
        
        $.each(data.value, function(i, val) {
            for(x=1;x<25;x++){
                price_data.push([x,val[x].price])
                mw_data.push([x,val[x].mw])
            }
            resource_id = i;
            resource_id_cnt++;
        })

        $.createGraph(price_data, mw_data, 'Day Ahead Projections', resource_id);
        $.createTables(data);
        if (resource_id_cnt > 1){
            $('#result').hide('fast')
        } else {
            $('#result').show('fast')
        }
        return false;
    }
    ,exportData : function(type){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/rep_dap_manager_xls'
        var parameters = "date=" + $('#datepicker').val();
        //parameters+= "&edate=" + $('#edate').val();
        parameters+= '&resource_id='+$('#resource_id').val();
        //parameters+= '&type='+type;
        $.download(url,parameters);
    }
})
</script>
<script>    
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
                    html+='<td id='+val+'>'+val+'</td>';
                    if (x % 4 === 0) {
                            html+='</tr><tr>';
                    }
                    var str_res_id='';

                    $('#'+val).die('click').live('click',function(e){
                        e.preventDefault()
                        $('#modal_resource').modal('hide')
                        $('#resource_id').val($(this).attr('id'))	
                        /*if ( $('#resource_id').val() ) {
                            res_id = $('#resource_id').val();
                            var arr_res_id = res_id.split(',')

                            $.each( arr_res_id ,function(i,val){
                                    if ( val != ' ' && val != '') {
                                            str_res_id+=val+',';	
                                    }
                            })
                            $('#resource_id').val(str_res_id + ' ' + $(this).attr('id') + ',')
                        } else {
                            $('#resource_id').val($(this).attr('id') + ',')	
                        }*/
                        //$( "#list-resources" ).dialog('close')
                    })
                })
                html+='</tr>';
                $('#list-table-res').html(html);
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

</script>
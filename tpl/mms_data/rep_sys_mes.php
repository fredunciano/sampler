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
            <div class="span2">Look for</div>
            <div class="span7">
                <input type="text" id="look_for">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">Urgency</div>
            <div class="span7">
                <label for="red" class="checkbox inline"><input type="checkbox" id="red"> Red</label>
                <label for="blue" class="checkbox inline"><input type="checkbox" id="blue"> Blue</label>
                <label for="green" class="checkbox inline"><input type="checkbox" id="green"> Green</label>
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
            <div class="span7">
                
            </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px"></div>
        <div id="export_btns_container">
            <button class="btn btn-success" id="btn_export_xls">Export to XLS</button>
            <button class="btn btn-success" id="btn_export_csv">Export to CSV</button>
        </div>
    </section>
    <br><br>
</div>


<script>
$("#red").attr('checked','checked');
$("#blue").attr('checked','checked');
$("#green").attr('checked','checked');
$.extend({
    loadData: function(){
        $('#grid').html('');
        $("#result").attr('class','alert alert-info');
        $("#result").html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
        $.post('../mms_data/rep_sys_mes_action',{sdate:$('#sdate').val(),edate:$('#edate').val(),
            look_for:$('#look_for').val(),red:$('#red:checked').val(),
            green:$('#green:checked').val(),blue:$('#blue:checked').val()},
            function(data){
                console.log(data);
                html = '<tr><th width="150px">Date</th><th>Details</th></tr>'; 
                if ( data.total ) {
                    $("#result").removeClass('alert alert-info');
                    var x=1;
                    $.each(data.value,function(i,val){
                        var bg;
                        x++;
                        if ( x % 2 === 0 ) bg = '#F0F2F5';
                        else bg = '#FFFFFF';

                        html+='<tr><td style="color:'+val.urgency+'">'+val.date+'</td><td style="color:'+val.urgency+'">'+val.message+'</td></tr>'
                    })
                    $('#result').html('<table id="grid" class="table table-bordered table-striped"></table>');
                    $('#grid').html(html);
                    $('#export_btns_container').show();
                } else {
                    $('#result').html(data.message);
                    $('#export_btns_container').hide();
                }
                

            });
            return false;
    },
    createGraph: function(data, title){
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
            xAxis: [{
                categories: ['H1', 'H2', 'H3', 'H4', 'H5', 'H6','H7', 'H8', 'H9', 'H10', 'H11', 'H12',
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
            }],
            tooltip: {
                shared: true

            },
            series: 
                data
        });
        return false;
    },
    createTables: function (data) {
        var series=[];
        var obj = {};
        var content;

        var total_html;
        var total_mw={};
        var mw=[];
        var total_mw_html;
        $.each(data.value, function(i, val) {
                var mw_content='';

                content+='<tr class="mw"><td><b>'+i+'</b></td>';

                $.each(val, function(index,data){
                        mw_content+= '<td>'+data.mw.toFixed(2)+'</td>';
                        if ( total_mw[index] ) {
                                total_mw[index] = data.mw + total_mw[index];
                        } else {
                                total_mw[index] = data.mw	
                        }

                });

                content+=mw_content;
                content+='</tr>';

        })

        var html = '<tr><th>Resource&nbsp;ID</th><th>H1</th><th>H2</th><th>H3</th><th>H4</th><th>H5</th><th>H6</th><th>H7</th><th>H8</th><th>H9</th><th>H10</th><th>H11</th><th>H12</th><th>H13</th><th>H14</th><th>H15</th><th>H16</th><th>H17</th><th>H18</th><th>H19</th><th>H20</th><th>H21</th><th>H22</th><th>H23</th><th>H24</th></tr>'
        var total = '<tr><th><b>Total</b></th>';

        $.each(total_mw,function(i, val){
                total_mw_html+= '<th>'+val.toFixed(2)+'</th>';	
        })

        total+=total_mw_html;
        $("#grid").html(html)
        $("#grid").append(content)
        if (data.total > 1) {
                $("#grid").append(total)
        }
    },
    formatData: function (data){
        var mw_data=[];
        var obj = {};
        var resource_id;

        $.each(data.value, function(i, val) {
            var name = i;
            var data = [];
            $.each(val, function(index,d){
                    data.push(d.mw)
            });
            resource_id = i;
            mw_data.push({name:i,data:data,id:i})
        })

        $.createGraph(mw_data, 'Realtime Dispatch Schedules');
        $.createTables(data);
        
        return false;
    }

    ,exportData : function(type){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/mms_data/file_rep_sys_mes'
        var parameters = "sdate=" + $('#sdate').val();
        parameters+= "&edate=" + $('#edate').val();
        parameters+= '&look_for='+$('#look_for').val();

        if ( typeof $('#red:checked').val() != 'undefined' ) {
            parameters+= '&red='+$('#red:checked').val();
        }

        if ( typeof $('#green:checked').val() != 'undefined' ) {
            parameters+= '&green='+$('#green:checked').val();
        }

        if ( typeof $('#blue:checked').val() != 'undefined' ) {
            parameters+= '&blue='+$('#blue:checked').val();
        }

        parameters+= '&type='+type;
        $.download(url,parameters);
    }
})

$('#btn_export_csv').die('click').live('click',function(){
    $.exportData('CSV');
});

$('#btn_export_xls').die('click').live('click',function(){
    $.exportData('XLS');
});
</script>
<script>
$('#sdate, #edate').datepicker();
$.loadData();
$('a.btn').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadData();
});
</script>
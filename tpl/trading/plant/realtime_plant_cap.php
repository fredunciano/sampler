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
    <legend><h4><?=$title?> <small>&nbsp;( Trading )</small></h4></legend>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10">
            <select id="resource" class="input-medium">
                <?php
                foreach ($resources as $r) {
                    echo '<option>'.$r->resource_id.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append">
            <input type="text" id="date" class="input-small"  readonly >
            <a class="btn btn-primary" href="#" id="submit_filter"><i class="icon-ok icon-white"></i>&nbsp;Display</a>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            
        </div>
    </div>
    <br><br>
    <div class="row-fluid" id="result"></div>
    <br><br>
</div>
<script>
$.extend({
    list : function(){
        
        $('#result').html('<legend><h6>Delivery Date : '+ $('#date').val()+'</h6></legend>'+
                          '<table class="table table-condensed " id="tbl_dap">'+
                          '<tr>'+
                          '<th width="150px">Interval</th>'+
                          '<th>Unit</th>'+
                          '<th>Remarks</th>'+
                          '<th>Description</th>'+
                          '<th>Source</th>'+
                          '</tr>'+
                          '</table>'+
                          '</div>');
        
        var table_html = '';
        for ( x=1;x<=24;x++ ) {
            start = x*100+1-100;
            end = x*100;
            xstart  = $.strPad(start,4);
            xend    = $.strPad(end,4);

            table_html+='<tr>';
            table_html+='<td>'+x+'&nbsp;('+xstart+'-'+xend+'H)</td>';
            table_html+='<td width="100px"><span style="width:70px" id="txt_unit_'+x+'" name="txt_unit_'+x+'"></span> MW</td>';
            table_html+='<td><span id="remarks_'+x+'" name="remarks_'+x+'"></span></td>';
            table_html+='<td><span style="height:35px;width:100%" id="desc_'+x+'" name="desc_'+x+'"></span></td>';
            table_html+='<td style="width:50px"><span id="source_'+x+'"></span></td>';
            table_html+='</tr>';
        }
        
        $('#tbl_dap').append(table_html)
        
        $.post('../trading_plant/realtime_plant_cap_load',{resource_id:$('#resource').val(),date:$('#date').val(),type:'DAP'},
        function(data){
            data = $.parseJSON(data);
            console.log(data)
 
            for ( x=1;x<=24;x++ ) {
                
                if (data.length !== 0) {
                    $('#txt_unit_'+x).html(data[x].mw);
                    $('#remarks_'+x).html(data[x].remarks);
                    $('#desc_'+x).html(data[x].description);
                    $('#source_'+x).html(data[x].type)
                }
                
            }
            
        });
    }
});
</script>
<script>

var sdate = new Date().toString("M/d/yyyy");
var date = Date.parse(sdate).toString("MM_dd_yyyy");


$('#date').val(sdate);

$.list();

$('#submit_filter').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.list();
});

</script>

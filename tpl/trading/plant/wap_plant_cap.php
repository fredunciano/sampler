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
        <div class="span10 input-append input-prepend">
            <input type="text" id="datepicker" class="input-small"><span class="add-on">-</span> 
            <input type="text" id="end_date" readonly class="input-small">
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
        var html = '';
        var tab_title = '';
        var tab_content = '';
        
        
        tab_title+='<ul class="nav nav-tabs">';
        for (x=1;x<=8;x++) {
            rdate = new Date($('#datepicker').val()).add({days: x-1}).toString("M/d/yyyy");
            if (x==1) {
                active = 'active';
            } else {
                active = '';
            }
            tab_title+='<li class="'+active+'"><a href="#c'+x+'" data-toggle="tab">'+rdate+'</a></li>';
        }
        tab_title+='</ul>';
        tab_content+='<div class="tab-content">';
        for (x=1;x<=8;x++) {
            if (x==1) {
                active = 'active';
            } else {
                active = '';
            }
            tab_content+='<div class="tab-pane '+active+'" id="c'+x+'">'+
                         '<table class="table table-condensed ">'+
                         '<tr>'+
                         '<th width="150px">Interval</th>'+
                         '<th>Unit</th>'+
                         '<th>Remarks</th>'+
                         '<th>Description</th>'+
                         '<th>Source</th>'+
                         '</tr>'
                         
                for ( x1=1;x1<=24;x1++ ) {
                    start = x1*100+1-100;
                    end = x1*100;
                    xstart  = $.strPad(start,4);
                    xend    = $.strPad(end,4);
                    
                    tab_content+='<tr>';
                    tab_content+='<td>'+x1+'&nbsp;('+xstart+'-'+xend+'H)</td>';
                    tab_content+='<td width="100px"><span id="txt_unit_'+x+'_'+x1+'" name="txt_unit_'+x+'_'+x1+'" ></span> MW</td>';
                    tab_content+='<td><span id="remarks_'+x+'_'+x1+'" name="remarks_'+x+'_'+x1+'"></span></td>';
                    tab_content+='<td><span id="desc_'+x+'_'+x1+'" name="desc_'+x+'_'+x1+'"></span></td>';
                    tab_content+='<td><span id="source_'+x+'_'+x1+'" name="source_'+x+'_'+x1+'"></span></td>';
                    tab_content+='</tr>';
                }
            tab_content+='</table></div>';
        }
        tab_content+='</div>';
        
        $('#result').html(tab_title)
        $('#result').append(tab_content)
        
    },
    loadData : function(){
        
        $.post('../trading_plant/wap_plant_cap_load',{resource_id:$('#resource').val(),date:$('#datepicker').val(),type:'WAP'},
        function(data){
            data = $.parseJSON(data);
            for (x=1;x<=8;x++) {
                
                rdate = new Date($('#datepicker').val()).add({days: x-1}).toString("yyyyMMdd");
                
                if (typeof data[rdate] === 'object') {
                    
                    for ( x1=1;x1<=24;x1++ ) {
                        if (data[rdate][x1] !== 0) {
                            $('#txt_unit_'+x+'_'+x1).html(data[rdate][x1].mw);
                            $('#remarks_'+x+'_'+x1).html(data[rdate][x1].remarks);
                            $('#desc_'+x+'_'+x1).html(data[rdate][x1].description);
                        }
                    }
                }
            }
            
        });   
    }
    
});
</script>
<script>

var sdate = new Date().add({days: 2,hours: 15}).toString("M/d/yyyy");
var edate = new Date(sdate).add({days: 7}).toString("M/d/yyyy");
var date = Date.parse(sdate).toString("MM_dd_yyyy");

$('#datepicker').datepicker();
$('#datepicker').val(sdate);
$('#end_date').val(edate);
$.list();
$.loadData();

$('#datepicker').change(function(){
    var edate = new Date($('#datepicker').val()).add({days: 7}).toString("M/d/yyyy");
    $('#end_date').val(edate);
});

$('#submit_filter').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.list();
    $.loadData();
});
</script>
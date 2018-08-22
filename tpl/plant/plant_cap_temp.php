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
        <div class="span2">Plant</div>
        <div class="span10">
            <select id="plant">
                <?php

                foreach($plants as $p){
                    echo '<option value='.$p->plant_name.'>'.$p->plant_name.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10">
            <select id="resource">
                <?php
                foreach ($resources as $r) {
                    echo '<option value='.$r['resource_id'].'>'.$r['resource_id'].'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10">
            <input type="text" id="date"  readonly="readonly">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">No. of Days</div>
        <div class="span10">
            <label class="radio"><input type="radio" id="dap" name="chkbox" checked>&nbsp;DAP [1 Day]</label>
            <label class="radio"><input type="radio" id="wap" name="chkbox">&nbsp;WAP [8 Days]</label>
        </div>
    </div>
    <br><br>
    <legend>Filename</legend>
    <div class="row-fluid">
        <div id="result" class="alert alert-block span12"></div>
    </div>
</div>

<script>
$.extend({
    loadUnitDropDown: function(){
        $.post('../plant/resource_dropdown',{plant:$('#plant').val()},
            function(data){
                html = '';
                $.each(data.value, function(i,val){
                    html+='<option value="'+val.resource_id+'">'+val.resource_id+'</option>';
                })
                $('#resource').html(html);
                return false;
            });
    },
    exportData : function(){
        
        var type = $("input:radio:checked").attr('id');
        var url = '../plant/excel_plant_avail'
        var parameters = "date=" + $('#date').val();
        parameters+= "&type=" + type;
        parameters+= "&resource_id=" + $('#resource').val();

        $.download(url,parameters);
    },
    getDAP : function(){
        
        $.post('../plant/get_cap_temp_date',{type:'DAP'},
            function(data){
                $('#date').val(data)
                var d = Date.parse($('#date').val());
                var dap_date = new Date(d).toString("M_d_yyyy");
                $('#result').html('<div class="span4"><h5><a href="#" id="button" role="button">Plant_Availability_DAP_['+dap_date+']</a></h5></div>')
                return false;
            });

    },
    getWAP : function(){
        $.post('../plant/get_cap_temp_date',{type:'WAP'},
            function(data){
                
                var arr_date = data.split('|');
                var sdate = arr_date[0];
                var edate = arr_date[1];
                $('#date').val(sdate + ' - ' + edate)
                var sd = Date.parse(sdate);
                var ed = Date.parse(edate);
                
                var start_date = new Date(sd).toString("M_d_yyyy");
                var end_date = new Date(ed).toString("M_d_yyyy");
                
                $('#result').html('<div class="span6"><h5><a href="#" id="button" role="button">Plant_Availability_WAP_['+start_date+'-'+end_date+']</a></h5></div>')
                return false;
            });
    }
});
</script>
<script>

$.getDAP();

$('#plant').change(function(){
    $.loadUnitDropDown();
})

//$('#date').val(sdate);

$("#dap").unbind('click').bind('click',function(){
    $.getDAP();
});

$("#wap").unbind('click').bind('click',function(){
    $.getWAP();
});

$('#button').die('click').live('click',function(){
    $.exportData()
});
</script>
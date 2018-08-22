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
        <legend><h4><?=$title?> <small>( Sales module )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2"> Date Covered</div>
            <div class="span10">
                <input type="text" id="sdate" name="sdate" value="<?=$sdate?>" class="span2"> to
                <input type="text" id="edate" name="edate" value="<?=$edate?>" class="span2">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span2">&nbsp;</div>
            <div class="span10">
                <button class="btn btn-primary" id="show">Display</button>
            </div>
        </div>
        <br>
        <div id="result"></div>
</div>

<script>
$.extend({
    list : function(){
        $('#filter-alert-msg').html('Loading...')
        $.post('../sales/contract_listing_action',{sdate:$('#sdate').val(),edate:$('#edate').val()},
        function(data){
            data = $.parseJSON(data);
            
            var html = '';
            var row  = '';
            //html = '<table class="table table-bordered"><tr><th>Customer</th><th>Start Date</th><th>End Date</th><th>Contracted Capacity</th><th>Status</th></tr>';
            
            $("#result").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $('#data').dataTable({

                "aoColumns": [
                    { "sTitle": "Customer" },
                    { "sTitle": "Start Date" },
                    { "sTitle": "End Date" },
                    { "sTitle": "Contracted Capacity" },
                    { "sTitle": "Status" }
                ]
            });
            
            $.each(data, function(i,val){
                var priv_link = '<a href="../sales/contract_management?id='+val.id+'">'+val.customer+'</a>';
                $('#data').dataTable().fnAddData([priv_link,val.start_date,val.end_date,val.contracted_capacity,val.status]);
            })
        })    
        /*    
            $.each (data, function(i,val){
                row+= '<tr><td><a href="../sales/contract_management?id='+val.id+'">'+val.customer+
                      '</a></td><td>'+val.start_date+'</td><td>'+val.end_date+
                      '</td><td>'+val.contracted_capacity+'</td><td>'+val.status+'</td></tr>'
            })
            html+=row;
            html+='</table>'
            $('#result').html(html)
            $('#filter-alert-msg').html('')
            
            
        })*/
    }
})
</script>
<script>
$('#sdate').datepicker();
$('#edate').datepicker();
$.list();
$('#show').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.list(); 
});
</script>
    
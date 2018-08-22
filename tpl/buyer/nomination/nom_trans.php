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
        <div class="span2">Participant</div>
        <div class="span10"><select id="participant"></select></div>
    </div>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10 input-append">
            <input type="text" id="datepicker" name="sdate" value="<?=$default_date?>" class="input-small">
            <input type="button" id="display_btn" value="Display" class="btn btn-primary"/>
        </div>
    </div>
    <br>
    <div class="row-fluid" id="result"></div>
</div>




<script>
$.extend({
    getList: function (s)
    {
        $('.pls_wait').html('Please wait...');

        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_trans_list'
        var parameters = "delivery_date=" + $('input[name=sdate]').val() + "&participant=" + $("#participant option:selected").text();

        $.ajax({
           type: "POST",
           url: url,
           data: parameters,
           success: function(msg){
                var ret = $.parseJSON(msg);
                
                var table = '<table id="table" class="table table-striped"></table>';
                $('#result').html(table);
                $('#table').append('<tr><th>Transaction</th><th>Type</th><th>Remarks</th><th>User</th>'+
                                   '<th>Date Created</th></tr>');
                
                var t = '';
                var h = '<tr><th>Transaction<br />ID</th>'
                        + '<th>Type</th>'
                        //+ '<th>Relevant Date</th>'
                        + '<th>Remarks</th>'
                        + '<th>User</th>'
                        + '<th width="135">Created Date</th>'
                        + '</tr>';

                $.each(ret,function(i, val){
                    
                    $('#table').append('<tr><td><a href=# name="'+ret[i].id+'" class="det">'+ret[i].id+'</a></td>'+
                        '<td>'+ret[i].type+'</td><td>'+ret[i].remarks+'</td>'+
                        '<td>'+ret[i].created_by+'</td><td>'+ret[i].created_date+'</td></tr>');
                    
                    h += '<tr><td><a href=# name="'+ret[i].id+'" class="det">'+ret[i].id+'</a></td>'
                        + '<td>'+ret[i].type+'</td>'
                        //+ '<td>'+ret[i].relevant_date+'</td>'
                        + '<td>'+ret[i].remarks+'</td>'
                        + '<td>'+ret[i].created_by+'</td>'
                        + '<td>'+ret[i].created_date+'</td>'
                        + '</tr>';
                });		

                
                //$('.pls_wait').html('');

           }
         });						
        return false;
    },
    get: function (parameters)
    {
        $('.pls_wait').html('Please wait...');

        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/nom_trans_det'

        $.ajax({
           type: "POST",
           url: url,
           data: parameters,
           success: function(msg){
                var ret = $.parseJSON(msg);
                var h = '';
                var c = '';
                var bg = '';

                for(var x=1; x<=24; x++){

                    bg = (x%2==0) ? '#DDDDDD' : '#FFFFFF';

                    h = '<tr><th bgcolor="'+bg+'">Interval</th>';
                    c += '<tr><th bgcolor="'+bg+'">'+x+'</th>';

                    $.each(ret, function(i, val){
                        h += '<th bgcolor="'+bg+'">'+i+' <br /> kW</th>';
                        c += '<td bgcolor="'+bg+'">'+val[x]+' </td>';
                    });

                    h += '</tr>';
                    c += '</tr>';
                }
                $('#details_dialog_content #t1').html(h + c);
                $('.pls_wait').html('');
           }
         });						
        return false;
    },
    listParticipants : function()
    {
        $.post('../buyer/listParticipants',
        function(data){
            var data = data.split("|")
            $.each(data, function(i,val){
                $('#participant').append('<option>'+val+'</option>')
            })
            $.showContractedCapacity();
        });
        
    },
});
</script>
<script type="text/javascript">

$.listParticipants();

setTimeout("$.getList();", 500);

$('#participant, #datepicker').change(function(){
    $.showContractedCapacity();
})

$('#frm1 input[name=sdate]').change(function(){
    $.getList('delivery_date='+$(this).val());
});

$('#frm1 input[name=sdate]').trigger('change');

$('#display_btn').click(function(){
    $.getList('delivery_date='+$(this).val());
});

$('a.det').live('click',function(){
    var id = $(this).attr('name');
    $.get('id=' + id);
    $('#details_dialog').dialog({width:650, height:510, position:top, title:"Transaction ID: " + id});
});

</script>
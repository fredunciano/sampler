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
    <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
    <div id="grid_data"></div>
</div>

<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Billing Period</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                <tr><td>Billing Period</td><td><input type="text" class="input-medium" id='billing_period' name="billing_period" readonly></td></tr>
                <tr>
                    <td>Start Month</td>
                    <td>
                        <select id="smonth" name="smonth" class="span2">
                            <?php
                            for ($x=1;$x<=12;$x++) {
                                echo '<option value="'.$x.'">'.date('F',mktime(0,0,0,$x,1,date('Y'))).'</option>';
                            }
                            ?>
                        </select>
                        <select id="sday" name="sday" class="input-mini">
                            <?php
                            for ($x=1;$x<=31;$x++) {
                                echo '<option>'.$x.'</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>End Month</td>
                    <td>
                        <select id="emonth" name="emonth" class="span2">
                            <?php
                            for ($x=1;$x<=12;$x++) {
                                echo '<option value="'.$x.'">'.date('F',mktime(0,0,0,$x,1,date('Y'))).'</option>';
                            }
                            ?>
                        </select>
                        <select id="eday" name="eday" class="input-mini">
                            <?php
                            for ($x=1;$x<=31;$x++) {
                                echo '<option>'.$x.'</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
    save : function(){
        if( ($('#smonth').val() + $('#sday').val()) > ($('#emonth').val() + $('#eday').val())){
            $('#error_box').attr('class','alert alert-error');
            $('#error_box').html('Start Date is greater than End Date');
            return false;
        }
        $.post('<?=$base_url?>/admin/billing_period_update',$('form').serialize(),
        function(data){
            ret = data.split('|');
            if (ret[0] == 1) {
                $('#error_box').attr('class','alert alert-success');
            } else {
                $('#error_box').attr('class','alert alert-error');
            }
            $('#error_box').html(ret[1]);
            $.list();
        })
    },
    list : function(order,field){
        $.post('<?=$base_url?>/admin/billing_period_list_json',{order:order,field:field},
        function(data){
            var data = $.parseJSON(data);
            $("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
            $("#data").append('<tr><td>Billing Period</td><td>Start Date</td><td>End Date</td><td>Last Modified</td></tr>');
            $.each(data, function(i,val){
                var start_bp = val.smonth + '-' + val.sday
                var end_bp = val.emonth + '-' + val.eday
                var priv_link = '<a href="#" id="'+val.id+'" class="edit_link">'+val.name+'</a>';
                $("#data").append('<tr><td>'+priv_link+'</td><td>'+start_bp+'</td><td>'+end_bp+'</td><td>'+val.modified+'</td></tr>')
            })
        })    
    }
})
</script>
<script>
$.list();
$("a.edit_link").die('click').live('click',function(e){
    e.preventDefault();
    $('#error_box').removeClass('alert');
    $('#error_box').html('');
    $('#modal').modal('show')
    $.post('<?=$base_url?>/admin/billing_period_data',{id:$(this).attr('id')},
        function(data){
            var data = $.parseJSON(data);
            $('input[id=id]').val(data.id);
            $('input[id=billing_period]').val(data.month_name);
            $('select[id=smonth]').val(data.smonth);
            $('select[id=sday]').val(data.sday);
            $('select[id=emonth]').val(data.emonth);
            $('select[id=eday]').val(data.eday);
            $('#btn-holder').html('<button class="btn btn-primary" id="update"><i class="icon-check"></i>&nbsp;&nbsp;Update&nbsp;&nbsp;</button>')
            return false;
    })
})

$("#update").die('click').live('click',function(e){
    e.preventDefault()
    $.save();    
})
</script>
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
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <div class="row-fluid">
        <div class="span2">Delivery Date</div>
        <div class="span10">
            <input type="text" id="dateval" value="<?echo $default_date?>" disabled="disabled" class="input-medium" />
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Templates</div>
        <div class="span10">
            <input type="hidden" id="hDAN" value="<?=$dan?>" />
            <input type="hidden" id="hWAN" value="<?=$wan?>" />
            <input type="hidden" id="hMAN" value="<?=$man?>" />
            <label class="radio"><input type="radio" value="DAN" name="template_type_rdo" checked>Day Ahead Nomination</label>
            <label class="radio"><input type="radio" value="WAN" name="template_type_rdo" >Week Ahead Nomination</label>
            <label class="radio"><input type="radio" value="MAN" name="template_type_rdo" >Month Ahead  Nomination</label>
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
    downloadTemplate : function(type){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/buyer/file_nom_templates'
        var parameters = "sdate=" + $('#dateval').val()+"&filename="+$('#btn_download').html()+'.xlsx'+ '&type='+type;
        $.download(url,parameters);
        return false;
    },
    showLink : function(){
        var type=$('input[type=radio]:checked').val();
        var filename = 'Nomination_'+type+'_'+$('#h'+type).val();
        var html = '';
        html+='<h5><a href="#" id="btn_download" role="button">'+filename+'</a></h5>';
		
		if(type=='DAN'){
			$('#dateval').val('<?php echo $default_date ?>');
		}else if(type=='WAN'){
			$('#dateval').val('<?php echo date("m/d/Y",strtotime($def_date_wan_start)).' - '. date("m/d/Y",strtotime($def_date_wan_end))?>');
		}else if(type=='MAN'){
			$('#dateval').val('<?php echo date("m/d/Y",strtotime($def_date_man_start)).' - '. date("m/d/Y",strtotime($def_date_man_end))?>');
		}
        
        $('#result').html(html)
    }
});
</script>
<script type="text/javascript">
    $.showLink();
	$("input:radio").click(function(){
		$.showLink();
	})

    $('#btn_download').die('click').live('click',function(){
        var type = $('input[name="template_type_rdo"]:checked').val();
        $.downloadTemplate(type);

    })
</script>



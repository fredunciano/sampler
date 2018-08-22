<style>
	th,td {
		text-align:center !important;
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
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    
    <div class="row-fluid">
   		<div class="span2">
   			Delivery Date
   		</div>
        <div class="span10 input-append">
            <input type="text" id="sdate" class="input-small" value="<?=$date?>">
            <button id="retrieve_btn" type="button" class="btn btn-primary">Retrieve</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="download_template" type="button" class="btn btn-success">Download Template</button>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Plant</div>
        <div class="span10">
        	<select class="datetext" id="plant">
        		<?php foreach ($plant_list as $p) {
        				echo "<option>".$p->plant_name,"</option>";
        			  }
        		
        		?>
        	</select>
        </div>
    </div>
    <br \>
    <div class="row-fluid">
    	<form enctype="multipart/form-data" id="pmr_form" method="post">
        <div class="span2">File</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span><input type="file" name="file" id="filebrowser" />
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    <a href="#" class="btn fileupload-exists btn-primary" id="submit_file">Upload</a>
                    
                </div>
                 <span id="msg-alert-submit"></span>     
                 <span id="export_handler" class="hide"><button id="x_xls" class="btn btn-success" type="button">Export to Excel</button></span>
            </div>
        </div>
        </form>
    </div>
    <hr>
    <div id="grid_data">
    </div>
    
</div>

<script type="text/javascript">
$.extend({
	list : function(){
		$('#grid_data').html('Loading<img src="../images/ajax-loader.gif">');
        $.post('<?=$base_url?>/trading/pmr_data',{date : $('#sdate').val(),plant : $('#plant').val() },
        function(data){
        	//console.log(data);
        	
        	
        	
			if (data.total >= 1) { 
		var html ='<table class="table table-condensed table-striped table-bordered">'
				html+='<tr><td></td><td>Running Hours</td><td>Fuel Consumption</td></tr>'
				$.each(data.fuel,function(i,val){
					if(val.fuel_consumption == '0.0'){
						val.fuel_consumption = 'N/A';
					}
					html+='<tr><td>'+val.plant+'</td><td>'+val.running_hours+'</td><td>'+val.fuel_consumption+'</td></tr>'
				})
				html+='</table><br \>'
			html+='<table  class="table table-condensed table-striped table-bordered">'
					html+='<tr><th rowspan="2">Date</th><th rowspan="2">Interval</th><th colspan="'+data.total+'">'+$('#plant').val()+'</th><th rowspan="2">Remarks</th><th rowspan="2">On Duty</th><th rowspan="2">Trader</th></tr>'
					//console.log(data.value[1])
					html+='<tr>'
					$.each(data.value,function(m,val){
						html+='<td>'+m+'</td>'
					})
					html+='</tr>'
				//	var interval = '1';
					for(i=1;i<=24;i++){
					html+='<tr><td>'+$('#sdate').val()+'</td><td>'+i+'</td>'
					$.each(data.value,function(mtr,interval){
						html+='<td>'+interval[i].value+'</td>'	
						
					})
					html+='<td>'+data.value['Plant Meter'][i].remarks+'</td><td>'+data.value['Plant Meter'][i].on_duty+'</td><td>'+data.value['Plant Meter'][i].trader+'</td>'
					
					html+='</tr>'
					}
				
				html+='</table'
				
				$('#grid_data').html(html);
				$('#export_handler').show();
			} else {
                $('#grid_data').html('No Data Available');
            }
			
			
        })
      },
      downloadReport : function () {
      	var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/pmr_xlsx'
        var parameters = "date=" + $('#sdate').val();
        $.download(url,parameters);
      },
      downloadTemplate : function () {
      	var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/pmr_template'
        var parameters = "date=" + $('#sdate').val();
        $.download(url,parameters);
      }
     })
</script>
<script>
$('#sdate').datepicker();
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    var path    = '../trading/pmr_upload_action';
    var options = {target: '#msg-alert-submit',
        url: path,
        beforeSubmit: function(){
            $('#msg-alert-submit').html('Loading<img src="../images/ajax-loader.gif">')
        },    
        success: function(data){
            //data = $.parseJSON(data);
            ret = data.split('|');
            console.log(data)
            
            $('#msg-alert-submit').html(ret[1])
        }
    };
    
    $('form').ajaxSubmit(options);
})
$('#retrieve_btn').unbind('click').bind('click',function(e){
	$('#msg-alert-submit').html('')
	$.list();
});
$('#download_template').unbind('click').bind('click',function(e){
	$.downloadTemplate();
});
$('#x_xls').unbind('click').bind('click',function(e){
	$.downloadReport();
});
</script>

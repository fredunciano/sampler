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
    <legend><h4>Upload <?=$title?> <small>( Fuel Interface )</small></h4></legend>
    <form enctype="multipart/form-data" method="post">
        <input type="hidden" id="tbl_name" value="<?=$title?>"/> 
    <div class="fileupload fileupload-new span5" data-provides="fileupload">
        <div class="input-append">
            <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
            <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span><input type="file" name="file" id="file" />
            </span>
            <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>  
        </div>
    </div>
    
    <div class="span4">
        <input type="submit" value="Upload" class="btn btn-primary" id="submit_file" />&nbsp;&nbsp;<span id="msg-alert-submit"></span>
    </div>
    </form><br><br><br><br>
        <legend><h4>Fuel Consumption <small></small></h4></legend>
        
       	<div class="row-fluid">
             <div class="span2">Delivery Date</div>
             	<div class="span7 input-append input-prepend">
                   <input type="text" id="datepicker" name="date" value="<?=$date?>" class="input-medium">
           		</div> 
   		</div>
        
        <div class="row-fluid">
			<div class="span2">Type</div>
            <div class="span7">  
                <select id="type" name="type" class="input-medium">
                    <option value="GENERATORS">GENERATORS</option>
                    <option value="SUPPLIERS">SUPPLIERS</option>
                </select>
            </div>
        </div>
        
        <div class="row-fluid">
			<div class="span2" id ="resource_name">Resource ID</div>
            <div class="span7">
                <select id="resource" name="resource" class="input-medium">
                    <option>Loading Resources...</option>
                    <?php
                    foreach($resource as $r){
                        echo '<option value='.$r['resource'].'>'.$r['resource'].'</option>';
                    }
                    ?>
                </select>  
            </div>
        </div>
                
        <div class="row-fluid">
			<div class="span2">Fuel Consumption</div>
            <div class="span7">
                <select id="fuel" name="fuel" class="input-medium">
                <?php
                foreach ( $fuel as $f ) {
                    echo '<option value="'.$f->fuel .'">'.ucwords(strtolower($f->fuel )).'</option>';
                }
                ?>
                <option value="add_fuel"> + Add New</option>
                </select>
            </div>
        </div>        
		
        <div class="row-fluid">
        	<div class = "span2"></div>
        	<div class = "span7">
			<label class="radio">
 				 <input type="radio" name="optionsRadios" id="optionsRadios1" value="Estimated" checked>
  				Estimated Values
			</label>
			<label class="radio">
  				 <input type="radio" name="optionsRadios" id="optionsRadios1" value="Actual">
  				Actual Values
			</label>
			</div>
        </div>    
   		<br>

   		<div class="row-fluid">	
            <div class="span2"></div>
            <div class="span10">
				<a class="btn btn-primary" href="#" id = "btn_show"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
            </div>
   	 	</div>
</div>
<div class = "span12 offset3"><br><legend></legend>   
		<div id = "result"></div>
		<div id="grid_data" class="container" style="margin-top: 10px"></div> 	 	
		
   	 	<div style="display: none;" id="export_btns_container">
       		 <br><button id="btn_export_xls" type="button" class = "btn btn-success"><i class = "icon-download icon-white"></i>Export to XLS</button><br><br>
        </div>
        <br>
        
	<div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
	    <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h4 id="ModalLabel">Add Fuel Consumption</h4>
	    </div>
	    <div class="modal-body">
	        <div id="error_box2"></div>
	        <form enctype="multipart/form-data" name="fuel_form" id="fuel_form" method="post">
	            <input type="hidden" id="id" name="id">
	            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
	                <tr><td>Fuel Type</td><td><input type="text" class="input-medium" id='fuel_type' name="fuel_type"></td></tr>
	                <tr><td>Description</td><td>
	                    <textarea id="description" name="description" rows="4" class="input-xlarge"></textarea>
	                </td></tr>
	            </table>
	        </form>
	    </div>
	    <div class="modal-footer">
	        <button  id="close" name="close" class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
	        <span id="btn-holder"></span>
	    </div>
	</div>        
	
</div>  
 
<script>
$('datepicker').datepicker();
function precise_round(num,decimals) {
    var rounded = Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
    var components = rounded.toString().split(".");
    //Comma-fies the first part
    components [0] = components [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return components.join(".");
}	
$.extend({
	loadResourceDropDown: function (){
		$.post('../trading/resource_category',{type:$('#type').val()},
			function(data){
				html = ''
                $.each(data.value, function(i,val){
                    if(i != 'resource1'){
                		html+='<option value="'+val.name+'">'+val.name+'</option>';
                	} 
                })
                $('#resource').html(html);
            });
            return false;
	},
	loadData: function (){
		
    	$("#grid_data").html('');
    	$('#result').attr('class','alert alert-info');
        $("#result").html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
		
		var fuel 		= $('#fuel').val()
		var resource	= $('#resource').val()
		var date		= $('#datepicker').val()
        var report_type = $('input[name="optionsRadios"]:checked').val();
        console.log(report_type)
        
		$.post('../trading/fuel_view_consumption',{fuel: fuel, resource: resource, date: date, report_type: report_type},
			function(data){
				console.log(data)
				if (data.total < 1){
                    $("#result").html('<span style="padding:10px">No Data to Display</span>');
                    $('#export_btns_container').hide();
				}else{	
					$("#result").html('');
					$("#result").removeClass('alert');
					$("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tbl_content">');

	            $('#tbl_content').dataTable({
	                "aoColumns": [
	                    { "sTitle": "Date", "sWidth": "10%", "sClass": "center left"},
	                    { "sTitle": "Interval", "sWidth": "10%",  "sClass": "center right" },
	                    { "sTitle": "Fuel Price", "sWidth": "10%", "sClass": "center right" },
	                    { "sTitle": "MQ (Mapped)", "sWidth": "10%", "sClass": "center right" },
	                    { "sTitle": "Consumption", "sWidth": "10%", "sClass": "center right" },
	                    { "sTitle": "Efficiency", "sWidth": "10%",  "sClass": "center right" },
	                    { "sTitle": "Variable Price", "sWidth": "10%", "sClass": "center right" },
	                ]
	                            
	            });
	
                $.each(data.value, function(i,val1){
                	$.each(val1, function(i,val){
                		
       					$('#tbl_content').dataTable().fnAddData([val.date,val.interval,precise_round(val.fuel_price,2),precise_round(val.mq,2),precise_round(val.consumption,2),precise_round(val.efficiency,2),precise_round(val.variable_price,2)]);
                	})
                })
                $('#result').html('<table class = "table table-bordered table-condensed table-striped"><tr><td>'+resource+'</td><td>'+fuel+'</td></tr></table>')
                $('#export_btns_container').show();
          	 }
        });
            return false;
	},
	exportData: function (){
			var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/file_fuel_download'
			var param = "fuel_type=" + $('#fuel').val()
			param += "&resource=" + $('#resource').val()
			param += "&date=" + $('#datepicker').val()
			param += "&report_type=" + $('input[name="optionsRadios"]:checked').val(); 
 			
			$.download(url,param);					
	},
	addNewFuel : function(){
        $.post('<?=$base_url?>/trading/fuel_type_consumption_add',$('#fuel_form').serialize(),
	        function(data){
	            ret = data.split('|');
	            
	            if (ret[0] == 1) {error_box2
					$('#error_box2').attr('class','alert alert-success');
					//$("#add_new_fuel").html('<img src="../images/done.png"> &nbsp;Done ')
			       	window.location = 'fuel_consumption';
	            } else {
	                //$('#error_box2').attr('class','alert alert-error');
	                $('#error_box2').html('<div class="alert alert-error"  style="padding:10px">Unable to Save Data</div>');
	              	//$("#add_new_fuel").html('<img src="../images/error.png"> &nbsp;Failed ')
					window.location = 'fuel_consumption';
	            }
	            $('#error_box2').html(ret[1]);
	        })
		}
})
	
	$("#add_new_fuel").die('click').live('click',function(e){
    e.preventDefault()
		if ($('#fuel_type').val() == ""){
			alert("Please input fuel type.")
			return false;
		}else {
			$(this).html('Saving <img src="../images/ajax-loader.gif">')
	    	$.addNewFuel();
	   }
	})

	$("#close").unbind('click').bind('click',function(e){
	    e.preventDefault();
	    
	   	window.location = 'fuel_consumption';
	   	
	});
	
$.loadResourceDropDown();

$('#type').change(function(){
	$.loadResourceDropDown();

})		

$('#submit_file').unbind('click').bind('click',function(e){
		e.preventDefault();

			var test = $('#file').val()
		    if (test.search('Fuel') >=  0 || test.search('fuel') >=  0 || test.search('FUEL') >=  0 ){
				var options = {
					url:'../trading/upload_fuel_data',
					beforeSubmit: function() { 
		            $('#msg-alert-submit').html('Uploading &nbsp;<img src="../images/ajax-loader.gif">')
		        	},
				success: function(data){
					$('#msg-alert-submit').html('Upload Complete')
					window.location = 'fuel_consumption';
					}
				};
					$('form').ajaxSubmit(options);
			}else{
		    	alert('Please upload template for Fuel Consumption' )
		    }		
});

$('#btn_show').unbind('click').bind('click',function(e){
	e.preventDefault();
	if ($('#datepicker').val() == ""){
		alert ("Please choose a date")
		return false
	}else{
		$.loadData();
		
	}
			
})

$('#btn_export_xls').unbind('click').bind('click',function(e){
	e.preventDefault();
		$.exportData();	
})

$('#fuel').change(function(){
	if ($('#fuel').val() == "add_fuel"){

		$('#modal').modal('show')
	}else{
		$('#modal').modal('hide')
		return false;		
	}
	$('#btn-holder').html('<button class="btn btn-primary" id="add_new_fuel"><i class="icon-check"></i>&nbsp;&nbsp;Add&nbsp;&nbsp;</button>')
})
		
</script> 

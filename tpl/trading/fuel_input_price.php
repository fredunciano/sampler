<link rel="stylesheet" type="text/css" href="<?=$base_url?>/css/datatables.css">
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
        <form method="post">
        <legend><h4><?=$title?> <small>( Fuel Interface )</small></h4></legend>
        
        <div class="row-fluid">
        	<div class = "span2">Month</div>
            <div class = "span5">
                <select name="month" class="datepicker input-medium" id="month" >
                    <?php
                    $billing_start = $def_date_man_start;
                    $billing_start = date_parse($billing_start);
                    for($x=1;$x<=12;$x++){
                        $time_tmp = mktime (0, 0, 0, $x+1 , 0, 0);
                        $month = date('F',$time_tmp);
                        $sel = (($billing_start['month']+1) == $x) ? 'selected=selected' : '';
                        echo '<option value="'.$month.'" '.$sel.' >'.$month .'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="row-fluid">
        	<div class = "span2">Year</div>
            <div class = "span5">
                <select name="year" class="datepicker input-medium" id="year">
                        <?php
                        for($x=2012;$x<=date('Y')+5;$x++){
                            $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                            echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                        }
                        ?>
                </select>
            </div>
        </div>	
   
       <div class="row-fluid">
			<div class="span2">Fuel Price Type</div>
            <div class="span7">
                <select id="fuel" name="fuel" class= "input-medium">
                <?php
                foreach ( $fuel as $f ) {
                    echo '<option value="'.$f->type.'">'.ucwords(strtolower($f->type )).'</option>';
					
                }				
                ?>		
						<option value="add_fuel"> + Add New</option>
                </select>
            </div>
       </div>
       
       <div class="row-fluid">
			<div class="span2">Fuel Price</div>
            <div class="span7">
                <input type="text"  class="input-medium" id="fuel_price" value = "" name="fuel_price">
            </div>
       </div> 

   		<div class="row-fluid">	
            <div class="span2"></div>
            <div class="span10">
			<a class="btn btn-primary" id="add_button" href="#"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Add Fuel Price </a>
            </div>
   	 	</div><br><br>
   	 	<div id="error_box" class ="row-fluid"></div> 

	</form>
    </section>
    
	<section id="global">

    <legend><h4>Fuel Price Result <small></small></h4></legend>
        <div class="row-fluid">
        	<div class = "span2">Year:</div>
            <div class = "span5">
                <select name="year2" class="datepicker input-medium" id="year2">
                        <?php
                        for($x=2012;$x<=date('Y')+5;$x++){
                            $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                            echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
							
                        }
                        ?>
                </select>
            </div>
        </div>
        
        <div class="row-fluid">
        	 <div class="span2"></div>
        	 <div class="span7">
        	 	<a class="btn btn-primary" href="#" id="btn_display"><i class="icon-align-right icon-white"></i>&nbsp;Show Data</a>
        	 </div>
        </div>
        <hr>
        <div id="result"></div>
        <div id="grid_data" class="container" style="margin-top: 10px">
    	</div>
    	<div id="grid_data1" class="container" style="margin-top: 10px">
    	</div>
        <div style="margin-top:10px; margin-bottom:6px;display: none;" id="export_btns_container">
            <button id="btn_export_xls" type="button" class="btn btn-success"><i class = "icon-download icon-white"></i>Export to XLS</button>
        </div>
	   </section>
    <br>
    <div class="modal fade in" id="modal" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Add Fuel Price</h4>
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
//('.selectpicker').selectpicker();

function precise_round(num,decimals) {
    var rounded = Math.round(num * Math.pow(10, decimals)) / Math.pow(10, decimals);
    var components = rounded.toString().split(".");
    //Comma-fies the first part
    components [0] = components [0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //Combines the two sections
    return components.join(".");
}

$("#fuel_price").numeric()

$.extend({
	    addFuelPrice : function(){
	    	console.log($('form').serialize())
	        $.post('<?=$base_url?>/trading/add_fuel_price',$('form').serialize(),
	        function(data){
	            ret = data.split('|');
  	
	            if (ret[0] == 1) {error_box
	                $('#error_box').attr('class','alert alert-success');
			       	window.location = 'fuel_input_price';
	            } else {
	                $('#error_box').attr('class','alert alert-error');
			       	window.location = 'fuel_input_price';
	            }

	            $('#error_box').html(ret[1]);
	        })
    	},
	    addNewFuel : function(){
	        $.post('<?=$base_url?>/trading/fuel_type_add',$('#fuel_form').serialize(),
	        function(data){
	            ret = data.split('|');
					
	            if (ret[0] == 1) {error_box
					
	                $('#error_box2').attr('class','alert alert-success');
    				//$("#add_new_fuel").html('<img src="../images/done.png"> &nbsp;Done ')
    				window.location = 'fuel_input_price';
			       	 //setTimeout(window.location ="fuel_input_price",20000);
	            } else {
	                $('#error_box2').attr('class','alert alert-error');
	                $('#error_box2').html('<div class="alert alert-error"  style="padding:10px">Unable to Save Data</div>');
	              	//$("#add_new_fuel").html('<img src="../images/error.png"> &nbsp;Failed ')
					window.location = 'fuel_input_price';
	            }
	            $('#error_box2').html(ret[1]);
	        })
    	},
	    loadData : function () {
			$('#grid_data').html('')
	    	$('#result').attr('class','alert alert-info');
	        $("#result").html('Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
	        
	        $('#export_btns_container').hide();
	      
	       $.post('<?=$base_url?>/trading/fuel_interface_action',{year2: $('#year2').val()},
	            function(data){
			        if (data.value == null){
							$('#result').html('<span style="padding:10px">No Data to Display</span>');
							$('#tbl_content').html('')
					}else{
						console.log(data)
						$("#result").html('');
		            	$("#result").removeClass('alert');
		            	$("#grid_data").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed table-hover" id="tbl_content">');
			            var html = ''
			            var html1 = ''
			            var html2 = ''
			            html+= '<thead><tr><th>Month</th>'
			            
			            for (x = 0; x < data.total; x++){
			            	if (data.value1.hasOwnProperty(x)){
			            		html+= '<th>'+data.value1[x]+'</th>'	
			            	}
			            }
			            
			            html+= '</tr></thead><tbody>'
			           
			            $.each(data.value, function (i, val1){
			            	html+= '<tr>'
			            	 $.each(val1, function (i, val){
			            	 	html+= '<td>'+i+'</td>'
				            	 	for (x = 0; x < data.total; x++){
				            	 		if (val.hasOwnProperty(data.value1[x])){
				            	 			html+= '<td>'+precise_round(val[data.value1[x]],2)+'</td>'	
				            	 		}else{
				            	 			html+= '<td>0</td>'
				            	 		}
				            	 	}
				            	 	         		        	
			            	})
			            	html+= '</tr>'
			            })
 						html+= '</tbody>'
 						//console.log(html)
			          	$('#tbl_content').html(html)
			           	$('#tbl_content').dataTable(html)	
			           	$('#export_btns_container').show();
					}
			 })     		
    	},exportData : function(export_type){
        var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/file_fuel_price'
      	var  parameters = "year=" + $('#year2').val();
        
        $.download(url,parameters);
    }
})

$("#add_button").die('click').live('click',function(e){
    e.preventDefault()
		if ($('#fuel_price').val() == ""){
			alert("Please input fuel price.")
			return false;
		}else{
			$(this).html('Saving <img src="../images/ajax-loader.gif">')
	    	$.addFuelPrice();
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

$("#btn_display").unbind('click').bind('click',function(e){
    e.preventDefault();
    //alert('h');
	$.loadData();
});

$("#btn_export_xls").unbind('click').bind('click',function(e){
    e.preventDefault();
	$.exportData();
});

$('#fuel').change(function(){
	if ($('#fuel').val() == "add_fuel"){	
		$('#modal').modal('show')
	}else{
		$('#modal').modal('hide')
		return false;		
	}
	$('#btn-holder').html('<button class="btn btn-primary" id="add_new_fuel"><i class="icon-check"></i>&nbsp;&nbsp;Add&nbsp;&nbsp;</button>')
})

$("#close").unbind('click').bind('click',function(e){
    e.preventDefault();
    
   	window.location = 'fuel_input_price';
   	
});


</script>

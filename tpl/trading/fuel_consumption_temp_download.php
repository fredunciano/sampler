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
			<div class="span2" id = "resource_name">Resource ID</div>
            <div class="span7">
                <select id="resource" name="resource" class="input-medium">
                    <option>Loading Resources...</option>
                    <?php
                    foreach($resource as $r){
                        echo '<option value="'.$r['resource'].'">'.$r['resource'].'</option>';
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
                    echo '<option value="'.ucwords(strtolower($f->fuel)).'">'.ucwords(strtolower($f->fuel )).'</option>';
                }
                ?>
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
        
   		<div class="row-fluid">	
			<div class="row-fluid">
            <div class="span2"></div>
            <div class="span10">
                <br><a class="btn btn-primary" href="#" id="btn_download" id = "btn_download"><i class="icon-arrow-down icon-white"></i>&nbsp;Download</a>
            </div>
       		</div>
   	 	</div>
       </form>
  	</section>
</div>

<script>
$("datepicker").datepicker();
$.extend({
	loadResourceDropDown1: function (){
		$.post('../trading/resource_dropdown',{supplier:$('#resource').val()},
			function(data){
				html = '';
                $.each(data.value, function(i,val){
                    html+='<option value="'+val+'">'+val+'</option>';  
                })
                $('#resources1').html(html);
            });
            return false;
	},
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
		$.post('../trading/resource_category',{type:$('#type').val()},
			function(data){
				html = ''
                $.each(data.value, function(i,val){
                    html+='<option value="'+val.resource+'">'+val.resource+'</option>';
                })
                $('#resource').html(html);
        });
            return false;
	},
	exportData: function (){
			var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/file_fuel_interface'
			var param = "resource=" + $('#resource').val()
			param += "&resources1=" + $('#resources1').val()
			param += "&type=" + $('#type').val()
			param += "&fuel=" + $('#fuel').val()
			param += "&date=" + $('#datepicker').val()
			param += "&values=" + $('input[name="optionsRadios"]:checked').val();
			
			$.download(url,param);
			console.log(param)		
	}
})

$.loadResourceDropDown();

$('#type').change(function(){
	$.loadResourceDropDown();
})

$("#btn_download").unbind('click').bind('click',function(e){
    e.preventDefault();
    	if ($('#datepicker').val() == ""){
    		alert("Please choose a date.")
    		return false;
    	}else{
    		$.exportData()	
    	}
})	
	
</script>
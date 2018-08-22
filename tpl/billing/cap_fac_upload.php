<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Billing and Settlements</div>
        <div>
            <ul class="submenu">
                <?php
                foreach ( $submenu as $sm ) {
                    echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
                }
                ?>
            </ul> 
        </div>
    </div>
</div>
<div class="span-19 last">
    <br>
    <fieldset class="fs-blue">
        <legend><?=$title?></legend>
        <form id="frm1" class="frm" enctype="multipart/form-data" onsubmit="return false;" method="post">
        <table>
            <tr>
                <th>Capacity Factor Template</th>
                <td><button id="download">Download Template</button></td>
            </tr>
            <tr>
                <th width="150px">Billing Period</th>
                <td >
                    <select name="billing_period_month" id="billing_period_month">
                        <?php
                        for ($x=1;$x<=12;$x++) {
                            echo '<option value="'.$x.'">'.date('F',mktime(0,0,0,$x,1,date('Y'))).'</option>';
                        }
                        ?>
                        
                    </select>
                    <select name="billing_period_year" id="billing_period_year">
                        <?php
                        for ($x=date('Y');$x>=date('Y')-2;$x--) {
                            echo '<option>'.$x.'</option>';
                        }
                        ?>
                    </select>
                </td> 
            </tr>
            <tr>
                <th>Customer</th>
                <td>
                    <select id="customer_id" name="customer_id">
                    <?php
                        foreach ($customers as $c) {
                            echo '<option value="'.$c->id.'">'.$c->name.'</option>';
                        }
                    ?>
                    </select>&nbsp;&nbsp;&nbsp;
                    <button id="retrieve_cap_fac">Retrieve</button>&nbsp;&nbsp;<span id="msg-alert-retrieve"></span>
                </td>
            </tr>
            <tr>
                <th>Upload Capacity Factor</th>
                <td><input type="file" name="filebrowser" id="filebrowser">
                	<button type="submit" value="Submit" id="upload_btn" >Populate</button>
                	<span id="msg-alert"></span></td>
            </tr>
        </table>
        </form>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result">
        <legend>Capacity Factor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
        <form id="frm2" method="post">
        <table>
            <tr>
                <th width="150px"><b>Capacity Factor (%)</b></th>
                <th><b>Capacity Factor Pricing (USD/kWh)</b></th>
                <th><b>Minimum Capacity</b></th>
            </tr>
            <?php
                
                for ($x=100;$x>=45;$x--) {
                    echo '
                            <tr>
                                <td>'.$x.'%</td>
                                <td><input type="text" id="cap_fac_pricing_'.$x.'"
                                    name="cap_fac_pricing_'.$x.'" style="margin:0"></td>
                                <td>
                                	<input type="radio" id="min_cap_fac_'.$x.'" name="min_cap_fac" value="'.$x.'">
                                </td>
                            </tr>   
                         ';
                }
            
            ?>
            
        </table>
        </form>    
        <div id="result"></div>
    </fieldset>
    <button id="submit_cap_fac">Submit Capacity Factor</button>&nbsp;&nbsp;<span id="msg-alert-submit"></span>
    <br><br><br><br><br>
</div>
<script src="../js/jquery.form.js"></script>
<script>
$.extend({
    exportData : function(){
        
        var url = '../billing/excel_cap_fac'
        var parameters = "billing_period_month=" + $('#billing_period_month').val();

        $.download(url,parameters);
    },
    parseData : function(){
        var path = '../billing/parse_cap_fac';
    
        var options = {target:'#msg-alert',
            url:path,
            data: {billing_period_month:$("#billing_period_month").val(),billing_period_year:$("#billing_period_year").val(),
                   customer_id:$("#customer_id").val()},
            beforeSubmit: function() { 
                $('#msg-alert').html('Loading...')
            },
            success: function(data) {
                //alert(data)
                //return false;
                data = $.parseJSON(data);
                
                var obj = data.value;

                for (x=100;x>=45;x--) {
                    $('#cap_fac_pricing_'+x).val(obj.cap_fac[x]);
                   
                }
                $('#msg-alert').html('')
                $('#result').html('')

            }};	
        $('#frm1').ajaxSubmit(options);	
    },
    insertCapFac : function(){
        $('#msg-alert-submit').html('Loading...');
        
        $.post('../billing/cap_fac_action',$('#frm1, #frm2').serialize(),
        function(data){
            $('#msg-alert-submit').html(data);
        });	
        return false;
    },
    getCapFac : function()
    {
        
        $('#msg-alert-retrieve').html('Loading...');
        $.post('../billing/cap_fac_load',$('#frm1').serialize(),
        function(data){
            //$('#min_cap_fac_75').attr('checked','checked');
            
            data = $.parseJSON(data);
            if (data.length !== 0) {
                for (x=100;x>=45;x--) {

                    $('#cap_fac_pricing_'+x).val(data[x].pricing);
                	if (data[x].min_cap_fac == '1'){
                		$('#min_cap_fac_'+x).attr('checked','checked');
                	}
                }
                $('#msg-alert-retrieve').html('');
            } else {
                $('#msg-alert-retrieve').html('Data not available');
                for (x=100;x>=45;x--) {
                    $('#cap_fac_pricing_'+x).val('');
                }
            }
        });	
        return false;
    }
});
</script>
<script>
$('#frm1').submit(function(e){
		e.preventDefault();
			if($('#filebrowser').val() == "") return false;
			
			var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/cap_fac_parser';
			
			var options = {
				target:'',
				url:url,
				beforeSubmit:	function() { 
					$('#resultbox').html('Loading...'); 
				},
				success:	function(data) {
					//console.log(data);
					var ret = $.parseJSON(data);
					$.each(ret, function(i, val){
						$('input[id=cap_fac_pricing_'+i+']').val(val.toString().replace(/\B(?=(?=\d*\.)(\d{3})+(?!\d))/g, ','));
					
					});
					$('#resultbox').html('');
					//$('#fileinput').val('');
					$('#filebrowser').val('');
					//$.updateTotalNominationValue();
				}
			};
			
			$("#frm1").ajaxSubmit(options);
		});
$('#download').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.exportData();
})
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.parseData();
}) 
$('#submit_cap_fac').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.insertCapFac();
})
$('#retrieve_cap_fac').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.getCapFac();
})
</script>
<style>
th.theader {
    text-align:center;
    background-color:#6897CA !important;
    padding:5px;
}
.theader {
	text-align:center;
}
.total td {
	text-align:center;
}
.field{
	 width:99%;

}
#fieldset {
	max-width:1024px;
    max-height:auto;
   overflow:auto; 
}
</style>
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
        <form enctype="multipart/form-data" method="post">
            <table>
               <tr>
                    <th width="150px">Billing Period</th>
                    <td>
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
                    <th></th>
                    <td><button id="btn_display_records" type="button">Display</button><button id="x_xls" type="button">Export to Excel</button></td>
                </tr>
            </table>
        </form>
    </fieldset><br>
    <div id="result_loader" class="loader"></div>
    <fieldset class="fs-blue field">
        <legend>Result</legend>
        <div id="fieldset">
            
        </div>    
    </fieldset>
     <!---
    <fieldset class="fs-blue">
        <form id="frm_data">
            <div id="tabs"></div>
        </form>
    </fieldset>--->
    <br><br><br>
</div>
<script src="../js/date.js"></script>
<script type="text/javascript">
	$.extend({
		loadData : function () {
		$("#result_loader").html('Please wait  &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
		html = '<table>';
		$.post('../billing/cap_fac_sum_action',{month : $('#billing_period_month').val(), year : $('#billing_period_year').val()},
		function(data){
			console.log(data.total)
				if (data.total > 1){
			console.log(data);
			html+= '<tr><th class="theader" style="width:100px">Capacity Factor (%)</th>'
			$.each(data.value['100%'],function(cust,x){
				html+= '<th class="theader">'+cust+'</th>'
			})
			html+='</tr>'
			$.each(data.value,function(p,value){
				html+='<tr><th class="theader">'+p+'</th>'
				$.each(value,function(i,val){
					console.log(val)
					html+='<td class="theader">'+parseFloat(val.pricing).toFixed(4)+'</td>'
				})
				html+='</tr>'
				
			})
			html+='</table>'
			$("#result_loader").html('');
			$("#fieldset").html(html);
				}else{
				$("#result_loader").html('');
				$("#fieldset").html('No Data to Display');
				}
			}
		
		)},
		exportExcel : function (){
			 var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/cap_fac_export';
       		 var parameters = "month="+$('#billing_period_month').val()+"&year="+$('#billing_period_year').val();
       	 	 $.download(url,parameters);
		}
	});
		
</script>
<script>
	$('#btn_display_records').unbind('click').bind('click',function(e){
		e.preventDefault();
		$.loadData();
	})
	$('#x_xls').unbind('click').bind('click',function(e){
		e.preventDefault();
		$.exportExcel();
	})
</script>
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
        <div class="submenu_title_box">BCQ - Reports</div>
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
        <form method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Customer</th>
                    <td>
                        <select id="cmb_buyers">
                            <?php
                            foreach ($customers as $i=>$val) {   
                                    echo '<option value="'.$val->name.'">'.$val->name.'</option>';
							}
                            ?>
                        </select>
                    </td>
                </tr>
               <tr>
                    <th width="150px">Billing Period</th>
                    <td>
                        <select name="month" class="datepicker" id="month" >
                            <?php
                            $billing_start = $def_date_man_start;
                            $billing_start = date_parse($billing_start);
                            for($x=1;$x<=12;$x++){
                                $time_tmp = mktime (0, 0, 0, $x+1 , 0, 0);
                                $month = date('F',$time_tmp);
                                $sel = (($billing_start['month']) == $x) ? 'selected=selected' : '';
                                echo '<option value="'.$x.'" '.$sel.' >'.$month .'</option>';
                            }
                            ?>
                        </select>
                        <select name="year" class="datepicker" id="year">
                            <?php
                            for($x=2006;$x<=date('Y')+5;$x++){
                                $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                                echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td><button id="btn_display_records" type="button">Display</button>&nbsp;&nbsp;<button id="x_xls" type="button">Export to Excel</button></td>
                </tr>
            </table>
        </form>
    </fieldset><br>
    
    <fieldset class="fs-blue field">
        <legend>Result</legend>
        <div id="result_loader" class="loader"></div>
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
		 var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
           		var mn = parseInt($('#month').attr('value'),10)-1;
           		var end_date = new Date(yr,mn,25);
           		var start_date = new Date(yr,mn,26);
           		
           		mdate = start_date.add( {months: -1 });
				var loop_date = start_date.clone();
				var hor_date = start_date.clone();
           		mdate = mdate.toString("d-MMM-yyyy");
                var trading_date = mdate
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,list_html = '';

         
            var parameters =  {'action':'list', 'date' : cur_selected_date, 'cust_id' : $('#cmb_buyers').val()};
		 $.post('../billing/bcq_report_action',parameters,
		 function(data){
		 	//console.log(data);
		 	//data = $.parseJSON(data)
		 	var html = '<table><tr><th class="theader">Interval</th>';
		 	 while (loop_date<=end_date){
               loop_date_string = loop_date.toString("d-MMM-yyyy");
               html+='<th class="theader">'+loop_date_string+'</th>'
               loop_date = loop_date.add(1).days();
           }
           	html+='<th class="theader">Total</th></tr>';
		 	var totalver = 0,
		 		total    = 0,
		 		totalhor = 0,
		 		x = 1;
		 		
		 		$.each(data,function(i,val){
		 		html+='<tr><th class="theader" style="position:absolute;padding:3px 5px 3px 5px;" width="35px" >'+i+'</th>'
		 			$.each(val,function(h,hour){
		 				if (hour == ''){
		 					hour = 0;
		 				}
		 			if (hour == 0){
		 			html+='<td class="theader">'+parseFloat(hour)+'</td>';	
		 			}else{
		 			html+='<td class="theader">'+parseFloat(hour).toFixed(7)+'</td>';	
		 			}
		 			totalver+=parseFloat(hour);
		 			total+=parseFloat(hour);
		 			})
		 			
		 		html+='<td class="theader">'+totalver.toFixed(7)+'</td></tr>'	
		 			totalver = 0;		 			
		 		})
		 		
		 		
		 		html+='<th class="theader" width="35px" style="position:absolute;padding:5px;">Total</td>';
		 		var hor = 1;
		 		while (hor_date<=end_date){
               		hor_date_string = hor_date.toString("yyyy-MM-dd");
               		$.each(data,function(i,val){
               			totalhor+=parseFloat(val[hor])	
               		})
               		hor++;
               		hor_date = hor_date.add(1).days();
               		if (isNaN(totalhor)){
               			totalhor = 0;
               		}
               		html+='<td class="theader">'+totalhor.toFixed(7)+'</td>';
               		totalhor = 0;
           		}		 		
		 		html+='<td class="theader">'+total.toFixed(7)+'</td></table>';
		 		$("#result_loader").html('');
		 		
		 		$("#fieldset").html(html);
		 		
		 		//$("#result_loader").html('');
		 });
		 
		},
		exportExcel : function() {
       		var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/bcq_report_xls'
       		var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
           		var mn = parseInt($('#month').attr('value'),10)-1;
           		var end_date = new Date(yr,mn,25);
           		var start_date = new Date(yr,mn,26);
           		
           		mdate = start_date.add( {months: -1 });
				var loop_date = start_date.clone();
				var hor_date = start_date.clone();
           		mdate = mdate.toString("d-MMM-yyyy");
                var trading_date = mdate
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,list_html = '';

         
            var parameters =  {'date' : cur_selected_date, 'cust_id' : $('#cmb_buyers').val()};
       	 	$.download(url,parameters);
    },
		
	});
	
	 $('#btn_display_records').unbind('click').bind('click',function(){
                $.loadData();
            });
            
     $('#x_xls').unbind('click').bind('click',function(){
     			$.exportExcel();
     });
</script>

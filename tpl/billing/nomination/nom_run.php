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
        <div class="submenu_title_box">Buyer Nomination</div>
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
                    <th>Type</th>
                    <td>
                        <select id="nom_type">
                            <option id="t_dan" value="DAN">DAN</option>
                            <option id="t_wan" value="WAN">WAN</option>
                            <option id="t_man" value="MAN">MAN</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><input type="checkbox" checked="checked" id="chk_all_buyers">All Buyers</th>
                    <td>
                        <select id="cmb_buyers" disabled="true">
                            <?php
                            foreach ($customers as $i=>$val) {
                                if ($customer_id === $val->id) {
                                    echo '<option value="'.$val->id.'" selected>'.$val->name.'</option>';
                                } else {
                                    echo '<option value="'.$val->id.'">'.$val->name.'</option>';
                                }
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
                    <td><button id="btn_display_records" type="button">Display</button><button id="x_csv" type="button">Export to CSV</button><button id="x_xlsx" type="button">Export to Excel</button></td>
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
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = ''
                ,nom_type = $('#nom_type').val();
                
               
         
		 var parameters =  {'action':'list', 'date' : cur_selected_date , 'type' : nom_type};
            if (!is_all_buyers) {
                parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            $.ajax({
                type: "POST"
                ,url : '../billing/nom_run_action'
                ,data: parameters
                ,dataType:'json'
                ,async: true
                ,success: function(data){
		 
		 	var html = '<table><tr><th class="theader">Interval</th>';
		 	 while (loop_date<=end_date){
               loop_date_string = loop_date.toString("d-MMM-yyyy");
               html+='<th class="theader" >'+loop_date_string+'</th>'
               loop_date = loop_date.add(1).days();
           }
           	html+='<th class="theader">Total</th></tr>';
		 	var totalver = 0,
		 		total    = 0,
		 		totalhor = 0;
		 		
		 		$.each(data,function(hour,date){
		 			html +='<tr><th class="theader" style="position:absolute;padding:3px 5px 3px 5px;" width="35px">'+hour+'</th>';
		 			$.each(date,function(i,val){
		 				if (val == ''){
		 					val = 0;
		 				}
		 				
		 			html+='<td class="theader">'+parseFloat(val).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
		 			totalver+=parseFloat(val);
		 			total+=parseFloat(val);
		 			})
		 			
		 			html+='<td class="theader">'+parseFloat(totalver).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td></tr>';
		 			totalver = 0;		 			
		 		})
		 		html+='<th class="theader" style="position:absolute;padding:3px 5px 3px 5px;" width="35px">Total</td>';
		 		while (hor_date<=end_date){
               		hor_date_string = hor_date.toString("yyyy-MM-dd");
               		$.each(data,function(hour,date){
               			
               			totalhor+=parseFloat(date[hor_date_string])	
               		})
               		hor_date = hor_date.add(1).days();
               		if (isNaN(totalhor)){
               			totalhor = 0;
               		}
               		html+='<td class="theader">'+totalhor.toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
               		totalhor = 0;
           		}		 		
		 		html+='<td class="theader">'+total.toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td></table>';
		 		$("#result_loader").html('');
		 		
		 		$("#fieldset").html(html);
		 		}
		 		,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#date").html('With errors');
                }
		 });
		 
		},
		exportCSV : function () {
    		var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
           		var mn = parseInt($('#month').attr('value'),10)-1;
           		var end_date = new Date(yr,mn,25);
           		var start_date = new Date(yr,mn,26);

           		mdate = start_date.add( {months: -1 });

           		mdate = mdate.toString("d-MMM-yyyy");
                var trading_date = mdate
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = ''
                ,nom_type = $('#nom_type').val();

           

            var parameters =  "action=list&date="+cur_selected_date+"&type="+nom_type+"&extension=.csv";
            if (!is_all_buyers) {
            	parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/nom_run_export'
       	 	$.download(url,parameters);
       	 	//$.post('../trading_nomination/nom_run_csv',{action : 'list', date : cur_selected_date, type: nom_type,cust_id : $('#cmb_buyers').attr('value')},function(data){
       	 	//	console.log(data)
       	 	//})
    	},
    	exportExcel : function () {
    		var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
           		var mn = parseInt($('#month').attr('value'),10)-1;
           		var end_date = new Date(yr,mn,25);
           		var start_date = new Date(yr,mn,26);

           		mdate = start_date.add( {months: -1 });

           		mdate = mdate.toString("d-MMM-yyyy");
                var trading_date = mdate
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = ''
                ,nom_type = $('#nom_type').val();

           

            var parameters =  "action=list&date="+cur_selected_date+"&type="+nom_type+"&extension=.xlsx";
            if (!is_all_buyers) {
            	parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/nom_run_export'
       	 	$.download(url,parameters);
       	 	//$.post('../trading_nomination/nom_run_csv',{action : 'list', date : cur_selected_date, type: nom_type,cust_id : $('#cmb_buyers').attr('value')},function(data){
       	 	//	console.log(data)
       	 	//})
    	}
		
	});
	
	 $('#btn_display_records').unbind('click').bind('click',function(e){
	 	e.preventDefault();
                 $.loadData();
                 
            });
     $('#x_csv').unbind('click').bind('click',function(e){
     	e.preventDefault();
     	$.exportCSV();
     });
     $('#x_xlsx').unbind('click').bind('click',function(e){
     	e.preventDefault();
     	$.exportExcel();
     });
     $('#chk_all_buyers').unbind('click').bind('click',function(){
                var is_all_buyers = $('#chk_all_buyers').is(':checked');
                if (is_all_buyers) {
                    $('#cmb_buyers').attr('disabled',true);
                } else {
                    $('#cmb_buyers').attr('disabled',false);
                }
            });
    
</script>

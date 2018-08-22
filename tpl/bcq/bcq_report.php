<style>
td.text-right, td.theader { text-align:right;}
th.text-center, td.text-center { text-align: center; }
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
        <div class="span2">Customer</div>
        <div class="span10">
            <select id="cmb_buyers">
                <?php
                foreach ($customers as $i=>$val) {   
                        echo '<option value="'.$val->name.'">'.$val->name.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Billing Period</div>
        <div class="span10">
            <select name="month" id="month" class="span2">
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
            <select name="year" id="year" class="span2">
                <?php
                for($x=2006;$x<=date('Y')+5;$x++){
                    $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                    echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <button id="btn_display_records" type="button" class="btn btn-primary">Display</button>&nbsp;&nbsp;
            <button id="x_xls" type="button" class="btn btn-success">Export to Excel</button>
        </div>
    </div>
    <br>
    <div id="grid_data"></div>
    <br>
</div>

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
		 $.post('../bcq/bcq_report_action',parameters,
		 function(data){
		 	console.log(data);
		 	//data = $.parseJSON(data)
		 	var html = '<table class="table table-bordered table-hover"><tr><td class="text-center"><b>Interval</b></td>';
		 	 while (loop_date<=end_date){
               loop_date_string = loop_date.toString("d-MMM-yyyy");
               html+='<td class="text-center"><b>'+loop_date_string+'</b></td>'
               loop_date = loop_date.add(1).days();
           }
           	html+='<th class="text-center">Total</th></tr>';
		 	var totalver = 0,
		 		total    = 0,
		 		totalhor = 0,
		 		x = 1;
		 		
		 		$.each(data,function(i,val){
		 		html+='<tr><th width="35px" class="text-center">'+i+'</th>'
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
		 		
		 		
		 		html+='<th class="text-center">Total</th>';
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
               		html+='<td class="text-right">'+totalhor.toFixed(7)+'</td>';
               		totalhor = 0;
           		}		 		
		 		html+='<td class="text-right">'+total.toFixed(7)+'</td></table>';
		 		$("#result_loader").html('');
		 		
		 		$("#grid_data").html(html);
		 		
        var w = $(document).width()-330;
        var h = $(document).height()-100;
        $('#grid_data').css('width',w+'px').css('height','auto').css('overflow','auto')
		 		//$("#result_loader").html('');
		 });
		 
		},
		exportExcel : function() {
       		var url = 'http://' + location.host + '<?=$base_url?>' + '/bcq/bcq_report_xls'
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

         
            var parameters =  'date=' + cur_selected_date +  '&cust_id=' + $('#cmb_buyers').val();
       	 	$.download(url,parameters);
    },
		
	});
	
     $.loadData();
	 $('#btn_display_records').unbind('click').bind('click',function(){
                $.loadData();
            });
     $('#x_xls').unbind('click').bind('click',function(){
     			$.exportExcel();
     });
</script>

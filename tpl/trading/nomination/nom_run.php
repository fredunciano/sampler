<style>
td.text-right, td.theader { text-align:right;}
th.text-center { text-align: center; }
</style>
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
    <legend><h4><?=$title?> <small>&nbsp;( Trading )</small></h4></legend>
    <div class="row-fluid">
        <div class="span2">Type</div>
        <div class="span10">
            <select id="nom_type">
                <option value="DAN">DAN</option>
                <option value="WAN">WAN</option>
                <option value="MAN">MAN</option>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"><label class="checkbox"><input type="checkbox" checked="checked" id="chk_all_buyers">All Buyers</label></div>
        <div class="span10">
            <select id="cmb_buyers" disabled="true">
                <?php
                foreach ($customers as $i=>$val) {
                    if ($customer_id === $val->name) {
                        echo '<option value="'.$val->name.'" selected>'.$val->name.'</option>';
                    } else {
                        echo '<option value="'.$val->name.'">'.$val->name.'</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Billing Period</div>
        <div class="span10">
            <select name="month" class="span2" id="month">
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
            <select name="year" class="span2" id="year">
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
            <button id="btn_display_records" class="btn btn-primary"><i class="icon-ok-circle"></i>&nbsp;Display</button>
            <button id="x_csv" class="btn btn-success"><i class="icon-download-alt"></i>&nbsp;Export to CSV</button>
            <button id="x_xlsx" class="btn btn-success"><i class="icon-download-alt"></i>&nbsp;Export to Excel</button>
        </div>
    </div>
    <br>
    <div id="result_loader" class="loader"></div>
    <div id="grid_result" class="grid-scroll" style="overflow:auto;width:110%; max-width: 100%">
    <div class="row-fluid" id="result"></div>
   	</div>
    <br><br>
</div>

<script type="text/javascript">
	$.extend({
		loadData : function () {
	     $('#grid').html('');
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
                ,url : '../trading_nomination/nom_run_action'
                ,data: parameters
                ,dataType:'json'
                ,async: true
                ,success: function(data){
		 
		 	var html = '<table class="table table-bordered table-hover"><tr><th class="text-center">Interval</th>'
		 	 while (loop_date<=end_date){
               loop_date_string = loop_date.toString("d-MMM-yyyy");
               html+='<th class="text-center">'+loop_date_string+'</th>'
               loop_date = loop_date.add(1).days();
           }
           	html+='<th class="text-center">Total</th></tr>';
		 	var totalver = 0,
		 		total    = 0,
		 		totalhor = 0;
		 		
		 		$.each(data,function(hour,date){
		 			html +='<tr><th width="35px" class="text-center">'+hour+'</th>';
		 			$.each(date,function(i,val){
		 				if (val == ''){
		 					val = 0;
		 				}
		 				
		 			html+='<td class="text-right">'+parseFloat(val).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td>';
		 			totalver+=parseFloat(val);
		 			total+=parseFloat(val);
		 			})
		 			
		 			html+='<td class="text-right">'+parseFloat(totalver).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+'</td></tr>';
		 			totalver = 0;		 			
		 		})
		 		html+='<th width="35px" class="text-center">Total</td>';
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
		 		
		 		$("#result").html(html);
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
            	// parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
              parameters = parameters+"&cust_id="+$('#cmb_buyers').val();
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading_nomination/nom_run_export'
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
            	// parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
              parameters = parameters+"&cust_id="+$('#cmb_buyers').val();
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }

    		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading_nomination/nom_run_export'
       	 	$.download(url,parameters);
       	 	//$.post('../trading_nomination/nom_run_csv',{action : 'list', date : cur_selected_date, type: nom_type,cust_id : $('#cmb_buyers').attr('value')},function(data){
       	 	//	console.log(data)
       	 	//})
    	}
		
	});
	
    $.loadData();
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

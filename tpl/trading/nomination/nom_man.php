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
        </div>
    </div>
    <br>
    <div id="result_loader" class="loader"></div>
    
    <div class="row-fluid" id="month-nom"></div>
    <br><br>
</div>

<script type="text/javascript">

    $.extend({
       displayMANRecords : function(){
           $("#result_loader").html('Please wait  &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
           var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
           var mn = parseInt($('#month').attr('value'),10)-1;
           var end_date = new Date(yr,mn,25);
           var start_date = new Date(yr,mn,26);

           start_date.add( {months: -1 });

           $('#date_start').html(start_date.toString("d-MMM-yyyy"));
           $('#date_end').html(end_date.toString("d-MMM-yyyy"));

           var loop_date = start_date.clone();

           var x = 0;
           var tab_title = '';
           var tab_content = '';
           tab_title+='<div style="overflow:scroll;width:100%">';
           tab_title+='<ul class="nav nav-tabs" style="width:3150px">';
           tab_content+='<div class="tab-content">';
           while (loop_date<=end_date){
               x++;
               loop_date_string = loop_date.toString("d-MMM-yyyy");
               //ADDED FOR WAN DATA QUERY//
	           var cur_selected_date = Date.parse(loop_date_string).toString('yyyy-MM-dd')
	           ,is_all_buyers = $('#chk_all_buyers').is(':checked')
	           ,list_html = '';
	           
	            var parameters =  {'action':'list', 'date' : cur_selected_date , 'type' : 'WAN'};
	            if (!is_all_buyers) {
	                parameters['cust_id'] =   $('#cmb_buyers').attr('value');
	            }
            	//END//
               if (x==1) {
                    active = 'active';
                } else {
                    active = '';
                }
               tab_title+='<li class="'+active+'"><a href="#c'+x+'" data-toggle="tab">'+loop_date_string+'</a></li>';               
               tab_content+='<div class="tab-pane '+active+'" id="c'+x+'">'+
                            '<p class="text-center text-info">Delivery Date : <b>'+loop_date_string+'</b></p>'+
                            '<table class="table table-condensed table-bordered table-hover">'+
                            '<tr>'+
                            '<th width="150px">Interval</th>'+
                            '<th>Unit</th>'+
                            '</tr>'

                   //WAN QUERY//    
                var row_contents = '';       
                
				$.ajax({
                type: "POST"
                ,url : '../trading_nomination/nom_action'
                ,data: parameters
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                	console.log(returnData)
                    var list_data = returnData.value,
                        interval_data = null,
                        row_contents = '',
                        left_index = 1,
                        right_index = 100;
				
                   

                    for (var i=1;i<=24;i++){
                        row_contents = '<tr>';
                        row_contents+= '<td>'
                            + i +' ('+ $.strPad(left_index,4,'0') + 'H'
                            + '-' + $.strPad(right_index,4,'0')   +'H)'
                            + '</td>';


                        var acc_value = 0;
                        var min_value = 0;
                        var nom_value = 0;
                        if ( typeof list_data[i.toString()] != 'undefined') {
                            nom_value = typeof list_data[i.toString()] != 'undefined' ? list_data[i.toString()] : 0;
                        }



                        if ( nom_value == null  ) {
                            nom_value = 0;
                        }


                        nom_value = parseFloat(nom_value).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        row_contents+= '<td>&nbsp;'+ nom_value +'MW</td>'; // nom
                        row_contents+= '</tr>';

                        tab_content+= row_contents;

                        left_index = left_index + 100;
                        right_index = right_index + 100;

                    }
                    $("#result_loader").html('');
                }
                
            });
            //WAN QUERY END//
               tab_content+='</table></div>';
               
               loop_date = loop_date.add(1).days();
           }
           tab_title+= '</ul>';
           tab_title+='</div>';
           tab_content+='</div>';
           $('#month-nom').html(tab_title+tab_content);
           
           $("#result_loader").html('');
       }

       ,displayMANSpecificDateRecords : function(dte){
            var cur_selected_date = Date.parse(dte).toString('yyyy-MM-dd')
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = '';

            // ################ loader
            $("#"+dte).html('');
            $("#result_loader").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');

            // ################ tab contents
            var parameters =  {'action':'list', 'date' : cur_selected_date , 'type' : 'MAN'};
            if (!is_all_buyers) {
                parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            /*else {
                var customers = [];
                $("#cmb_buyers option").each(function(){
                    customers.push($(this).val())
                });
                parameters['cust_id'] =   customers.join(',');
            }*/
            $.ajax({
                type: "POST"
                ,url : '../trading_nomination/nom_action'
                ,data: parameters
                ,dataType:'json'
                ,async: false
                ,success: function(returnData){
                    var list_data = returnData.value,
                        interval_data = null,
                        row_contents = '',
                        left_index = 1,
                        right_index = 100;

                    list_html = ' <table>';
                    list_html+= '<tr>';
                    list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">Interval</td>';
                    //list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">ACC (kW)</td>';
                    //list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">Min. Allowable Nomination (kW)</td>';
                    list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">Nomination (kW)</td>';
                    list_html+= '</tr>';

                    for (var i=1;i<=24;i++){
                        row_contents = '<tr>';
                        row_contents+= '<td class="tablestyle" style="width:125px;padding-left:20px">'
                            + i +' ('+ $.strPad(left_index,4,'0') + 'H'
                            + '-' + $.strPad(right_index,4,'0')   +'H)'
                            + '</td>';


                        var acc_value = 0;
                        var min_value = 0;
                        var nom_value = 0;
                        if ( typeof list_data[i.toString()] != 'undefined') {
                            nom_value = typeof list_data[i.toString()] != 'undefined' ? list_data[i.toString()] : 0;
                        }



                        if ( nom_value == null  ) {
                            nom_value = 0;
                        }


                        nom_value = parseFloat(nom_value).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        row_contents+= '<td class="tablestyle" style="background-color:#F2F7B9;padding:12px;min-width: 120px;text-align: right;">&nbsp;'+ nom_value +'</td>'; // nom
                        row_contents+= '</tr>';

                        list_html+= row_contents;

                        left_index = left_index + 100;
                        right_index = right_index + 100;

                    }
                    list_html += '</table>';
                    $("#"+dte).html(list_html);
                    $("#result_loader").html('');
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#"+dte).html('With errors');
                }
            });
        }
    });
    $.extend({
    	
    	exportCsv : function(){
    		var yr = parseInt($('#year').attr('value'),10) ; // should be zero-based
           		var mn = parseInt($('#month').attr('value'),10)-1;
           		var end_date = new Date(yr,mn,25);
           		var start_date = new Date(yr,mn,26);

           		mdate = start_date.add( {months: -1 });

           		mdate = mdate.toString("d-MMM-yyyy");
                var trading_date = mdate
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = '';

           

            var parameters =  "action=list&date="+cur_selected_date+"&type=MAN";
            if (!is_all_buyers) {
            	parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading_nomination/ma_nom_csv'
       	 	$.download(url,parameters);
    	}
    });

    $(document).ready(function() {
            $.displayMANRecords();
            $('#btn_display_records').unbind('click').bind('click',function(){
                 $.displayMANRecords();
                
            });
			$('#x_csv').unbind('click').bind('click',function(e){
				e.preventDefault();
				//$.testdata();
                 $.exportCsv();
            });
            $('#chk_all_buyers').unbind('click').bind('click',function(){
                var is_all_buyers = $('#chk_all_buyers').is(':checked');
                if (is_all_buyers) {
                    $('#cmb_buyers').attr('disabled',true);
                } else {
                    $('#cmb_buyers').attr('disabled',false);
                }
            });
    });
</script>

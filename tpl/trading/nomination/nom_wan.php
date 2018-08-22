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
        <div class="span2">Relevant Trading Day</div>
        <div class="span10">
            <input style="width:200px" type="text" name="trading_date" id="trading_date" value="<?=$def_date_wan_start?>" />
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
    <p class="text-center text-info"></p>
    <div class="row-fluid" id="week-nom"></div>
    <br><br>
</div>

<script type="text/javascript">

    $.extend({
       displayWANRecords : function(){
          $("#result_loader").html('Please wait  &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');  
           var weekdays = ["Monday","Tuesday","Wednesday","Thursday","Friday"],
               trading_weekday = weekdays [Date.parse( $("#trading_date").val() ).getDay()],
               start_date = null,
               end_date = null;
               //console.log(trading_weekday)

           start_date = Date.parse( $("#trading_date").val() );
           end_date = Date.parse( $("#trading_date").val() );
           end_date = end_date.add(6).days();

           $('#date_start').html(start_date.toString("d-MMM-yyyy"));
           $('#date_end').html(end_date.toString("d-MMM-yyyy"));

           var loop_date = start_date.clone();
           var tabs_selectors = "";
           var tab_contents = '<ul id="week-nom-tab-selectors">';
           var tabs = "";

           $('#week-nom').html("");
           var x = 0;
           var tab_title = '';
           var tab_content = '';
           tab_title+='<div style="overflow:auto;width:100%">';
           tab_title+='<ul class="nav nav-tabs">';
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
            
            /*
                   for ( x1=1;x1<=24;x1++ ) {
                       start = x1*100+1-100;
                       end = x1*100;
                       xstart  = $.strPad(start,4);
                       xend    = $.strPad(end,4);

                       tab_content+='<tr>';
                       tab_content+='<td>'+x1+'&nbsp;('+xstart+'-'+xend+'H)</td>';
                       tab_content+='<td width="100px"><span id="txt_unit_'+x+'_'+x1+'" name="txt_unit_'+x+'_'+x1+'" ></span> MW</td>';
                       tab_content+='<td><span id="remarks_'+x+'_'+x1+'" name="remarks_'+x+'_'+x1+'"></span></td>';
                       tab_content+='<td><span id="desc_'+x+'_'+x1+'" name="desc_'+x+'_'+x1+'"></span></td>';
                       tab_content+='<td><span id="source_'+x+'_'+x1+'" name="source_'+x+'_'+x1+'"></span></td>';
                       tab_content+='</tr>';
                   }
               */
               tab_content+='</table></div>';
               
               loop_date = loop_date.add(1).days();
           }
           tab_title+= '</ul>';
           tab_title+='</div>';
           tab_content+='</div>';
           $('#week-nom').html(tab_title+tab_content);
           
           $("#result_loader").html('');

       }
    });
    $.extend({
    	exportCsv : function(){
    		 var trading_date = $("#trading_date").val()
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = '';

            // ################ loader
           $('#date').html(Date.parse(trading_date).toString("MMMM d, yyyy"));
            

            // ################ tab contents
            var parameters =  "action=list&date="+cur_selected_date+"&type=WAN";
            if (!is_all_buyers) {
            	parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading_nomination/wa_nom_csv'
       	 	$.download(url,parameters);
    	}
    });
    $(document).ready(function() {
            $.displayWANRecords();
            $('#btn_display_records').unbind('click').bind('click',function(e){
            	e.preventDefault();
            	
                 $.displayWANRecords();
               
                 //alert("test");
                 //$.displayWANSpecificDateRecords();
            });

            $("#trading_date").datepicker();
			$('#x_csv').unbind('click').bind('click',function(e){
				e.preventDefault();
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

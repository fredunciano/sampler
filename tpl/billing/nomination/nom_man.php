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
                        &nbsp;&nbsp;&nbsp;<button id="x_csv">Export to CSV</button>
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
                    <td><button id="btn_display_records" type="button">Display</button></td>
                </tr>
            </table>
        </form>
    </fieldset><br>
    <div id="result_loader" class="loader"></div>
    <fieldset id="fldst_list" style="display: none;" class="fs-blue">
        <div style="text-align: center;font-weight: bold;margin-bottom: 10px;">Delivery Date: <b id="date_start">Mar 02, 2012</b> to <b id="date_end">Mar 02, 2012</b></div>
        <div id="month-nom" class="ui-tabs ui-widget ui-widget-content ui-corner-all">


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
<script src="../js/jquery.pad.js"></script>
<script src="../js/jquery.form.js"></script>
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
           var tabs_selectors = "";
           var tab_contents = '<ul id="month-nom-tab-selectors">';
           var tabs = "";

           $('#fldst_list').css('display','none');
           $('#month-nom').html("");
           while (loop_date<=end_date){
               loop_date_string = loop_date.toString("d-MMM-yyyy");
               tab_contents+= '<li><a href="#'+ loop_date_string +'">'+ loop_date_string +'</a></li>';
               tabs+='<div id="'+ loop_date_string +'" style="margin-top:20px;">';
               tabs+='hello <br/> world';
               tabs+='</div>';

               loop_date = loop_date.add(1).days();
           }
           tab_contents+= '</ul>';
           $('#month-nom').html(tab_contents+tabs);
           $('#month-nom').tabs( "destroy" );

           // ### create tabs
           $('#month-nom').tabs({
               select:  function(event, ui) {
                   var tab_selected = ui.tab.text;
                   $.displayMANSpecificDateRecords(tab_selected);
               }
           });

           var cur_selected = parseInt($('#month-nom').tabs( "option", "selected" ),10);
           if ( cur_selected == 0) {
               $('#month-nom').tabs('option', 'selected', 1);
           }
           $('#month-nom').tabs('option', 'selected', 0);
           $("#result_loader").html('');
           $('#fldst_list').show('slow');
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
                ,url : '../billing/nom_action'
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
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/ma_nom_csv'
       	 	$.download(url,parameters);
    	}
    });

    $(document).ready(function() {

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

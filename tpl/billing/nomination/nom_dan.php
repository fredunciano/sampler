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
                    <th width="150px">Relevant Trading Day:</th>
                    <td><input style="width:200px" type="text" name="trading_date" id="trading_date" value="<?php echo $def_date?>"/>
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
        <div style="text-align: center;font-weight: bold;margin-bottom: 10px;">Delivery Date: <b id="date">Mar 02, 2012</b></div>
        <div id="data_list">

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
       displayDANRecords : function(){
            var trading_date = $("#trading_date").val()
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,is_all_buyers = $('#chk_all_buyers').is(':checked')
                ,list_html = '';

            // ################ loader
           $('#date').html(Date.parse(trading_date).toString("MMMM d, yyyy"));
            $("#result_loader").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');

            // ################ tab contents
            var parameters =  {'action':'list', 'date' : cur_selected_date , 'type' : 'DAN'};
            if (!is_all_buyers) {
                parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            $.ajax({
                type: "POST"
                ,url : '../billing/nom_action'
                ,data: parameters
                ,dataType:'json'
                ,async: true
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
                    //$("#date").html(list_html);

                    $('#fldst_list').show();
                    $('#data_list').html(list_html).fadeIn("slow");
                    $("#result_loader").html('');
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    alert("Error on accessing webservice data " + jqXHR.responseText );
                    $("#date").html('With errors');
                }
            });
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
            var parameters =  "action=list&date="+cur_selected_date+"&type=DAN";
            if (!is_all_buyers) {
            	parameters = parameters+"&cust_id="+$('#cmb_buyers').attr('value');
                //parameters['cust_id'] =   $('#cmb_buyers').attr('value');
            }
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/billing/da_nom_csv'
       	 	$.download(url,parameters);
    	}
    });

    $(document).ready(function() {

            $('#btn_display_records').unbind('click').bind('click',function(){
                 $.displayDANRecords();
            });

            $("#trading_date").datepicker();
			$('#x_csv').unbind('click').bind('click',function(e){
				e.preventDefault();
                 $.exportCsv();
            });
			//$("#cmb_buyers").change(function(){
			//	var value = $("#cmb_buyers").val();
			//	alert(value);
			//})
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

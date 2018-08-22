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
            <input style="width:200px" type="text" name="trading_date" id="trading_date" value="<?=$def_date?>" />
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <button id="btn_display_records" class="btn btn-primary"><i class="icon-ok-circle"></i>&nbsp;Display</button>
            <button id="x_csv" class="btn btn-success"><i class="icon-download-alt"></i>&nbsp;Export to CSV</button>
        </div>
    </div>
    <br><br>
    <div id="result_loader" class="loader"></div>
    <p class="text-center text-info">Delivery Date : <b id="date"></b></p>
    <div class="row-fluid" id="data_list"></div>
    <br><br>
</div>

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
                ,url : '../trading_nomination/nom_action'
                ,data: parameters
                ,dataType:'json'
                ,async: true
                ,success: function(returnData){
                    var list_data = returnData.value,
                        interval_data = null,
                        row_contents = '',
                        left_index = 1,
                        right_index = 100;

                    list_html = ' <table class="table table-hover table-bordered">';
                    list_html+= '<tr>';
                    list_html+= '<th>Interval</th>';
                    //list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">ACC (kW)</td>';
                    //list_html+= '<td style="text-align:center;padding:5px" class="tablestyle">Min. Allowable Nomination (kW)</td>';
                    list_html+= '<th>Nomination (kW)</th>';
                    list_html+= '</tr>';

                    for (var i=1;i<=24;i++){
                        row_contents = '<tr>';
                        row_contents+= '<td style="width:125px;">'
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
                        row_contents+= '<td>&nbsp;'+ nom_value +'</td>'; // nom
                        row_contents+= '</tr>';

                        list_html+= row_contents;

                        left_index = left_index + 100;
                        right_index = right_index + 100;

                    }
                    list_html += '</table>';
                    //$("#date").html(list_html);

                    $('#fldst_list').show();
                    $('#data_list').html(list_html);
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
            
    		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading_nomination/da_nom_csv'
       	 	$.download(url,parameters);
    	}
    });

    $(document).ready(function() {
            $.displayDANRecords();
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

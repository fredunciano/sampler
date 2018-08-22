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
    <legend><h1><?=$title?> <small>&nbsp;( Trading )</small></h1></legend>
    <div class="row-fluid">
        <div class="span2"><label class="checkbox"><input type="checkbox" checked="checked" id="chk_all_buyers">All Customers</label></div>
        <div class="span10">
            <select id="cmb_buyers" disabled="true"></select>
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
        </div>
    </div>
    <br>
    <div id="result_loader" class="loader"></div>
    
    <div class="row-fluid" id="data_list"></div>
    <br><br>
</div>

<script type="text/javascript">

    $.extend({
       displayCustomers : function () {
       	
       	$.post('../trading_acc/acc_customers',{date:$('#trading_date').val(),type:'DAN'},
       	function(data){
       		var cust_list = '';
       		$.each(data.value,function(i,value){
       			cust_list += '<option value="'+value.customer+'">'+value.customer+'</option>';	
       		})
       		$('#cmb_cust').html(cust_list);
       		$('.hide').show();
       	})
       	
       	
       	
       	//$('#cmb_cust').html(customers);
       },
       displayDANRecords : function(){
            var trading_date = $("#trading_date").val()
                ,cur_selected_date = Date.parse(trading_date).toString('yyyy-MM-dd')
                ,is_all_cust = $('#chk_all_cust').is(':checked')
                ,list_html = '';

            // ################ loader
           var date = Date.parse(trading_date).toString("MMMM d, yyyy")
            $("#result_loader").html('Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');

            // ################ tab contents
            var parameters =  {'action':'list', 'date' : cur_selected_date , 'type' : 'DAN'};
            if (!is_all_cust) {
                parameters['cust_id'] =   $('#cmb_cust').attr('value');
            }
            $.ajax({
                type: "POST"
                ,url : '../trading_acc/acc_dan_summary_action'
                ,data: parameters
                ,dataType:'json'
                ,async: true
                ,success: function(returnData){
                    var list_data = returnData.value,
                        interval_data = null,
                        row_contents = '',
                        left_index = 1,
                        right_index = 100;
					
                    list_html = '<p class="text-center text-info">Delivery Date : <b>'+date+'</b></p>'
                    list_html+= ' <table class="table table-bordered table-hover">';
                    list_html+= '<tr>';
                    list_html+= '<th>Interval</th>';
                    list_html+= '<th>Max. ACC (kW)</th>';
                    list_html+= '<th>Min. ACC (kW)</th>';
                    list_html+= '</tr>';

                    for (var i=1;i<=24;i++){
                        row_contents = '<tr>';
                        row_contents+= '<td style="width:125px">'
                            + i +' ('+ $.strPad(left_index,4,'0') + 'H'
                            + '-' + $.strPad(right_index,4,'0')   +'H)'
                            + '</td>';


                        var acc_value = 0;
                        var min_value = 0;
                        var max_acc = 0;
                        var min_acc = 0;
                        if ( typeof list_data[i.toString()] != 'undefined') {
                            max_acc = typeof list_data[i.toString()].max != 'undefined' ? list_data[i.toString()].max : 0;
                            min_acc = typeof list_data[i.toString()].min != 'undefined' ? list_data[i.toString()].min : 0;
                        }



                        if ( max_acc == null  ) {
                            max_acc = 0;
                        }
                        if ( min_acc == null  ) {
                            min_acc = 0;
                        }


                        max_acc = parseFloat(max_acc).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        min_acc = parseFloat(min_acc).toFixed(3).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                        row_contents+= '<td>&nbsp;'+ max_acc +'</td>'; //min
                        row_contents+= '<td>&nbsp;'+ min_acc +'</td>'; //max
                        row_contents+= '</tr>';

                        list_html+= row_contents;

                        left_index = left_index + 100;
                        right_index = right_index + 100;

                    }
                    list_html += '</table>';
                    //$("#date").html(list_html);
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

    $(document).ready(function() {
 			$.displayCustomers();
            $.displayDANRecords();
            $('#btn_display_records').unbind('click').bind('click',function(){
                 $.displayDANRecords();
            });

            $("#trading_date").datepicker();
			$("#trading_date").change(function(){
				$('#chk_all_cust').attr('checked','checked');
				$('#cmb_cust').attr('disabled',true);
				$.displayCustomers();
			})

            $('#chk_all_cust').unbind('click').bind('click',function(){
                var is_all_cust = $('#chk_all_cust').is(':checked');
                if (is_all_cust) {
                    $('#cmb_cust').attr('disabled',true);
                } else {
                    $('#cmb_cust').attr('disabled',false);
                }
            });
    });
</script>
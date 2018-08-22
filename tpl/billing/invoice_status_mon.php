<title><?=$title?></title>
<div class="span-19 last" style="margin-left: 10px;">
    <br>
    <fieldset class="fs-blue">
        <legend><?=$title?></legend>
        <table>
            <tr>
                <th>Billing Period</th>
                <td>
                    <select id="month">
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
                    <select id="year">
                        <?php
                        for($x=2006;$x<=date('Y')+5;$x++){
                            $sel = ($billing_start['year'] == $x) ? 'selected=selected' : '';
                            echo '<option value="'.$x.'" '.$sel.' >'.$x.'</option>';
                        }
                        ?>
                    </select>
                    &nbsp;<button id="btn_display" type="button">Display</button>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <ul style="list-style: none;">
                        <li><b>Legend</b></li>
                        <li class="no-invoice-data" style="height:auto;background-position: left; text-align:left; padding-left:30px; padding-top:12px;">Not yet Confirmed</li>
                        <li class="confirmed-data" style="height:auto;background-position: left; text-align:left; padding-left:30px; padding-top:12px;">Confirmed</li>
                        <li class="verified-data" style="height:auto;background-position: left; text-align:left; padding-left:30px; padding-top:12px;">Viewed by Buyer</li>
                    </ul>
                </td>
            </tr>
        </table>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result" style="width:100%">
        <legend>Result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</legend>
        <div id="result_loader"></div>
        <div id="result">
            <table cellspacing="1" id="invoice_status_list" style="display: table;">
                <tbody>
                <tr>
                    <th rowspan="2">&nbsp;</th>
                    <th colspan="4" id="billing_period_label">Billing Period : June 2013</th>
                </tr>
                <tr>
                    <th class="sub-header" style="max-width: 40px;min-width: 40px;">Transmittal 1</th>
                    <th class="sub-header" style="max-width: 40px;min-width: 40px;">Transmittal 2</th>
                    <th class="sub-header" style="max-width: 40px;min-width: 40px;">Power Bill</th>
                    <th class="sub-header" style="max-width: 40px;min-width: 40px;">Manual Invoice </th>
                </tr>
                </tbody>
             </table>
        </div>
    </fieldset>

    <br><br><br><br><br>
</div>

<link rel="stylesheet" type="text/css" href="../css/jquery.cluetip.css" />
<link rel="stylesheet" type="text/css" href="../css/ui.daterangepicker.css" />

<style type="text/css">
    #invoice_status_list td {
        background-color: #ffffff;
        border: 1px solid #cccccc;
        padding:8px;
        border-radius: 4px;
        text-align: left;
    }

    #invoice_status_list th {
        background-color: #333333;
        border: 1px solid #cccccc;
        padding:8px;
        border-radius: 4px;
        text-align: center;
        color: #f5f5f5;
    }

    #invoice_status_list .sub-header {
        background-color: #636161;
    }


    .verified-data {
        background-image: url("../images/bullet_green.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }

    .confirmed-data {
        background-image: url("../images/bullet_red.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }

    .no-invoice-data {
        background-image: url("../images/bullet_gray.png");
        background-position: center center;
        background-repeat: no-repeat;
        cursor: pointer;
        height: 32px;
        margin: 0;
        text-align: center;
    }



</style>
<script src="../js/date.js"></script>
<script src="../js/jquery.cluetip.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/jquery.cluetip.css" />
<script type="text/javascript">

    $.extend({
        populateList : function(){
            $('#result_loader').html('Please wait  &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
            $("#invoice_status_list").find("tr:gt(2)").remove().hide();

            var billing_month =$('#month').val()
                ,billing_year =$('#year').val()
            var tmp_dte_string = billing_year + '-' + billing_month + '-01';
            var billing_period_label = Date.parse(tmp_dte_string).toString('MMMM yyyy');
            $('#billing_period_label').html('Billing Period : '+billing_period_label);
            $.ajax({
                type: "POST",
                url: '../billing/invoice_status_mon_action',
                data: {'action' : 'list','billing_month':billing_month,'billing_year':billing_year},
                async : true,
                success: function(data){
                    if ( data.total === 0 ) {
                        // no customers
                    }else {
                        var customer_list = data.value.customer_list;
                        var invoice_list = data.value.invoice_list_with_fullnames;
                        var customer = null;
                        var customer_id = '';
                        var customer_name = '';
                        var contents = '';
                        var transmittal1_class_name = '';
                        var transmittal1_tooltip_text = '';
                        var transmittal2_class_name = '';
                        var transmittal2_tooltip_text = '';
                        var invoice_class_name = '';
                        var invoice_tooltip_text = '';
                        var invoice_customer = null;
                        var invoice_type = null;
                        var manual_invoice_class_name = '';
                        var manual_invoice_tooltip_text = '';
                        for (var c=0;c<customer_list.length;c++){
                            customer = customer_list[c];
                            customer_id = customer.id;
                            customer_name = customer.name;
                            transmittal1_class_name = 'no-invoice-data';
                            transmittal2_class_name = 'no-invoice-data';
                            invoice_class_name= 'no-invoice-data';
                            manual_invoice_class_name= 'no-invoice-data';

                            transmittal1_tooltip_text = 'Not yet Confirmed';
                            transmittal2_tooltip_text = 'Not yet Confirmed';
                            invoice_tooltip_text = 'Not yet Confirmed';
                            manual_invoice_tooltip_text = 'Not yet Confirmed';


                            if ( typeof invoice_list['cust_'+customer_id] != 'undefined'){
                                invoice_customer = invoice_list['cust_'+customer_id];

                                // transmittal 1
                                if ( typeof invoice_customer['type_1'] != 'undefined' ) {
                                    invoice_type = invoice_customer['type_1'];
                                    if ( parseInt(invoice_type.status,10) === 0  ) {
                                        transmittal1_class_name = 'confirmed-data';
                                        transmittal1_tooltip_text = 'Transmittal 1 was confirmed by ' + invoice_type.confirmed_by_fullname + ' on ' + invoice_type.confirmed_date;
                                    }else if ( parseInt(invoice_type.status,10) === 1  ){
                                        transmittal1_class_name = 'verified-data';
                                        transmittal1_tooltip_text = 'Buyer viewed the Transmittal 1 by ' + invoice_type.buyer_viewed_by_fullname + ' on ' + invoice_type.buyer_viewed_date;
                                    }
                                }

                                /// transmittal 2
                                if ( typeof invoice_customer['type_2'] != 'undefined' ) {
                                    invoice_type = invoice_customer['type_2'];
                                    if ( parseInt(invoice_type.status,10) === 0  ) {
                                        transmittal2_class_name = 'confirmed-data';
                                        transmittal2_tooltip_text = 'Transmittal 2 was confirmed by ' + invoice_type.confirmed_by_fullname + ' on ' + invoice_type.confirmed_date;
                                    }else if ( parseInt(invoice_type.status,10) === 1  ){
                                        transmittal2_class_name = 'verified-data';
                                        transmittal2_tooltip_text = 'Buyer viewed the Transmittal 2 by ' + invoice_type.buyer_viewed_by_fullname + ' on ' + invoice_type.buyer_viewed_date;
                                    }
                                }

                                /// invoice
                                if ( typeof invoice_customer['type_3'] != 'undefined' ) {
                                    invoice_type = invoice_customer['type_3'];
                                    if ( parseInt(invoice_type.status,10) === 0  ) {
                                        invoice_class_name = 'confirmed-data';
                                        invoice_tooltip_text = 'Invoice was confirmed by ' + invoice_type.confirmed_by_fullname + ' on ' + invoice_type.confirmed_date;
                                    }else if ( parseInt(invoice_type.status,10) === 1  ){
                                        invoice_class_name = 'verified-data';
                                        invoice_tooltip_text = 'Buyer viewed the Invoice data by ' + invoice_type.buyer_viewed_by_fullname + ' on ' + invoice_type.buyer_viewed_date;
                                    }
                                }

                                /// manual invoice
                                if ( typeof invoice_customer['type_4'] != 'undefined' ) {
                                    invoice_type = invoice_customer['type_4'];
                                    if ( parseInt(invoice_type.status,10) === 0  ) {
                                        manual_invoice_class_name = 'confirmed-data';
                                        manual_invoice_tooltip_text = 'Manual Invoice was confirmed by ' + invoice_type.confirmed_by_fullname + ' on ' + invoice_type.confirmed_date;
                                    }else if ( parseInt(invoice_type.status,10) === 1  ){
                                        manual_invoice_class_name = 'verified-data';
                                        manual_invoice_tooltip_text = 'Buyer viewed the Manual Invoice data by ' + invoice_type.buyer_viewed_by_fullname + ' on ' + invoice_type.buyer_viewed_date;
                                    }
                                }

                            }


                            contents+='<tr>' +
                                '<td style="min-width: 30px;">'+ customer_name+'</td>' +
                                '<td style="text-align: center;"><p class="'+transmittal1_class_name+'" title="'+transmittal1_tooltip_text+'">&nbsp;</p> </td> ' +
                                '<td style="text-align: center;"><p class="'+transmittal2_class_name+'" title="'+transmittal2_tooltip_text+'">&nbsp;</p> </td> ' +
                                '<td style="text-align: center;"><p class="'+invoice_class_name+'" title="'+invoice_tooltip_text+'">&nbsp;</p> </td> ' +
                                '<td style="text-align: center;"><p class="'+manual_invoice_class_name+'" title="'+manual_invoice_tooltip_text+'">&nbsp;</p> </td> ' +
                                '</tr>';
                        }

                        $("#invoice_status_list").append(contents).show('slow');
                        $('#invoice_status_list p').cluetip({splitTitle: '|' , showTitle : false});

                    }
                    $('#result_loader').html('');


                }
            });
        }
    });
    $(document).ready(function(){
        $('#btn_display').unbind().bind('click',function(){
            $.populateList();
        }) ;

        $('#btn_display').trigger('click');

    });
</script>
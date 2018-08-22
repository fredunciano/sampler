<title><?=$title?></title>
<div class="span-19 last" style="margin-left: 10px;">
    <br>

    <fieldset class="fs-blue">
        <legend><?=$title?></legend>
        <form enctype="multipart/form-data" method="post">
            <table>
                <tr>
                    <th>Customer</th>
                    <td>
                        <span><?=$customers?></span>
                    </td>
                </tr>
                <tr>
                    <th width="150px">Billing Year </th>
                    <td>
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
    <fieldset class="fs-blue field">
        <legend>Result</legend>
        <div id="fieldset">

        </div>
    </fieldset>

    <br><br><br>
</div>


<div id="dialog_transmittal_1">
    &nbsp;
</div>
<div id="dialog_transmittal_2">
    &nbsp;
</div>
<div id="dialog_invoice">

</div>

<div id="dialog_manual_invoice_viewer">
    <span id="dialog_manual_invoice_viewer_loader"></span>
    <input type="hidden" name="hid_manual_invoice_filepath" id="hid_manual_invoice_filepath" value="">
    <div id="container_manual_invoice">
    </div>
</div>

<style>
    th.theader {
        text-align:center;
        background-color:#6897CA !important;
        padding:5px;
        min-width: 60px;
        font-weight: bold;
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

<script src="../js/date.js"></script>
<script type="text/javascript">
    var YearlyData = {};
    $.extend({
          populateConfirmedInvoices : function(){
              var billing_year =$('#year').val()

              $.ajax({
                  type: "POST",
                  url: '../buyer/invoice_contracts_action',
                  data: {'action' : 'get-archive-invoice-list','billing_year':billing_year},
                  async : false,
                  success: function(data){
                      if ( data.total === 0 ) {
                          $('#fieldset').html('No records found');
                      }else {
                            YearlyData = data.value;
                            var contents = '<table><tr>' +
                                '<th class="theader" >&nbsp;</th>' +
                                '<th class="theader">Transmittal 1</th>' +
                                '<th  class="theader">Transmittal 2</th>' +
                                '<th class="theader">Invoice</th>' +
                                '<th class="theader">Manual Invoice</th>' +
                                '</tr>';
                            var tmp_date = null, month_title_label = '';
                            var month_data = null, type_data = null;
                            for (var m=1;m<=12;m++){
                                var billing_year =$('#year').val()
                                tmp_date = Date.parse(billing_year+'-'+m+'-01');
                                month_title_label =tmp_date.toString("MMMM yyyy");
                                contents+='<tr><td style="height: 35px;">'+ month_title_label +'</td>';

                                // transmittal 1
                                if ( typeof data.value['type_1'] != 'undefined' ) {
                                    type_data =  data.value['type_1'];

                                    if (typeof type_data['month_'+m] != 'undefined') {
                                        month_data = type_data['month_'+m];

                                        contents+='<td style="text-align: center;cursor: pointer;" name="transmittal_1" month="'+m+'">' +
                                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                            'Transmittal 1' +
                                            '</td>';
                                    }else {
                                        contents+= '<td>&nbsp;</td>';
                                    }
                                }else {
                                    contents+= '<td>&nbsp;</td>';
                                }

                                // transmittal 2
                                if ( typeof data.value['type_2'] != 'undefined' ) {
                                    type_data =  data.value['type_2'];

                                    if (typeof type_data['month_'+m] != 'undefined') {
                                        month_data = type_data['month_'+m];

                                        contents+='<td style="text-align: center;cursor: pointer;" name="transmittal_2" month="'+m+'">' +
                                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                            'Transmittal 2' +
                                            '</td>';
                                    }else {
                                        contents+= '<td>&nbsp;</td>';
                                    }
                                }else {
                                    contents+= '<td>&nbsp;</td>';
                                }

                                // invoice
                                if ( typeof data.value['type_3'] != 'undefined' ) {
                                    type_data =  data.value['type_3'];

                                    if (typeof type_data['month_'+m] != 'undefined') {
                                        month_data = type_data['month_'+m];

                                        contents+='<td style="text-align: center;cursor: pointer;" name="invoice" month="'+m+'">' +
                                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                            'Invoice' +
                                            '</td>';
                                    }else {
                                        contents+= '<td>&nbsp;</td>';
                                    }
                                }else {
                                    contents+= '<td>&nbsp;</td>';
                                }

                                // manual invoice
                                $('#container_manual_invoice').html('');
                                if ( typeof data.value['type_4'] != 'undefined' ) {

                                    type_data =  data.value['type_4'];

                                    if (typeof type_data['month_'+m] != 'undefined') {
                                        month_data = type_data['month_'+m];

                                        contents+='<td style="text-align: center;width:25%;cursor: pointer" name="manual_invoice" month="'+m+'">' +
                                            '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                            'Manual Invoice' +
                                            '</td>';
                                    }else {
                                        contents+= '<td>&nbsp;</td>';
                                    }


                                }else {
                                    contents+= '<td>&nbsp;</td>';
                                }

                                contents+='</tr>';
                            }


                          contents += '</table>';
                          $('#fieldset').html(contents);
                      }


                  }
              });
          }
          ,updateInvoiceStatus : function(type,billing_month){
            var billing_year =$('#year').val();
            $.ajax({
                type: "POST",
                url: '../buyer/invoice_contracts_action',
                data: {'action' : 'update-invoice-status','type': type, 'billing_month':billing_month,'billing_year':billing_year},
                async : true,
                success: function(msg){
                    // do nothing
                }
            });
          }
        ,viewManualInvoiceFile : function(mn){
            var filepath = YearlyData['type_4']['month_'+mn].html;
            var baseurl = '<?php echo $base_url;?>';
            var siteurl = document.location.protocol+'//'+document.location.hostname+baseurl+'/buyer/invoice_generate_contract_get_manual_invoice_file?filepath='+filepath;
            $('#container_manual_invoice').html('');
            if ( filepath.length > 0 ) {
                var manual_invoice_contents = ' <object data="'+siteurl+'" type="application/pdf" width="96%" height="90%">' +
                    'alt : <a href="'+siteurl+'">'+filepath+'</a>' +
                    '</object>';
                $('#container_manual_invoice').html(manual_invoice_contents);
                $('#dialog_manual_invoice_viewer').dialog('open');
            }
        }
    });

    $(document).ready(function(){
        $('#dialog_transmittal_1').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('td[name="transmittal_1"]').unbind('click').live('click', function(e){
            e.preventDefault();
            var mn = $(this).attr('month');
            var contents = YearlyData['type_1']['month_'+mn].html;
            $.updateInvoiceStatus(1,mn);
            $('#dialog_transmittal_1').html(contents);
            $('#dialog_transmittal_1').dialog('open');


        });

        $('#dialog_transmittal_2').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('td[name="transmittal_2"]').unbind('click').live('click', function(e){
            e.preventDefault();
            var mn = $(this).attr('month');
            var contents = YearlyData['type_2']['month_'+mn].html;
            $.updateInvoiceStatus(2,mn);
            $('#dialog_transmittal_2').html(contents);
            $('#dialog_transmittal_2').dialog('open');


        });
        $('#dialog_invoice').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });

        $('td[name="invoice"]').unbind('click').live('click', function(e){
            e.preventDefault();
            var mn = $(this).attr('month');
            var contents = YearlyData['type_3']['month_'+mn].html;
            $.updateInvoiceStatus(3,mn);
            $('#dialog_invoice').html(contents);
            $('#dialog_invoice').dialog('open');


        });


        $('#dialog_manual_invoice_viewer').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });

        $('td[name="manual_invoice"]').unbind('click').live('click', function(e){
            e.preventDefault();
            var mn = $(this).attr('month');
            $.updateInvoiceStatus(4,mn);
            $.viewManualInvoiceFile(mn);
        });


        $('#btn_display_records').unbind().live('click',function(e){
            e.preventDefault();
            $.populateConfirmedInvoices();
        });

        $('#btn_display_records').trigger('click');

    });

</script>
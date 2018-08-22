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
    $.extend({
          populateConfirmedInvoices : function(){
              var billing_month =$('#month').val()
                  ,billing_year =$('#year').val()

              $.ajax({
                  type: "POST",
                  url: '../buyer/invoice_contracts_action',
                  data: {'action' : 'get-confirmed-invoice-list','billing_month':billing_month,'billing_year':billing_year},
                  async : false,
                  success: function(data){
                      if ( data.total === 0 ) {
                          $('#fieldset').html('No records found');
                      }else {
                            var contents = '<table><tr>';

                            if ( typeof data.value['type_1'] != 'undefined' ) {
                                contents+='<td style="text-align: center;width:25%;cursor: pointer;" id="transmittal_1">' +
                                    '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                    'Transmittal 1' +
                                    '</td>';
                                $('#dialog_transmittal_1').html(data.value['type_1'].html);
                            }else {
                                $('#dialog_transmittal_1').html('');
                            }

                          if ( typeof data.value['type_2'] != 'undefined' ) {
                              contents+='<td style="text-align: center;width:25%;cursor: pointer" id="transmittal_2">' +
                                  '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                  'Transmittal 2' +
                                  '</td>';
                              $('#dialog_transmittal_2').html(data.value['type_2'].html);
                          }else {
                              $('#dialog_transmittal_2').html('');
                          }

                          if ( typeof data.value['type_3'] != 'undefined' ) {
                              contents+='<td style="text-align: center;width:25%;cursor: pointer" id="invoice">' +
                                  '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                  'Invoice' +
                                  '</td>';
                              $('#dialog_invoice').html(data.value['type_3'].html);
                          }else {
                              $('#dialog_invoice').html('');
                          }

                          $('#container_manual_invoice').html('');
                          if ( typeof data.value['type_4'] != 'undefined' ) {
                              contents+='<td style="text-align: center;width:25%;cursor: pointer" id="manual_invoice">' +
                                  '<span class="ui-icon ui-icon-document" style="margin:0 auto"></span>' +
                                  'Manual Invoice' +
                                  '</td>';

                              var filepath = data.value['type_4'].html;
                              var baseurl = '<?php echo $base_url;?>';
                              var siteurl = document.location.protocol+'//'+document.location.hostname+baseurl+'/buyer/invoice_generate_contract_get_manual_invoice_file?filepath='+filepath;

                              if ( filepath.length > 0 ) {
                                  var manual_invoice_contents = ' <object data="'+siteurl+'" type="application/pdf" width="96%" height="90%">' +
                                      'alt : <a href="'+siteurl+'">'+filepath+'</a>' +
                                      '</object>';
                                  $('#container_manual_invoice').html(manual_invoice_contents);
                              }
                          }

                          contents += '</tr></table>';
                          $('#fieldset').html(contents);

                          var due_date = data.value['type_2'].due_date
                              ,due_date_str = '';
                          if ( due_date != null && typeof due_date != 'undefined' ) {
                              due_date_str = Date.parse(due_date).toString('MMM dd, yyyy');
                          }
                          var tableRow = $("td").filter(function() {
                              return $(this).text() == "Due Date";
                          }).next().html(due_date_str).addClass('hdr_content');
                      }


                  }
              });
          }
          ,updateInvoiceStatus : function(type){
            var billing_month =$('#month').val()
                ,billing_year =$('#year').val();

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
    });

    $(document).ready(function(){

        $('#dialog_transmittal_1').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('#transmittal_1').unbind('click').live('click', function(e){
            e.preventDefault();
            $.updateInvoiceStatus(1);
            $('#dialog_transmittal_1').dialog('open');
        });

        $('#dialog_transmittal_2').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('#transmittal_2').unbind('click').live('click', function(e){
            e.preventDefault();
            $.updateInvoiceStatus(2);
            $('#dialog_transmittal_2').dialog('open');
        })
        $('#dialog_invoice').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });
        $('#invoice').unbind('click').live('click', function(e){
            e.preventDefault();
            $.updateInvoiceStatus(3);
            $('#dialog_invoice').dialog('open');
        });


        $('#dialog_manual_invoice_viewer').dialog({
            autoOpen: false,
            show: "drop",
            hide: "drop",
            width: 650,
            modal: true
        });

        $('#manual_invoice').unbind('click').live('click', function(e){
            e.preventDefault();
            $.updateInvoiceStatus(4);
            $('#dialog_manual_invoice_viewer').dialog('open');
        });

        $('#btn_display_records').unbind().live('click',function(e){
            e.preventDefault();
            $.populateConfirmedInvoices();


        });

        $('#btn_display_records').trigger('click');

    });

</script>
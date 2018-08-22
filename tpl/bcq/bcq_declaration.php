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
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <div class="row-fluid">
        <div class="span2">URL</div>
        <div class="span10">
            <select id="url" disabled>
                <!--option>https://stl1.wesm.ph</option>
                <option>https://stl2.wesm.ph</option>
                <option>202.138.137.43</option-->
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10">
            <select id="participant">
                <?php
                foreach ($listParticipants as $p) {
                    echo '<option>'.$p->participant.'</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Trading Date</div>
        <div class="span10">
            <input type="text" id="datepicker" name="date" value="<?=$date?>">
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Unit</div>
        <div class="span10">
            <select id="unit"></select>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span2">Transaction ID</div>
        <div class="span10">
            <input type="text" style="text-transform: uppercase" id="transaction_id">
        </div>
    </div>


    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <span id="wbss"></span>
            &nbsp;<a href="#modal_email" role="button" data-toggle="modal" id="send_to_email" style="display:inline-block" class="hide btn btn-primary" disabled >Send to Email</a>
            &nbsp;<button id="trans_id" class="hide btn btn-primary">Save to WBSS submission</button>
            &nbsp;<button id="x_excel" class="hide btn btn-success">Export to Excel</button>
            &nbsp;<button id="x_csv" class="hide btn btn-success">Export to CSV</button>
        </div>
    </div>

    <br>
    <span id = 'msg_alert'></span><br>
    <div id="result" style="overflow-x: scroll"></div>
    <br>
</div>
<!--div class="modal fade in" id="modal_email" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <form enctype="multipart/form-data" method="post">   
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">Send to Email</h4>
    </div>
    <div class="modal-body">
        <div class="row-fluid">
            <div class="span2">Send to:</div>
            <div class="span9"><input type="text" id="send_to" style="width:95%" ></div>
        </div>

         <div class="row-fluid">
            <div class="span2">Cc:</div>
            <div class="span9"><input type="text" id="send_cc"  style="width:95%" ></div>
        </div>

         <div class="row-fluid">
            <div class="span2">Bcc :</div>
            <div class="span9"><input type="text" id="send_bcc"  style="width:95%" ></div>
        </div>

        <div class="row-fluid">
            <div class="span2">Subject:</div>
            <div class="span9"><input type="text" id="subject"  style="width:95%" ></div>
        </div>
        <div class="row-fluid">
            <div class="span2">Message:</div>
            <div class="span9">
                <textarea id="content" rows="5" class="span15"  style="width:95%" ></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" id="send">Send</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
    </form>
</div-->

<script>
$.extend({
    loadData : function() {
        $('#result').html('&nbsp;&nbsp;&nbsp;Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/bcq_declaration_action',{date:$('#datepicker').val(),participant:$('#participant').val()},
            function(data){
                var plants = '<option> Aggregate </option>';
                var html = '<p class="text-center text-info">Delivery Date : <b>'+$('#datepicker').val()+'</b></p>'
                html+= '<table class="table table-bordered table-hover"><tr><th class="theader">Buyer&nbsp;Name</th>';
                for (var b=1;b<=24;b++) {
                    html+='<th class="theader">'+b+'</th>';
                };
                    html+='</tr>'
                if(data.total < 1) {
                   $("#result").html('<span style="padding:10px">No Data to Display</span>');


                }else{
                    $('#wbss').html(data.wbss)
                    $(".hide").show();
                    $.each(data.unit,function(i,unit){
                        plants +='<option value="'+unit.plant+'">'+unit.plant+'</option>';
                    })
                    $('#unit').html(plants)
                    var H1 = 0;var H2 = 0;var H3 = 0;var H4 = 0;var H5 = 0;var H6 = 0;var H7 = 0;var H8 = 0;var H9 = 0;var H10 = 0;
                    var H11 = 0;var H12 = 0;var H13 = 0;var H14 = 0;var H15 = 0;var H16 = 0;var H17 = 0;var H18 = 0;var H19 = 0;
                    var H20 = 0;var H21 = 0;var H22 = 0;var H23 = 0;var H24 = 0;

                    $.each(data.value,function(c,hour){
                        html += '<tr><td class="theader">'+c+'</td>';
                        $.each(hour,function(h,hr){

                            html += '<td class="theader">'+parseFloat(hr.declaration)+'</td>';

                        })
                        H1+=parseFloat(hour[1].declaration);
                        H2+=parseFloat(hour[2].declaration);
                        H3+=parseFloat(hour[3].declaration);
                        H4+=parseFloat(hour[4].declaration);
                        H5+=parseFloat(hour[5].declaration);
                        H6+=parseFloat(hour[6].declaration);
                        H7+=parseFloat(hour[7].declaration);
                        H8+=parseFloat(hour[8].declaration);
                        H9+=parseFloat(hour[9].declaration);
                        H10+=parseFloat(hour[10].declaration);
                        H11+=parseFloat(hour[11].declaration);
                        H12+=parseFloat(hour[12].declaration);
                        H13+=parseFloat(hour[13].declaration);
                        H14+=parseFloat(hour[14].declaration);
                        H15+=parseFloat(hour[15].declaration);
                        H16+=parseFloat(hour[16].declaration);
                        H17+=parseFloat(hour[17].declaration);
                        H18+=parseFloat(hour[18].declaration);
                        H19+=parseFloat(hour[19].declaration);
                        H20+=parseFloat(hour[20].declaration);
                        H21+=parseFloat(hour[21].declaration);
                        H22+=parseFloat(hour[22].declaration);
                        H23+=parseFloat(hour[23].declaration);
                        H24+=parseFloat(hour[24].declaration);
                    })
                html+='<tr class="total"><td>Total</td><td>'+H1.toFixed(2)+'</td><td>'+H2.toFixed(2)+'</td><td>'+H3.toFixed(2)+'</td>'
                html+='<td>'+H4.toFixed(2)+'</td><td>'+H5.toFixed(2)+'</td><td>'+H6.toFixed(2)+'</td><td>'+H7.toFixed(2)+'</td>'
                html+='<td>'+H8.toFixed(2)+'</td><td>'+H9.toFixed(2)+'</td><td>'+H10.toFixed(2)+'</td><td>'+H11.toFixed(2)+'</td>'
                html+='<td>'+H12.toFixed(2)+'</td><td>'+H13.toFixed(2)+'</td><td>'+H14.toFixed(2)+'</td><td>'+H15.toFixed(2)+'</td>'
                html+='<td>'+H16.toFixed(2)+'</td><td>'+H17.toFixed(2)+'</td><td>'+H18.toFixed(2)+'</td><td>'+H19.toFixed(2)+'</td>'
                html+='<td>'+H20.toFixed(2)+'</td><td>'+H21.toFixed(2)+'</td><td>'+H22.toFixed(2)+'</td><td>'+H23.toFixed(2)+'</td>'
                html+='<td>'+H24.toFixed(2)+'</td></tr>'
                html+='</table>';
                $("#result").html('');
                $("#result").html(html);

               }
            })
    },
    loadUnit : function(){

        var parameters = {date:$('#datepicker').val(),unit:$('#unit').val()};
        
        $('#result').html('&nbsp;&nbsp;&nbsp;Getting Data &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/bcq_declaration_plant_action',parameters,
        function(data){
                var html = '<table class="table table-bordered table-hover"><tr><th class="theader">Buyer&nbsp;Name</th>';
                for (var b=1;b<=24;b++) {
                    html+='<th class="theader">'+b+'</th>';
                };
                    html+='</tr>'
                if(data.total < 1) {
                    $("#result").html('<span style="padding:10px">No Data to Display</span>');

                }else{
                    $(".hide").show();
                    var H1 = 0;var H2 = 0;var H3 = 0;var H4 = 0;var H5 = 0;var H6 = 0;var H7 = 0;var H8 = 0;var H9 = 0;var H10 = 0;
                    var H11 = 0;var H12 = 0;var H13 = 0;var H14 = 0;var H15 = 0;var H16 = 0;var H17 = 0;var H18 = 0;var H19 = 0;
                    var H20 = 0;var H21 = 0;var H22 = 0;var H23 = 0;var H24 = 0;

                    $.each(data.value,function(c,hour){
                        html += '<tr><td class="theader">'+c+'</td>';
                        $.each(hour,function(h,hr){

                            html += '<td class="theader">'+parseFloat(hr.declaration)+'</td>';

                        })
                        H1+=parseFloat(hour[1].declaration);
                        H2+=parseFloat(hour[2].declaration);
                        H3+=parseFloat(hour[3].declaration);
                        H4+=parseFloat(hour[4].declaration);
                        H5+=parseFloat(hour[5].declaration);
                        H6+=parseFloat(hour[6].declaration);
                        H7+=parseFloat(hour[7].declaration);
                        H8+=parseFloat(hour[8].declaration);
                        H9+=parseFloat(hour[9].declaration);
                        H10+=parseFloat(hour[10].declaration);
                        H11+=parseFloat(hour[11].declaration);
                        H12+=parseFloat(hour[12].declaration);
                        H13+=parseFloat(hour[13].declaration);
                        H14+=parseFloat(hour[14].declaration);
                        H15+=parseFloat(hour[15].declaration);
                        H16+=parseFloat(hour[16].declaration);
                        H17+=parseFloat(hour[17].declaration);
                        H18+=parseFloat(hour[18].declaration);
                        H19+=parseFloat(hour[19].declaration);
                        H20+=parseFloat(hour[20].declaration);
                        H21+=parseFloat(hour[21].declaration);
                        H22+=parseFloat(hour[22].declaration);
                        H23+=parseFloat(hour[23].declaration);
                        H24+=parseFloat(hour[24].declaration);
                    })
                html+='<tr class="total"><td>Total</td><td>'+H1.toFixed(10)+'</td><td>'+H2.toFixed(10)+'</td><td>'+H3.toFixed(10)+'</td>'
                html+='<td>'+H4.toFixed(10)+'</td><td>'+H5.toFixed(10)+'</td><td>'+H6.toFixed(10)+'</td><td>'+H7.toFixed(10)+'</td>'
                html+='<td>'+H8.toFixed(10)+'</td><td>'+H9.toFixed(10)+'</td><td>'+H10.toFixed(10)+'</td><td>'+H11.toFixed(10)+'</td>'
                html+='<td>'+H12.toFixed(10)+'</td><td>'+H13.toFixed(10)+'</td><td>'+H14.toFixed(10)+'</td><td>'+H15.toFixed(10)+'</td>'
                html+='<td>'+H16.toFixed(10)+'</td><td>'+H17.toFixed(10)+'</td><td>'+H18.toFixed(10)+'</td><td>'+H19.toFixed(10)+'</td>'
                html+='<td>'+H20.toFixed(10)+'</td><td>'+H21.toFixed(10)+'</td><td>'+H22.toFixed(10)+'</td><td>'+H23.toFixed(10)+'</td>'
                html+='<td>'+H24.toFixed(10)+'</td></tr>'
                html+='</table>';
                $("#result").html('');
                $("#result").html(html);

               }
            })
    },
    exportExcel : function() {
       var url = 'http://' + location.host + '<?=$base_url?>' + '/bcq/bcq_export_xls'
        var parameters = "sdate=" + $('#datepicker').val();
         $.download(url,parameters);
    },
    exportCsv : function() {
        var url = 'http://' + location.host + '<?=$base_url?>' + '/bcq/bcq_export_csv'
        var parameters = "sdate=" + $('#datepicker').val();
         $.download(url,parameters);
    },
    sendToEmail : function() {
        /* ## Original Code - without status message while sending email
        //$('#fieldset').html('&nbsp;&nbsp;&nbsp;Sending Email &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/send_to_email',{date:$('#datepicker').val(),send_to:$('#send_to').val(),subject:$('#subject').val(),content:$('#content').val(),participant:$('#participant').val(),send_cc:$('#send_cc').val(),send_bcc:$('#send_bcc').val()},
        function(data){
            $('#result').html(data)
        });
        */
        var options = {
            url: '../bcq/send_to_email',
            data: {date:$('#datepicker').val(),send_to:$('#send_to').val(),subject:$('#subject').val(),content:$('#content').val(),participant:$('#participant').val(),send_cc:$('#send_cc').val(),send_bcc:$('#send_bcc').val()},
            beforeSubmit: function() { 
                //$('#result').attr('class','alert alert-info');
                $('#result').html('Sending Email &nbsp;<img src="../images/ajax-loader.gif">')
            },
            success: function(data){
                $('#result').html(data)
                //$("#result").removeClass('alert');  
            }
            };
            $('form').ajaxSubmit(options);
    }

    ,setupEmailDefaults : function(){

    $.post('../bcq/get_participant_email_settings',{participant:$('#participant').val()},
            function(data){
            $('#send_to').val(data.value.to);
            $('#send_cc').val(data.value.cc);
            $('#send_bcc').val(data.value.bcc);
            $('#subject').val(data.value.subject);
            $('#content').val(data.value.content);
        })
    }
})
</script>
<script>
$('#datepicker').datepicker();
$.loadData();
$('#datepicker').change(function() {
    $(".hide").hide();
    $.loadData();
});
$('#participant').change(function(){
    $.loadData();
});
$('#unit').change(function(){

    var unit = $.trim($('#unit').val());
    var parameters = {};
    if (unit === 'Aggregate') {
       $.loadData();
    }else{
        $.loadUnit();
    }
    
})

$('#x_excel').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.exportExcel();
});
$('#x_csv').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.exportCsv();
});
$('#c_bcq').die().live('click', function(e){
    e.preventDefault();
    $('#result').html('&nbsp;&nbsp;&nbsp;Submitting WBSS &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/wbss_submission',{url:$('#url').val(),participant:$('#participant').val(),date:$('#datepicker').val()},
        function(data){
            console.log(data)
            $('#result').html(data);
        }
    );
})

$('#trans_id').die().live('click', function(e){
    e.preventDefault();
    $('#result').html('&nbsp;&nbsp;&nbsp;Submitting WBSS &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">')
        $.post('../bcq/wbss_submission_update',{participant:$('#participant').val(),date:$('#datepicker').val(),trans_id: $('#transaction_id').val()},
        function(data){
            console.log(data)
            $('#result').html(data);
        }
    );
})

$('#send').die('click').live('click', function(e){
    e.preventDefault();
    $.sendToEmail();
})


$('#modal_email').on('show', function () {
  $.setupEmailDefaults();

})
</script>

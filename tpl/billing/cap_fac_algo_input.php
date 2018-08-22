<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Billing and Settlements</div>
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
        <form enctype="multipart/form-data" id="frm1" method="post">
        <input type="hidden" name="participant" value="GMCP" />
        <table>
            <tr>
                <th width="150px">Date</th>
                <td><input type="text" id="datepicker" name="date" value="<?=$date?>">
                    <button id="retrieve">Retrieve</button>&nbsp;<span id="msg-alert-submit"></span>
                </td>
            </tr>
            <!--tr>
                <th>Upload MQ</th>
                <td><input type="file" name="filebrowser"><button id="submit_file">Upload</button>&nbsp;<span id="msg-alert"></span></td>
            </tr-->
        </table>
        </form>
    </fieldset><br>
    <fieldset class="fs-blue" style="width:100%">
        <legend>Input</legend>
        <form id="frm2" method="post">
        <div class="grid-scroll">
        <table>
            <tr>
                <th width="60px">Interval</th>
                <td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td>
                <td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td>
                <td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td>
            </tr>
            <tr>
                <th>SD</th>
                <td><input name="sd_1" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_2" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_3" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_4" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_5" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_6" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_7" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_8" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_9" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_10" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_11" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_12" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_13" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_14" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_15" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_16" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_17" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_18" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_19" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_20" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_21" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_22" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_23" type="text" style="width:60px;border-radius:3px"></td>
                <td><input name="sd_24" type="text" style="width:60px;border-radius:3px"></td>
                <td><button id="submit_sd">Submit</button><span id="msg-alert-submitsd"></span></td>
            </tr>
            <!--tr id="mq"></tr-->
            <tr id="eho"></tr>
        </table>
        </div>
        </form>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result" style="width:100%">
        <legend>Buyers</legend>
        <div class="grid-scroll">
        <table class="table" id="content"></table>
        <div id="result"></div>
        </div>
    </fieldset>
    <br><br><br><br><br>
</div>
<script src="../js/jquery.form.js"></script>
<script>
$.extend({
    listDailyBuyersQ : function(){
        
    },
    loadInputs : function(){
        $('#msg-alert-submit').html('Loading...');
        $.post('../billing/cap_fac_algo_input_load',$('#frm1').serialize(),
        function(data){
            //console.log(data)
            //return false;
            data = $.parseJSON(data);
            
            /*var mq_disp = []
            $.each(data.mq, function(i,mq){
                $.each(mq, function(i2,sein){
                    $.each(sein, function(i3,val){
                        mq_disp[i3] = (mq_disp[i3]) ? mq_disp[i3] : 0; 
                        mq_disp[i3] += (val.delivered - val.received)
                        //console.log("mq: "+ mq_disp[i3]);
                        //console.log("a: " + (val.delivered - val.received));
                    })
                    
                })
            })*/
            
            var eho_disp = []
            
            $.each(data.eho, function(i,eho){
            	eho_disp[i] = (eho) ? eho : 0;
            })
            
            var html = "";
            
            $.each(data.content, function(i,val){
                
                var spacer              = '';
                var cust_html           = '';
                var cc_html             = '';
                var bcq_nom_html        = '';
                var bcq_alloc_html      = '';
                var validation_html     = '';
                var buyers_q_html       = '';
                var cap_fac_html        = '';
                
                var spacer_html_int         = '';
                var cust_html_int           = '';
                var cc_html_int             = '';
                var bcq_nom_html_int        = '';
                var bcq_alloc_html_int      = '';
                var validation_html_int     = '';
                var buyers_q_html_int       = '';
                var cap_fac_html_int        = '';
                
                var cc_total        = 0;
                var bcq_nom_total   = 0;
                var bcq_alloc_total = 0;
                var buyers_q_total  = 0;
                var cap_fac_total   = 0;
                
                $.each(val, function(name,val1){
                    bcq_nom = val1.bcq_nom ? val1.bcq_nom : 0;
                    spacer_html_int+='<td style="background:#FFF"></td>';
                    cust_html_int+='<td>'+name+'</td>';
                    cc_html_int+='<td>'+val1.cc+'</td>';
                    bcq_nom_html_int+='<td>'+bcq_nom+'</td>';
                    bcq_alloc_html_int+='<td>'+val1.bcq_alloc+'</td>';
                    validation_html_int+='<td>'+val1.validation+'</td>';
                    buyers_q_html_int+='<td>'+val1.buyers_q+'</td>';
                    cap_fac_html_int+='<td>'+val1.cap_fac+'%</td>';
                    
                    cc_total+=val1.cc;
                    bcq_nom_total+=bcq_nom;
                    bcq_alloc_total+=val1.bcq_alloc;
                    buyers_q_total+=val1.buyers_q;
                    cap_fac_total+=val1.cap_fac;
                })
                
                spacer          += '<tr ><th style="background:#FFF"></th>'+spacer_html_int+'</tr>';
                cust_html       += '<tr><th>H'+i+'</th>'+cust_html_int+'<td>Total</td></tr>';
                cc_html         += '<tr><th>CC</th>'+cc_html_int+'<td>'+cc_total+'</td></tr>';
                bcq_nom_html    += '<tr><th>BCQ&nbsp;Nom</th>'+bcq_nom_html_int+'<td>'+bcq_nom_total+'</td></tr>';
                bcq_alloc_html  += '<tr><th>BCQ&nbsp;Allocation</th>'+bcq_alloc_html_int+'<td>'+parseInt(bcq_alloc_total)+'</td></tr>';
                validation_html += '<tr><th>Validation</th>'+validation_html_int+'<td></td></tr>';
                buyers_q_html   += '<tr><th>Buyers&nbsp;Q</th>'+buyers_q_html_int+'<td>'+parseInt(buyers_q_total)+'</td></tr>';
                cap_fac_html    += '<tr><th>Capacity&nbsp;Factor</th>'+cap_fac_html_int+'</tr>';
                
                html += spacer+cust_html+bcq_nom_html+cc_html+bcq_alloc_html+validation_html+
                       buyers_q_html+cap_fac_html;
                   
                $('input[name=sd_'+i+']').val(parseInt(buyers_q_total))
                   
            })
            
            $('#content').html(html);
            
            /*if (data.sd.length !== 0) {
                $.each(data.sd, function(i,sd){
                    for (x=1;x<=24;x++) {
                        sd_disp = (sd[x]) ? sd[x] : 0;
                        $('input[name=sd_'+x+']').val(sd_disp.sd)
                    }
                })
            } else {
                for (x=1;x<=24;x++) {
                    $('input[name=sd_'+x+']').val(0)
                }
            }*/
            //alert(mq_disp[1])
            //mq_html     = '<td>MQ</td>';
            eho_html    = '<td>EhO</td>';
            for (x=1;x<=24;x++) {
                
                //mq_disp1 = (mq_disp[x]) ? mq_disp[x] : 0;
                eho1	 = (eho_disp[x]) ? eho_disp[x] : 0; 
                
                //mq_html+='<td>'+mq_disp1+'</td>';
                eho_html+='<td>'+eho1+'</td>';
            }
            //$('#mq').html(mq_html)
            $('#eho').html(eho_html)
            //$('#msg-alert-submit').html('');
            
            $('#msg-alert-submit').html('');
        });	
        return false;
    },
    parseData : function(){
        var path = '../billing/parse_cap_fac_algo';
    
        var options = {target:'#msg-alert',
            url:path,
            data: {date:$("#datepicker").val()},
            beforeSubmit: function() { 
                $('#msg-alert').html('Loading...')
            },
            success: function(data) {
                
                data = $.parseJSON(data);
                
                var msg = data.message;
                
                $('#msg-alert').html(msg)
                $('#result').html('')

            }};	
        $('#frm1').ajaxSubmit(options);	
    },
    insertSD : function(){
        $('#msg-alert-submitsd').html('Loading...');
        $.post('../billing/submit_sd',$('#frm1, #frm2').serialize(),
        function(data){
            $('#msg-alert-submitsd').html(data);
            $.loadInputs();
        });	
        return false;
    },
    getInput : function()
    {
        $('#msg-alert-retrieve').html('Loading...');
        $.post('../billing/cap_fac_load',$('#frm1').serialize(),
        function(data){
            
            
            data = $.parseJSON(data);
            if (data.length !== 0) {
                for (x=100;x>=45;x--) {
                    $('#cap_fac_pricing_'+x).val(data[x].pricing);
                }
                $('#msg-alert-retrieve').html('');
            } else {
                $('#msg-alert-retrieve').html('Data not available');
                for (x=100;x>=45;x--) {
                    $('#cap_fac_pricing_'+x).val('');
                }
            }
        });	
        return false;
    }
});
</script>
<script>
$.loadInputs();
$('#download').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.exportData();
})
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.parseData();
}) 
$('#submit_cap_fac').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.insertCapFac();
})
$('#retrieve').unbind('click').bind('click',function(e){
    e.preventDefault();
    $.loadInputs();
})
$('#submit_sd').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.insertSD();
    
})
</script>
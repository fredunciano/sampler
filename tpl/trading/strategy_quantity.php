<title><?=$title?></title>


<div class="span-19 last" style="margin-left: 20px; margin-top: 20px;">
    <fieldset class="fs-blue">
        <legend><?=$title?></legend>
        <form method="post">
            <table>
                <tr>
                    <th width="150px">Delivery Date</th>
                    <td>
                        <input type="text" id="datepicker" style="width:150px;" value="<?=$date?>">
                        <button id="btnDisplayRecords" type="button">Display</button>
                    </td>
                </tr>

            </table>
        </form>
    </fieldset><br>
    <div id="result_loader" class="loader"></div>
    <fieldset class="fs-blue">
        <legend>Result</legend>
        <div id="results_container" style="display: none;">
            <table cellspacing="1" id="results_list">
            </table>
        </div>
    </fieldset>
</div>
<style type="text/css">
    #results_container {
        margin-top:5px;
        overflow: auto;
        padding:4px;
    }

    #results_list th {
        background-color: #F2EDED;
        text-align: center;
    }
    table#results_list td {
        min-width: 60px;
    }

    table#results_list td.sectiontitle {
        background-color: #DCF9CC;
        font-size: 11px;
        letter-spacing: 2px;
    }
    table#results_list td.intervaldata {
        text-align: right;
    }

    table#results_list td:first-child {
        min-width: 180px;
        font-weight: bold;
    }

    div.span-19 {
        margin-bottom: 60px;
    }
</style>
<script src="../js/date.js"></script>
<script type="text/javascript">
    CUR_RESULT_DATA = {};
    _int = null;
    $.extend({
        getResultListData:function(){
            var date_selected = $('#datepicker').val();
            var result_data = null;
            $.ajax({
                type: "POST"
                ,url : '../trading/strategy_quantity_action'
                ,data: { 'date' : Date.parse(date_selected).toString("yyyy-MM-dd"),'action' : 'list'}
                ,dataType:'json'
                ,async: false
                ,success: function(data){
                    result_data = typeof data.value != 'undefined' ? data.value : {} ;
                }
                ,error: function(jqXHR, textStatus, errorThrown){
                    console.log("Error on accessing webservice data " + jqXHR.responseText );
                }
            });

            return result_data;
        }
        ,populateResultList : function(data){
            var contents = ''
                ,resources_list = typeof data.resources != 'undefined' ? data.resources : {}
                ,nominations = typeof data.nominations != 'undefined' ? data.nominations : {};


            // Aggregated Contracted Capacity row
            var agg_contract_capacity = typeof data.agg_contracted_capacity != 'undefined' ? ( data.agg_contracted_capacity === null ? 0 : parseFloat(data.agg_contracted_capacity)  ) : 0;
            contents += '<tr>' +
                '<td>Aggregated Contracted Capacity </td>' +
                '<td colspan="24">'+ $.formatNumberToCurrency(agg_contract_capacity) +'</td>' +
                '</tr>';

            var resource = null
                ,resource_dap = null
                ,resource_rt = null
                , indx = null
                , day_ahead_contents = ''
                , realtime_contents = ''
                , i =0
                ,interval_dap = null
                ,interval_nom = ''
                ,tot_interval_nom = 0
                ,interval_dap_disp = ''
                ,interval_rt = null
                ,interval_rt_disp = ''
                ,total_dap = {}
                ,total_rt = {}
                ,tmp = null;


            // ####### day ahead header
            day_ahead_contents+='<tr><td colspan="25" class="sectiontitle">Day Ahead</td></tr>';
            day_ahead_contents+='<tr><th>&nbsp;</th>';
            for (var i=1;i<=24;i++){
                day_ahead_contents+='<th>Interval '+ i + '</th>';
            }
            day_ahead_contents+='</tr>';


            // ##### realtime header
            realtime_contents+='<tr> <td colspan="25">&nbsp;</td> </tr><tr><td colspan="25" class="sectiontitle">Realtime</td></tr>';
            realtime_contents+='<tr><th>&nbsp;</th>';
            for (var i=1;i<=24;i++){
                realtime_contents+='<th>Interval '+ i + '</th>';
            }
            realtime_contents+='</tr>';
            for (indx in resources_list){
                resource = resources_list[indx];
                resource_dap = typeof resource.dap != 'undefined' ? resource.dap : {};
                resource_rt = typeof resource.rtpa != 'undefined' ? resource.rtpa : {};

                day_ahead_contents+='<tr><td>DAP ('+ indx +')</td>';
                realtime_contents+='<tr><td>RTPA ('+ indx +')</td>';

                for (i=1;i<=24;i++){

                    interval_dap = typeof resource_dap[i] != 'undefined' ? parseFloat(resource_dap[i].mw) : null;
                    interval_rt = typeof resource_rt[i] != 'undefined' ? parseFloat(resource_rt[i].mw) : null;

                    if ( interval_dap != null ) {
                        interval_dap_disp = $.formatNumberToSpecificDecimalPlaces(interval_dap,2);
                        tmp = typeof total_dap['i_'+i] != 'undefined' ? total_dap['i_'+i] : 0;
                        total_dap['i_'+i] = tmp+interval_dap;
                    }else {
                        interval_dap_disp = '';
                    }
                    day_ahead_contents+='<td class="intervaldata">'+ interval_dap_disp +'</td>';


                    if ( interval_rt != null ) {
                        interval_rt_disp = $.formatNumberToSpecificDecimalPlaces(interval_rt,2);
                        tmp = typeof total_rt['i_'+i] != 'undefined' ? total_rt['i_'+i] : 0;
                        total_rt['i_'+i] = tmp+interval_rt;
                    }else {
                        interval_rt_disp = '';
                    }
                    realtime_contents+='<td class="intervaldata">'+ interval_rt_disp +'</td>';



                }
                day_ahead_contents+='</tr>';
                realtime_contents+='</tr>';
            }

            // ### other rows
            var total_dap_row='<tr><td>Total DAP</td>';
            var total_day_ahead_nom_row = '<tr><td>Total Day Ahead Nominations</td>';
            var day_ahead_ucs = '<tr><td>UCS</td>', ucs = '';
            var day_ahead_uccb = '<tr><td>UCCB</td>', uccb = '';
            var interval_total_dap = 0;
            var total_rtpa_row = '<tr><td>Total RTPA</td>', total_rtpa_val = 0;
            var rt_adj_nom_row = '<tr><td>Adjusted Total Nominations</td>', rt_adj_nom_val = 0;
            var rt_ucs_row = '<tr><td>UCS</td>', rt_ucs = '';
            var rt_uccb_row = '<tr><td>UCCB</td>', rt_uccb = '';


            for (i=1;i<=24;i++){
                tmp = typeof total_dap['i_'+i] != 'undefined' ? $.formatNumberToSpecificDecimalPlaces(parseFloat(total_dap['i_'+i]),2) : '';
                interval_total_dap = typeof total_dap['i_'+i] != 'undefined' ? parseFloat(total_dap['i_'+i]) : 0;
                total_dap_row+='<td class="intervaldata">'+ tmp +'</td>';

                // nom
                interval_nom = typeof nominations[i] != 'undefined' ? $.formatNumberToSpecificDecimalPlaces(parseFloat(nominations[i].mw),2) : '';
                tot_interval_nom = typeof nominations[i] != 'undefined' ? parseFloat(nominations[i].mw) : 0;
                total_day_ahead_nom_row+='<td class="intervaldata">'+ interval_nom +'</td>';

                // day ahead ucs && day ahead uccb
                if ( interval_total_dap > agg_contract_capacity ) {
                    ucs = interval_total_dap-agg_contract_capacity;
                    uccb = agg_contract_capacity - tot_interval_nom;
                }else {
                    ucs = 0;
                    if ( interval_total_dap > tot_interval_nom ) {
                        uccb = interval_total_dap - tot_interval_nom;
                    }else {
                        uccb = 0;
                    }
                }
                day_ahead_ucs+='<td class="intervaldata">'+ $.formatNumberToSpecificDecimalPlaces(ucs,2) +'</td>';
                day_ahead_uccb+='<td class="intervaldata">'+ $.formatNumberToSpecificDecimalPlaces(uccb,2) +'</td>';


                // rtpa
                tmp = typeof total_rt['i_'+i] != 'undefined' ? $.formatNumberToSpecificDecimalPlaces(parseFloat(total_rt['i_'+i]),2) : '';
                total_rtpa_val = typeof total_rt['i_'+i] != 'undefined' ? parseFloat(total_rt['i_'+i]) : 0;
                total_rtpa_row+='<td class="intervaldata">'+ tmp +'</td>';

                // other realtime rows
                if ( total_rtpa_val > tot_interval_nom ) {
                    rt_adj_nom_val  = tot_interval_nom;
                }else {
                    rt_adj_nom_val = total_rtpa_val;
                }
                rt_adj_nom_row+='<td class="intervaldata">'+ $.formatNumberToSpecificDecimalPlaces(rt_adj_nom_val,2) +'</td>';


                if ( total_rtpa_val > agg_contract_capacity ) {
                    rt_ucs = total_rtpa_val - agg_contract_capacity;
                    rt_uccb = agg_contract_capacity - tot_interval_nom;
                }else {
                    rt_ucs = 0;

                    if ( total_rtpa_val > tot_interval_nom ) {
                        rt_uccb = total_rtpa_val -tot_interval_nom ;
                    }else {
                        rt_uccb = 0;
                    }
                }
                rt_ucs_row+='<td class="intervaldata">'+ $.formatNumberToSpecificDecimalPlaces(rt_ucs,2) +'</td>';
                rt_uccb_row+='<td class="intervaldata">'+ $.formatNumberToSpecificDecimalPlaces(rt_uccb,2) +'</td>';

            }

            total_dap_row+='</tr>';
            total_day_ahead_nom_row+='</tr>';
            day_ahead_ucs+='</tr>';
            day_ahead_uccb+='</tr>';
            day_ahead_contents+=total_dap_row+total_day_ahead_nom_row+day_ahead_ucs+day_ahead_uccb;


            total_rtpa_row+='</tr>';
            rt_adj_nom_row+='</tr>';
            rt_ucs_row+='</tr>';
            rt_uccb_row+='</tr>';
            realtime_contents+= total_rtpa_row+rt_adj_nom_row+rt_ucs_row+rt_uccb_row;

            var note_row = '<tr> <td colspan="25">&nbsp;</td> </tr>' +
                '<tr> <td colspan="25" style="font-style: italic;">NOTE: All quantities in MW</td> </tr>' +
                '<tr> <td colspan="25">&nbsp;</td> </tr>';
            contents+=day_ahead_contents+realtime_contents+note_row;
            $('#results_list').html(contents);
            CUR_RESULT_DATA = data;

        }
        ,updateResultsData : function(){
            // get new data for comparison
            var data = $.getResultListData();
            var differences = $.compareJsonObjects(CUR_RESULT_DATA,data);

            if ( differences.length > 0 ) {
                $.populateResultList(data);
            }
        }
    });
    $(document).ready(function() {

        var width_ = $('div.last').css('width').replace(/px/gi, "");
        width_ = parseInt(width_,10) - 15;
        $('#results_container').css('width',width_+'px');

        $('#btnDisplayRecords').unbind().bind('click',function(){
            if ( _int != null ) {
                _int =window.clearInterval(_int);
            }

            $("#result_loader").html('Loading data Please wait &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" />');
            $('#results_container').hide();
            $('#results_list').html('');

            var data = $.getResultListData();
            $.populateResultList(data);

            $('#results_container').show('fadeIn');
            $("#result_loader").html('');

            _int = self.setInterval(function(){$.updateResultsData()  },300000);
        });

        $('#btnDisplayRecords').trigger('click');

    });
</script>
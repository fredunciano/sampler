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
        <table>
            <tr>
                <th width="150px">
                    Billing Period
                </th>
                <td >
                    <select>
                        <?php
                        for ($x=1;$x<=12;$x++) {
                            echo '<option value="'.$x.'">'.date('F',mktime(0,0,0,$x,1,date('Y'))).'</option>';
                        }
                        ?>
                        
                    </select>
                </td> 
            </tr>
            <tr>
                <th>Customer</th>
                <td>
                </td>
            </tr>
        </table>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result">
        <legend>Filename&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </legend>
        <div id="result"></div>
    </fieldset>
</div>
<script src="../js/date.js"></script>
<script>
$.extend({
    exportData : function(){
        
        var type = $("input:radio:checked").attr('id');
        var url = '../plant/excel_plant_avail'
        var parameters = "date=" + $('#date').val();
        parameters+= "&type=" + type;
        parameters+= "&resource_id=" + $('#resource').val();

        $.download(url,parameters);
    }
});
</script>
<script>
var sdate = new Date().add({days: 1,hours: 15}).toString("M/d/yyyy");
var date = Date.parse(sdate).toString("MM_dd_yyyy");

$('#result').html('<span><b>Plant_Availability_DAP_['+date+']</b>&nbsp;<button>Download</button></span>')
$('#date').val(sdate);

$("#dap").unbind('click').bind('click',function(){

    var sdate = new Date().add({days: 1,hours: 15}).toString("M/d/yyyy");
    var date = Date.parse(sdate).toString("MM_dd_yyyy");

    $("#date").val(sdate) ;

    $('#result').html('<span><b>Plant_Availability_DAP_['+date+']</b>&nbsp;<button>Download</button></span>')
});

$("#wap").unbind('click').bind('click',function(){

    var d = Date.parse($('#date').val());
    var sdate = new Date(d).add({ days: 1}).toString("M/d/yyyy");
    var edate = new Date(d).add({ days: 8}).toString("M/d/yyyy");
    var hsdate = Date.parse(sdate).toString("MM_dd_yyyy");
    var hedate = Date.parse(edate).toString("MM_dd_yyyy");
    
    $("#date").val(sdate + ' - ' + edate)
    
    $('#result').html('<span><b>Plant_Availability_WAP_['+hsdate+'-'+hedate+']</b>&nbsp;<button>Download</button></span>')

});

$('button').die('click').live('click',function(){
    $.exportData()
});
</script>
<title><?=$title?></title>
<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Manual Downloaders</div>
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
        <legend>Monthly Settlement Surplus Report</legend>
        <table>
            <tr>
                <th width="150px">Report Type</th>
                <td>
                    <select id="report_type">
                        <option value="RTD">Real Time Ex-Ante (RTD)</option>
                        <option value="RTX">Real Time Ex-Post (RTD)</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Region</th>
                <td>
                    <select id="region">
                        <option value="LUZON">Luzon</option>
                        <option value="VISAYAS">Visayas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Date</th>
                <td>
                    <input type="text"  readonly="true" style="background-color:#ffffff;" id="sdate" name="sdate" value="<?=$sdate?>"> to 
                    <input type="text"  readonly="true" style="background-color:#ffffff;" id="edate" name="edate" value="<?=$edate?>">
                </td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <td><button>Download</button></td>
            </tr>
        </table>
    </fieldset><br>
    <fieldset class="fs-blue" id="fs-result">
        <legend>Result&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </legend>
        <div id="result"></div>
    </fieldset>
    <div class="span-19 last">&nbsp;</div>
    <div class="span-19 last">&nbsp;</div>
    <div class="span-19 last">&nbsp;</div>
</div>
<script>
$('button').unbind('click');
$('button').bind('click',function(){
    $("#result").html('Please wait while data is being downloaded &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
    $.post('../market_data/man_dl_mps_action',{sdate:$('#sdate').val(),edate:$('#edate').val(),
            report_type:$('#report_type').val(),region:$('#region').val()},
            function(data){
                    $("#result").html(data);
                    return false;
            });
});
</script>
<style>
	th,td {
		text-align:center !important;
	}
</style>
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
   		<div class="span2">
   			Delivery Date
   		</div>
        <div class="span10 input-append">
            <input type="text" id="sdate" class="input-small" value="<?=$date?>">
            <button id="retrieve_btn" type="button" class="btn btn-primary">Retrieve</button>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span2">Participant</div>
        <div class="span10">
        	<select id="plant"></select>
        </div>
    </div>
    <br \>
    <div class="row-fluid">
    	<form enctype="multipart/form-data" id="pmr_form" method="post">
        <div class="span2">File</div>
        <div class="span10">
            <div class="fileupload fileupload-new span6" data-provides="fileupload">
                <div class="input-append">
                    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span><input type="file" name="file" id="filebrowser" />
                    </span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                    <a href="#" class="btn fileupload-exists btn-primary" id="submit_file">Upload</a>

                </div>
                 <span id="msg-alert-submit"></span>
                 <span id="export_handler" class="hide"><button id="x_xls" class="btn btn-success" type="button">Export to Excel</button></span>
            </div>
        </div>
        </form>
    </div>
    <hr>
    <div id="grid_data" style="overflow:auto">
    </div>

</div>

<script type="text/javascript">
	$.extend({
		getParticipants : function () {
			$.post('../trading/get_mq_participants_ld',{date : $('#sdate').val()},
				function(data){
					var html = '';
					$.each(data,function(i,val){
						html +='<option>'+val+'</option>';
					})
					$('#plant').html(html);
				})
		},
		list : function () {
			$.post('../trading/daily_mq_ld_list',{date : $('#sdate').val(), participant : $('#plant').val()},
				function(data){
					$('#grid_data').html('Loading<img src="../images/ajax-loader.gif">')
					if (data.total >= 1) {
					var html = '<table class="table table-striped table-bordered">';
					//var x = 1;

						$.each(data.value,function(p,cust){
							html += '<tr><td>Participant</td><td>'+p+'</td></tr>'
							html += '<tr><td>Customer</td>';
							$.each(cust,function(cust,sein){

									html+='<td>'+cust+'</td>'


							})
							html+='</tr><tr><td>SEIN</td>'
							$.each(cust,function(cust,sein){
								$.each(sein,function(s,interval){

								html+='<td>'+s+'</td>'

								})
							})
							html+='</tr><tr><td>Interval</td>'

							$.each(cust,function(cust,sein){
								$.each(sein,function(s,interval){

								html+='<td>ADJ</td>'

								})
							})

							html+='</tr>'
						})
						$.each(data.value,function(p,cust){

							for(x=1;x<=24;x++){
								html+='<tr><td>'+x+'</td>'
							$.each(cust,function(cust,sein){
								$.each(sein,function(s,interval){
									html+='<td style="background-color:#'+interval[x].adjusted_bg+'">'+interval[x].adjusted+'</td>'
								})


							})
								html+='</tr>'
							}
						})
					html +='</table>';
					$('#grid_data').html(html);
					$('#export_handler').show();
					} else {
						$('#grid_data').html('No Data Available');
            		}
				})
		},
		downloadReport : function () {
      	var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/daily_mq_ld_xlsx'
        var parameters = "date=" + $('#sdate').val();
        $.download(url,parameters);
      }
	})
</script>

<script>
$('#sdate').datepicker();
$('#sdate').change(function(e){
	$.getParticipants();
})
$('#retrieve_btn').unbind('click').bind('click',function(e){
	$.list();
	$('#msg-alert-submit').html('')
})
$('#x_xls').unbind('click').bind('click',function(e){
	$.downloadReport();
});
$('#submit_file').unbind('click').bind('click',function(e){
    e.preventDefault();
    var path    = '../trading/daily_mq_load_upload';
    var options = {target: '#msg-alert-submit',
        url: path,
        beforeSubmit: function(){
            $('#msg-alert-submit').html('Loading<img src="../images/ajax-loader.gif">')
        },
        success: function(data){
            //data = $.parseJSON(data);
            //console.log(data)

            ret = data.split('|');


            $('#msg-alert-submit').html(ret[1])
        }
    };

    $('form').ajaxSubmit(options);
})
</script>

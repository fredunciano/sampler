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
    <section id="global">
        <legend><h4><?=$title?> <small>( Bids and Offers )</small></h4></legend>
        <div class="row-fluid">
            <div class="span2">Date</div>
            <div class="input-append span4">
                <div class="btn-group">
                <input type="text" name="date" id="date" value="<?=$sdate?>" class="span5"/>
                <button class="btn" id="display_btn">Display</button>
                </div>
            </div>
            <div class="input-append span6">
                <div class="btn-group">
                <input id="search" type="text" class="span5" placeholder="Transaction ID"/> 
                <button class="btn" id="search_btn">Search<i class="icon icon-search"></i></button>
                </div>
            </div>
        </div><br>
        <legend>Submitted Records</legend>
        <table class="table table-bordered table-striped" id="t0">
            <thead>
                <tr>
                    <th>WESM Transaction ID</th>
                    <th>Resource ID</th>
                    <th>Delivery Date</th>
                    <th>Date Created</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </section>
</div>
<div class="modal modal_offer fade in" id="modal_offer" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel">WESM XML/RESPONSE INFO</h4>
    </div>
    <div class="modal-body">
        <table id="list-table-offer" class="table table-bordered table-condensed"></table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>

<script>
$.extend({
	listSummary: function (){
		
		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/list_summary';
		var parameters = "delivery_date="+$("#date").val();
		
		$.ajax({
		   type: "POST",
		   url: url,
		   data: parameters,
		   success: function(msg){
		   		
		   		var ret = $.parseJSON(msg);
		   		var h = '';
		   		if(ret.length > 0){
					$.each(ret, function(i, val){
						h += '<tr>'
							+ '<td><a href="#modal_offer" class="desc_btn" id="'+ret[i].response_trans_id+'" role="button" data-toggle="modal">'+ret[i].response_trans_id+'</a></td>' 
                            + '<td>' + ret[i].resource_id.replace(',',', ') + '</td>' 
							+ '<td>' + ret[i].delivery_date + '</td>' 
							+ '<td>' + ret[i].created_date + '</td>' 
                            + '<td>' + ret[i].created_by + '</td>'
                            + '<td>' + ret[i].action + '</td>'
							+ '<td ><button class="btn download" id="'+ret[i].response_trans_id+'">Download&nbsp;<i class="icon icon-download"></i></button></td>'
							+ '</tr>';
					});
					
				}else{
				
					h += '<tr><td colspan=6>No Records.</td></tr>';
				}
				
				$('#resultbox').html(''); 
                $('#t0 tbody').html('');
				$('#t0').append(h);
		   }
		 });						
		return false;
	},
	getDesc: function (trans_id){
		
		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/get_desc';
		var parameters = "trans_id="+trans_id;
		
		$.ajax({
		   type: "POST",
		   url: url,
		   data: parameters,
		   success: function(msg){
		   		//console.log(msg);
		   		var ret = $.parseJSON(msg);
		   		
		   		//var h = '<table class="table" style="height:100%;">';
                var h = '';
		   		h+= '<tr><th class="span2">Resource ID:</th><th>'+ret.resource_id+'</th></tr>'
                    +'<tr><th>Delivery Date:</th><th>'+ret.delivery_date+'</th></tr>'
                    +'<tr><th>Created Date:</th><th>'+ret.created_date+'</th></tr>'
                    +'<tr><th>User:</th><th>'+ret.created_by+'</th></tr>';
                h+= '<tr><td colspan="2"><div class="span6" style="padding:15px;">&nbsp;&nbsp;Request: <textarea class="editor" rows="20" style="background-color:#F9F9D6;min-height: 450px; height:100%;margin:5px" readonly>'+ret.generated_xml+'</textarea></div>'
                    +'<div class="span6">Response: <div style="width:100%;  min-height: 450px; height:100%; background-color:#F4F6FC; margin:4px 2px 0px 0px; border:1px solid #00A7FB; text-align:center">'+ret.response_str+'</div></div>'
                    +'</td></tr>';
                $('#list-table-offer').html('');
				$('#list-table-offer').append(h);
		   }
		 });
		 
		return false;
	},
	downloadReport : function (getid) {
		
		var url = 'http://' + location.host + '<?=$base_url?>' + '/trading/download_report'
       	var parameters = "trans_id=" + getid;
        $.download(url,parameters);
       	 
       	 /*$.post('../trading/download_report',{trans_id : getid},
       	 function(data){
       	 console.log(data);
       	 })*/
       	 
	},
	searchTrans : function () {
		if ($('#search').val() == ''){
			alert('Please Enter a Transaction ID');
		}else{
            $('#search_cont').html('Searching &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
            $.post('../trading/search_action',{transid : $('#search').val()},

                function(ret){
                //console.log(ret);
                //var ret = $.parseJSON(ret);
                var h = '';	
                if(ret.length > 0){
                    $.each(ret, function(i, val){
                        h += '<tr>'
                            + '<td><a href="#modal_offer" class="desc_btn" id="'+ret[i].response_trans_id+'" role="button" data-toggle="modal">'+ret[i].response_trans_id+'</a></td>' 
                            + '<td>' + ret[i].resource_id.replace(',',', ') + '</td>' 
                            + '<td>' + ret[i].delivery_date + '</td>' 
                            + '<td>' + ret[i].created_date + '</td>' 
                            + '<td>' + ret[i].created_by + '</td>'
                            + '<td>' + ret[i].action + '</td>'
                            + '<td><button class="btn download" id="'+ret[i].response_trans_id+'">Download&nbsp;<i class="icon icon-download"></i></button></td>'

                            + '</tr>';
                    });

                }else{

                    h += '<tr><td colspan=6>No Records.</td></tr>';
                }

            //$('#resultbox').html(''); 
                    $('#t0 tbody').html('');
                    $('#t0').append(h);

            $('#search_cont').html('')	
            })
		}
	}
	
});
</script>
<script>
$('#date').datepicker();    
$.listSummary();

$("#display_btn").click(function(){
    $.listSummary();
});
$("#search_btn").click(function(e){
    e.preventDefault();
    $.searchTrans();
});

$("a.desc_btn").live('click', function(e){
    e.preventDefault();
    var id = $(this).attr("id");

    $.getDesc(id);
});
$('.download').live('click',function(e){
e.preventDefault();

var trans_id = $(this).attr('id');
$.downloadReport(trans_id);
});
</script>
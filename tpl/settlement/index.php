<style>
#mylist{
    margin-left: 0;
}
#mylist li {
  float: left;
  width: 14em;
  margin: 0;
  padding: 0;
  list-style: none;
  margin-top: 10px;
  
} 


}
</style>
<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ) {
            echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }
        ?>
    </ul>  
</div>
<div class="span12">
    <legend><h4><?=$title?> <small> (Upload Raw File)</small></h4></legend>

     <div class="row-fluid">
        <div class="span2">
            <label class="checkbox"><input type="checkbox" checked="checked" id="chk_all_traders">All Resources&nbsp;&nbsp;&nbsp;</label></div>
        <div class="span10">
            <select id="#"  class="span3">
            	  	<?php
                        foreach ($listResource as $i) {
                            echo '<option value="'.$i->resource_id.'">'.$i->resource_id.'</option>';
                        }
                        ?>
    
            </select>
        </div>
    </div>
  <!--   <div class="row-fluid">
        <div class="span2">
            <label>Columns:&nbsp;&nbsp;&nbsp;</label></div>
        <div class="span10"></div>
    </div> -->
     <div class="row-fluid">
        <div class="span2">
            <span>Columns</span><br>
            <label class="checkbox"><input type="checkbox" id="chk_all_columns"><span id="check_label">Check All&nbsp;&nbsp;&nbsp;</span></label>
        </div>
        <div class="span10">
            <div class="row-fluid">
                <ul id="mylist">
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="EAQSI"    id="#">EAQSI</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="EAP"      id="#">EAP</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="EPETA"    id="#">EPETA</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="Imbalance" id="#">Imbalance</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="EAETA"    id="#">EAETA</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="MQ"       id="#">MQ</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="EPP"      id="#">EPP</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="TA"       id="#">TA</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="BCQ"      id="#">BCQ</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="Initial"  id="#">Initial</label></li>
                    <li><label class="checkbox"><input type="checkbox" class="tbl_col" name="tbl_col_name" value="Target"   id="#">Target</label></li>
                </ul>
                <button class="btn btn-primary" id="sample-btn">Show Columns</button>
            <input type="text" name="#" id="input_result">
            </div><br>
            
        </div>
    </div>
    <div class="row-fluid">
    	<div class="span2"><label>Billing Period:</label></div>
    	<div class="span10">
    		 <select id="#" class="span3">
                   <?php
                    for ($x=1;$x<=12;$x++) {
                    if($x == date('m')){
                    	echo '<option selected value="'.$x.'">'.date('F',mktime(0,0,0,$x,1)).'</option>';
                    }else{
                        echo '<option value="'.$x.'">'.date('F',mktime(0,0,0,$x,1)).'</option>';
                    }
                    }
                    ?>
                    
                </select>

                <select id="#" class="span3">
                    <?php
                    for ($x=date('Y');$x>=(date('Y')-4);$x--) {
                        echo '<option>'.$x.'</option>';
                    }
                    ?>
                </select>
    	</div>
    	
    </div><!-- end of billing period row -->
    <div class="row-fluid">
    	<div class="span2"></div>
    	<div class="span10">
    		<input class="btn btn-primary span3" value="Display">
    		<input class="btn btn-success span3" value="Export CSV">
    	</div>
    </div>
    <br>
    <legend></legend>
    <div class="row-fuid">
    	
    	 <table class="table table-condensed table-bordered table-striped" id="#">
            <thead>
                <tr style="background-color: gray;">
                    <td style="color: white;">Upload Files</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- start of file upload section -->
     <div class="row fluid">
           <div class="span2 justify-content-center" >Files:</div>
           <div class="span10">
				<div class="fileupload fileupload-new span5" data-provides="fileupload">
					<div class="input-append">
						<div class="uneditable-input span5"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
						<span class="btn btn-file"><span class="fileupload-new">Select file</span>
						<span class="fileupload-exists">Change</span><input type="file" name="filebrowser" id="filebrowser" />
						</span>
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						<input type="submit" value="Upload" class="btn fileupload-exists btn-primary" /><span id="resultbox"></span>
					</div>
				</div>
           </div>
            </div> <!-- end of file upload section -->
            <div id="grid_data"></div>
</div><!-- end of span12 -->

<script> 
    $('#chk_all_columns').change(function(e){
     
        e.preventDefault();
        var chk = $(this).attr('checked');
        var checked_col = $("input:checkbox:checked");
        // alert(chk);
        if(chk) {
            $('#check_label').html('Uncheck All')
            $('.tbl_col').attr('checked','checked')
            console.log(checked_col.length);
            
        } else {
            $('#check_label').html('Check All')
            $('.tbl_col').removeAttr('checked')
           
        }
    });
 
      // $('#sample-btn').on('click', function(){
        
      //   var val = [];
      //   $('.tbl_col:checkbox:checked').each(function(i){

      //     var val[i] = $(this).val();
      //     $('#input_result').val(val[i].toString());
      //   });
      // });
  
    $(function(){
      $('#sample-btn').click(function(){
     
        var val = [];
        $('.tbl_col:checkbox:checked').each(function(i){
          val[i] = $(this).val();
          // // console.log(val[i]);
          //   alert(val[]);
          // document.write(val.split(","));
          $('#input_result').val(val.toString());
        });
      });
    });


	
</script>
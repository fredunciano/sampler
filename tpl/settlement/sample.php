<style>
td.text-right, th.text-right { text-align: right;}
th.text-center, td.text-center { text-align: center; }
ul.mylist {
    -moz-column-count: 3;
    /*-moz-column-gap: 15px;*/
    -webkit-column-count: 3;
  /*  -webkit-column-gap: 15px;*/
    column-count: 3;
   /* column-gap: 10px;*/
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
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <h1><?=$client_name?></h1>
    <br/>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">
            <ul class="mylist">
                <li>1</li>
                <li>2</li>
                <li>3</li>
                <li>4</li>
                <li>5</li>
                <li>6</li>
                <li>7</li>
                <li>8</li>
                <li>9</li>
                <li>10</li>
                <li>11</li>
            </ul>
        </div>
    </div>
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
<input type="button" id="save_value" name="save_value" value="Save" />

    <div id="sample_result">
        <input type="text" name="input_text" id="input_result">
    </div>
</div>














<?php
                function myfunction($value,$p){
                    echo "empty($p) ||";
                }
                $a = array("a"=>"$fname","b"=>"$lname","c"=>"$id");
                array_walk($a,"myfunction");
            ?>
<script>
      $(function(){
      $('#save_value').click(function(){
     
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
          // // console.log(val[i]);
          //   alert(val[]);
          // document.write(val.split(","));
          $('#input_result').val(val.toString());
        });
      });
    });

</script>












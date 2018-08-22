<title><?=$title?></title>
<style>
    #actual-load-tb th{
        border-radius: 0;
    }    
</style>
<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Plant Interface</div>
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
                <th width="150px">Current Actual Load</th>
                <td><input><button>Submit</button></td>
            </tr>
            
        </table>
        <table id="actual-load-tb">
            <tr>
            <?php
            for($x=1;$x<=12;$x++){
                echo '
                        
                        <th>Interval '.$x.'</th>
                            
                        
                     ';
            }
            ?>
            </tr>
            <tr>
            <?php
            for($x=1;$x<=12;$x++){
                echo '
                        
                        <th>12</th>
                            
                        
                     ';
            }
            ?>
            </tr>
        </table>
    </fieldset>
</div>
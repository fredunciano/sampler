
<title><?=$title?></title>
<div class="span-4 colborder">
    <div id="submenu_container">
        <div class="submenu_title_box">Adhoc Report Menu</div>
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
    
</div>

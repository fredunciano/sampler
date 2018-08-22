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
        <form method="post">
            <legend><h4><?=$title?> <small>( Data Extraction )</small></h4></legend>
            <div class="row-fluid">
                <div class="span2">Resource ID</div>
                <div class="span10">
                    <select id="resource_id" name="resource_id">
                        <option value="all">All</option>
                        <?php
                        foreach ($resource_arr as $resource_id) {

                            echo '<option value="'.$resource_id.'">'.$resource_id.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">Equipment type</div>
                <div class="span10">
                    <select name="equipment_type">
                        <option value="UN">UN</option>
                        <option value="LN">LN</option>
                        <option value="L1">L1</option>
                        <option value="L2">X2</option>
                    </select>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">Date Options</div>
                <div class="span10">
                    <label class="radio inline">
                        <input type="radio" name="date_option" value="latest" id="latest" checked>Latest
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="date_option" value="range_from" id="date_range">Date Range
                    </label>
                    <div id="date_range_container" style="display:none;margin:10px" class="input-append input-prepend">
                        <span class="add-on">from</span><input type="text" name="date_from" class="datetext"><span class="add-on">to</span><input type="text" name="date_to" class="datetext">
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span2">Hour Options</div>
                <div class="span10">
                    <label class="radio inline">
                        <input type="radio" name="hour_option" value="all" id="all" checked>All
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="hour_option" value="hour_range" id="hour_range">Hour Range
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="hour_option" value="specific" id="specific">Specific
                    </label>
                    <div id="hour_range_container" style="display:none;padding:10px">
                        <span class="add-on">from</span>
                        <select name="hour_range_from" class="select_small">
                            <?php
                            for ($x=1;$x<=24;$x++) {
                                echo '<option value="'.$x.'">'.$x.'</option>';
                            }
                            ?>
                        </select>
                        <span class="add-on">to</span>
                        <select name="hour_range_to" class="select_small">
                            <?php
                            for ($x=1;$x<=24;$x++) {
                                echo '<option value="'.$x.'">'.$x.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div id="specific_container" style="display:none;padding:5px">
                        <table class="table table-condensed">
                            <tr>
                                <?php
                                for ($x=1;$x<=24;$x++) {
                                    echo '<td><label class="checkbox"><input type="checkbox" name="specific_hour[]" value="'.$x.'">'.$x.'</label></td>';
                                    if ($x==15) {
                                        echo '</tr><tr>';
                                    }
                                }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <hr>
            <div class="row-fluid">
                <div class="span2"></div>
                <div class="span10">
                    <a class="btn btn-primary" href="#" id="download"><i class="icon-arrow-down icon-white"></i>&nbsp;Download</a>
                </div>
            </div>

            <hr>
            <div id="result"></div>
        </form>
    </section>
</div>

<script>
    $.extend({

        extractData : function(){

            $("#result").attr('class','alert alert-info');
            $("#result").html('Please wait while data is being extracted &nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif">');
            $.post('../market_data/data_extraction_os_action',$('form').serialize(),

            function(data){
                $("#result").html(data);
                return false;

            });
        }

    })
</script>
<script>
    $('#resource_id').change(function(){
        if ($(this).val() !== 'all' ) {
            $('#region_container').css('display','none')
        } else {
            $('#region_container').css('display','')
        }
    })

    $('input[name=date_from],input[name=date_to]').datepicker();
    $('#date_range').change(function(){
        $('#date_range_container').css('display','block');
    })
    $('#latest').change(function(){
        $('#date_range_container').css('display','none');
    })
    $('#all').change(function(){
        $('#hour_range_container').css('display','none');
        $('#specific_container').css('display','none');
    })
    $('#hour_range').change(function(){
        $('#hour_range_container').css('display','block');
        $('#specific_container').css('display','none');
    })
    $('#specific').change(function(){
        $('#hour_range_container').css('display','none');
        $('#specific_container').css('display','block');
    })
    $('#download').unbind('click').bind('click', function(e){
        e.preventDefault();
        $.extractData();
    })
</script>

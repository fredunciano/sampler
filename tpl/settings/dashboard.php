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
    <legend><h4><?=$title?><small>&nbsp;</small></h4></legend>
    <form method="post">
    <div class="row-fluid">
        <table class="table table-striped">
            <?php
            $special_widgets = array(14,15,16,17);
            $is_with_demand_lwap= false;
            $market_demand_lwap = array();
            foreach ($widgets as $d) {
                $widget_id = $d['id'];
                if (in_array($widget_id, $special_widgets)) {
                    $is_with_demand_lwap= true;
                    $market_demand_lwap[] = $d;
                }else {
                    echo '<tr>
                        <td><label class=checkbox><input type=checkbox name=widget[] value="'.$d['id'].'">'.$d['title'].'</label></td>
                        <td>'.$d['desc'].'</td>
                      </tr>';
                    switch ($d['id']) {
                        case 1 : 
                            $ticker = '';
                            foreach ($resources as $r) {
                                $ticker.='<label class="checkbox inline"><input type=checkbox class="ticker" name="subwidget_1[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_1" style="display:none">
                                        <td>Resource ID</td>
                                        <td>'.$ticker.'</td>
                                  </tr>';
                            break;
                        case 2 : 
                            $rtd_graph_resource = '';
                            foreach ($resources as $r) {
                                $rtd_graph_resource.='<label class="checkbox inline"><input type=checkbox class="rtd_graph" name="subwidget_2[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_2" style="display:none">
                                        <td>Resource ID</td>
                                        <td>'.$rtd_graph_resource.'</td>
                                  </tr>';
                            break;
                        case 3 : 
                            $rtd_grid_resource = '';
                            foreach ($resources as $r) {
                                $rtd_grid_resource.='<label class="checkbox inline"><input type=checkbox class="rtd_grid" name="subwidget_3[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_3" style="display:none">
                                        <td>Resource ID</td>
                                        <td>'.$rtd_grid_resource.'</td>
                                  </tr>';
                            break;
                        case 5 : 
                            $rtem_resource = '';
                            foreach ($resources as $r) {
                                $rtem_resource.='<label class="checkbox inline"><input type=checkbox class="rtem" name="subwidget_5[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_5" style="display:none">
                                        <td>Resource ID</td>
                                        <td>'.$rtem_resource.'</td>
                                  </tr>';
                            break;
                        case 6 : 
                            $nodal_prices = '';
                            foreach ($resources as $r) {
                                $nodal_prices.='<label class="checkbox inline"><input type=checkbox class="nodal_prices" name="subwidget_6[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_6" style="display:none">
                                        <td>Resource ID</td>
                                        <td>'.$nodal_prices.'</td>
                                  </tr>';
                            break;

                        case 7 : 
                            $nomination = '';
                            foreach ($resources as $r) {
                                $nomination.='<label class="checkbox inline"><input type=checkbox class="nomination" name="subwidget_7[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_7" style="display:none">
                                        <td>Resource ID</td>
                                        <td>'.$nomination.'</td>
                                  </tr>';
                            break;
                        case 11 : 
                            $dap = '';
                            foreach ($resources as $r) {
                                $dap.='<label class="checkbox inline"><input type=checkbox class="dap" name="subwidget_11[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_11" style="display:none">
                                        <td>Resource ID </td>
                                        <td>'.$dap.'</td>
                                  </tr>';
                            break;
                        case 12 : 
                            $dap = '';
                            foreach ($resources as $r) {
                                $dap.='<label class="checkbox inline"><input type=checkbox class="dap_prices" name="subwidget_12[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_12" style="display:none">
                                        <td>Resource ID </td>
                                        <td>'.$dap.'</td>
                                  </tr>';
                            break;
                        case 13 : 
                            $dap = '';
                            foreach ($resources as $r) {
                                $dap.='<label class="checkbox inline"><input type=checkbox class="dap_schedules" name="subwidget_13[]" value="'.$r->resource_id.'">'.$r->resource_id.'</label>';
                            }
                            echo '<tr id="subwidget_13" style="display:none">
                                        <td>Resource ID </td>
                                        <td>'.$dap.'</td>
                                  </tr>';
                            break;
                        default :
                            echo '<tr style="display:none">
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                  </tr>';
                            break;
                    } // case
                }
                
            }
            
            if ( $is_with_demand_lwap ) {
                        $demand_lwap = '';
                        foreach ($market_demand_lwap as $d) {
                            $demand_lwap.='<label class="checkbox inline"><input type=checkbox name=widget[]  value="'.$d['id'].'">'.$d['title'].'</label>';
                        }
                     echo '<tr>
                        <td>Daily Market Demand and LWAP Graph</td>
                        <td>'.$demand_lwap.'</td>
                      </tr>';
                }
            ?>
        </table>
    </div>
    <?php
        if (!$widgets) {
            echo '
                    <blockquote class="pull-left">
                        <h4>Dashboard has not yet been enabled for this account</h4>
                        <p>Please contact your System Administrator to enable your dashboard</p>
                    </blockquote>
                ';
        } else {
            echo '<button class="btn btn-primary" id="save">Save Widgets</button>&nbsp;<span id="alert-msg"></span>';
        }
    ?>
    </form>
    <br><br><br>
</div>

<script>
$.extend({
    getDashboardData : function() {
        $.post('<?=$base_url?>/settings/dashboard_data',{},
            function(data) {
                data = $.parseJSON(data);
                $.each(data, function(i,val) {
                    $('input:checkbox[value='+val.widget_id+']').attr('checked','checked')
                    if (val.resource_ids) {
                        arr_resource = val.resource_ids.split('|');
                        $.each(arr_resource, function(i2,resource){
                            $('input[name="subwidget_'+val.widget_id+'[]"][value="'+resource+'"]').attr('checked','checked')
                            $('#subwidget_'+val.widget_id).css('display','');
                        })
                    }
                })
            })
    },
    saveDashboard : function() {
        $.post('<?=$base_url?>/settings/dashboard_save',$('form').serialize(),
            function(data){
                $('#alert-msg').html(data)
            })
    }
})
</script>
<script>
$.getDashboardData();
$('#save').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.saveDashboard();
})
$('input:checkbox[value=2]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=2]').prop('checked')) {
        $('#subwidget_2').css('display','');
    } else {
        $('#subwidget_2').css('display','none');
        $('.rtd_graph').removeAttr('checked');
    }
})
$('input:checkbox[value=3]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=3]').prop('checked')) {
        $('#subwidget_3').css('display','');
    } else {
        $('#subwidget_3').css('display','none');
        $('.rtd_grid').removeAttr('checked');
    }
})
$('input:checkbox[value=5]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=5]').prop('checked')) {
        $('#subwidget_5').css('display','');
    } else {
        $('#subwidget_5').css('display','none');
        $('.rtem').removeAttr('checked');
    }
})
$('input:checkbox[value=6]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=6]').prop('checked')) {
        $('#subwidget_6').css('display','');
    } else {
        $('#subwidget_6').css('display','none');
        $('.nodal_prices').removeAttr('checked');
    }
})

$('input:checkbox[value=11]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=11]').prop('checked')) {
        $('#subwidget_11').css('display','');
    } else {
        $('#subwidget_11').css('display','none');
        $('.dap').removeAttr('checked');
    }
})
$('input:checkbox[value=12]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=12]').prop('checked')) {
        $('#subwidget_12').css('display','');
    } else {
        $('#subwidget_12').css('display','none');
        $('.dap_prices').removeAttr('checked');
    }
})
$('input:checkbox[value=13]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=13]').prop('checked')) {
        $('#subwidget_13').css('display','');
    } else {
        $('#subwidget_13').css('display','none');
        $('.dap_schedules').removeAttr('checked');
    }
})
/*$('input:checkbox[value=7]').unbind('click').bind('click', function(){
    if ($('input:checkbox[value=7]').prop('checked')) {
        $('#subwidget_7').css('display','');
    } else {
        $('#subwidget_7').css('display','none');
        $('.nomination').removeAttr('checked');
    }
})*/
</script>
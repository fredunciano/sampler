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
        <h4>Announcement</h4>
        <div>
            <div id="alerts"></div>
            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
            <div class="btn-group">
              <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
              </div>
            <div class="btn-group">
              <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                </ul>
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
              <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
              <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>
              <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>
              <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>
              <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
              <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
              <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
              <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
              <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
            </div>
            <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="icon-link"></i></a>
                  <div class="dropdown-menu input-append">
                      <input class="span2" placeholder="URL" type="text" data-edit="createLink">
                      <button class="btn" type="button">Add</button>
              </div>
              <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="icon-cut"></i></a>

            </div>

            <div class="btn-group">
              <a class="btn" title="" id="pictureBtn" data-original-title="Insert picture (or just drag &amp; drop)"><i class="icon-picture"></i></a>
              <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" style="opacity: 0; position: absolute; top: 0px; left: 0px; width: 41px; height: 30px; ">
            </div>
            <div class="btn-group">
              <a class="btn" data-edit="undo" title="" data-original-title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
              <a class="btn" data-edit="redo" title="" data-original-title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
            </div>
            <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="" style="display: none; ">
        </div>
        <div id="editor" class="editor" name="editor" contenteditable="true"></div>

    </div>
      
    <table class="table table-striped">
        <?php
        $special_widgets = array(14,15,16,17);
        $is_with_demand_lwap= false;
        $market_demand_lwap = array();
        foreach ($widgets as $w) {
            //if ($w->id !== 7 && $w->id !== 8) {
            $widget_id = $w->id;
            if (in_array($widget_id, $special_widgets)) {
                $is_with_demand_lwap= true;
                $market_demand_lwap[] = $w;
            }else {
                echo '<tr>
                    <td><label class=checkbox><input type=checkbox name=widget[] value="'.$w->id.'">'.$w->title.'</label></td>
                    <td>'.$w->desc.'</td>
                  </tr>';
                switch ($w->id) {
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
                    default :
                        echo '<tr style="display:none">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
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
                }
            }
            
        }
        if ( $is_with_demand_lwap ) {
                $demand_lwap = '';
                foreach ($market_demand_lwap as $d) {
                    $demand_lwap.='<label class="checkbox inline"><input type=checkbox name=widget[]  value="'.$d->id.'">'.$d->title.'</label>';
                }
             echo '<tr>
                <td>Daily Market Demand and LWAP Graph</td>
                <td>'.$demand_lwap.'</td>
              </tr>';
        }
        ?>
    </table>
    
    <?php
        if (!$widgets) {
            echo '
                    <blockquote class="pull-left">
                        <h4>Dashboard has not yet been enabled for this account</h4>
                        <p>Please contact your System Administrator to enable your dashboard</p>
                    </blockquote>
                ';
        } else {
            echo '<button class="btn btn-primary" id="save">Save Big Screen</button>&nbsp;<span id="alert-msg"></span>';
        }
    ?>
    </form>
    <br><br><br><br><br>
</div>
<script>
    
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    
  });

</script>
<script>
$.extend({
    updateWidgets : function(){
        $.post('<?=$base_url?>/admin/big_screen_dashboard_update',$('form').serialize()+"&editor="+$('#editor').html(),
            function(data){
                ret = data.split('|');
                $('#alert-msg').html(ret[1]);
            });
    },
    getWidgets : function(){
        $('input[type=checkbox]').removeAttr('checked');
        $.post('<?=$base_url?>/admin/big_screen_list_json',{},
            function(data){
               data = $.parseJSON(data);
               $.each(data, function(i,val) {
                    $('input:checkbox[value='+val.widget_id+']').attr('checked','checked')
                    if (99999 == val.widget_id) {
                        $('#editor').html(val.announcement);
                    }
                    if (val.resource_ids) {
                        arr_resource = val.resource_ids.split('|');
                        $.each(arr_resource, function(i2,resource){
                            $('input[name="subwidget_'+val.widget_id+'[]"][value="'+resource+'"]').attr('checked','checked')
                            $('#subwidget_'+val.widget_id).css('display','');
                        })   
                    }
                })
            });
    }
})
</script>
<script>
$.getWidgets();    
$('#save').unbind('click').bind('click', function(e){
    e.preventDefault();
    $.updateWidgets();
})
$('#privilege').change(function(){
    $.getWidgets();
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
</script>
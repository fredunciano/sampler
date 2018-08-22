<style>
td.text-right, th.text-right { text-align: right;}
th.text-center, td.text-center { text-align: center; }
</style>
<div class="span3">
    <ul class="nav nav-tabs nav-stacked" >
        <?php
        foreach ( $submenu as $sm ){
                    echo '<li><a href="'.$base_url.$sm['link'].'">'.$sm['title'].'</a></li>';
        }?>
    </ul>  
</div>
<div class="span12">
    <legend><h4><?=$title?> <small>&nbsp;</small></h4></legend>
    <br/>
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span10">   
              <div class="row-fluid">
                 <div class="span2"> 
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_user" id="add-user-btn">Add User</button>
                </div>
             </div>       
        </div>
    </div>
    <br>
    <div class="row-fluid">
        <div class="span2">Display</div>
        <div class="span10">
            <div id="displaylist"></div>
        </div>
    </div>
</div>
<!-- Modal Edit here -->
<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="ModalLabel"></h4>
          </div>
          <div class="modal-body">
                 <div id="reg_result"></div>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-condensed">
                    <tr><td>First Name</td><td><input type="text" id='edit_fname' name="fname"></td></tr>
                    <tr><td>Last Name</td><td><input type="text" id='edit_lname' name="lname"></td></tr>
                    <tr><td>Email</td><td><input type="email" id='email' name="email"></td></tr>                 
                </table>
            </form>
          </div>
          <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true" id="modal-close-btn">Close</button>
                <span id="btn-holder"></span>
          </div>
    </div>
</div>
<!-- Modal delete here -->
<div class="modal fade in" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true" style="display:none">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 id="ModalLabel_delete">Delete User</h4>
    </div>
    <div class="modal-body">
        <div id="error_box"></div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <span id="btn-holder"></span>
    </div>
</div>
<script>
    $.extend({
        insert: function(){
                 
                 var fname = $('#edit_fname').val();
                 var lname = $('#edit_lname').val();
                 var email = $('#email').val();
                 
                $.post('../crud/user_add', {fname:fname,lname:lname,email:email},

                function(data){
                    $.show_crud();
                    var arr = data.split('|');
                    var stat = arr[0];
                    var msg = arr[1];

                    if(arr[0] == 1){
                         $('#reg_result').addClass('alert alert-success')
                         $('#reg_result').html(msg);
                    }else{
                         $('#reg_result').removeAttr('class')
                         $('#reg_result').addClass('alert alert-warning')
                         $('#reg_result').html(msg);
                    }
                
                    return false;
                    // alert(data);

                });
        },
        show_crud: function(){

                $.post('<?=$base_url?>/crud/user_list_json',{},
                function(data){
                    var data = $.parseJSON(data); 
 
                    $("#displaylist").html('<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="data">');
                    $('#data').dataTable({

                        "aoColumns": [
                            { "sTitle": "Id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "First&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "Last&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "Email&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;" },
                            { "sTitle": "&nbsp;" }
                        ]
                    });
                    $.each(data, function(i,val){
                        var edit_link = '<a href="#" id="'+val.id+'" class="edit_button" name="'+val.id+'" data-toggle="modal" data-target="#modal_user">'+val.id+'</a>';
                        var del_link = '<a href="#" id="'+val.fname+'" class="delete_button" name="'+val.id+'"><i class="icon-remove"></i></a>';

                        $('#data').dataTable().fnAddData([edit_link,val.fname,val.lname,val.email,del_link,]);
                    })  
                }) 
        },
        user_update: function(){

                var id = $('#id').val();
                var fname =$('#edit_fname').val();
                var lname =$('#edit_lname').val();
                var email =$('#email').val();

             $.post('../crud/update_user',{id:id,fname:fname,lname:lname, email:email},

                
                function(data){
                    $.show_crud();
                    var arr = data.split('|');
                    var stat = arr[0];
                    var msg = arr[1];

                    if(arr[0] == 1){
                         $('#reg_result').addClass('alert alert-success')
                         $('#reg_result').html(msg);
                    }else{
                         $('#reg_result').removeAttr('class')
                         $('#reg_result').addClass('alert alert-warning')
                         $('#reg_result').html(msg);
                    }
                    
                    return false;
                    // alert(data);

                });
        }

});

</script>

<script>

    // display of datatables
         $.show_crud();
         $('#add-user-btn').on('click', function(e){
                e.preventDefault();
                $('#ModalLabel').html('<h4 id="ModalLabel">Add User</h4>');
                $(':input').val('');
                $('#btn-holder').html('<button class="btn btn-primary" id="insert-btn">Save</button>');

                $('#insert-btn').unbind('click').bind('click',function(e){            
                     $.insert();
                });

        });
       
        $('.delete_button').die('click').live('click', function(e){
            e.preventDefault()
            var id = $(this).attr('name');
            var name = $(this).attr('id');

            bootbox.confirm("<p class=bootbox-text>Are you sure you want to delete <span class=bootbox-red>"+name+"?</span></p>", function(result) {
                if (result) {
                     $.post('../crud/delete_user',{id:id},
                        function(data){
                                bootbox.alert('<p class=bootbox-text>'+data+' <span class=bootbox-red>'+name+'</span></p>')
                                $.show_crud();
                    })
                }
            }); 
        });
        $('.edit_button').die('click').live('click', function(e){
             e.preventDefault()
             $('#reg_result').empty().removeClass('alert');
             var id = $(this).attr('name');
             var name = $(this).attr('id');
            // $('#modal_user').show();

            $.post('../crud/get_user_by_id',{id:$(this).attr('id')},
                 function(data){
                    var data = $.parseJSON(data);
            
                    $('input[id=id]').val(data.id);
                    $('#ModalLabel').html('<h4 id="ModalLabel">Update User</h4>');
                    $('#btn-holder').html('<button class="btn btn-primary" id="update_user">Update User</button>');
                    $('input[id=edit_fname]').val(data.fname);
                    $('input[id=edit_lname]').val(data.lname);
                    $('input[id=email]').val(data.email);

                    return false;             
            })
          
        });
        $('#update_user').die('click').live('click', function(e){
             e.preventDefault()
             $.user_update();
        });
               
    </script>
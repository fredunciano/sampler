<?php
Class CrudController Extends baseController {


    function __construct($registry) {
        parent::__construct($registry);
    }

    public function index(){
        $this->registry->template->title    =   'Settlement Data';
        $this->registry->template->page     =   'settlement/index.php';
        $this->registry->template->submenu  =   $this->sample_sub();
        $this->registry->template->listResource = json_decode($this->resource_ins()->listAll());
       
        $this->registry->template->show('index');
    }

    public function sample(){
        $this->registry->template->title    =   'Sample';
        $this->registry->template->page     =   'settlement/sample.php';
        $this->registry->template->submenu  =   $this->sample_sub();
        $this->registry->template->show('index');

    }
   
    public function crud(){
        $this->registry->template->title    =   'CRUD';
        $this->registry->template->page     =   'settlement/crud.php';
        $this->registry->template->submenu  =   $this->crud_sub();
        $this->registry->template->show('index');


    }
    public function user_add(){
        $r = $_REQUEST;
        $data['fname'] = ucwords($r['fname']);
        $data['lname'] = $r['lname'];
        $data['email'] = $r['email'];

        $error_mes = array(
            'empty'     => '0|Please fill all fields',
            'success'   => '1|Successfully saved',
            'error'     => '0|Unable to save',
            'match'     => '0|Only letters and white space allowed',
            'email'     => '0|Invalid Email Format',
            'email_exist'     => '0|Email Already Exist'
        );
       
            if(empty($data['fname']) || empty($data['lname']) || empty($data['email'])){
                    
                 $ret = $error_mes['empty'];           
            }else{
               
                if (!preg_match("/^[a-zA-Z ]*$/",$data['fname']) || !preg_match("/^[a-zA-Z ]*$/",$data['lname'])) {
                  $ret = $error_mes['match'];  
                }else{
                         $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";
                        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !preg_match($pattern,$data['email'])  ) {
                          $ret = $error_mes['email']; 
                        }else{
                                 $user_result_email = $this->new_crud()->check_user($data);
                                 if($user_result_email > 0){
                                     $ret = $error_mes['email_exist'];
                                    }else{
                                        $savedata = $this->new_crud()->add_data($data);
                    
                                            if($savedata){
                                                $ret = $error_mes['success'];
                                            }else{
                                                $ret = $error_mes['error'];
                                            }
                                    }
                             } 
                     }
                
                  }
        echo $ret;
    }

    public function user_list_json(){
        // echo "Hello World";
        $list_data = $this->new_crud()->list_all();
        echo json_encode($list_data);
    }

    public function delete_user(){
        $id = $_REQUEST['id'];
        $success = $this->new_crud()->delete_user($id);
        
        if ($success) {
            $ret = "Sucessfully deleted";
        } else {
            $ret = "Unable to delete";
        }
        
        echo  $ret;
    }

    public function get_user_by_id(){


            $id = $_REQUEST['id'];

            $user_obj = $this->new_crud()->get_by_id($id);
            echo json_encode($user_obj);
    }

    public function update_user(){

            $r = $_REQUEST;
            $data['id'] =    $r['id'];
            $data['fname'] = $r['fname'];
            $data['lname'] = $r['lname'];
            $data['email'] = $r['email'];

            $error_mes = array(
                'empty'     => '0|Please fill all fields',
                'success'   => '1|Successfully updated',
                'error'     => '0|Unable to save',
                'match'     => '0|Only letters and white space allowed',
                'email'     => '0|Invalid Email Format'

            );

              if(empty($data['fname']) || empty($data['lname'])){
                    
                 $ret = $error_mes['empty'];           
            }else{

                if (!preg_match("/^[a-zA-Z ]*$/",$data['fname']) || !preg_match("/^[a-zA-Z ]*$/",$data['lname']) ) {
                  $ret = $error_mes['match'];  

                }else{
                         $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i";

                        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !preg_match($pattern,$data['email'])  ) {
                          $ret = $error_mes['email']; 

                        }else{

                                $user_update = $this->new_crud()->update_by_id($data);
                    
                                if($user_update){
                                    $ret = $error_mes['success'];
                                }else{
                                    $ret = $error_mes['error'];
                                }  
                        } 
                }
                
            }

           
            echo $ret;
    }

    public function sample_sub(){
        $submenu = array(
                array(
                    'title' =>  'Settlement Data',
                    'link'  =>  '/crud/index'
                ),
                array(
                    'title' =>  'CRUD',
                    'link'  =>  '/crud/crud'
                ),
                array(
                    'title' =>  'Sample',
                    'link'  =>  '/crud/sample'
                )
                
            );
             return $submenu;
    }
     public function crud_sub(){
        $submenu = array(
                
                array(
                    'title' =>  'CRUD',
                    'link'  =>  '/crud/crud'
                )
            );
             return $submenu;
    }

    private function resource_ins(){
        return new Resources;
    }

    private function new_crud(){
        return new Crud;
    }


  
    




}


?>
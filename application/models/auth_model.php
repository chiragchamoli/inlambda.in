<?php 

 class Auth_model extends MY_Model {

  public function __construct()
  {
    parent::__construct();  
    //$this->table = 'users';
  }
   

/*
    OK, so just to double check:
    table names should be plural
    1. Models are singular names and database tables are plural names
    2. All primary keys are ‘id’
    3. All foreign keys are ‘singular_table_id’ (note_id, user_id, etc)
    4. app/config/database.php is setup correctly
      For next developer ///
      Table: Item
      Columns: ItemID, Title, Content
      Table: Tag
      Columns: TagID, Title
      Table: ItemTag
      Columns: ItemID, TagID
*/





   function validate_login($username,$password)
   {
      $user =  $this->find_by_user_name($username);

      if($user && $this->validate_password($password,$user))
      {
        
       $this->user_login($user->id);
         return $user;
      }
      else
         return false;
   }

   private function validate_password($password,$user)
   {  
      //echo $password;
      //print_r

      $salt = substr($user->user_password, 0, 64);
      $hash = substr($user->user_password, 64, 64);
      $password_hash = hash('sha256',$salt.$password);
      return $password_hash == $hash;
   }


   public function user_login($user_id)  { $this->session->set_userdata('user_id',$user_id);   }

   function set_password($plaintext) { $this->user_password = $this->hash_password($plaintext);  }

   private function hash_password($unhashed_password)
   {
      //$salt = bin2hex(mycrypt_create_iv(32, MYCRYPT_DEV_URANDOM)); // for Linox
      $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_RAND));
      $hash = hash('sha256',$salt.$unhashed_password);
      return $salt.$hash;
   }
   
   function make_new_user($user_data)
   {

    $plain_password = $user_data['user_password'];
    $hashed_password = $this->hash_password( $plain_password);
    $new_user = array(
                'user_name' => $user_data['user_name'],
                'user_group' => $user_data['user_group'],
                'user_password' => $hashed_password
      );

    print_r($new_user);
    $new_user_id  = $this->user_model->insert($new_user);

    if($new_user_id)
      echo "Admin Added";

    die();
/*

      $user = Admin::create(array(
              'user_name' => $name,
              'password' => $pass,
              'user_group' => $group
              ));
      if(!$user) return false;
      else
         return $user;*/
   }


public function logout($user_id) {   $this->session->sess_destroy();}

 }

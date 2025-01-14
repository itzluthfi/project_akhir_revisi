<?php

require_once __DIR__ . './node_role.php';

class User extends Role {
    public $user_id;
    public $user_username;
    public $user_password;
    public $role_id;

    // public function __construct($user_id,$user_username,$user_password,$user_role)
    // {
    //     $this->user_id = $user_id;
    //     $this->user_username = $user_username;
    //     $this->user_password = $user_password;
    //     $this->user_role = $user_role;
    // }

    public function __construct($user_id,$user_username,$user_password,$role_id,$role_name,$role_description,$role_status,$role_gaji)
    {
        parent::__construct($role_id,$role_name,$role_description,$role_status,$role_gaji);
        $this->user_id = $user_id;
        $this->user_username = $user_username;
        $this->user_password = $user_password;
        $this->role_id = $role_id;
        $this->role_name = $role_name;
        $this->role_description = $role_description;
        $this->role_status = $role_status;
        $this->role_gaji = $role_gaji;
    }
}

?>
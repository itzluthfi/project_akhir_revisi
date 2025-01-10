<?php

class User {
    public $user_id;
    public $user_username;
    public $user_password;
    public $id_role;

    // public function __construct($user_id,$user_username,$user_password,$user_role)
    // {
    //     $this->user_id = $user_id;
    //     $this->user_username = $user_username;
    //     $this->user_password = $user_password;
    //     $this->user_role = $user_role;
    // }

    public function __construct($user_id,$user_username,$user_password,$id_role)
    {
        $this->user_id = $user_id;
        $this->user_username = $user_username;
        $this->user_password = $user_password;
        $this->id_role = $id_role;
    }
}

?>
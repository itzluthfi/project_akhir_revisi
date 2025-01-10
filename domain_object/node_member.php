<?php
class Member {
    public $id;
    public $name;
    public $phone;
    public $point;
    public $password;

    public function __construct($id, $name, $password,$phone,$point) {    
        $this->id = $id;
        $this->name = $name;    
        $this->phone = $phone;
        $this->point = $point;
        $this->password = $password;
    }
}


?>
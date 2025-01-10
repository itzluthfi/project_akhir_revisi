<?php

require_once "/laragon/www/project_akhir/model/dbConnect.php";

// /laragon/www/project_akhir/model/modelMember.php

require_once "/laragon/www/project_akhir/domain_object/node_member.php";

class modelMember {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = new Database('localhost', 'root', '', 'poswarkop');
        // $this->initializeDefaultMembers();
    }

    private function initializeDefaultMembers() {
        // Cek apakah tabel kosong, jika ya, tambahkan member default
        $members = $this->getAllMembers();
        if (count($members) === 0) {
            $this->addMember("Brillian", "brillian123", "08123456789", 1000);
            $this->addMember("Habib", "habibin123", "08234567890", 1500);
            $this->addMember("Luthfi", "luppy123", "08345678901", 2000);
        }
    }

    public function addMember($name, $password, $phone, $point) {
        // Escape input untuk mencegah SQL Injection
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $password = mysqli_real_escape_string($this->db->conn, $password);
        $phone = (int)$phone;
        $point = (int)$point;

        $query = "INSERT INTO members (username, password, phone, point) VALUES ('$name', '$password', '$phone', $point)";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error adding member: " . addslashes($e->getMessage()) . "');</script>";
            return false;
        }
    }

    public function getAllMembers() {
        $query = "SELECT * FROM members";
        $result = $this->db->select($query);
    
        $members = [];
        foreach ($result as $row) {
            $members[] = new Member($row['id'], $row['username'], $row['password'], $row['phone'], $row['point']);
        }
    
        if ($members != null) {
            echo "<script>console.log('Members fetched successfully: " . addslashes(json_encode($members)) . "');</script>";
            return $members;
        }
        echo "<script>console.log('No members found.');</script>";
        return null;
    }
    
    public function getMemberById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM members WHERE id = $id";
        $result = $this->db->select($query);
    
        if (count($result) > 0) {
            $row = $result[0];
            $member = new Member($row['id'], $row['username'], $row['password'], $row['phone'], $row['point']);
            echo "<script>console.log('Member fetched successfully: " . addslashes(json_encode($member)) . "');</script>";
            return $member;
        }
    
        echo "<script>console.log('Member with ID $id not found.');</script>";
        return null;
    }
    

    public function updateMember($id, $name, $password, $phone, $point) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $password = mysqli_real_escape_string($this->db->conn, $password);
        $phone = mysqli_real_escape_string($this->db->conn, $phone);
        $point = (int)$point;

        $query = "UPDATE members SET username = '$name', password = '$password', phone = '$phone', point = $point WHERE id = $id";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error updating member: " . addslashes($e->getMessage()) . "');</script>";
            return false;
        }
    }

    public function deleteMember($id) {
        $id = (int)$id;
        $query = "DELETE FROM members WHERE id = $id";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error deleting member: " . addslashes($e->getMessage()) . "');</script>";
            return false;
        }
    }

    public function __destruct() {
        // Menutup koneksi database
        $this->db->close();
    }
}
?>
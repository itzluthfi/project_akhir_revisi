<?php

// require_once "/laragon/www/project_akhir/domain_object/node_user.php";  // Jika Anda masih ingin menggunakan node
// include_once "/laragon/www/project_akhir/model/dbConnect.php";

require_once __DIR__ . '/dbConnectNew.php';
require_once __DIR__ . '../../domain_object/node_user.php';



class modelUser {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = Databases::getInstance();
        $this->initializeDefaultUser(); // Anda bisa menambahkan ini jika ingin menambahkan item default saat pertama kali  
    }

    public function initializeDefaultUser() {
        // Cek apakah ada user yang terdaftar di database
        if (empty($this->getAllUser())) {
            $this->addUser("luthfi", "luthfi123", 1);
            $this->addUser("habib", "habib123", 3);
            $this->addUser("adam", "adam123", 4);
        }
    }

    public function addUser($user_username, $user_password, $id_role) {
        // Escape input untuk mencegah SQL Injection
        $user_username = mysqli_real_escape_string($this->db->conn, $user_username);
        $user_password = mysqli_real_escape_string($this->db->conn, $user_password);
        $id_role = (int)$id_role;

        // Hash password sebelum disimpan
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $query = "INSERT INTO users (username, password, role_id) VALUES ('$user_username', '$hashed_password', $id_role)";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error adding user: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    public function getAllUser() {
        $query = "SELECT * FROM users";
        $result = $this->db->select($query);
        
        $users = [];
        foreach ($result as $row) {
            // Membuat objek User dan menyimpannya ke array
            $users[] = new User($row['id'], $row['username'], $row['password'], $row['role_id']);
        }

        // Simpan semua user ke dalam sesi
        $_SESSION['users'] = $users;
        
        return $users;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = $id";
        $result = $this->db->select($query);
        
        if (count($result) > 0) {
            $row = $result[0];
            $user = new User($row['id'], $row['username'], $row['password'], $row['role_id']);
            
            // Simpan ke sesi
            $_SESSION['user'] = $user;

            return $user;
        }
        
        return null;
    }

    public function updateUser($id, $user_username, $user_password, $id_role) {
        // Escape input untuk mencegah SQL Injection
        $user_username = mysqli_real_escape_string($this->db->conn, $user_username);
        $user_password = mysqli_real_escape_string($this->db->conn, $user_password);
        $id_role = (int)$id_role;

        // Hash password sebelum disimpan
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $query = "UPDATE users SET username = '$user_username', password = '$hashed_password', role_id = $id_role WHERE id = $id";
        try {
            $this->db->execute($query);

            // Update sesi setelah berhasil diupdate di DB
            $updatedUser = $this->getUserById($id);
            $_SESSION['user'] = $updatedUser;

            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error updating user: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = $id";
        try {
            $this->db->execute($query);

            // Hapus dari sesi jika ada
            if (isset($_SESSION['user']) && $_SESSION['user']->user_id == $id) {
                unset($_SESSION['user']);
            }

            // Perbarui daftar user di sesi
            $this->getAllUser();

            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error deleting user: " . $e->getMessage() . "');</script>";
            return false;
        }
    }
}
?>
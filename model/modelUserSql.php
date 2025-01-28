<?php



require_once __DIR__ . '../../config/dbConnectNew.php';

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

    
    private function getRoleById($role_id) {
        $role_id = (int)$role_id;
        $query = "SELECT * FROM roles WHERE id = $role_id";
        $result = $this->db->select($query);

        if (count($result) > 0) {
            $row = $result[0];
            $role = new Role($row['id'], $row['name'], $row['description'], $row['status'], $row['gaji']);
            echo "<script>console.log('Role fetched successfully: " . addslashes(json_encode($role)) . "');</script>";
            return $role;
        }

        echo "<script>console.log('Role with ID $role_id not found.');</script>";
        return null;
    }

    public function getAllUser() {
        $query = "SELECT * FROM users";
        $result = $this->db->select($query);
    
        // Jika hasil query kosong, kembalikan null
        if (empty($result)) {
            return null;
        }
    
        $users = [];
        foreach ($result as $row) {
            $role = $this->getRoleById($row['role_id']); // Ambil role berdasarkan role_id
            $users[] = new User(
                $row['id'],
                $row['username'],
                $row['password'],
                $row['role_id'],
                $role ? $role->role_name : null,
                $role ? $role->role_description : null,
                $role ? $role->role_status : null,
                $role ? $role->role_gaji : null
            );
        }
    
        return $users;
    }
    

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = $id";
        $result = $this->db->select($query);
    
        // Jika hasil query kosong, kembalikan null
        if (empty($result)) {
            return null;
        }
    
        $row = $result[0];
        $role = $this->getRoleById($row['role_id']); // Ambil role berdasarkan role_id
    
        return new User(
            $row['id'],
            $row['username'],
            $row['password'],
            $row['role_id'],
            $role ? $role->role_name : null,
            $role ? $role->role_description : null,
            $role ? $role->role_status : null,
            $role ? $role->role_gaji : null
        );
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
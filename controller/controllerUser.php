<?php
require_once "/laragon/www/project_akhir/model/modelUserSql.php";

class ControllerUser {
    private $modelUser;

    public function __construct() {
        $this->modelUser = new modelUser();
    }

    public function handleAction($action) {
        $message = ""; // Default pesan

        switch ($action) {
            case 'add':
                if (isset($_POST['user_username'], $_POST['user_password'], $_POST['id_role'])) {
                    $user_username = trim($_POST['user_username']);
                    $user_password = trim($_POST['user_password']);
                    $id_role = intval($_POST['id_role']);

                    if ($this->modelUser->addUser($user_username, $user_password, $id_role)) {
                        $message = "User added successfully!";
                    } else {
                        $message = "Failed to add user.";
                    }
                } else {
                    $message = "Incomplete user data provided.";
                }
                break;

            case 'update':
                if (isset($_GET['id'], $_POST['user_username'], $_POST['user_password'], $_POST['id_role'])) {
                    $user_id = intval($_GET['id']);
                    $user_username = trim($_POST['user_username']);
                    $user_password = trim($_POST['user_password']);
                    $id_role = intval($_POST['id_role']);

                    if ($this->modelUser->updateUser($user_id, $user_username, $user_password, $id_role)) {
                        $message = "User updated successfully!";
                    } else {
                        $message = "Failed to update user.";
                    }
                } else {
                    $message = "Incomplete user data or ID not provided.";
                }
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);

                    if ($this->modelUser->deleteUser($id)) {
                        $message = "User deleted successfully!";
                    } else {
                        $message = "Failed to delete user.";
                    }
                } else {
                    $message = "User ID not provided.";
                }
                break;

            default:
                $message = "Action not recognized for user.";
                break;
        }

        // Redirect setelah aksi dilakukan
        echo "<script>alert('$message'); window.location.href='/project_akhir/views/user/user_list.php';</script>";
    }
}
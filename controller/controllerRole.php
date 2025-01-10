<?php
require_once "/laragon/www/project_akhir/model/modelRoleSql.php";

class ControllerRole {
    private $modelRole;

    public function __construct() {
        // Instantiate modelRole class to interact with role data
        $this->modelRole = new modelRole();
    }

    public function handleAction($action) {
        // Default message initialization
        $message = '';

        // Switch based on the action provided
        switch ($action) {
            case 'add':
                // Ensure required fields are available before processing
                if (isset($_POST['role_name'], $_POST['role_description'], $_POST['role_status'], $_POST['role_gaji'])) {
                    $role_name = $_POST['role_name'];
                    $role_description = $_POST['role_description'];
                    $role_status = $_POST['role_status'];
                    $role_gaji = $_POST['role_gaji'];

                    // Add the new role using the model
                    if ($this->modelRole->addRole($role_name, $role_description, $role_status, $role_gaji)) {
                        $message = "Role added successfully!";
                    } else {
                        $message = "Failed to add role.";
                    }
                } else {
                    $message = "All required fields must be filled.";
                }
                break;

            case 'update':
                // Ensure required fields are available before processing
                if (isset($_POST['role_id'], $_POST['role_name'], $_POST['role_description'], $_POST['role_status'], $_POST['role_gaji'])) {
                    $role_id = $_POST['role_id'];
                    $role_name = $_POST['role_name'];
                    $role_description = $_POST['role_description'];
                    $role_status = $_POST['role_status'];
                    $role_gaji = $_POST['role_gaji'];

                    // Update the role using the model
                    if ($this->modelRole->updateRole($role_id, $role_name, $role_description, $role_status, $role_gaji)) {
                        $message = "Role updated successfully!";
                    } else {
                        $message = "Failed to update role.";
                    }
                } else {
                    $message = "All required fields must be filled.";
                }
                break;

            case 'delete':
                // Ensure the role ID is provided for deletion
                if (isset($_GET['id'])) {
                    $role_id = $_GET['id'];

                    // Delete the role using the model
                    if ($this->modelRole->deleteRole($role_id)) {
                        $message = "Role deleted successfully!";
                    } else {
                        $message = "Failed to delete role.";
                    }
                } else {
                    $message = "Role ID not provided.";
                }
                break;

            default:
                // Handle unrecognized actions
                $message = "Action not recognized for role.";
                break;
        }

        // Display message and redirect to the role list page
        echo "<script>alert('$message'); window.location.href='/project_akhir/views/role/role_list.php';</script>";
    }
}
<?php

require_once __DIR__ . '../../model/modelMemberSql.php';

class ControllerMember {
    private $modelMember;

    public function __construct() {
        $this->modelMember = new modelMember();
    }

    public function handleAction($action) {
        switch ($action) {
            case 'add':
                $member_name = $_POST['member_name'];
                $member_password = $_POST['member_password'];
                $member_phone = $_POST['member_phone'];
                $member_point = $_POST['member_point'];
                if ($this->modelMember->addMember($member_name,$member_password, $member_phone, $member_point)) {
                    $message = "Member added successfully!";
                } else {
                    $message = "Failed to add member22.";
                }
                break;

            case 'update':
                $member_id = $_POST['member_id'];
                $member_name = $_POST['member_name'];
                $member_password = $_POST['member_password'];
                $member_phone = $_POST['member_phone'];
                $member_point = $_POST['member_point'];
                if ($this->modelMember->updateMember($member_id, $member_name,$member_password, $member_phone, $member_point)) {
                    $message = "Member updated successfully!";
                } else {
                    $message = "Failed to update member.";
                }
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    if ($this->modelMember->deleteMember($id)) {
                        $message = "Member deleted successfully!";
                    } else {
                        $message = "Failed to delete member.";
                    }
                } else {
                    $message = "Member ID not provided.";
                }
                break;

            case 'getMemberById':
                if (isset($_GET['id'])) {
                    $member = $this->modelMember->getMemberById($_GET['id']);
                    if ($member) {
                        return $member;
                    } else {
                        $message = "Member not found.";
                    }
                } else {
                    $message = "Member ID not provided.";
                }
                return;

            default:
                $message = "Action not recognized for member.";
                break;
        }

        // Redirect after action
        echo "<script>alert('$message'); window.location.href='./views/member/member_list.php';</script>";
    }
}
?>
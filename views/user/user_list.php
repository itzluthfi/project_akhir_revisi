<?php
 require_once __DIR__ . '../../../init.php';
 require_once __DIR__ . '../../../auth_check.php';


$obj_user = $modelUser->getAllUser();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
.w-Search-Input {
    width: 400px;
}
</style>

<body class="bg-gray-100 font-sans leading-normal tracking-normal overflow-hidden">

    <!-- Navbar -->
    <?php include_once __DIR__ . '../../includes/navbar.php' ?>


    <!-- Main container -->
    <div class="flex">
        <!-- Sidebar -->
        <?php include_once __DIR__ . '../../includes/sidebar.php' ?>


        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Your main content goes here -->
            <div class="container mx-auto overflow-y-auto h-[calc(100vh-4rem)]">
                <h1 class="text-4xl font-bold mb-5 pb-2 text-gray-800 italic">Manage User</h1>

                <!-- Button to Insert New User -->
                <div class="mb-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-plus"></i>
                        <a href="../../views/user/user_input.php"> Add New User</a>
                    </button>
                </div>

                <input id="search-input" type="text" name="query" placeholder="Search By Username Or ID"
                    class="p-2 border border-gray-300 rounded-xl w-Search-Input" />

                <!-- Users Table -->
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">User ID</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Username</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Password</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Role</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Salary</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <!-- Dynamic Data Rows -->


                            <?php foreach($obj_user as $user){ 
                                $user_role = $modelRole->getRoleById($user->role_id);
                                
                            ?>
                            <tr class="text-center">
                                <td class="w-1/12 py-3 px-4 text-blue-600"><?= $user->user_id ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $user->user_username ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $user->user_password ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $user_role->role_name ?></td>
                                <td class="w-1/6 py-3 px-4">
                                    RP. <?=   number_format($user_role->role_gaji) ?></td>
                                <td class="w-1/6 py-3 px-4">
                                    <button
                                        class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-1 px-2 rounded mr-2">
                                        <a href="../../views/user/user_update.php?id=<?= $user->user_id ?>"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2"
                                        onclick="return confirmDelete(<?= $user->user_id ?>)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            // Redirect ke halaman delete dengan fitur=delete
            window.location.href = "../../response_input.php?modul=user&fitur=delete&id=" + userId;
        } else {
            // Batalkan penghapusan
            alert("Gagal menghapus data");
            return false;
        }
    }
    </script>

</body>

</html>
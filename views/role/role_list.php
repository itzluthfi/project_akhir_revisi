<?php
 require_once __DIR__ . '../../../init.php';
 require_once __DIR__ . '../../../auth_check.php';

 $obj_role = $modelRole->getAllRoleFromDB();
//  var_dump($obj_role);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Role</title>
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
    <?php include_once '/laragon/www/project_akhir/views/includes/navbar.php'; ?>

    <!-- Main container -->
    <div class="flex">
        <!-- Sidebar -->
        <?php include_once "/laragon/www/project_akhir/views/includes/sidebar.php"; ?>


        <!-- Main Content -->
        <div class="flex-1 p-8 ">
            <!-- Your main content goes here -->
            <div class="container mx-auto overflow-y-auto h-[calc(100vh-4rem)]">

                <h1 class="text-4xl font-bold mb-5 pb-2 text-gray-800 italic">Manage Role</h1>


                <!-- Button to Insert New Role -->
                <div class="mb-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-plus"></i>
                        <a href="/project_akhir/views/role/role_input.php"> Add New Role</a>
                    </button>
                </div>
                <input id="search-input" type="text" name="query" placeholder="Search By Name Or Id"
                    class="p-2 border border-gray-300 rounded-xl w-Search-Input " />

                <!-- Roles Table -->
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-full bg-white grid-cols-1 ">
                        <thead class="bg-gray-800 text-white">

                            <tr>
                                <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">Role ID</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Role Name</th>
                                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Role Description</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Role Status</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Role Salary</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>

                        </thead>
                        <tbody class="text-gray-700">
                            <!-- Dynamic Data Rows -->
                            <?php foreach($obj_role as $role){ ?>

                            <tr class="text-center">
                                <td class="py-3 px-4 text-blue-600"><?= $role->role_id ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $role->role_name ?></td>
                                <td class="w-1/4 py-3 px-4"><?= $role->role_description ?></td>
                                <td class="w-1/6 py-3 px-4">
                                    <span
                                        class="<?= $role->role_status ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?> 
    inline-flex items-center justify-center px-4 py-1 rounded-full text-sm font-semibold shadow-sm transition-all duration-200 hover:shadow-md hover:scale-105">
                                        <?= $role->role_status ? "Active" : "Non Active" ?>
                                    </span>

                                </td>




                                <td class="w-1/6 py-3 px-4">RP. <?= number_format($role->role_gaji )?></td>
                                <td class="w-1/6 py-3 px-4">
                                    <button
                                        class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-1 px-2 rounded mr-2">
                                        <a href="/project_akhir/views/role/role_update.php?id=<?= $role->role_id?>"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2"
                                        onclick="return confirmDelete(<?= $role->role_id ?>)">
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
    function confirmDelete(roleId) {
        if (confirm('Apakah Anda yakin ingin menghapus role ini?')) {
            // Redirect ke halaman delete dengan fitur=delete
            window.location.href = "/project_akhir/response_input.php?modul=role&fitur=delete&id=" + roleId;
        } else {
            // Batalkan penghapusan
            alert("gagal menghapus data");
            return false;
        }
    }
    </script>

</body>

</html>
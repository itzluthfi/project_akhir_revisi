<?php
    require_once "/laragon/www/project_akhir/init.php";

    $obj_roles = $modelRole->getRoleById($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role Update</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>

    <!-- Main container -->
    <div class="flex">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Formulir Input Role -->
            <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Update Role</h2>
                <form action="../../response_input.php?modul=role&fitur=update" method="POST">
                    <input type="hidden" name="role_id" value="<?= $obj_roles->role_id ?>">
                    <!-- Nama Role -->
                    <div class="mb-4">
                        <label for="role_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Role:</label>
                        <input type="text" id="role_name" name="role_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Nama Role" required value="<?= $obj_roles->role_name ?>">
                    </div>

                    <!-- Salary Role -->
                    <div class="mb-4">
                        <label for="role_gaji" class="block text-gray-700 text-sm font-bold mb-2">Salary
                            Role:</label>
                        <input type="number" id="role_gaji" name="role_gaji"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Gaji Role" required value="<?= $obj_roles->role_gaji ?>">
                    </div>

                    <!-- Role Deskripsi -->
                    <div class="mb-4 text-left">
                        <label for="role_description" class="block text-gray-700 text-sm font-bold mb-2">Role
                            Deskripsi:</label>
                        <textarea id="role_description" name="role_description"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Deskripsi Role" rows="3"
                            required> <?= $obj_roles->role_description ?></textarea>
                    </div>

                    <!-- Role Status -->
                    <div class="mb-4">
                        <label for="role_status" class="block text-gray-700 text-sm font-bold mb-2">Role Status:</label>
                        <select id="role_status" name="role_status"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                            <option value="1" <?= $obj_roles->role_status == 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= $obj_roles->role_status == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>

                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="flex items-center justify-between">
                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Submit
                        </button>

                        <!-- Tombol Cancel -->
                        <a href="javascript:history.back()"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
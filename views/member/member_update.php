<?php
     require_once __DIR__ . '../../../init.php';


    // Get member data based on the ID received from the URL
    $obj_member = $modelMember->getMemberById($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Member</title>
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
            <!-- Update Member Form -->
            <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Update Member</h2>
                <form action="../../response_input.php?modul=member&fitur=update" method="POST">
                    <input type="hidden" name="member_id" value="<?= $obj_member->id ?>">

                    <!-- Member Name -->
                    <div class="mb-4">
                        <label for="member_name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                        <input type="text" id="member_name" name="member_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Enter member name" required value="<?= $obj_member->name ?>">
                    </div>

                    <!-- Password Member -->
                    <div class="mb-4">
                        <label for="member_password" class="block text-gray-700 text-sm font-bold mb-2">Password
                            :</label>
                        <input type="password" id="member_password" name="member_password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Passsword " required value="<?= $obj_member->password ?>">
                    </div>

                    <!-- Member Phone -->
                    <div class="mb-4">
                        <label for="member_phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                        <input type="text" id="member_phone" name="member_phone"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Enter phone number" required value="<?= $obj_member->phone ?>">
                    </div>

                    <!-- Member Points -->
                    <div class="mb-4">
                        <label for="member_point" class="block text-gray-700 text-sm font-bold mb-2">Points:</label>
                        <input type="number" id="member_point" name="member_point"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Enter points" required value="<?= $obj_member->point ?>">
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="flex items-center justify-between">
                        <!-- Submit Button -->
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Submit
                        </button>

                        <!-- Cancel Button -->
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
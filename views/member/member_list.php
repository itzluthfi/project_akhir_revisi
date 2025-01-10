<?php
 require_once __DIR__ . '../../../init.php';
 require_once __DIR__ . '../../../auth_check.php';

    $obj_members = $modelMember->getAllMembers();

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Member</title>
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
    <?php include '../includes/navbar.php'; ?>

    <!-- Main container -->
    <div class="flex">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Member Management -->
            <div class="container mx-auto overflow-y-auto h-[calc(100vh-4rem)]">
                <h1 class="text-4xl font-bold mb-5 pb-2 text-gray-800 italic">Manage Members</h1>

                <!-- Button to Insert New Member -->
                <div class="mb-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-plus"></i>
                        <a href="./member_input.php">Add New Member</a>
                    </button>
                </div>

                <!-- Search Input -->
                <input id="search-input" type="text" name="query" placeholder="Search By Name Or Id"
                    class="p-2 border border-gray-300 rounded-xl w-Search-Input " />

                <!-- Members Table -->
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-full bg-white grid-cols-1">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">Member ID</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Member Name</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Member Password</th>
                                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Phone Number</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Points</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <!-- Dynamic Data Rows -->
                            <?php foreach($obj_members as $member) { ?>
                            <tr class="text-center">
                                <td class="py-3 px-4 text-blue-600"><?= $member->id ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $member->name ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $member->password ?></td>
                                <td class="w-1/4 py-3 px-4"><?= $member->phone ?></td>
                                <td class="w-1/6 py-3 px-4">
                                    <?= $member->point ?>
                                </td>
                                <td class="w-1/6 py-3 px-4">
                                    <!-- Edit Button -->
                                    <button
                                        class="bg-violet-500 hover:bg-violet-700 text-white font-bold py-1 px-2 rounded mr-2">
                                        <a href="./member_update.php?id=<?= $member->id ?>"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                    </button>
                                    <!-- Delete Button -->
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2">
                                        <a
                                            href="../../response_input.php?modul=member&fitur=delete&id=<?= $member->id ?>"><i
                                                class="fa-solid fa-trash"></i></a>
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

</body>

</html>
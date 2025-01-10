<?php

require_once __DIR__ . '../../../init.php';

require_once __DIR__ . '../../../auth_check.php';

// Ambil data cart dari modelCart
$obj_carts = $modelCart->getAllCartItems();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart List</title>
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
            <div class="container mx-auto overflow-y-auto h-[calc(100vh-4rem)] mb-4">
                <h1 class="text-4xl font-bold mb-5 pb-2 text-gray-800 italic">Manage Cart</h1>
                <!-- Button to Insert New Item -->
                <div class="mb-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-plus"></i>

                        <a href="./item_input.php">Add New Item</a>
                    </button>
                </div>
                <!-- search form -->
                <input id="search-input" type="text" name="query" placeholder="Search By Name Or Id"
                    class="p-2 border border-gray-300 rounded-xl w-Search-Input " />

                <!-- Items Table -->
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-full bg-white grid-cols-1">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">Cart ID</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Member ID</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Item ID</th>
                                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Item Name</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Price</th>
                                <th class="w-1/8 py-3 px-4 uppercase font-semibold text-sm">Quantity</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Total Price</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <!-- Dynamic Data Rows -->
                            <?php foreach($obj_carts as $cart){ ?>
                            <tr class="text-center">
                                <td class="py-3 px-4 text-blue-600"><?= $cart->id ?></td>
                                <td class="py-3 px-4 "><?= $cart->member_id ?></td>
                                <td class="py-3 px-4 "><?= $cart->item_id ?></td>
                                <td class="w-1/4 py-3 px-4"><?= $cart->item_name ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $cart->item_price ?></td>
                                <td class="w-1/8 py-3 px-4"><?= $cart->quantity ?></td>
                                <td class="w-1/6 py-3 px-4"><?= $cart->total_price ?></td>
                                <td class="w-1/6 py-3 px-4">
                                    <button
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2">
                                        <a href="../../response_input.php?modul=cart&fitur=delete&id=<?= $cart->id ?>"><i
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
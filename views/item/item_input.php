<?php
    require_once "/laragon/www/project_akhir/init.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input item</title>
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
            <!-- Formulir Input item -->
            <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Input item</h2>
                <form action="/project_akhir/response_input.php?modul=item&fitur=add" method="POST">
                    <!-- Nama item -->
                    <div class="mb-4">
                        <label for="item_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Item:</label>
                        <input type="text" id="item_name" name="item_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Nama item" required>
                    </div>

                    <!-- Harga item -->
                    <div class="mb-4">
                        <label for="item_price" class="block text-gray-700 text-sm font-bold mb-2">Harga
                            Item:</label>
                        <input type="number" id="item_price" name="item_price"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Harga item" required>
                    </div>

                    <!-- Stock item -->
                    <div class="mb-4">
                        <label for="item_stock" class="block text-gray-700 text-sm font-bold mb-2">Stock
                            Item:</label>
                        <input type="number" id="item_stock" name="item_stock"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Jumlah Stock item" required>
                    </div>

                    <!-- item star -->
                    <div class="mb-4">
                        <label for="item_star" class="block text-gray-700 text-sm font-bold mb-2">Star
                            Item:</label>
                        <input type="number" id="item_star" name="item_star"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            placeholder="Masukkan Jumlah Stock item" required>
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
<?php 
//require_once "/laragon/www/project_akhir/model/modelRole.php"; 
require_once "/laragon/www/project_akhir/init.php";   
include "/laragon/www/project_akhir/auth_check.php";    
$obj_role = $modelRole->getAllRole(); 
$obj_member = $modelMember->getAllMembers(); 
$obj_item = $modelItem->getAllItem(); 
$obj_sale = $modelSale->getAllSales(); 


// Ambil tanggal dan total penjualan dari setiap objek penjualan
$sales_dates = [];
$sales_totals = [];
foreach ($obj_sale as $sale) {
    $sales_dates[] = $sale->sale_date; // Asumsi ada field sale_date
    $sales_totals[] = $sale->sale_totalPrice;
}

// Menghitung total penjualan
$total_sales = 0;
foreach ($obj_sale as $sale) {
    $total_sales += $sale->sale_totalPrice;
}

//information label card
$non_active_roles = [];
foreach ($obj_role as $role) {
    if (!$role->role_status) {
        $non_active_roles[] = $role;
    }
}

$Out_of_stock_items = [];
foreach ($obj_item as $item) {
    if ($item->item_stock == 0) {
        $Out_of_stock_items[] = $item;
    }
}

$zero_point_members = [];   
foreach ($obj_member as $member) {
    if ($member->point == 0) {
        $zero_point_members[] = $member;
    }
}

// Encode data untuk digunakan di JavaScript
$sales_dates_json = json_encode($sales_dates);
$sales_totals_json = json_encode($sales_totals);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <div class="flex h-screen">
        <!-- Sidebar -->

        <?php include_once '/laragon/www/project_akhir/views/includes/sidebar.php'; ?>



        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto h-[calc(100vh-4rem)]">
            <div class="container mx-auto">
                <h1 class="text-4xl font-bold mb-5 pb-2 text-gray-800 italic">Dashboard Page</h1>

                <!-- item start -->
                <div class="mx-6 mb-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2 xl:grid-cols-4">
                    <!-- User Card -->
                    <div class="card bg-blue-50 shadow-lg rounded-lg p-8">
                        <div class="card-body">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-2xl font-semibold text-gray-700">Member</h4>
                                <div
                                    class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-0">
                                <h2 class="text-3xl font-bold text-gray-800"><?= count($obj_member) ?></h2>
                                <p><span class="text-gray-600">
                                        <?= count($zero_point_members) ?></span> <span class="text-indigo-500">Zero
                                        Point</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Item Card -->
                    <div class="card bg-green-50 shadow-lg rounded-lg p-6">
                        <div class="card-body">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-2xl font-semibold text-gray-700">Item</h4>
                                <div
                                    class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-cube"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-0">
                                <h2 class="text-3xl font-bold text-gray-800"><?= count($obj_item) ?>
                                </h2>
                                <p><span class="text-gray-600">
                                        <?= count($Out_of_stock_items) ?></span> <span class="text-yellow-500">Out
                                        Of
                                        Stock</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Role Card -->
                    <div class="card bg-yellow-50 shadow-lg rounded-lg p-6">
                        <div class="card-body">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-2xl font-semibold text-gray-700">Role</h4>
                                <div
                                    class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-0">
                                <h2 class="text-3xl font-bold text-gray-800"><?= count($obj_role) ?>
                                </h2>
                                <p><span class="text-gray-600"><?= count($non_active_roles) ?></span> <span
                                        class="text-red-500">Non Active</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Sale Card -->
                    <div class="card bg-red-50 shadow-lg rounded-lg p-6">
                        <div class="card-body">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-2xl font-semibold text-gray-700">Total Sales</h4>
                                <div
                                    class="bg-indigo-600 bg-opacity-10 rounded-md w-10 h-10 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-0">
                                <!-- Menampilkan total penjualan -->
                                <div class=" flex flex-col gap-0">
                                    <h2 class="text-3xl font-bold text-blue-500">
                                        Rp. <?= number_format($total_sales, 2) ?>
                                    </h2>
                                </div>
                                <!-- Menampilkan jumlah total sale -->
                                <p><span class="text-gray-600"><?= count($obj_sale) ?></span> <span
                                        class="text-green-500">Completed</span>
                                </p>
                            </div>

                        </div>
                    </div>

                </div>


                <!-- Sales Chart and Table Section -->
                <div class="mx-6 mt-8">
                    <!-- Sales Chart -->
                    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sales Overview</h2>
                        <canvas id="salesChart" width="400" height="200"></canvas>
                    </div>

                    <!-- Sales Data Table -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Sales Data</h2>
                        <table class="min-w-full bg-white border">
                            <thead class="border-b-2 border-gray-300 text-gray-800">
                                <tr>
                                    <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">ID sale</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">User</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Member</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Total Harga</th>
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Dibayar</th>
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Kembalian</th>
                                    <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php if (!empty($obj_sale)) {
                                // var_dump($obj_sale);
                                foreach ($obj_sale as $sale) { ?>
                                <tr class="text-center">
                                    <td class="py-3 px-4 text-blue-600">
                                        <?php echo htmlspecialchars($sale->sale_id); ?></td>
                                    <!-- <td class="w-1/4 py-3 px-4"><?php echo htmlspecialchars($sale->sale_date); ?></td> -->
                                    <td class="w-1/4 py-3 px-4">
                                        <?php $user = $modelUser->getUserById($sale->id_user);$role = $modelRole->getRoleById($sale->id_user); echo htmlspecialchars("{$user->user_username} - [{$role->role_name}]"); ?>
                                    </td>
                                    <td class="w-1/4 py-3 px-4">
                                        <?php $member = $modelMember->getMemberById($sale->id_member); echo htmlspecialchars($member->name); ?>
                                    </td>
                                    <td class="w-1/4 py-3 px-4">
                                        <?php echo htmlspecialchars($sale->sale_totalPrice); ?>
                                    </td>
                                    <td class="w-1/6 py-3 px-4"><?php echo htmlspecialchars($sale->sale_pay); ?>
                                    </td>
                                    <td class="w-1/6 py-3 px-4"><?php echo htmlspecialchars($sale->sale_change); ?>
                                    </td>
                                    <td class="w-1/6 py-3 px-4">
                                        <div class="flex items-center space-x-4">
                                            <button
                                                class="border-2 border-gray-700 bg-white hover:bg-gray-800 hover:text-white text-gray-800 font-bold py-1 px-2 rounded"
                                                onclick="openModal('modal-<?php echo $sale->sale_id; ?>')">
                                                Details
                                            </button>
                                            <!-- <button
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mr-2"
                                                onclick="return confirmDelete(<?= $sale->sale_id ?>)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button> -->
                                        </div>

                                    </td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>

        <!-- Modal untuk detail sale -->
        <?php if (!empty($obj_sale)) {
            foreach ($obj_sale as $sale) { ?>
        <div id="modal-<?php echo $sale->sale_id; ?>"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detail sale:
                        <?php echo htmlspecialchars($sale->sale_id); ?></h3>
                    <div class="mt-2">
                        <table class="min-w-full bg-white overflow-y-auto overflow-x-auto">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="w-1/8 py-3 px-4 uppercase font-semibold text-sm">Id</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Barang</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Harga</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Jumlah</th>
                                    <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php foreach ($sale->detailSale as $detail) { ?>
                                <tr class="text-center">
                                    <td class="py-3 px-2"><?php echo htmlspecialchars($detail->item_id); ?></td>
                                    <td class="py-3 px-3"><?php echo htmlspecialchars($detail->item_name); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($detail->item_price); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($detail->item_qty); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($detail->subtotal); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            onclick="closeModal('modal-<?php echo $sale->sale_id; ?>')">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php } } ?>

    </div>


    <script>
    // Ambil data dari PHP
    const salesDates = <?php echo $sales_dates_json; ?>;
    const salesTotals = <?php echo $sales_totals_json; ?>;

    // Konfigurasi data chart menggunakan data dari PHP
    const salesData = {
        labels: salesDates,
        datasets: [{
            label: 'Total Penjualan (USD)',
            data: salesTotals,
            backgroundColor: 'rgba(99, 102, 241, 0.2)', // Background warna Indigo
            borderColor: 'rgba(99, 102, 241, 1)', // Border warna Indigo
            borderWidth: 1
        }]
    };

    // Konfigurasi dan render chart
    const salesConfig = {
        type: 'line',
        data: salesData,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };

    const salesChart = new Chart(
        document.getElementById('salesChart'),
        salesConfig
    );
    </script>


    <script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
        } else {
            console.error('Modal not found: ', id);
        }
    }


    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    // function confirmDelete(saleId) {
    //     if (confirm('Apakah Anda yakin ingin menghapus role ini?')) {
    //         // Redirect ke halaman delete dengan fitur=delete
    //         window.location.href = "/project_akhir/response_input.php?modul=sale&fitur=delete&id=" + saleId;
    //     } else {
    //         // Batalkan penghapusan
    //         alert("gagal menghapus data");
    //         return false;
    //     }
    // }
    </script>

</body>

</html>
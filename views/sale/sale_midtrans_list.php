<?php
 require_once __DIR__ . '../../../init.php';
 require_once __DIR__ . '../../../auth_check.php';
$sales = $modelSale->getAllSalesMidtrans();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar sale By Midtrans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Script untuk mengaktifkan modal -->
    <script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function confirmDelete(saleId) {
        if (confirm('Apakah Anda yakin ingin menghapus role ini?')) {
            // Redirect ke halaman delete dengan fitur=delete
            window.location.href = "../../response_input.php?modul=sale&fitur=delete&id=" + saleId;
        } else {
            // Batalkan penghapusan
            alert("gagal menghapus data");
            return false;
        }
    }
    </script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal overflow-hidden">

    <!-- Navbar -->
    <?php include '../includes/navbar.php'; ?>

    <!-- Main container -->
    <div class="flex">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto h-[calc(100vh-4rem)]">

            <h1 class="text-4xl font-bold mb-5 pb-2 text-gray-800 italic">Manage Sales By Midtrans</h1>


            <!-- Main Container for Transactions -->
            <div class="container mx-auto">
                <input id="search-input" type="text" name="query" placeholder="Search By Name Or Id"
                    class="p-2 border border-gray-300 rounded-xl w-Search-Input " style="width: 26rem;" />
                <!-- Print PDF Button -->
                <button onclick="printSales()"
                    class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-print"></i> Cetak All Sale - [ PDF ]
                </button>
                <!-- sale Table -->
                <div class="bg-white shadow-md  my-6">
                    <table class="min-w-full bg-white table-auto mt-4 rounded-lg overflow-hidden shadow-md">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm">ID sale</th>
                                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Member</th>
                                <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Total Harga</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Status</th>
                                <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            <?php if (!empty($sales)) {
                                // var_dump($sales);
                                foreach ($sales as $sale) { ?>
                            <tr class="text-center">
                                <td class="py-3 px-4 text-blue-600">
                                    <?php echo htmlspecialchars($sale->sale_id); ?></td>

                                <td class="w-1/4 py-3 px-4">
                                    <?php $member = $modelMember->getMemberById($sale->id_member); echo htmlspecialchars($member->name); ?>
                                </td>
                                <td class="w-1/4 py-3 px-4"><?php echo htmlspecialchars($sale->sale_totalPrice); ?></td>
                                <td class="w-1/6 py-3 px-4"> <span
                                        class="<?= $sale->sale_status == "pending" ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' ?> 
    inline-flex items-center justify-center px-4 py-1 rounded-full text-sm font-semibold shadow-sm transition-all duration-200 hover:shadow-md hover:scale-105">
                                        <?= $sale->sale_status == "pending" ? "Pending" : "Settlement" ?>
                                    </span></td>
                                <td class="w-1/6 py-3 px-4">
                                    <div class="flex items-center space-x-4">
                                        <button onclick="openModal('modal-<?php echo $sale->sale_id; ?>')" class="group relative inline-flex h-10 w-10 items-center justify-center
                                            overflow-hidden rounded-full bg-neutral-950 font-medium text-neutral-200
                                            transition-all duration-300 hover:w-28">
                                            <div
                                                class="inline-flex whitespace-nowrap opacity-0 transition-all duration-200 group-hover:-translate-x-3 group-hover:opacity-100">
                                                Details</div>
                                            <div class="absolute right-3">
                                                <svg width="13" height="13" viewBox="0 0 15 15" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" class="h-4 w-4">
                                                    <path
                                                        d="M8.14645 3.14645C8.34171 2.95118 8.65829 2.95118 8.85355 3.14645L12.8536 7.14645C13.0488 7.34171 13.0488 7.65829 12.8536 7.85355L8.85355 11.8536C8.65829 12.0488 8.34171 12.0488 8.14645 11.8536C7.95118 11.6583 7.95118 11.3417 8.14645 11.1464L11.2929 8H2.5C2.22386 8 2 7.77614 2 7.5C2 7.22386 2.22386 7 2.5 7H11.2929L8.14645 3.85355C7.95118 3.65829 7.95118 3.34171 8.14645 3.14645Z"
                                                        fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                                                    </path>
                                                </svg>
                                            </div>
                                        </button>
                                        <!-- Print PDF Button -->
                                        <button onclick="printSales()"
                                            class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded">
                                            <i class="fa fa-print pr-1"></i>Cetak PDF
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
    <?php if (!empty($sales)) {
    foreach ($sales as $sale) { ?>
    <div id="modal-<?php echo $sale->sale_id; ?>"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div
            class="relative top-20 mx-auto p-8 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-1/3 shadow-xl rounded-lg bg-white transition-all duration-300 ease-in-out transform">
            <div class="flex justify-between items-center mb-5">
                <h3 class="text-2xl font-semibold text-gray-900">Detail Penjualan
                    #<?php echo htmlspecialchars($sale->sale_id); ?></h3>
                <!-- Print PDF Button -->
                <button onclick="printSales()"
                    class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fa fa-print"></i> Cetak PDF
                </button>
                <button class="text-gray-500 hover:text-gray-700"
                    onclick="closeModal('modal-<?php echo $sale->sale_id; ?>')">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="space-y-4">

                <div class="flex justify-between">
                    <div class="font-semibold text-gray-700">Member :</div>
                    <div><?php
                        $member = $modelMember->getMemberById($sale->id_member); 
                        echo htmlspecialchars($member->name);
                    ?></div>
                </div>

                <div class="flex justify-between">
                    <div class="font-semibold text-gray-700">Total Harga :</div>
                    <div><?php echo htmlspecialchars($sale->sale_totalPrice); ?></div>
                </div>

                <div class="flex justify-between">
                    <div class="font-semibold text-gray-700">Status :</div>
                    <!-- <div><?php echo htmlspecialchars($sale->sale_status); ?></div> -->
                    <span
                        class="<?= $sale->sale_status == "pending" ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' ?> 
    inline-flex items-center justify-center px-4 py-1 rounded-full text-sm font-semibold shadow-sm transition-all duration-200 hover:shadow-md hover:scale-105">
                        <?= $sale->sale_status == "pending" ? "Pending" : "Settlement" ?>
                    </span>
                </div>

                <!-- Table Detail Item -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-800">Detail Item :</h4>
                    <table class="min-w-full bg-white table-auto mt-4 rounded-lg overflow-hidden shadow-md">
                        <thead class="bg-gray-800    text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">ID</th>
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-right">Harga</th>
                                <th class="py-3 px-4 text-right">Jumlah</th>
                                <th class="py-3 px-4 text-right">Sub Total</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">
                            <?php foreach ($sale->detailSale as $detail) { 
                                 $items = $modelItem->getItemById($detail->item_id);
                            ?>

                            <tr class="hover:bg-gray-100 transition-all duration-300">
                                <td class="py-2 px-4"><?php echo htmlspecialchars($detail->item_id); ?></td>
                                <td class="py-2 px-4"><?php echo htmlspecialchars($items->item_name); ?></td>
                                <td class="py-2 px-4 text-right"><?php echo htmlspecialchars($items->item_price); ?>
                                </td>
                                <td class="py-2 px-4 text-right"><?php echo htmlspecialchars($detail->item_qty); ?></td>
                                <td class="py-2 px-4 text-right">
                                    <?php echo htmlspecialchars($items->item_price * $detail->item_qty); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Close Button -->
            <div class="mt-6 text-center">
                <button class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-400"
                    onclick="closeModal('modal-<?php echo $sale->sale_id; ?>')">
                    Close
                </button>

            </div>

        </div>
    </div>
    <?php } } ?>



    <script>
    // delete sale
    function deleteSale(saleId) {
        if (confirm('Apakah Anda yakin ingin menghapus penjualan ini?')) {
            // Redirect to delete page with fitur=delete
            window.location.href = `../../response_input.php?modul=sale&fitur=delete&id=${saleId}`;
        } else {
            alert("Penghapusan data dibatalkan");
        }
    }
    </script>

</body>

</html>
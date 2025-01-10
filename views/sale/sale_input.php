<?php
require_once "/laragon/www/project_akhir/init.php";
$items = $modelItem->getAllItem();
$members = $modelMember->getAllMembers();
$user_id = unserialize($_SESSION['user_login'])->user_id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal overflow-hidden">

    <!-- Navbar -->
    <?php include_once '../includes/navbar.php'; ?>

    <div class="flex">
        <!-- Sidebar -->
        <?php include_once '../includes/sidebar.php'; ?>


        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto h-[calc(100vh-4rem)]">

            <h2 class="text-4xl font-bold mb-4">Transaksi Baru</h2>
            <form action="../../response_input.php?modul=sale&fitur=add" method="POST" id="transaksiForm">



                <div class="mb-4 w-1/3 max-w-md">
                    <label for="memberSelect" class="block text-gray-800 text-xl font-semibold">Pilih Member</label>
                    <select id="memberSelect" class="mt-1 p-2 border border-gray-300 rounded w-full">
                        <option value="" disabled selected>Pilih Member</option>
                        <?php
                    foreach ($members as $member) {
                        echo "<option value='{$member->id}'>{$member->id} - {$member->name} </option>";
                    }
                    ?>
                    </select>
                </div>

                <h3 class="text-xl font-semibold mb-2">Detail Barang</h3>

                <!-- Select and Input for new item -->
                <div class="mb-4 grid grid-cols-3 gap-4">
                    <div>
                        <label for="itemSelect" class="block text-gray-700">Barang</label>
                        <select id="itemSelect" class="mt-1 p-2 border border-gray-300 rounded w-full">
                            <option value="" disabled selected>Pilih Barang</option>
                            <?php
                            foreach ($items as $item) {
                                echo "<option value='{$item->item_id}' data-name='{$item->item_name}' data-price='{$item->item_price}'>
                                {$item->item_id} - {$item->item_name} - Rp{$item->item_price}
                                </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="jumlahInput" class="block text-gray-700">Jumlah</label>
                        <input type="number" id="jumlahInput" class="mt-1 p-2 border border-gray-300 rounded w-full"
                            min="1">
                    </div>
                    <div>
                        <button type="button" id="addBarangBtn"
                            class="relative inline-flex items-center justify-center px-5 py-2 text-base tracking-tighter text-white bg-blue-500 rounded-md group mt-6">
                            <span
                                class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-blue-700 rounded-md group-hover:mt-0 group-hover:ml-0"></span>
                            <span class="absolute inset-0 w-full h-full bg-white rounded-md"></span>
                            <span
                                class="absolute inset-0 w-full h-full transition-all duration-200 ease-in-out delay-100 bg-blue-700 rounded-md opacity-0 group-hover:opacity-100"></span>
                            <span
                                class="relative text-blue-600 transition-colors duration-200 ease-in-out delay-100 group-hover:text-white">Tambah
                                Barang</span>
                        </button>
                    </div>

                </div>

                <!-- Table selected items -->
                <table id="itemTable" class="w-full bg-white shadow-lg rounded-lg overflow-hidden mt-8">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-1 border-b border-gray-300 text-left">ID</th>
                            <th class="px-1 py-2 border-b border-gray-300 text-left">Nama Item</th>
                            <th class="py-1 border-b border-gray-300 text-left">Quantity</th>
                            <th class="px-1 py-2 border-b border-gray-300 text-left">Harga</th>
                            <th class="px-1 py-2 border-b border-gray-300 text-left">Subtotal</th>
                            <th class="px-1 py-2 border-b border-gray-300 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <!-- Display total harga -->
                <div class="mb-4 mt-2">
                    <label for="sale_totalPrice" class="block text-gray-700">Total Harga</label>
                    <a id="sale_totalPrice" class="block mt-1 p-2 w-80 rounded bg-white">Rp <span>0</span></a>
                </div>

                <!-- Display kembalian -->
                <div class="mb-4">
                    <label for="sale_change" class="block text-gray-700">Kembalian</label>
                    <a id="sale_change" class="block mt-1 p-2 w-80 rounded bg-white"><span>0</span></a>
                </div>

                <!-- Input untuk jumlah pembayaran -->
                <div class="mb-4">
                    <label for="sale_pay" class="block text-gray-700">Pembayaran</label>
                    <input type="number" name="sale_pay" id="sale_pay"
                        class="mt-1 p-2 border border-gray-300 rounded w-[40%]" required>
                </div>

                <button type="submit "
                    class="relative inline-flex items-center justify-center px-6 py-3 text-lg  tracking-tighter text-white bg-gray-800 rounded-md group">
                    <span
                        class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-purple-600 rounded-md group-hover:mt-0 group-hover:ml-0"></span>
                    <span class="absolute inset-0 w-full h-full bg-white rounded-md "></span>
                    <span
                        class="absolute inset-0 w-full h-full transition-all duration-200 ease-in-out delay-100 bg-purple-600 rounded-md opacity-0 group-hover:opacity-100 "></span>
                    <span
                        class="relative text-purple-600 transition-colors duration-200 ease-in-out delay-100 group-hover:text-white">Simpan
                        Transaksi</span>
                </button>

                <!-- Tombol Batal -->
                <button type="button" id="cancelButton"
                    class="relative inline-flex items-center justify-center px-6 py-3 text-lg tracking-tighter text-white bg-red-500 rounded-md group ml-4">
                    <span
                        class="absolute inset-0 w-full h-full mt-1 ml-1 transition-all duration-300 ease-in-out bg-red-700 rounded-md group-hover:mt-0 group-hover:ml-0"></span>
                    <span class="absolute inset-0 w-full h-full bg-white rounded-md "></span>
                    <span
                        class="absolute inset-0 w-full h-full transition-all duration-200 ease-in-out delay-100 bg-red-700 rounded-md opacity-0 group-hover:opacity-100 "></span>
                    <span
                        class="relative text-red-700 transition-colors duration-200 ease-in-out delay-100 group-hover:text-white">Batal</span>
                </button>



                <!-- Hidden input for item details -->
                <input type="hidden" name="sale_totalPrice" id="sale_totalPriceHidden" value="0">
                <input type="hidden" name="sale_change" id="sale_changeHidden" value="0">
                <input type="hidden" name="items" id="items">
                <!-- Input hidden untuk member_id -->
                <input type="hidden" name="id_member" id="member_id" value="">
                <input type="hidden" name="id_user" id="user_id" value="<?= $user_id?>">


            </form>
        </div>
    </div>

    <script>
    const totalPriceDisplay = document.getElementById('sale_totalPrice');
    const salePayInput = document.getElementById('sale_pay');
    const saleChangeDisplay = document.getElementById('sale_change');

    // Form submission event to check payment amount
    document.getElementById('transaksiForm').addEventListener('submit', function(event) {
        const totalPrice = parseInt(document.getElementById('sale_totalPrice').value);
        const payment = parseInt(salePayInput.value);

        console.log("Form akan dikirim dengan:");
        console.log("Total Price (hidden input):", document.getElementById('sale_totalPrice').value);
        console.log("Change (hidden input):", document.getElementById('sale_change').value);
        if (payment < totalPrice) {
            event.preventDefault();
            alert('Uang yang dibayarkan kurang!');
            return;
        }

    });

    // Add item event
    document.getElementById('addBarangBtn').addEventListener('click', function() {
        const itemSelect = document.getElementById('itemSelect');
        const memberSelect = document.getElementById('memberSelect');
        const jumlahInput = document.getElementById('jumlahInput');
        const itemTable = document.getElementById('itemTable').querySelector('tbody');
        const itemsInput = document.getElementById('items');

        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const itemId = selectedOption.value;
        const itemName = selectedOption.getAttribute('data-name');
        const itemPrice = parseFloat(selectedOption.getAttribute('data-price'));
        const quantity = parseInt(jumlahInput.value);

        if (itemId && quantity > 0) {
            const subtotal = itemPrice * quantity;

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="py-2 px-1 border-b border-gray-300">${itemId}</td>
                <td class="py-2 px-1 border-b border-gray-300">${itemName}</td>
                <td class="py-2 px-1 border-b border-gray-300">${quantity}</td>
                <td class="py-2 px-1 border-b border-gray-300">Rp${itemPrice.toLocaleString()}</td>
                <td class="py-2 px-1 border-b border-gray-300">Rp${subtotal.toLocaleString()}</td>
                <td class="px-1 py-2 border-b border-gray-300">
                    <button type="button" class="text-red-500 remove-item">Hapus</button>
                </td>
            `;

            itemTable.appendChild(newRow);

            // Update hidden input for items
            const currentItems = JSON.parse(itemsInput.value || "[]");
            currentItems.push({
                item_id: itemId,
                item_name: itemName,
                item_price: itemPrice,
                item_qty: quantity
            });
            itemsInput.value = JSON.stringify(currentItems);

            updateTotalPrice();

            // Clear the selection and input
            itemSelect.value = '';
            jumlahInput.value = '';
        }
    });

    // Remove item event
    document.getElementById('itemTable').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            const row = event.target.closest('tr');
            row.remove();

            const itemsInput = document.getElementById('items');
            const currentItems = JSON.parse(itemsInput.value || "[]");
            const itemId = row.children[0].textContent;
            const updatedItems = currentItems.filter(item => item.item_id !== itemId);
            itemsInput.value = JSON.stringify(updatedItems);

            updateTotalPrice();
        }
    });

    salePayInput.addEventListener('keyup', updateChange);

    function updateTotalPrice() {
        const itemRows = document.querySelectorAll('#itemTable tbody tr');
        let total = 0;

        itemRows.forEach(row => {
            const subtotalText = row.children[4].textContent.replace('Rp', '').replace(/\./g, '');
            const subtotal = parseInt(subtotalText);
            total += (subtotal * 1000);
        });

        totalPriceDisplay.textContent = 'Rp' + total.toLocaleString();

        document.getElementById('sale_totalPrice').value = total;
        document.getElementById('sale_totalPriceHidden').value = total;
        console.log("Total Price (hidden input):", document.getElementById('sale_totalPriceHidden').value);

        updateChange();
    }

    function updateChange() {
        const totalPrice = parseInt(document.getElementById('sale_totalPrice').value) || 0;
        const payment = parseInt(salePayInput.value) || 0;
        const change = payment - totalPrice;

        saleChangeDisplay.textContent = 'Rp' + (change < 0 ? 0 : change).toLocaleString();

        document.getElementById('sale_change').value = change < 0 ? 0 : change;
        document.getElementById('sale_changeHidden').value = change < 0 ? 0 : change;
        console.log("Change (hidden input):", document.getElementById('sale_changeHidden').value);
    }

    document.getElementById('cancelButton').addEventListener('click', function() {
        // Reset member select
        document.getElementById('memberSelect').value = '';

        // Reset item select and quantity
        document.getElementById('itemSelect').value = '';
        document.getElementById('jumlahInput').value = '';

        // Clear the item table
        const itemTableBody = document.querySelector('#itemTable tbody');
        itemTableBody.innerHTML = '';

        // Reset hidden inputs
        document.getElementById('sale_totalPriceHidden').value = '0';
        document.getElementById('sale_changeHidden').value = '0';
        document.getElementById('items').value = '[]';

        // Reset total price and change displays
        document.getElementById('sale_totalPrice').textContent = 'Rp 0';
        document.getElementById('sale_change').textContent = 'Rp 0';

        // Reset payment input
        document.getElementById('sale_pay').value = '';

        console.log('Semua form telah direset.');
    });

    // Update nilai input hidden member_id setiap kali pilihan berubah
    document.getElementById('memberSelect').addEventListener('change', function() {
        const memberSelect = document.getElementById('memberSelect');
        const selectedMemberId = memberSelect.value;
        const memberIdInput = document.getElementById('member_id');
        memberIdInput.value = selectedMemberId; // Update input hidden dengan ID member yang dipilih
    });
    </script>

</body>

</html>
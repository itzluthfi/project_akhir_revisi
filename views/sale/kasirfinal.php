<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <?php include_once '../includes/navbar.php'; ?>

    <!-- Main container -->
    <div class="flex">
        <!-- Sidebar -->
        <?php include_once '../includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content p-8 flex-grow max-w-screen-lg mx-auto">
            <div class="form-container bg-white shadow-lg rounded-lg p-4">
                <label for="item_id" class="mr-2">ID Item:</label>
                <input type="number" id="item_id"
                    class="mr-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />

                <label for="item_qty" class="mr-2">Quantity:</label>
                <input type="number" id="item_qty" min="1"
                    class="mr-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />

                <button onclick="addItem()" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                    Tambah Item
                </button>
                <div id="errorContainer" class="text-red-500 mt-2"></div>
            </div>

            <table id="itemTable" class="w-full bg-white shadow-lg rounded-lg overflow-hidden mt-8">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-1 border-b border-gray-300 text-left">ID</th>
                        <th class="px-1 py-2 border-b border-gray-300 text-left">Nama Item</th>
                        <th class="py-1 border-b border-gray-300 text-left">Quantity</th>
                        <th class="px-1 py-2 border-b border-gray-300 text-left">Harga</th>
                        <th class="px-1 py-2 border-b border-gray-300 text-left">Harga Setelah Diskon</th>
                        <th class="px-1 py-2 border-b border-gray-300 text-left">Subtotal</th>
                        <th class="px-1 py-2 border-b border-gray-300 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div id="totalHargaContainer" class="bg-gray-200 shadow-lg rounded-lg p-4 mt-8">
                <strong>Total Harga : Rp<span id="totalHargaSebelumDiskon" class="font-bold">0</span></strong><br />
                <strong>Total Diskon: Rp<span id="totalDiskon" class="font-bold">0</span></strong><br />
                <strong>Total Harga Setelah Diskon : Rp<span id="totalHarga" class="font-bold">0</span></strong>
            </div>

            <div class="form-container2 bg-white shadow-lg rounded-lg p-4 mt-8 flex items-center justify-between">
                <label for="item_qtyTunai" class="mr-2">Bayar Tunai:</label>
                <input type="number" id="item_qtyTunai"
                    class="mr-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />

                <button onclick="bayar()" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 mr-2">
                    Bayar
                </button>

                <button onclick="batal()" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                    Batal
                </button>

                <div id="kembalianContainer" class="text-lg mt-2"></div>
            </div>
        </div>
        <!-- end main content -->
    </div>

    <script>
    // Menyimpan data item sementara
    let items = [];
    let totalHarga = 0;
    let totalDiskon = 0;

    function addItem() {
        // Ambil nilai dari input
        const item_id = document.getElementById("item_id").value;
        const item_qty = document.getElementById("item_qty").value;

        // Validasi input
        if (!item_id || !item_qty || item_qty <= 0) {
            document.getElementById("errorContainer").innerText = "ID Item dan Quantity harus diisi dengan benar.";
            return;
        }

        // Reset pesan error
        document.getElementById("errorContainer").innerText = "";

        // Ambil data item dari server menggunakan AJAX
        fetch(`response_input.php?modul=item&fitur=getItemById&id=${item_id}`)
            .then(response => response.json())
            .then(item => {
                alert(item);
                if (!item) {
                    document.getElementById("errorContainer").innerText = "Item tidak ditemukan.";
                    return;
                }

                // Hitung subtotal dan diskon
                const subtotal = item.item_price * item_qty;
                const diskon = subtotal * 0.1; // contoh diskon 10%
                const hargaSetelahDiskon = subtotal - diskon;

                // Tambahkan item ke array
                const newItem = {
                    id: item_id,
                    name: item.item_name,
                    item_qty: item_qty,
                    harga: item.item_price,
                    hargaSetelahDiskon: hargaSetelahDiskon,
                    subtotal: subtotal
                };
                items.push(newItem);

                // Update total harga dan diskon
                totalHarga += subtotal;
                totalDiskon += diskon;

                // Tambahkan data ke tabel
                renderTable();

                // Update total harga di tampilan
                document.getElementById("totalHargaSebelumDiskon").innerText = totalHarga.toLocaleString();
                document.getElementById("totalDiskon").innerText = totalDiskon.toLocaleString();
                document.getElementById("totalHarga").innerText = (totalHarga - totalDiskon).toLocaleString();
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById("errorContainer").innerText = "Terjadi kesalahan saat mengambil data item.";
            });
    }

    // Render tabel item
    function renderTable() {
        const tbody = document.querySelector("#itemTable tbody");
        tbody.innerHTML = ""; // Kosongkan tabel

        items.forEach((item, index) => {
            const row = `
            <tr>
                <td>${item.id}</td>
                <td>${item.name}</td>
                <td>${item.item_qty}</td>
                <td>Rp${item.harga.toLocaleString()}</td>
                <td>Rp${item.hargaSetelahDiskon.toLocaleString()}</td>
                <td>Rp${item.subtotal.toLocaleString()}</td>
                <td>
                    <button onclick="removeItem(${index})" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                        Hapus
                    </button>
                </td>
            </tr>
        `;
            tbody.innerHTML += row;
        });
    }

    // Fungsi untuk menghapus item dari tabel
    function removeItem(index) {
        const removedItem = items.splice(index, 1)[0];
        totalHarga -= removedItem.subtotal;
        totalDiskon -= removedItem.subtotal * 0.1; // Diskon sesuai subtotal

        // Update total harga di tampilan
        document.getElementById("totalHargaSebelumDiskon").innerText = totalHarga.toLocaleString();
        document.getElementById("totalDiskon").innerText = totalDiskon.toLocaleString();
        document.getElementById("totalHarga").innerText = (totalHarga - totalDiskon).toLocaleString();

        // Render ulang tabel
        renderTable();
    }
    </script>
</body>

</html>
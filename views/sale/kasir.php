<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Item ke Tabel</title>
    <!-- Tambahkan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet" />
</head>
<style>
.active-link {
    background-color: #4a5568;
    /* bg-gray-700 */
}
</style>

<body class="bg-gray-100 flex">
    <div class="sidebar h-screen w-70 fixed top-0 left-0 bg-gray-900 text-white pt-20">
        <div class="user-info text-center pb-4">
            <h4 class="profil text-lg">Welcome Back, {{.Username}}</h4>
            <p>Role: {{.Role}}</p>
        </div>
        <a href="/kasirNonMember" class="block py-2 px-4 text-white hover:bg-gray-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            Penjualan Non Member
        </a>
        <a href="/kasirMember" class="block py-2 px-4 text-white hover:bg-gray-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
            </svg>
            Penjualan Member
        </a>
        <a href="/historyPenjualan" class="block py-2 px-4 text-white hover:bg-gray-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
            </svg>
            History Penjualan
        </a>
        <a href="/logout" class="block py-2 px-4 text-white hover:bg-gray-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
            </svg>
            Logout
        </a>
    </div>
    <!-- Konten Utama -->
    <div class="main-content ml-60 p-8 flex-grow max-w-screen-lg mx-auto">
        <div class="form-container bg-white shadow-lg rounded-lg p-4">
            <label for="itemId" class="mr-2">ID Item:</label>
            <input type="number" id="itemId"
                class="mr-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
            <label for="jumlah" class="mr-2">Jumlah:</label>
            <input type="number" id="jumlah" min="1"
                class="mr-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
            <button onclick="addItem()" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                Tambah Item
            </button>
            <div id="errorContainer" class="error mt-2"></div>
            <div id="successContainer" class="success mt-2"></div>
        </div>

        <table id="itemTable" class="w-full bg-white shadow-lg rounded-lg overflow-hidden mt-8">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-1 border-b border-gray-300 text-left">Id</th>
                    <th class="px-1 py-2 border-b border-gray-300 text-left">
                        Nama Item
                    </th>
                    <th class="py-1 border-b border-gray-300 text-left">Jumlah</th>
                    <th class="px-1 py-2 border-b border-gray-300 text-left">Harga</th>
                    <th class="px-1 py-2 border-b border-gray-300 text-left">
                        Harga Diskon
                    </th>
                    <th class="px-1 py-2 border-b border-gray-300 text-left">
                        Subtotal
                    </th>
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
            <label for="jumlahTunai" class="mr-2">Jumlah Tunai:</label>
            <input type="number" id="jumlahTunai"
                class="mr-2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" />
            <button onclick="bayar()" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 mr-2">
                Bayar
            </button>
            <button onclick="batal()" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">
                Batal
            </button>
            <div id="kembalianContainer" class="success text-lg"></div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".sidebar a");

        // Set active class on the link matching current URL
        links.forEach((link) => {
            if (link.href === window.location.href) {
                link.classList.add("active-link");
            }
        });

        // Add click event listener to each link
        links.forEach((link) => {
            link.addEventListener("click", function() {
                // Remove active class from all links
                links.forEach((l) => l.classList.remove("active-link"));
                // Add active class to the clicked link
                this.classList.add("active-link");
            });
        });
    });
    </script>

    <script>
    let totalHarga = 0;
    let totalHargaSebelumDiskon = 0;
    let totalDiskon = 0;

    function getItemDetails(itemId) {
        return fetch(`/getItemDetails?id=${itemId}`).then((response) => {
            if (!response.ok) {
                errorContainer.textContent = `item dengan id tersebut tidak ditemukan!`;
                errorContainer.style.color = "red";

                throw new Error("Item not found");
            }
            return response.json();
        });
    }

    function resetTransaction() {
        const table = document
            .getElementById("itemTable")
            .getElementsByTagName("tbody")[0];
        const rowCount = table.rows.length;

        for (let i = rowCount - 1; i >= 0; i--) {
            table.deleteRow(i);
        }

        totalHarga = 0;
        totalHargaSebelumDiskon = 0;
        totalDiskon = 0;

        document.getElementById("totalHargaSebelumDiskon").textContent =
            totalHargaSebelumDiskon.toLocaleString();
        document.getElementById("totalDiskon").textContent = (
            totalHargaSebelumDiskon - totalHarga
        ).toLocaleString();
        document.getElementById("totalHarga").textContent =
            totalHarga.toLocaleString();

        document.getElementById("jumlahTunai").value = "";
        document.getElementById("itemId").value = "";
        document.getElementById("jumlah").value = "";
        document.getElementById("kembalianContainer").textContent = "";
        document.getElementById("errorContainer").textContent = "";
        document.getElementById("successContainer").textContent = "";
    }

    function TambahItemStock(itemId, jumlah) {
        return fetch(`/TambahItemStock?id=${itemId}&jumlah=${jumlah}`, {
            method: "POST",
        }).then((response) => {
            if (!response.ok) {
                throw new Error("Failed to update stock");
            }
            return response.json();
        });
    }

    function KurangiItemStock(itemId, jumlah) {
        return fetch(`/KurangiItemStock?id=${itemId}&jumlah=${jumlah}`, {
            method: "POST",
        }).then((response) => {
            if (!response.ok) {
                throw new Error("Failed to update stock");
            }
            return response.json();
        });
    }

    

    function hapusItem(button) {
        const row = button.closest("tr");

        // Ambil itemId dan jumlah dari atribut data-itemId dan data-jumlah pada tombol hapus
        const itemId = button.getAttribute("data-item-id");
        // Ambil jumlah dari sel yang sesuai pada baris tabel
        const jumlahText = row.cells[2].textContent.trim();
        const jumlah = parseInt(jumlahText);

        // Ambil subtotal dari kolom subtotal
        const subtotalText = row.cells[5].textContent.trim();
        const subtotal = parseInt(
            subtotalText.replace("Rp", "").replace(",", "")
        );

        const hargaDiskonText = row.cells[4].textContent.trim();
        const hargaDiskon = parseInt(
            hargaDiskonText.replace("Rp", "").replace(",", "")
        );

        // Kurangi totalHarga dan totalHargaSebelumDiskon sesuai dengan subtotal yang dihapus
        totalHarga -= subtotal - hargaDiskon * jumlah;
        totalHargaSebelumDiskon -= subtotal;
        totalDiskon = totalHargaSebelumDiskon - totalHarga;

        // Tampilkan kembali totalHarga dan totalHargaSebelumDiskon setelah pengurangan
        document.getElementById("totalHarga").textContent =
            totalHarga.toLocaleString();
        document.getElementById("totalHargaSebelumDiskon").textContent =
            totalHargaSebelumDiskon.toLocaleString();
        document.getElementById("totalDiskon").textContent =
            totalDiskon.toLocaleString();

        // Hapus baris dari tabel
        row.remove();

        // Bersihkan pesan sukses dan error
        document.getElementById("successContainer").textContent = "";
        document.getElementById("errorContainer").textContent = "";

        // Tambahkan kembali stok menggunakan TambahItemStock
        TambahItemStock(itemId, jumlah).catch((error) => {
            errorContainer.textContent = error.message;
            errorContainer.style.color = "red";
        });

        //tampilkan stok item
        getItemDetails(itemId).then((item) => {
            if (item) {
                errorContainer.textContent =
                    `Stok item ${item.nama} berhasil di kembalikan. Stok tersisa: ${item.jmlStock}`;
                errorContainer.style.color = "green";
                return;
            }
        });
    }

    function bayar() {
        const jumlahTunai = parseInt(
            document.getElementById("jumlahTunai").value
        );
        const totalHargaValue = parseInt(totalHarga);

        if (!jumlahTunai || jumlahTunai < totalHargaValue) {
            document.getElementById("kembalianContainer").textContent =
                "Jumlah tunai tidak mencukupi";
            document.getElementById("kembalianContainer").style.color = "red";
            return;
        }

        const kembalian = jumlahTunai - totalHargaValue;
        document.getElementById(
            "kembalianContainer"
        ).textContent = `Kembalian: Rp ${kembalian.toLocaleString()}`;
        document.getElementById("kembalianContainer").style.color = "green";

        // Mengambil data penjualan dari tabel
        const table = document
            .getElementById("itemTable")
            .getElementsByTagName("tbody")[0];
        const rows = Array.from(table.rows);
        const salesDetails = rows.map((row) => ({
            idItem: parseInt(row.cells[0].textContent.trim()),
            namaItem: row.cells[1].textContent.trim(),
            jumlah: parseInt(row.cells[2].textContent.trim()),
            harga: parseInt(
                row.cells[3].textContent.replace("Rp", "").replace(",", "").trim()
            ),
            hargaDiskon: parseInt(
                row.cells[4].textContent.replace("Rp", "").replace(",", "").trim()
            ),
            subtotal: parseInt(
                row.cells[5].textContent.replace("Rp", "").replace(",", "").trim()
            ),
        }));

        // Mengirim data penjualan ke server
        fetch("/recordSale", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    totalHarga: totalHargaValue,
                    jumlahTunai: jumlahTunai,
                    kembalian: kembalian,
                    details: salesDetails,
                    isMember: false, // Penjualan non-member
                    memberId: 0,
                    // tanggal: new Date().toISOString(),
                }),
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Failed to record sale");
                }
                return response.json();
            })
            .then((data) => {
                alert("Pembayaran berhasil!, kembalian: RP. " + kembalian);
                resetTransaction();
            })
            .catch((error) => {
                document.getElementById("errorContainer").textContent =
                    error.message;
                document.getElementById("errorContainer").style.color = "red";
            });
    }

    function batal() {
        // Ambil itemId dan jumlah dari atribut data-itemId dan data-jumlah pada tombol hapus
        const table = document
            .getElementById("itemTable")
            .getElementsByTagName("tbody")[0];
        const rows = Array.from(table.rows);

        // Iterasi setiap baris tabel
        rows.forEach((row) => {
            // Ambil itemId dari sel pertama (id item), ganti dengan cara yang sesuai
            const itemId = row.cells[0].textContent.trim();
            // Ambil jumlah dari sel kedua, ganti dengan cara yang sesuai
            const jumlah = parseInt(row.cells[2].textContent.trim());

            // Tambahkan kembali stok menggunakan TambahItemStock
            TambahItemStock(itemId, jumlah).catch((error) => {
                errorContainer.textContent = error.message;
                errorContainer.style.color = "red";
            });
        });

        resetTransaction();
    }
    </script>
</body>

</html>
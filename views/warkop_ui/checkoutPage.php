<?php
// Cek apakah data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data POST
    $dataKeranjang = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];
    $idAnggota = isset($_POST['member_id']) ? htmlspecialchars($_POST['member_id']) : 'Tamu';
} else {
    // Jika tidak ada data POST, redirect ke halaman sebelumnya
    echo "<script>window.history.back();</script>";
    exit;
   
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-paCT6pMtbDZC9Xrg"></script>
</head>

<body>
    <div class="font-[sans-serif] bg-white">
        <div class="flex max-sm:flex-col gap-12 max-lg:gap-4 h-full">
            <!-- Bagian Keranjang -->
            <div
                class="bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 sm:h-screen sm:sticky sm:top-0 lg:min-w-[370px] sm:min-w-[300px]">
                <div class="relative h-full">
                    <div class="px-4 py-8 sm:overflow-auto sm:h-[calc(100vh-60px)]">
                        <div class="space-y-4">

                            <?php
                            $totalHarga = 0;
                            foreach ($dataKeranjang as $item) {
                                $totalHarga += $item['total_price'];
                                ?>
                            <div class="flex items-start gap-4">
                                <div class="w-32 h-28 max-lg:w-24 max-lg:h-24 flex p-3 shrink-0 bg-gray-300 rounded-md">
                                    <img src="img/menu/<?= $item['item_name'] ?>.jpg"
                                        alt="<?= htmlspecialchars($item['item_name']) ?>"
                                        class="w-full object-contain" />
                                </div>
                                <div class="w-full">
                                    <h3 class="text-base text-white"><?= htmlspecialchars($item['item_name']) ?></h3>
                                    <ul class="text-xs text-gray-300 space-y-2 mt-2">
                                        <!-- <li class="flex flex-wrap gap-4">Ukuran <span class="ml-auto">-</span></li> -->
                                        <li class="flex flex-wrap gap-4">Jumlah <span
                                                class="ml-auto"><?= htmlspecialchars($item['quantity']) ?></span></li>
                                        <li class="flex flex-wrap gap-4">Total Harga <span class="ml-auto">Rp
                                                <?= number_format($item['total_price'], 0, ',', '.') ?></span></li>
                                    </ul>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>

                    <div class="md:absolute md:left-0 md:bottom-0 bg-gray-800 w-full p-4">
                        <h4 class="flex flex-wrap gap-4 text-base text-white">Total <span class="ml-auto">Rp
                                <?= number_format($totalHarga, 0, ',', '.') ?></span>
                        </h4>
                    </div>
                </div>
            </div>

            <!-- Formulir Checkout -->
            <div class="max-w-4xl w-full h-max rounded-md px-4 py-8 sticky top-0">
                <h2 class="text-2xl font-bold text-gray-800">Selesaikan Pesanan Anda</h2>
                <form class="mt-8" id="checkout-form" method="POST">
                    <div>
                        <h3 class="text-base text-gray-800 mb-4">Detail Pribadi</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <input type="text" name="nama_depan" placeholder="Nama Depan"
                                    class="px-4 py-3 bg-gray-100 focus:bg-transparent text-gray-800 w-full text-sm rounded-md focus:outline-blue-600"
                                    required />
                            </div>
                            <div>
                                <input type="text" name="nama_belakang" placeholder="Nama Belakang"
                                    class="px-4 py-3 bg-gray-100 focus:bg-transparent text-gray-800 w-full text-sm rounded-md focus:outline-blue-600"
                                    required />
                            </div>
                            <div>
                                <input type="email" name="email" placeholder="Email"
                                    class="px-4 py-3 bg-gray-100 focus:bg-transparent text-gray-800 w-full text-sm rounded-md focus:outline-blue-600"
                                    required />
                            </div>
                            <div>
                                <input type="text" name="phone" placeholder="No. Telepon"
                                    class="px-4 py-3 bg-gray-100 focus:bg-transparent text-gray-800 w-full text-sm rounded-md focus:outline-blue-600"
                                    required />
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 max-md:flex-col mt-8">
                        <button type="button"
                            class="rounded-md px-6 py-3 w-full text-sm tracking-wide bg-transparent hover:bg-gray-100 border border-gray-300 text-gray-800 max-md:order-1"
                            onclick="window.history.back()">Batal</button>
                        <button type="button" id="pay-button"
                            class="rounded-md px-6 py-3 w-full text-sm tracking-wide bg-blue-600 hover:bg-blue-700 text-white">Selesaikan
                            Pembelian</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <script type="text/javascript">
    document.querySelector('#pay-button').addEventListener('click', async function(event) {
        event.preventDefault(); // Mencegah submit default form

        // Ambil data form
        const formData = new FormData(document.querySelector('#checkout-form'));
        const data = new URLSearchParams(formData);
        const ObjData = Object.fromEntries(data);

        // Tambahkan dataKeranjang ke ObjData
        ObjData.cart_data = <?= json_encode($dataKeranjang); ?>;
        ObjData.total_price = <?= $totalHarga ?>; // Total harga keseluruhan
        ObjData.member_id = <?= $idAnggota ?>; // ID Anggota

        try {
            console.log(ObjData);
            // Kirim data form ke server
            const response = await fetch('./placeOrderMidtrans.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(ObjData),
            });

            const token = await response.text();
            console.log(token);
            snap.pay(token, {
                onSuccess: function(result) {
                    console.log('Pembayaran berhasil:', result);

                    fetch('updateStatusMidtrans.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                orderId: result
                                    .order_id,
                                status: 'settlement',
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Status berhasil diperbarui di database:', data
                                    .message);
                                // Redirect ke halaman transaksi list
                                window.location.href = 'profile.php';
                            } else {
                                console.error('Gagal memperbarui status:', data.message);
                                alert('Terjadi kesalahan saat memperbarui status: ' + data
                                    .message);
                            }
                        })
                        .catch(error => {
                            console.error('Error saat memperbarui status:', error);
                            alert('Terjadi kesalahan pada server: ' + error.message);
                        });
                },
                onPending: function(result) {
                    console.log('Menunggu pembayaran:', result);
                    alert('Transaksi Anda sedang menunggu pembayaran.');
                },
                onError: function(result) {
                    console.error('Pembayaran gagal:', result);
                    alert('Terjadi kesalahan pada pembayaran: ' + result.message);
                },
                onClose: function() {
                    console.log('Pembayaran ditutup oleh pengguna.');
                    alert('Anda menutup pembayaran sebelum menyelesaikannya.');
                }
            });


        } catch (error) {
            alert('Kesalahan terjadi: ' + error.message);
        }
    });
    </script>



</body>

</html>
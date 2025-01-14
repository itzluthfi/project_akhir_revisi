<?php 
 require_once __DIR__ . '../../../init.php';


$isLogin = false;

// Cek apakah ada cookie untuk member_login
if (isset($_COOKIE['member_login'])) {
    // Jika ada, set sesi dari cookie
    $_SESSION['member_login'] = $_COOKIE['member_login'];
}

// Cek apakah ada sesi pengguna yang aktif
if (isset($_SESSION['member_login'])) {
    // Jika ada, arahkan ke halaman role_list
    $isLogin = true;
}



$allMenu = $modelItem->getAllItem();

if($isLogin){
    $member_id = unserialize($_SESSION['member_login'])->id;
    $carts = $modelCart->getCartsByMemberId($member_id);
}else{
    $carts = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>warkop MJ</title>

    <!-- fonts -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;1,700&display=swap"
        rel="stylesheet">

    <!-- css -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- feather icon -->
    <script src="https://unpkg.com/feather-icons" defer></script>

    <!-- tailwind -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" defer></script>

    <style>
    /* Shopping Cart Styling */
    .shopping-cart {
        position: fixed;
        /* Agar tetap di posisi yang sama saat scroll */
        top: 95px;
        right: 0;
        height: 90vh;
        width: 410px;
        padding: 1.5rem;
        color: var(--bg);
        transform: translateX(100%);
        background-color: #fff;
        /* Menyembunyikan di sebelah kanan layar */
        transition: transform 0.5s ease;
        /* Animasi smooth */
        box-shadow: -5px 0 10px rgba(0, 0, 0, 0.2);
        /* Tambahkan shadow agar lebih menarik */
        z-index: 999;
        /* Agar berada di atas elemen lain */
        border-radius: 10px;
    }

    .shopping-cart.active {
        transform: translateX(0);
        /* Muncul dari sebelah kanan ke kiri */
    }

    .shopping-cart h2 {
        font-size: 24px;
        margin-bottom: 10px;
        margin-left: 120px;
    }

    /* Cart Items */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 5px;
        /* Mengurangi jarak antar item */
        max-height: 430px;
        max-width: 420px;
        /* Tentukan tinggi maksimum area keranjang */
        overflow-y: auto;
        overflow-x: auto;
        /* Menambahkan scroll vertikal jika diperlukan */
        padding-right: 10px;
        /* Memberikan jarak jika scrollbar muncul */
    }

    .shopping-cart .cart-item {
        margin: 4px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;

        /* Menyelaraskan item secara vertikal */
        padding: 10px;
        /* Mengurangi padding antar item */
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;

    }

    .cart-item img {
        max-width: 80px;
        /* Mengurangi ukuran gambar */
        height: auto;
        object-fit: cover;
        border-radius: 8px;
    }

    .item-detail {
        flex-grow: 1;
        margin-left: 10px;
    }

    .item-detail h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        word-wrap: break-word;
    }

    .item-price {
        font-size: 14px;
        color: #777;
        margin-top: 5px;
    }

    .item-quantity {
        display: flex;
        gap: 5px;
        /* Mengurangi jarak antar tombol kuantitas */
        margin-top: 5px;
    }

    .item-quantity button {
        padding: 5px 8px;
        /* Menyesuaikan ukuran tombol */
        font-size: 14px;
        cursor: pointer;
    }

    .remove-item {
        font-size: 18px;
        cursor: pointer;
        color: #d9534f;
        margin-left: -40px;
    }

    /* Total Price Section */
    .total-price {
        margin-top: 15px;
        font-size: 18px;
        font-weight: bold;
        text-align: left;
    }

    /* Checkout Button */
    .checkout-button {
        width: 75%;
        padding: 10px;
        background-color: #b6895b;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 15px;
    }

    .checkout-button:hover {
        background-color: #c3792f;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {

        .shopping-cart.active {
            transform: translateX(0);
            top: 60px;
            right: 0;
            height: 92vh;
            width: 380px;
            /* Muncul dari sebelah kanan ke kiri */
        }

        .cart-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-item img {
            max-width: 60px;
        }

        .item-detail h3 {
            font-size: 14px;
        }

        .item-quantity {
            flex-direction: column;
        }

        .remove-item {
            align-self: flex-start;
            margin-top: 10px;
        }

        .total-price {
            font-size: 16px;
        }
    }

    #login-button,
    #logout-button {
        display: inline-block;
        padding: 8px 20px;
        background-color: #b6895b;
        border-radius: 5px;
        border-color: #fff;
        text-align: center;
        font-weight: bold;
    }

    #login-button:hover,
    #logout-button:hover {
        background-color: #c3792f;
        color: black;

    }

    .profile-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        /* Ukuran lingkaran */
        height: 40px;
        /* Ukuran lingkaran */
        border: 2px solid #f7b80a;
        /* Warna border */
        border-radius: 50%;
        /* Membuat border melingkar */
        text-decoration: none;
        /* Hilangkan underline */
        color: #b6895b;
        /* Warna ikon */
        background-color: black;
        /* Warna latar belakang */
        transition: transform 0.2s ease-in-out;
        /* Animasi hover */
    }

    .profile-button:hover {
        transform: scale(1.1);
        /* Membesarkan ikon saat hover */
    }

    .profile-button i {
        width: 20px;
        height: 20px;
    }
    </style>

</head>

<body>
    <!-- navbar start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">warkop<span> MJ</span>.</a>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">tentang kami</a>
            <a href="#menu">Menu</a>
            <a href="#products">produk</a>
            <a href="#contact">kontak</a>
        </div>

        <div class="navbar-extra">
            <a href="#" id="search-button"><i data-feather="search"></i>
                <a href="#" id="<?=  $isLogin ? "shopping-cart-button" : ""  ?>" <?php  if (!$isLogin): ?>
                    onclick="alert('Login terlebih dahulu untuk mengakses fitur ini'); return false;" <?php endif; ?>>
                    <i data-feather="shopping-cart"></i>
                    <span class="quanty-badge" style="color: #f7b80a;">
                        <?= count($carts) ?>
                    </span>
                </a>

                <a href="#" id="hamburger-menu"><i data-feather="menu"></i>
                </a>
                <?php if ($isLogin): ?>
                <!-- profile link -->
                <a id="my-profile-button" href="./profile.php" class="profile-button">
                    <i data-feather="user"></i>
                </a>

                <a id="logout-button" href="../../response_input.php?modul=logout&fitur=member">Logout</a>
                <?php else: ?>
                <a id="login-button" href="./login_member.php">Login</a>
                <?php endif; ?>
        </div>
        <!-- search form start -->
        <div class="search-form">
            <input type="search" id="search-box" placeholder="search here...">
            <label for="search-box"><i data-feather="search"></i></label>
        </div>
        <!-- search form end -->

        <!-- Shopping Cart Start -->
        <div class="shopping-cart" id="shopping-cart">
            <h2>Shopping Cart</h2>
            <div class="cart-items">
                <?php if (!empty($carts)) {
        foreach ($carts as $cartItem) { ?>
                <div class="cart-item">
                    <div class="cart-item-img">
                        <img src="img/menu/<?= $cartItem->item_name ?>.jpg"
                            alt="<?= htmlspecialchars($cartItem->item_name) ?>" />
                    </div>
                    <div class="item-detail">
                        <h3><?= htmlspecialchars($cartItem->item_name) ?></h3>
                        <div class="item-price">IDR <?= number_format($cartItem->item_price, 0, ',', '.') ?></div>
                        <div class="item-quantity">
                            <button onclick="decreaseQuantity(<?= $cartItem->id ?>)">-</button>
                            <span id="quantity-<?= $cartItem->id ?>"><?= htmlspecialchars($cartItem->quantity) ?></span>
                            <button onclick="increaseQuantity(<?= $cartItem->id ?>)">+</button>
                        </div>
                    </div>
                    <button class="remove-item" onclick="removeItem(<?= $cartItem->id ?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2" class="feather feather-trash-2">
                            <path d="M3 6h18M19 6l-1 14H6L5 6m2 0h12M10 11v6m4-6v6"></path>
                        </svg>
                    </button>
                </div>
                <?php } 
    } else { ?>
                <p>Your cart is empty.</p>
                <?php } ?>
            </div>

            <!-- Total Harga -->
            <div class="total-price">
                <strong>Total Harga:</strong>
                <span id="totalPrice">
                    Rp <?= number_format(array_sum(array_map(function($item) {
            return $item->item_price * $item->quantity;
        }, $carts)), 0, ',', '.') ?>
                </span>
            </div>

            <!-- Form Checkout -->
            <form action="./checkoutPage.php" method="POST">
                <!-- Kirim semua data keranjang sebagai input tersembunyi -->
                <input type="hidden" name="member_id" value="<?= $member_id ?>" />
                <input type="hidden" name="cart_data" value="<?= htmlspecialchars(json_encode($carts)) ?>" />

                <!-- Tombol Checkout -->
                <button type="submit" class="checkout-button" id="checkout-button">Checkout</button>
            </form>
        </div>
        <!-- Shopping Cart End -->







    </nav>
    <!-- navbar end -->

    <!-- hero section start -->

    <section class="hero" id="home">
        <main class="content">
            <h1>Ada Masalah? Ya <span>Ngopi</span> Aja</h1>
            <p>Jangan biarkan stres menguasai, mari kita
                ngobrol sambil ngopi!</p>
            <a href="#" class="cta">beli sekarang</a>
        </main>
    </section>
    <!-- <?= var_dump($carts); ?> -->

    <!-- hero section end -->



    <!-- about section start -->
    <section id="about" class="about">
        <h2><span>Tentang</span> Kami</h2>

        <div class="row">
            <div class="about-img">
                <img src="img/tentang-kami.jpg" alt="Tentang Kami">
            </div>
            <div class="content">

                <p>Warkop Kopi kami lahir dari semangat kebersamaan dan cita rasa khas yang sederhana namun mendalam.
                    Bagi kami, <span class="italic">warkop bukan sekadar tempat minum kopi</span>, tetapi ruang
                    berkumpul
                    yang penuh
                    kehangatan,
                    tempat di mana obrolan sederhana menjadi kenangan indah.</p>
                <p>Setiap cangkir kopi yang kami sajikan bukan hanya tentang rasa, tetapi juga tentang nilai dan
                    tradisi. Kami berkomitmen menjaga suasana warkop yang ramah, bersahaja, dan terbuka bagi siapa saja
                    yang mencari tempat istirahat atau inspirasi. Di sini, kopi dan pertemanan disajikan dengan porsi
                    yang pas untuk semua.</p>
            </div>
        </div>
    </section>
    <!-- about section end -->




    <!-- menu section start -->
    <section id="menu" class="menu">
        <h2><span>Menu</span> Kami</h2>
        <p>Nikmati berbagai pilihan kopi dan camilan favorit yang kami sajikan dengan cita rasa khas.</p>

        <!-- Row Wrapper Outside the PHP Loop -->
        <div class="row">
            <?php foreach ($allMenu as $menu) {  ?>
            <div class="menu-card">
                <img src="img/menu/<?= $menu->item_name ?>.jpg" alt="<?= $menu->item_name ?>" class="menu-card-img">
                <h3 class="menu-card-title"><?= $menu->item_name ?></h3>
                <p class="menu-card-price">RP. <?= $menu->item_price ?></p>
            </div>
            <?php } ?>
        </div>
    </section>
    <!-- menu section end -->



    <!-- products section start -->
    <section class="products" id="products">
        <h2><span>produk unggulan</span> kami</h2>
        <p>Jelajahi koleksi produk unggulan kami yang dirancang untuk memberikan pengalaman terbaik.
            Temukan pilihan favorit
            Anda di sini!</p>

        <div class="row">
            <?php foreach ($allMenu as $menu) { ?>
            <div class="product-card">
                <div class="product-icons">
                    <a href="#" class="cart-button" data-item-id="<?= $menu->item_id ?>"
                        data-item-name="<?= $menu->item_name ?>" data-item-image="img/menu/<?= $menu->item_name ?>.jpg"
                        <?php if (!$isLogin): ?>
                        onclick="alert('Login terlebih dahulu untuk mengakses fitur ini'); return false;" <?php else: ?>
                        onclick="showQuantityPopup(event, this); return false;" <?php endif; ?>>
                        <i data-feather="shopping-cart"></i>
                    </a>

                    <a href="#" class="item-detail-button" data-star="<?= $menu->item_star ?>" <?php if (!$isLogin): ?>
                        onclick="alert('Login terlebih dahulu untuk mengakses fitur ini'); return false;"
                        <?php endif; ?>>
                        <i data-feather="eye"></i>
                    </a>
                </div>
                <div class="product-image">
                    <img src="img/menu/<?= $menu->item_name ?>.jpg" alt="<?= $menu->item_name ?>">
                </div>
                <div class="product-content">
                    <h3>coffe <?= $menu->item_name ?></h3>
                    <div class="product-stars">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <i data-feather="star" <?= ($i <= $menu->item_star) ? 'class="star-full"' : ''; ?>></i>
                        <?php } ?>
                    </div>
                    <div class="product-price">
                        RP. <?= ceil($menu->item_price * 0.8) ?>
                        <span>RP. <?= $menu->item_price ?></span>
                    </div>
                </div>
            </div>
            <?php } ?>


            <!-- Popup untuk jumlah item -->
            <div id="quantityPopup"
                style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); width: 600px;">
                <button onclick="closePopup()"
                    style="position: absolute; top: 8px; right: 10px; background: none; border: none; font-size: 40px; font-weight: bold; cursor: pointer; color: #333;">&times;</button>

                <form action="../../response_input.php?modul=cart&fitur=add" method="POST">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <div style="flex: 1; text-align: center;">
                            <img id="popupImage" src="" alt="Gambar Produk"
                                style="max-width: 100%; border-radius: 8px;" />
                        </div>
                        <div style="flex: 1;">
                            <h2 style="margin-bottom: 15px; color: #333; text-align: center; font-size: 24px;"></h2>
                            <h3 style="margin-bottom: 10px; color: #010101; text-align: center;">Masukkan Jumlah Item
                            </h3>
                            <input type="number" id="popupQuantity" name="quantity" value="1" min="1"
                                style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; text-align: center;"
                                placeholder="Jumlah">
                            <input type="hidden" name="member_id" value="<?= $member_id ?>">
                            <input type="hidden" name="item_id" value="">
                            <button type="submit" id="confirmQuantity"
                                style="padding: 8px 12px; background-color: #b6895b; color: white; border: none; border-radius: 5px; width: 100%; margin-bottom: 10px;">Konfirmasi</button>
                            <button type="button" onclick="closePopup()"
                                style="padding: 8px 12px; background-color: #010101; color: white; border: none; border-radius: 5px; width: 100%;">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
    </section>
    <!-- products section end -->






    <!-- contact section start -->
    <section id="contact" class="contact">
        <h2><span>Kontak</span> Kami</h2>
        <p>Jangan ragu untuk menghubungi kami melalui form di bawah ini atau datang langsung ke warkop
            kami~</p>

        <div class="row">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.958140793931!2d112.57559401469219!3d-7.3585891946899!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7808809a2ed0c3%3A0xed8cd2d758019d59!2sWarkop%20MJ!5e0!3m2!1sid!2sid!4v1675781074414!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>

            <form onsubmit="submitToWhatsApp(event)">
                <div class="input-group">
                    <i data-feather="user"></i>
                    <input type="text" id="name" placeholder="nama" required>
                </div>
                <div class="input-group">
                    <i data-feather="mail"></i>
                    <input type="email" id="email" placeholder="email" required>
                </div>
                <div class="input-group">
                    <i data-feather="phone"></i>
                    <input type="text" id="phone" placeholder="no hp" required>
                </div>
                <button type="submit" class="btn">kirim pesan</button>
            </form>
        </div>
    </section>
    <!-- contact section end -->



    <!-- footer start -->
    <footer>
        <div class="socials">
            <a href="https://instagram.com/itzluthfi"><i data-feather="instagram"></i></a>
            <a href="https://twitter.com/itzluthfi"><i data-feather="twitter"></i></a>
            <a href="https://facebook.com/itzluthfi"><i data-feather="facebook"></i></a>
            <script>
            // Aktifkan semua ikon Feather Icons pada halaman
            feather.replace();
            </script>
        </div>

        <div class="links">
            <a href="#home">Home</a>
            <a href="#about">tentang kami</a>
            <a href="#menu">Menu</a>

            <a href="#contact">kontak</a>
        </div>

        <div class="credit">
            <p>created by <a href="">luthfi shidqi habibulloh</a>. | &copy;2023.</p>
        </div>
    </footer>
    <!-- footer end -->


    <!-- modal box item details start -->
    <div class="modal" id="item-detail-modal">
        <div class="modal-container">
            <a href="#" class="close-icon"><i data-feather="x"></i></a>
            <div class="modal-content">
                <img src="img/products/1.jpg" alt="<?= htmlspecialchars($menu->item_name) ?>">
                <div class="product-content">
                    <h3><?= htmlspecialchars($menu->item_name) ?></h3>
                    <!-- Deskripsi manual -->
                    <p>Ini adalah deskripsi produk manual yang bisa diubah sesuai keinginan. Misalnya, deskripsi kopi
                        yang sangat enak dan nikmat.</p>
                    <div class="product-stars">
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <i data-feather="star" <?= ($i <= $menu->item_star) ? 'class="star-full"' : '' ?>></i>
                        <?php } ?>
                    </div>

                    <div class="product-price" style="font-size: 1.3rem;font-weight: bold;">
                        RP. <?= ceil($menu->item_price * 0.8) ?>
                        <span style="text-decoration: line-through;
                        font-weight: lighter;font-size: 1rem;">RP. <?= $menu->item_price ?></span>
                    </div>

                    <a href="#"><i data-feather="shopping-cart rounded"></i> <span>add to cart</span></a>
                </div>
            </div>
        </div>
    </div>
    <!-- modal box item details end -->




    <!-- hak akses member(login) start -->

    <!-- hak akses member(login) end -->


    <!-- product start -->
    <script>
    function showQuantityPopup(event, button) {
        event.preventDefault();

        // Ambil data dari tombol yang diklik
        const itemId = button.getAttribute('data-item-id');
        const itemName = button.getAttribute('data-item-name');
        const itemImage = button.getAttribute('data-item-image');

        // Update konten popup
        document.getElementById('popupImage').src = itemImage;
        document.querySelector('#quantityPopup h2').textContent = "coffee " + itemName;
        document.querySelector('[name="item_id"]').value = itemId;

        // Tampilkan popup
        document.getElementById('quantityPopup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('quantityPopup').style.display = 'none';
    }

    // Tombol Konfirmasi
    document.getElementById('confirmQuantity').addEventListener('click', function(event) {
        const quantity = document.getElementById('popupQuantity').value;

        // Validasi
        if (quantity <= 0) {
            alert('Jumlah item harus lebih dari 0');
            return;
        }

        document.querySelector('#quantityPopup form').submit();
        closePopup();
    });
    </script>

    <!-- product end -->

    <!-- modal close strt-->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const itemdetailmodal = document.querySelector("#item-detail-modal");
        const closeIcon = document.querySelector(".modal-container .close-icon");

        // Tutup modal ketika tombol close-icon diklik
        closeIcon.onclick = (e) => {
            e.preventDefault();
            itemdetailmodal.style.display = "none";
            console.log("close");
        };

        // Tutup modal ketika klik di luar modal
        window.onclick = (e) => {
            if (e.target === itemdetailmodal) {
                itemdetailmodal.style.display = "none";
                console.log("Modal ditutup");
            }
        };
    });
    </script>
    <!-- modal end -->

    <!-- contact form-->
    <script>
    function submitToWhatsApp(event) {
        event.preventDefault();

        // Mengambil nilai dari input
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;

        // ID nomor WhatsApp tujuan
        const phoneNumber = '62895806705493'; // Ganti dengan nomor WhatsApp tujuan

        // Format pesan yang akan dikirim
        const message = `Halo, saya ${name}.%0AEmail: ${email}%0ANo HP: ${phone}%0ASaya ingin menghubungi Anda.`;

        // Mengarahkan ke WhatsApp
        const whatsappURL = `https://wa.me/${phoneNumber}?text=${message}`;
        window.open(whatsappURL, '_blank');
    }
    </script>
    <!-- shopping cart logic -->
    <script>
    function submitForm(e, linkElement) {
        // Prevent default behavior
        e.preventDefault();

        // Submit the closest form
        const form = linkElement.closest('form');
        if (form) {
            form.submit();
        }
    }


    function decreaseQuantity(id) {
        const quantityElement = document.getElementById(`quantity-${id}`);
        let quantity = parseInt(quantityElement.textContent);
        if (quantity > 1) {
            quantityElement.textContent = quantity - 1;
            updateTotalPrice();
        }
    }

    function increaseQuantity(id) {
        const quantityElement = document.getElementById(`quantity-${id}`);
        let quantity = parseInt(quantityElement.textContent);
        quantityElement.textContent = quantity + 1;
        updateTotalPrice();
    }

    function updateQuantity(id, delta) {
        const quantitySpan = document.getElementById(`quantity-${id}`);
        let quantity = parseInt(quantitySpan.textContent) + delta;
        if (quantity < 1) return; // Cegah jumlah negatif atau nol

        fetch(`../../response_input.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id,
                    quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    quantitySpan.textContent = quantity;
                    document.getElementById(`price-${id}`).textContent = data.newPrice;
                    document.getElementById(`totalPrice`).textContent = data.totalPrice;
                }
            });
    }

    function removeItem(id) {
        fetch(`/response_input.php?modul=cart&fitur=delete&id=${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`cart-item-${id}`).remove();
                    document.getElementById(`totalPrice`).textContent = data.totalPrice;
                }
            });
    }

    function checkout() {
        fetch(`/response_input.php?modul=cart&fitur=checkout`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Checkout berhasil!");
                    document.getElementById("shopping-cart").innerHTML = "<p>Your cart is empty.</p>";
                }
            });
    }
    </script>



    <!-- feather icon -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        feather.replace(); // Pastikan ikon Feather diganti setelah DOM siap
    });
    </script>

    <!-- my javascript -->
    <script src="js/script.js"> </script>
</body>

</html>
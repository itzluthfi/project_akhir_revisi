<?php
 require_once __DIR__ . '../../../init.php';
//  require_once __DIR__ . '../../../auth_check.php';
$sales = $modelSale->getAllSalesMidtrans();
$user = unserialize($_SESSION['member_login']);
// var_dump($user);
?>

<!DOCTYPE html>
<html lang="en" data-theme="custom">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#b6895b',
                    background: '#010101',
                }
            }
        },
        daisyui: {
            themes: [{
                custom: {
                    "primary": "#b6895b",
                    "background": "#010101",
                    "base-100": "#010101",
                },
            }],
        },
    }
    </script>
    <style>
    .btn-custom {
        background-color: #b6895b;
        color: #010101;
    }

    .btn-custom:hover {
        background-color: #a07a4f;
    }

    .bg-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23b6895b' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    </style>
</head>

<body class="bg-background text-primary min-h-screen bg-pattern">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-base-100 rounded-box shadow-xl p-6 mb-8 backdrop-blur-sm bg-opacity-80">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <div class="avatar">
                    <div class="w-48 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img src="https://api.dicebear.com/6.x/adventurer/svg?seed=Felix" alt="Profile Picture" />
                    </div>
                </div>
                <div class="flex-1 space-y-4 w-full">
                    <!-- Back Button -->
                    <button onclick="window.history.back()"
                        class="fixed top-4 right-4 z-50 btn btn-custom flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <h1 class="text-4xl font-bold text-center lg:text-left">User Profile</h1>
                    <!-- Update Button -->
                    <button onclick="window.location.href='profileUpdate.php'"
                        class="btn btn-custom flex items-center gap-2 text-lg">
                        <i class="fas fa-edit"></i> Update
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text text-primary">Username</span></label>
                            <input type="text" value="<?= $user->name ?>"
                                class="input input-bordered bg-background text-primary" readonly />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text text-primary">Password</span>
                            </label>
                            <div class="relative">
                                <input type="password" value="<?= $user->password ?>" id="password-field"
                                    class="input input-bordered bg-background text-primary w-full pr-10" readonly />
                                <button type="button" onclick="togglePasswordVisibility()"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i id="toggle-icon" class="fas fa-eye text-gray-500"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text text-primary">Phone</span></label>
                            <input type="tel" value="<?= $user->phone ?>"
                                class="input input-bordered bg-background text-primary" readonly />
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text text-primary">Points</span></label>
                            <input type="number" value="<?= $user->point ?>"
                                class="input input-bordered bg-background text-primary" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-base-100 rounded-box shadow-xl p-6 backdrop-blur-sm bg-opacity-80">
            <h2 class="text-2xl font-bold mb-4">Sales History</h2>
            <div class="overflow-x-auto max-h-[360px] overflow-y-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th class="bg-primary text-background">ID</th>
                            <th class="bg-primary text-background">Total Price</th>
                            <th class="bg-primary text-background">Status</th>
                            <th class="bg-primary text-background">Date</th>
                            <th class="bg-primary text-background">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $sale) { ?>
                        <tr>
                            <td><?= $sale->sale_id ?> </td>
                            <td><?= $sale->sale_totalPrice ?></td>
                            <td><span class="badge badge-success"><?= $sale->sale_status ?></span></td>
                            <td><?= $sale->sale_date ?></td>
                            <td><label for="modal-001" class="btn btn-custom btn-sm">Details</label></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal for Sale ID 001 -->
    <input type="checkbox" id="modal-001" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box bg-base-100">
            <h3 class="font-bold text-lg">Sale Details - ID: 001</h3>
            <p>Member ID: M001</p>
            <p>Points Used: 50</p>
            <p>Date: 2023-05-15</p>
            <p>Status: <span class="badge badge-success">Completed</span></p>
            <div class="overflow-x-auto mt-4">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID Item</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>I001</td>
                            <td>Product A</td>
                            <td>2</td>
                            <td>$100.00</td>
                        </tr>
                        <tr>
                            <td>I002</td>
                            <td>Product B</td>
                            <td>1</td>
                            <td>$150.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <p class="font-bold">Total: $250.00</p>
            </div>
            <div class="modal-action">
                <label for="modal-001" class="btn btn-custom">Close</label>
            </div>
        </div>
    </div>

    <!-- Modal for Sale ID 002 -->
    <input type="checkbox" id="modal-002" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box bg-base-100">
            <h3 class="font-bold text-lg">Sale Details - ID: 002</h3>
            <p>Member ID: M002</p>
            <p>Points Used: 20</p>
            <p>Date: 2023-05-10</p>
            <p>Status: <span class="badge badge-warning">Pending</span></p>
            <div class="overflow-x-auto mt-4">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID Item</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>I003</td>
                            <td>Product C</td>
                            <td>1</td>
                            <td>$120.50</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <p class="font-bold">Total: $120.50</p>
            </div>
            <div class="modal-action">
                <label for="modal-002" class="btn btn-custom">Close</label>
            </div>
        </div>
    </div>

    <!-- Modal for Sale ID 003 -->
    <input type="checkbox" id="modal-003" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box bg-base-100">
            <h3 class="font-bold text-lg">Sale Details - ID: 003</h3>
            <p>Member ID: M003</p>
            <p>Points Used: 0</p>
            <p>Date: 2023-05-05</p>
            <p>Status: <span class="badge badge-error">Cancelled</span></p>
            <div class="overflow-x-auto mt-4">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>ID Item</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>I004</td>
                            <td>Product D</td>
                            <td>3</td>
                            <td>$75.25</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-right mt-4">
                <p class="font-bold">Total: $75.25</p>
            </div>
            <div class="modal-action">
                <label for="modal-003" class="btn btn-custom">Close</label>
            </div>
        </div>
    </div>
    <script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password-field');
        const toggleIcon = document.getElementById('toggle-icon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Point of Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
.register-button:hover {
    background-color: #de7d1d;
}

.login-link a:hover {
    color: #de7d1d;
    text-decoration: underline;
}
</style>

<body class="bg-gray-100">

    <!-- Container -->
    <div class="relative flex flex-wrap min-h-screen items-center justify-center py-10">

        <!-- Background Video -->
        <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover z-0 opacity-75">
            <source src="../../public/img/bg-coffe2.mp4" type="video/mp4">
        </video>

        <!-- Overlay to darken video -->
        <div class="absolute inset-0 bg-black opacity-50 z-10"></div>

        <!-- Register component -->
        <div class="relative flex shadow-lg rounded-lg overflow-hidden bg-white z-20 opacity-90 transition-all">
            <!-- Register form -->
            <div class="flex flex-col justify-center p-8" style="width: 24rem; height: 36rem;">
                <h1 class="text-2xl font-bold text-center text-purple-700 italic" style="color: #b6895b;">
                    Join Us at </h1>
                <h1 class="text-4xl font-bold text-center text-purple-700" style="color: #b6895b;">My Point Of Sale</h1>
                <p class="text-gray-500 text-center italic">Create your account!</p>

                <!-- Form -->
                <form class="mt-6 opacity-65 hover:opacity-100 transition-opacity duration-300"
                    action="/project_akhir/response_input.php?modul=register&fitur=add" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1" for="username">Username</label>
                        <input id="username" type="text" name="username" placeholder="Enter your Username" required
                            class="block w-full border border-gray-300 rounded-md focus:border-purple-700 focus:ring-1 focus:ring-purple-700 py-2 px-3 text-gray-700 transition duration-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1" for="email">Email</label>
                        <input id="email" type="email" name="email" placeholder="Enter your Email" required
                            class="block w-full border border-gray-300 rounded-md focus:border-purple-700 focus:ring-1 focus:ring-purple-700 py-2 px-3 text-gray-700 transition duration-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1" for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="*****" required
                            class="block w-full border border-gray-300 rounded-md focus:border-purple-700 focus:ring-1 focus:ring-purple-700 py-2 px-3 text-gray-700 transition duration-200" />
                    </div>

                    <button type="submit"
                        class="register-button w-full text-center text-white transition duration-200 px-4 py-2 rounded-md"
                        style="background-color: #b6895b;">Register</button>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-4 login-link">
                    <span class="text-sm text-gray-400 italic">Already have an account?</span>
                    <a href="./login_member.php" class="text-sm font-semibold text-purple-700" style="color: #b6895b;">
                        <span class="hover:underline">Login here</span>
                    </a>
                </div>
            </div>

            <!-- Register Video Banner -->
            <div class="flex items-center justify-center bg-gray-300 relative transition-opacity opacity-70 hover:opacity-100 duration-1000"
                style="width: 24rem; height: 36rem;">
                <video autoplay muted loop class="object-cover w-full h-full">
                    <source src="../../public/img/bg-coffe2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</body>

</html>
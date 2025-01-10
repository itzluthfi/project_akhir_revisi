<?php
// var_dump($_COOKIE['user_login']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Point of Sale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<style>
.sign-in-button:hover {
    background-color: #de7d1d;

}

.forgot-password a:hover {
    color: #de7d1d;
    font-style: underline;
}
</style>

<body class="bg-gray-100">

    <!-- Container -->
    <div class="relative flex flex-wrap min-h-screen items-center justify-center py-10 ">

        <!-- Background Video -->
        <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover z-0 opacity-75">
            <source src="../../public/img/bg-coffe2.mp4" type="video/mp4">
        </video>

        <!-- Overlay to darken video -->
        <div class="absolute inset-0 bg-black opacity-50 z-10"></div>

        <!-- Login component -->
        <div class="relative flex shadow-lg rounded-lg overflow-hidden bg-white z-20 opacity-90 transition-all">
            <!-- Login form -->
            <div class="flex flex-col justify-center p-8" style="width: 24rem; height: 32rem;">
                <h1 class="text-2xl font-bold text-center text-purple-700 italic" style="color: #b6895b;">
                    Welcome To </h1>
                <h1 class="text-4xl font-bold text-center text-purple-700" style="color: #b6895b;">Warkop MJ</h1>
                <p class="text-gray-500 text-center italic">Please enter your details Member!</p>

                <!-- Form -->
                <form class="mt-6 opacity-65 hover:opacity-100  transition-opacity duration-300"
                    action="/project_akhir/response_input.php?modul=login&fitur=member" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1" for="username">Username</label>
                        <input id="username" type="text" name="username_login" placeholder="Enter your Username"
                            required
                            class="block w-full border border-gray-300 rounded-md focus:border-purple-700 focus:ring-1 focus:ring-purple-700 py-2 px-3 text-gray-700 transition duration-200" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-1" for="password">Password</label>
                        <input id="password" type="password" name="password_login" placeholder="*****" required
                            class="block w-full border border-gray-300 rounded-md focus:border-purple-700 focus:ring-1 focus:ring-purple-700 py-2 px-3 text-gray-700 transition duration-200" />
                    </div>

                    <div class="mb-4 flex items-center forgot-password">
                        <input id="remember" name="remember_me" type="checkbox" class="mr-2" />
                        <label for="remember" class="text-sm font-semibold">Remember me for 1 day</label>

                    </div>
                    <div class="mb-2 flex items-center justify-center register">
                        <a href="./register_member.php" class="text-sm font-semibold text-purple-700 "
                            style="color: #b6895b;">
                            Don't have an account?<span class="hover:underline ml-1">register here</span> </a>
                    </div>

                    <button type="submit"
                        class="sign-in-button  w-full text-center text-white  transition duration-200 px-4 py-2 rounded-md"
                        style="background-color: #b6895b;">Sign
                        in</button>
                </form>

                <!-- <div class="text-center mt-4 ">
                    <span class="text-sm text-gray-400 italic">Don't have an account?</span>
                    <a href="#" class="text-sm font-semibold text-purple-700 hover:underline ">Sign up</a>
                </div> -->
            </div>

            <!-- Login Video Banner -->
            <div class="flex items-center justify-center bg-gray-300 relative transition-opacity opacity-70 hover:opacity-100 duration-1000"
                style="width: 24rem; height: 32rem;">
                <video autoplay muted loop class="object-cover w-full h-full  ">
                    <source src="../../public/img/bg-coffe2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

    </div>
</body>

</html>
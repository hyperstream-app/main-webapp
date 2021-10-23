<?php
require 'assets/includes/functions.php';
if(isset($_POST['login'])) {
    userLogin();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/tailwind.css">
</head>
<body>
<div class="relative min-h-screen flex ">
    <div class="flex flex-col sm:flex-row items-center md:items-start sm:justify-center md:justify-start flex-auto min-w-0 bg-white">
      <div class="sm:w-1/2 xl:w-3/5 h-full hidden md:flex flex-auto items-center justify-center p-10 overflow-hidden bg-purple-900 text-white bg-no-repeat bg-cover relative"
        style="background-image: url(https://images.unsplash.com/photo-1579451861283-a2239070aaa9?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80);">
        <div class="absolute bg-gradient-to-b from-indigo-600 to-blue-500 opacity-75 inset-0 z-0"></div>
        <div class="w-full  max-w-md z-10">
          <div class="sm:text-4xl xl:text-5xl font-bold leading-tight mb-6">Login to access your account</div>
          <div class="sm:text-sm xl:text-md text-gray-200 font-normal"> Hyperstream is world's first app that allows you skip the long queues of the shopping mart and be in and out of a store in just 10 minutes.</div>
        </div>
      </div>
      <div class="md:flex md:items-center md:justify-center w-full sm:w-auto md:h-full w-2/5 xl:w-2/5 p-8  md:p-10 lg:p-14 sm:rounded-lg md:rounded-none bg-white">
        <div class="max-w-md w-full space-y-8">
          <div class="text-center">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
              Welcome Back!
            </h2>
            <p class="mt-2 text-sm text-gray-500">Please sign in to your account</p>
          </div>
          <form class="mt-8 space-y-6" action="" method="POST">
            <div class="relative">
              <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">Email</label>
              <input name="email"
                class="w-full text-base px-4 py-2 border-b border-gray-300 focus:outline-none rounded-2xl focus:border-indigo-500"
                type="email" placeholder="mail@gmail.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : null ?>">
            </div>
            <div class="mt-8 content-center">
              <label class="ml-3 text-sm font-bold text-gray-700 tracking-wide">
                Password
              </label>
              <input name="password"
                class="w-full content-center text-base px-4 py-2 border-b rounded-2xl border-gray-300 focus:outline-none focus:border-indigo-500"
                type="password" placeholder="Enter your password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : null ?>">
            </div>
            <div class="flex items-center justify-between">
              
             
            </div>
            <div>
              <button name="login" type="submit"
                class="w-full flex justify-center bg-gradient-to-r from-indigo-500 to-blue-600  hover:bg-gradient-to-l hover:from-blue-500 hover:to-indigo-600 text-gray-100 p-4  rounded-full tracking-wide font-semibold  shadow-lg cursor-pointer transition ease-in duration-500">
                Sign in
              </button>
            </div>
            <p class="flex flex-col items-center justify-center mt-10 text-center text-md text-gray-500">
              <span>Don't have an account? <a href="./signup.php"
                class="text-indigo-400 hover:text-blue-500 no-underline hover:underline cursor-pointer transition ease-in duration-300">Sign
                up</a></span>
            </p><br>
            <span class="text-red-400"><?php include 'assets/includes/formErrors.php'; ?></span>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

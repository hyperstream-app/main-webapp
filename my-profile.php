<?php
require 'assets/includes/functions.php';
isAuthenticated();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/tailwind.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-gray-100">
  <section class="p-5">
    <h2 class="text-3xl text-center mb-10"><u>Recently Visited Stores</u></h2>
    <div class="container mx-auto flex flex-wrap flex-row justify-around items-center">

      <div class="container mx-auto my-5 p-5">
        <div class="md:flex no-wrap md:-mx-2 ">
            <div class="w-full md:w-12/12 mx-2 h-64">
                <!-- Profile tab -->
                <!-- About Section -->
                <div class="bg-white p-3 shadow-sm rounded-sm">
                    <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                        <span class="tracking-wide">About</span>
                    </div>
                    <div class="text-gray-700">
                        <div class="grid md:grid-cols-2 text-sm">
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Full Name</div>
                                <div class="px-4 py-2">Jane</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Email</div>
                                <div class="px-4 py-2">Female</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Phone</div>
                                <div class="px-4 py-2">+11 998001001</div>
                            </div><br>
                            <hr>
                            <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                                <span class="tracking-wide">Recent Payments</span>
                            </div>
                            <div class="grid grid-cols-2">
                               <div class="px-4 py-2 font-semibold">#11</div>
                                <div class="px-4 py-2"><a href="assets/invoices/"><i class="material-icons nav-icon">assignment</i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="bg-white p-3 shadow-sm rounded-sm">
                </div>
            </div>
        </div>
      
    </div>
  </section><br>
  <?php include('assets/includes/navbar.php'); ?>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>

</html>
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

<body>
  <header class="text-gray-600 body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col items-center">
      <div class="bg-white shadow p-4 flex w-full">
        <span class="w-auto flex justify-end items-center text-gray-500 p-2">
          <i class="material-icons text-3xl">search</i>
        </span>
        <input class="w-full rounded p-2" type="text" placeholder="Visited stores here...">
        <button class="bg-red-400 hover:bg-red-300 rounded text-white p-2 pl-4 pr-4">
          <p class="font-semibold text-xs">Search</p>
        </button>
      </div>
    </div>
  </header>
  <section class="p-5">
    <h2 class="text-3xl text-center mb-10"><u>Recently Visited Stores</u></h2>
    <div class="container mx-auto flex flex-wrap flex-row justify-around items-center">

      <!--Recent Store-->
      <?php
        $stores = getAllStores();
        foreach($stores as $store) {
      ?>
        <div class="bg-white card-shadow p-3 rounded lg:w-72 p-4 mb-10 h-100" style="height: 100%;">
            <div>
                <div style="background-image: url(assets/images/<?php echo $store['store_image']; ?>)" class="bg-cover bg-center bg-gray-300 h-32 rounded">
            </div>
            </div>
                <div class="mt-6">
                <p class="text-lg text-bold tracking-wide text-gray-600 mb-2">
                    <?php echo $store['store_name']; ?>
                </p>
                <p class="text-sm text-gray-600 font-hairline">
                    Located at: <?php echo $store['store_address']; ?>
                </p>
            </div>
            <div class="mt-6">
                <a href="connect-to-store.php?id=<?php echo $store['id']; ?>" class="rounded shadow-md flex items-center shadow bg-red-400 px-4 py-2 text-white hover:bg-red-300">
                    Connect with the store
                </a>
            </div>
        </div>
      <?php  
        }
      ?>
      
    </div>
  </section><br>
  <?php include('assets/includes/navbar.php'); ?>
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/script.js"></script>
</body>

</html>
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
    <section class="p-5">
      <h2 class="text-3xl text-center mb-10"><u><?php getStoreName(); ?></u></h2>
      <div class="container mx-auto flex flex-wrap flex-row justify-around items-center">
        <div class="mt-8">
            <div class="flex flex-col space-y-4">
                
      <?php
        $items = getCartItems();
        $total_amount = 0;
        foreach($items as $item) {
          $total_amount += ($item['product_price'] * $item['quantity']);
          $image = $item['product_image'];
      ?>
            
              <div class="flex space-x-4 bg-green-100 p-5" id="<?php echo $item['id']; ?>">
                <div class="product-image" style="background-image: url('assets/images/<?php echo $image; ?>');">
                </div>
                <div>
                  <h2 class="text-xl font-bold"><?php echo $item['product_name']; ?></h2>
                  <p class="text-sm"><?php echo $item['product_description']; ?>...</p><br>
                  <span class="text-red-600 pt-4">Price: </span> Rs. <?php echo $item['product_price']; ?><br>
                  <span class="text-red-600 pt-4">Quantity: </span> <span id="item_<?php echo $item['id']; ?>" data-quantity="<?php echo $item['quantity']; ?>"><?php echo $item['quantity']; ?></span><br>
                  <span class="text-4xl delete-item" onclick="decrementQuantity('<?php echo $item['id']; ?>')">-</span>
                  &nbsp;&nbsp;&nbsp;
                  <span class="text-3xl delete-item" onclick="incrementQuantity('<?php echo $item['id']; ?>')">+</span>
                </div>
                <div>
                  <svg xmlns="http://www.w3.org/2000/svg" onclick="deleteItem('<?php echo $item['id']; ?>')" class="w-6 h-6 delete-item" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </div>
              </div>
              
            
        <?php 
          }
        ?>
        </div>
      </div>
      </div>
      </section>
      <div><br><br><br><br><br></div>
      <!-- bottom navbar -->
      <nav class="nav">
        <a href="scan-items.php" class="text-white text-center font-bold py-2 px-4 rounded items-btn">
          Add New Item
        </a>
        <a href="#" id="rzpBtn" class="text-white text-center font-bold py-2 px-4 rounded items-btn">
          Checkout
        </a>
      </nav>
      <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/script.js"></script>
      <script>
        const rzpBtn = document.getElementById('rzpBtn');
        rzpBtn.onclick = function (e) {
          jQuery.ajax({
            type: 'post',
            url: 'payment_process.php',
            data: 'user_id=<?php echo $_SESSION["user_id"]; ?>&amount=<?php echo $total_amount; ?>&store_id=<?php echo $_SESSION["store_id"]; ?>&status=incomplete',
            success: function(result) {
              if(result == 'incomplete') {
                var options = {
                  "key": "rzp_test_ITyKYENzz5LHR2",
                  "amount": <?php echo $total_amount; ?>*100,
                  "currency": "INR",
                  "name": "Hyperstream",
                  "description": "Payment for My Cart Items",
                  "image": "https://avatars.githubusercontent.com/u/92117119?s=400&u=a8f575c411e097687c10c431d8b53280ec286464&v=4",
                  "handler": function (response) {
                    console.log(response.razorpay_payment_id);
                    jQuery.ajax({
                      type: 'post',
                      url: 'payment_process.php',
                      data: 'user_id=<?php echo $_SESSION["user_id"]; ?>&status=complete&amount=<?php echo $total_amount; ?>&payment_id='+response.razorpay_payment_id,
                      success: function(result) {
                        
                        if(result == 'complete') {
                          alert('SUCCESS: Your payment has been completed, you may now checkout with your items');
                          window.location.href = 'my-profile.php';
                        } else {
                          alert('An error occurred while making the payment, please try again!');
                        }
                      }
                    });
                  }
                };
                var razorpayModal = new Razorpay(options);
                razorpayModal.open();
              } else {
                alert('An error occurred while making the payment, please try again!')
              }
            }
          });
          e.preventDefault();
        }
      </script>
</body>
</html>
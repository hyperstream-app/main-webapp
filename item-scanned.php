<?php
require 'assets/includes/functions.php';
isAuthenticated();
if(isset($_GET['item'])) {
    addItemToCart();
}
?>
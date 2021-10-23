<?php
require 'assets/includes/functions.php';
isAuthenticated();
if(isset($_POST['item_id']) && isset($_POST['quantity'])) {
    updateQuantity($_POST['quantity'], $_POST['item_id']);
}
?>
<?php
require 'assets/includes/functions.php';
isAuthenticated();
if(isset($_POST['id'])) {
    deleteItem();
}
?>
<?php
require 'assets/includes/functions.php';
if(isset($_POST['status'])) {
    if($_POST['status'] == 'incomplete') {
        incompletePayment();
    } elseif($_POST['status'] == 'complete') {
        completePayment();
    }
}
?>
<?php
session_start();
require 'assets/includes/db.php';
require 'vendor/autoload.php';
date_default_timezone_set('Asia/Kolkata');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//check authentication
function isAuthenticated() {
    if(!isset($_SESSION['user_id'])) {
        header('location: ./');
        exit();
    }
}

//signup
function incompleteSignup() {
    global $formErrors;
    $formErrors = array();

    $name = $email = $phone = $password = null;

    if(empty($_POST['name'])) {
        array_push($formErrors, 'Name field cannot remain empty!');
    }

    if(empty($_POST['email'])) {
        array_push($formErrors, 'Email field cannot remain empty!');
    }

    if(empty($_POST['phone'])) {
        array_push($formErrors, 'Phone field cannot remain empty!');
    }

    if(empty($_POST['password'])) {
        array_push($formErrors, 'Password field cannot remain empty!');
    }

    if(substr($_POST['email'], -9) == 'gmail.com' || substr($_POST['email'], -8) == 'yahoo.co' || substr($_POST['email'], -11) == 'hotmail.com') {
        // return true;
    } else {
        array_push($formErrors, 'You cannot use temporary emails. Please use a gmail.com, yahoo.co or hotmail.com');
    }

    if(isDataExists($_POST['email'], $_POST['phone'])) {
        array_push($formErrors, 'A user with the same details already exists, please re-enter correct details!');
    }

    if(empty($formErrors)) {
        global $conn;

        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO `customers`(`name`,`email`,`phone`,`password`, `status`) VALUES(?, ?, ?, ?, '0')");
        $stmt->bind_param('ssss', $name, $email, $phone, $password);
        $stmt->execute();

        $user_id = mysqli_insert_id($conn);
        $email_verification_token = generateSignupToken($user_id);

        if($stmt) {
            require 'assets/PHPMailer/Exception.php';
            require 'assets/PHPMailer/PHPMailer.php';
            require 'assets/PHPMailer/SMTP.php';
            $mail = new PHPMailer(true);                
                                                       
            $mail->Host = '';  
            $mail->SMTPAuth = true;                               
            $mail->Username = '';                 
            $mail->Password = '';                           
            $mail->SMTPSecure = 'tls';                           
            $mail->Port = 587;           
            $mail->setFrom('', 'Account Activation | Hyperstream');
            $mail->addAddress($email);               
            $mail->isHTML(true);                                  
            $mail->Subject = 'Signup Verification';
            $mail->Body    = '<h1>Email Verification</h1><p>Please click <a href="https://jstseguru.in/hyperstream/signup.php?token='.$email_verification_token.'&id='.$user_id.'">here</a> or on the link below to verify your email:<br><a href="https://jstseguru.in/hyperstream/signup.php?token='.$email_verification_token.'&id='.$user_id.'">https://jstseguru.in/hyperstream/signup.php?token='.$email_verification_token.'&id='.$user_id.'</a></p>';
            $mail->send();
            echo "<script>alert('A verification link has been sent to you on ".$email.", please click on it to verify your email.')</script>";
        } else {
            echo "<script>alert('An error occurred, please try again!')</script>";
        }
    }
}


function completeSignup() {
    global $conn;
    $token = $_GET['token'];
    $user_id = $_GET['id'];

    $verification_token = getVerifiedToken($user_id);
    if($verification_token == false) {
        echo "<script>alert('The token is not valid, please click on the link sent to you on your email address!')</script>";
    } 
    elseif(trim($verification_token) == trim($token)) {
        $stmt = $conn->prepare("UPDATE `customers` SET `status` = '1' WHERE `id` = ?");
        $stmt->bind_param('s', $user_id);
        $stmt->execute();

        if($stmt) {
            echo "<script>alert('Your account has been successfully activated!')</script>";
            deleteToken($user_id);
            header('refresh: 0, url=./');
        } else {
            echo "<script>alert('An error occurred, please try again!')</script>";
        }
    } 
    else {
        echo "<script>alert('An error occurred, please try again!')</script>";
    }
}


function deleteToken($user_id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM `signup_token` WHERE `user_id` = ?");
    $stmt->bind_param('s', $user_id);
    $stmt->execute();
}


function getVerifiedToken($user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT `token` FROM `signup_token` WHERE `user_id` = ? LIMIT 1");
    $stmt->bind_param('s', $user_id);
    $stmt->execute();

    if($stmt) {
        $result = $stmt->get_result();
        if($result) {
            $row = $result->fetch_assoc();
            if($row) {
                return $row['token'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}


function generateSignupToken($user_id) {
    global $conn;   
    $verification_token = base64_encode(openssl_random_pseudo_bytes(30));

    $stmt = $conn->prepare("INSERT INTO `signup_token`(`user_id`, `token`) VALUES(?, ?)");
    $stmt->bind_param('ss', $user_id, $verification_token);
    $stmt->execute();

    if($stmt) {
        return $verification_token;
    } else {
        return false;
    }
}


function isDataExists($email, $phone) {
    global $conn;
    $stmt = $conn->prepare("SELECT `id` FROM `customers` WHERE `email` = ? OR `phone` = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $phone);
    $stmt->execute();

    if($stmt) {
        $stmt->store_result();
        if($stmt->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}



//login
function userLogin() {
    global $formErrors;
    $formErrors = array();
    $email = $password = null;

    if(empty($_POST['email'])) {
        array_push($formErrors, 'Email field cannot remain empty!');
    }

    if(empty($_POST['password'])) {
        array_push($formErrors, 'Password field cannot remain empty!');
    }

    if(empty($formErrors)) {
        global $conn;

        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT `id`, `password` FROM `customers` WHERE `email` = ? AND `status` = '1' LIMIT 1");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        if($stmt) {
            $result = $stmt->get_result();
            if($result) {
                $row = $result->fetch_assoc();
                if($row) {
                    $hashed_password = $row['password'];
                    if(password_verify($password, $hashed_password)) {
                        $_SESSION['user_id'] = $row['id'];
                        header('location: ./dashboard');
                        exit();
                    } else {
                        array_push($formErrors, 'Please enter valid login credentials!');
                    }
                } else {
                    array_push($formErrors, 'Please enter valid login credentials!');
                }
            } else {
                array_push($formErrors, 'Please enter valid login credentials!');
            }
        } else {
            array_push($formErrors, 'An error occurred, please try again!');
        }
    }
}


//get all stores
function getAllStores() {
    global $conn;
    $rows = array();
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT store.id, store.store_name, store.store_address, store.store_image FROM `store` JOIN `connections` ON connections.store_id = store.id WHERE connections.user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    if($stmt) {
        $result = $stmt->get_result();
        if($result) {
            while($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
            return $rows;
        }
    }
}


//get a store name
function getStoreName() {
    global $conn;
    
    $stmt = $conn->prepare("SELECT `store_name` FROM `store` WHERE `id` = ? LIMIT 1");
    $stmt->bind_param('s', $_SESSION['store_id']);
    $stmt->execute();

    if($stmt) {
        $result = $stmt->get_result();
        if($result) {
            $row = $result->fetch_assoc();
            if($row) {
                echo $row['store_name'];
            }
        }
    }
}


//connect to a store
function connectToStore() {
    global $conn;
    if(isset($_GET['id'])) {
        $store_id = $_GET['id'];
        disconnectOtherStores();
        if(updateConnections($_SESSION['user_id'], $store_id)) {
            $_SESSION['store_id'] = $store_id;
            header('location: ./my-cart-items.php');
            exit();
        } else {
            echo '<script>An error occurred while connecting to the shop</script>';
            header('refresh:0, url=dashboard');
            exit();
        }
    } else {
        $auth_id = $_POST['auth_id'];

        $stmt = $conn->prepare("SELECT `id` FROM `store` WHERE `auth_id` = ? LIMIT 1");
        $stmt->bind_param('s', $auth_id);
        $stmt->execute();


        if($stmt) {
            $result = $stmt->get_result();
            if($result) {
                $row = $result->fetch_assoc();
                if($row) {
                    disconnectOtherStores();
                    if(checkConnections($_SESSION['user_id'], $row['id']) == true) {
                        updateConnections($_SESSION['user_id'], $row['id']);
                        $_SESSION['store_id'] = $row['id'];
                        echo 'connected';
                    } else {
                        establishConnection($_SESSION['user_id'], $row['id']);
                        $_SESSION['store_id'] = $row['id'];
                        echo 'connected';
                    }
                } else {
                    echo 'error';
                }
            } else {
                echo 'error';
            }
        } else {
            echo 'error';
        }
    }
}

//update connections when using QR code
function updateConnections($user_id, $store_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE `connections` SET `status` = 'connected' WHERE `user_id` = ? AND `store_id` = ?");
    $stmt->bind_param('ii', $user_id, $store_id);
    $stmt->execute();
    
    if($stmt) {
        return true;
    }
    
    return false;
}


//check connections
function checkConnections($user_id, $store_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT `id` FROM `connections` WHERE `user_id` = ? AND `store_id` = ?");
    $stmt->bind_param('ii', $user_id, $store_id);
    $stmt->execute();
    
    if($stmt) {
        $stmt->store_result();
        if($stmt->num_rows() > 0) {
            return true;
        }
    }
}


//establish connection
function establishConnection($user_id, $store_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `connections`(`user_id`, `store_id`, `status`) VALUES(?, ?, 'connected')");
    $stmt->bind_param('ii', $user_id, $store_id);
    $stmt->execute();
}


//disconnect all stores when connecting to a new one
function disconnectOtherStores() {
    global $conn;

    $stmt = $conn->prepare("UPDATE `connections` SET `status` = 'not_connected' WHERE `user_id` = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
}

//show cart items
function getCartItems() {
    global $conn;
    $rows = array(); 

    $stmt = $conn->prepare("SELECT items.id, items.quantity, products.product_name, products.product_image, products.product_description, products.product_price FROM `items` JOIN `products` ON items.item_id = products.product_id WHERE items.user_id = ? ORDER BY items.id DESC");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();

    if($stmt) {
        $result = $stmt->get_result();
        if($result) {
            while($row = $result->fetch_assoc()) {
                array_push($rows, $row);
            }
            return $rows;
        }
    }
}

//add item to cart
function addItemToCart() {
    global $conn;
    $item_code = $_GET['item'];
    $user_id = $_SESSION['user_id'];
    $store_id = $_SESSION['store_id'];

    $item_id = getItemIdFromCode($item_code);
    $stmt = $conn->prepare("INSERT INTO `items`(`user_id`, `item_id`, `quantity`, `status`) VALUES(?, ?, '1', 'in_cart')");
    $stmt->bind_param('is', $user_id, $item_code);
    $stmt->execute();

    if($stmt) {
        echo 'success';
    } else {
        echo 'failed';
    }
}

//get item id from barcode
function getItemIdFromCode($item_code) {
    global $conn;

    $stmt = $conn->prepare("SELECT `id` FROM `products` WHERE `product_id` = ? LIMIT 1");
    $stmt->bind_param('s', $item_code);
    $stmt->execute();

    if($stmt) {
        $result = $stmt->get_result();
        if($result) {
            $row = $result->fetch_assoc();
            if($row) {
                return $row['id'];
            }
            
        }
    }
}

//update item quantity
function updateQuantity($quantity, $item_id) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("UPDATE `items` SET `quantity` = ? WHERE `id` = ? AND `user_id` = ?");
    $stmt->bind_param('isi', $quantity, $item_id, $user_id);
    $stmt->execute();
}


function deleteItem() {
    global $conn;
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM `items` WHERE `user_id` = ? AND `id` = ?");
    $stmt->bind_param('ii', $_SESSION['user_id'], $id);
    $stmt->execute();

}


function incompletePayment() {
    global $conn;
    $user_id = $_POST['user_id'];
    $store_id = $_POST['store_id'];
    $amount = $_POST['amount'];
    $date = date('Y-m-d h:i:s');

    $stmt = $conn->prepare("INSERT INTO `payments`(`user_id`, `store_id`, `amount`, `status`, `added_on`) VALUES(?, ?, ?, 'incomplete', ?)");
    $stmt->bind_param('ssss', $user_id, $store_id, $amount, $date);
    $stmt->execute();

    if($stmt) {
        echo 'incomplete';
    } else {
        echo 'error';
    }
}


function completePayment() {
    global $conn;
    $user_id = $_POST['user_id'];
    $payment_id = $_POST['payment_id'];
    $date = date('d M Y h:i:s a');

    $stmt = $conn->prepare("UPDATE `payments` SET `status` = 'completed', `payment_id` = ? WHERE `user_id` = ?");
    $stmt->bind_param('ss', $payment_id, $user_id);
    $stmt->execute();



    if($stmt) {
        //user details
        $fullUserDetails = fullUserDetail();
        foreach($fullUserDetails as $fullUserDetail) {
            $name = $fullUserDetail['name'];
            $email = $fullUserDetail['email'];
            $phone = $fullUserDetail['phone'];
            $amount = $fullUserDetail['amount'];
            $payment_id = $fullUserDetail['payment_id'];
            $store_name = $fullUserDetail['store_name'];
        }

        //cart items
        $fullCartItems = getCartItems();
        $orders = "";
        foreach($fullCartItems as $fullCartItem) {
            $product_name = $fullCartItem['product_name'];
            $price = $fullCartItem['product_price'];
            $quantity = $fullCartItem['quantity'];
            $total_product_price = $price * $quantity;
            $image = $fullCartItem['product_image'];
            $orders .= "<tr><td colspan='2' style='padding:0px 15px;'><p style='font-size:14px;margin:0;padding:10px;border:solid 1px #ddd;font-weight:bold;display: flex;'><img src='assets/images/$image' height='100' style='margin-right: 20px;' /><span style='display:block;font-size:15px;font-weight:normal;'>$product_name <br><b>Rs. $price x  $quantity</b><br><br>Total: Rs. $total_product_price</span></p></td></tr>";
        }
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML("<html><body style='background-color:#e2e1e0;font-family: Open Sans, sans-serif;font-size:100%;font-weight:400;line-height:1.4;color:#000;width:100%'><table style='max-width:670px;margin:50px auto 10px;background-color:#fff;padding:50px;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);-moz-box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24);box-shadow:0 1px 3px rgba(0,0,0,.12),0 1px 2px rgba(0,0,0,.24); border-top: solid 10px green;'><thead><tr><th style='text-align:left;'><img style='max-width: 75px;' src='https://avatars.githubusercontent.com/u/92117119?s=400&u=a8f575c411e097687c10c431d8b53280ec286464&v=4' alt='corstech'></th><th style='text-align:right;font-weight:400;'>$date</th></tr></thead><tbody> <tr> <td style='height:35px;'></td> </tr> <tr><td colspan='2' style='border: solid 1px #ddd; padding:10px 20px;'><p style='font-size:14px;margin:0 0 6px 0;'><span style='font-weight:bold;display:inline-block;min-width:150px'>Transaction status</span>&nbsp; <b style='color:green;font-weight:normal;margin:0'>Success</b></p><p style='font-size:14px;margin:0 0 6px 0;'><span style='font-weight:bold;display:inline-block;min-width:146px'>Transaction ID</span>&nbsp;$payment_id</p><p style='font-size:14px;margin:0 0 0 0;'><spanstyle='font-weight:bold;display:inline-block;min-width:146px'><b>Transaction Amount</b></span>&nbsp; Rs. $amount.00</p></td></tr><tr><td style='height:35px;'></td></tr><tr><td style='width:50%;padding:20px;vertical-align:top'><p style='margin:0 0 10px 0;padding:0;font-size:14px;'><spanstyle='display:block;font-weight:bold;font-size:13px'><b>Name</b></span> $name</p><p style='margin:0 0 10px 0;padding:0;font-size:14px;'><spanstyle='display:block;font-weight:bold;font-size:13px;'><b>Email</b></span> $email</p><p style='margin:0 0 10px 0;padding:0;font-size:14px;'><spanstyle='display:block;font-weight:bold;font-size:13px;'><b>Phone</b></span> $phone</p></td><td style='width:50%;padding:20px;vertical-align:top'><p style='margin:0 0 10px 0;padding:0;font-size:14px;'><spanstyle='display:block;font-weight:bold;font-size:13px;'><b>Store Name</b></span> $store_name</p></td></tr><tr><td colspan='2' style='font-size:20px;padding:30px 15px 0 15px;'>Orders</td></tr>$orders</tbody><tfooter><tr><td colspan='2' style='font-size:14px;padding:50px 15px 0 15px;'><strong style='display:block;margin:0 0 10px 0;'>Regards</strong> Hyperstream<br> Kaifi Azmi Marg, KD Colony, Sector 12, Rama Krishna Puram, New Delhi, Delhi 110022<br><br><b>Phone:</b> +91-9811672146<br><b>Email:</b> support@hyperstream.com</td></tr></tfooter></table></body></html>");
        $filepath = 'assets/invoices/'.$payment_id.'.pdf';
        $mpdf->Output($filepath, 'F');
        echo 'complete';
        deleteAllCartItems();
    } else {
        echo 'error';
    }
}


function fullUserDetail() {
    global $conn;
    $rows = array();

    $stmt = $conn->prepare("SELECT customers.name, customers.email, customers.phone, payments.amount, payments.payment_id, store.store_name FROM customers JOIN payments ON customers.id = payments.user_id JOIN store ON payments.store_id = store.id WHERE customers.id = ? LIMIT 1");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();

    if($stmt) {
        $result = $stmt->get_result();
        if($result) {
            $row = $result->fetch_assoc();
            if($row) {
                array_push($rows, $row);
            }
            return $rows;
        }
    }
}


function deleteAllCartItems() {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM `items` WHERE `user_id` = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();

}
?>
var path = window.location.href;
$("nav a.nav-link").each(function () {
    if (this.href === path) {
        $(this).addClass("active");
    }
});

let scanner = new Instascan.Scanner({ video: document.getElementById('video') });
scanner.addListener('scan', function (auth_id) {
    jQuery.ajax({
        url: 'authenticate-store-qr',
        type: 'post',
        data: 'auth_id=' + auth_id,
        success: function (result) {
            if (result.trim() == 'connected') {
                window.location.href = 'my-cart-items';
            } else {
                alert('This QR Code is not valid. Either the store is not verified on our platform or the QR Code is malfunctioning');
            }
        }
    })
});
Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        scanner.start(cameras[1]);
    } else {
        console.error('No cameras found.');
    }
}).catch(function (e) {
    console.error(e);
});

// alert("𝗣𝗹𝗲𝗮𝘀𝗲 𝗰𝗼𝗻𝗳𝗶𝗿𝗺 𝘆𝗼𝘂𝗿 𝗼𝗿𝗱𝗲𝗿");
function incrementQuantity(item_id) {
    //get item
    var item = document.getElementById('item_' + item_id);
    //get current quantity
    var current_quantity = item.getAttribute('data-quantity');
    //if items exceed 10 
    if (current_quantity >= 10) {
        alert('Quantity cannot exceed 10');
    } else {
        //increment quantity by 1
        current_quantity++;
        //handle increment accordingly
        item.setAttribute('data-quantity', current_quantity);
        item.innerHTML = current_quantity;
        jQuery.ajax({
            type: 'post',
            url: 'item-quantity',
            data: 'quantity=' + current_quantity + '&item_id=' + item_id,
            success: function (result) { }
        });
    }
}

function decrementQuantity(item_id) {
    //get item
    var item = document.getElementById('item_' + item_id);
    //get current quantity
    var current_quantity = item.getAttribute('data-quantity');
    //if items less than 1
    if (current_quantity <= 1) {
        alert('Items cannot be less than 1 unit. If you don\'t want this item anymore, you can remove it from the cart using the delete option')
    } else {
        //decrement quantity by 1
        current_quantity--;
        //handle increment accordingly
        item.setAttribute('data-quantity', current_quantity);
        item.innerHTML = current_quantity;
        jQuery.ajax({
            type: 'post',
            url: 'item-quantity',
            data: 'quantity=' + current_quantity + '&item_id=' + item_id,
            success: function (result) { }
        });
    }
}

function deleteItem(id) {
    var item = document.getElementById(id);
    item.style.display = 'none';
    jQuery.ajax({
        type: 'post',
        url: 'delete-item',
        data: 'id=' + id,
        success: function (result) { }
    });
}


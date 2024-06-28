const navOrderButton = document.getElementById('nav-order');
const orderLink = navOrderButton.querySelector('a');
const pickupButton = document.getElementById('pickupButton');

//Event Change href for a tag order menu item
orderLink.addEventListener('click', function(event) {
    event.preventDefault();
    var pickup = localStorage.getItem('pickup');
    if (pickup === '1') {
        orderLink.href = '/order';
    } 
    else {
        orderLink.href = '#order-popup-nav';}
        window.location.href = orderLink.href;
    }
);

//Event click select pick on pop up
document.getElementById('pickupButton').addEventListener('click', function() {
    var pickup = 1;
    var method = 'pickup';
    var ConfirmMethod = '';

    if (localStorage.getItem('pickup') === '1') {
        ConfirmMethod = 'pickup';
        var acheckLink = document.getElementById('acheck');
        acheckLink.click();

    } else {
        window.location.href = '/order';
    }

    localStorage.setItem('pickup', pickup);
    localStorage.setItem('ConfirmMethod', ConfirmMethod);
    localStorage.setItem('method', method);
});


//Event click view map on pop up
document.addEventListener('DOMContentLoaded', function() {
    var items = document.querySelectorAll('.items-infor-pickup-content');

    items.forEach(function(item) {
        item.addEventListener('click', function() {
            items.forEach(function(el) {
                el.classList.remove('active');
            });

            item.classList.add('active');

            var linkmapElement = item.querySelector('.linkmap');
            if (linkmapElement) {
                var linkmapText = linkmapElement.textContent || linkmapElement.innerText;

                var viewmapElement = document.getElementById('viewmap');
                if (viewmapElement) {
                    viewmapElement.setAttribute('href', linkmapText);
                }
            }

            var idtoreElement = item.querySelector('.idstore');
            var idtoreText = idtoreElement ? (idtoreElement.textContent || idtoreElement.innerText) : '';

            localStorage.setItem('ID_Store', idtoreText);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var storePickupText = document.getElementById('store-pickup').textContent.trim().replace('Store: ', '');
    var addressPickupText = document.getElementById('address-pickup').textContent.trim().replace('Address: ', '');

    localStorage.setItem('pickup_store', storePickupText);
    localStorage.setItem('pickup_address', addressPickupText);
});

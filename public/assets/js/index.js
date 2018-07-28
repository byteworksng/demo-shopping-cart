const API_URL = window.location.origin;


$(document).ready(function () {
    // load pace page loader indicator


    slideUpProduct('product');

    fetchWallet();

    getCartItemCount();

    $("#exampleModalCenter").on('shown.bs.modal', function () {
        $("#input-id").rating({
            'min': 1,
            'max': 5,
            'theme': 'krajee-fa',
            'showCaption': false,
            'showClear': false
        });
    });


});

/*
 * for slide up the product display on hover
 *
 */
function slideUpProduct(cat) {
    $('.' + cat).each(function (vl, val) {
        $(val).mouseover(function () {
            $(this).css('background-position', '0 -70px').css('transition', 'all 0.5s ease-in').css('-webkit-transition', 'all 0.5s ease-in').css('-moz-transition', 'all 0.5s ease-in').css('-o-transition', 'all 0.5s ease-in').css('-ms-transition', 'all 0.5s ease-in');
            $(val.firstElementChild).css('margin-top', '180px').css('transition', 'all 0.5s ease-in').css('-webkit-transition', 'all 0.5s ease-in').css('-moz-transition', 'all 0.5s ease-in').css('-o-transition', 'all 0.5s ease-in').css('-ms-transition', 'all 0.5s ease-in');
        });
        $(this).mouseout(function () {
            $(this).css('background-position', '0 0').css('transition', 'all 0.5s ease-in').css('-webkit-transition', 'all 0.5s ease-in').css('-moz-transition', 'all 0.5s ease-in').css('-o-transition', 'all 0.5s ease-in').css('-ms-transition', 'all 0.5s ease-in');
            $(val.firstElementChild).css('margin-top', '250px').css('transition', 'all 0.5s ease-in').css('-webkit-transition', 'all 0.5s ease-in').css('-moz-transition', 'all 0.5s ease-in').css('-o-transition', 'all 0.5s ease-in').css('-ms-transition', 'all 0.5s ease-in');
        });
    });
}


/*
 * Retrieve current wallet amount
 *
 */
function fetchWallet() {
    let url = API_URL + '/wallet';
    $.get(url, function (res) {
        $('#wallet').text(JSON.parse(res).cash);
    })
}


/*
 * Add an item to cart
 *
 */
function addToCart(product) {
    let url = API_URL + "/order/cart";

    // set default quantity;
    product.qty = 1;
    product.total = product.price;


    // send to server
    $.post(url, JSON.stringify(product), function () {
        let cartCounterElement = $('#cart-count');
        let currentItemsCount = +cartCounterElement.text();
        let newItemCount = currentItemsCount + 1;
        cartCounterElement.text(newItemCount);
    });


}


/*
 * Retrieve no of items in current cart
 *
 */
function getCartItemCount() {
    let url = API_URL + '/order/cart/count';

    $.get(url, function (res) {
        if (res) {
            $('#cart-count').text(res);
        } else {
            $('#cart-count').text(0);
        }
    });

}


/*
 * Line item total ( qty x price)
 *
 */
function sumLineTotal(event, cartId) {
    let qty = event.target.value;
    let index = $(event.target).data('qty-index');
    let table = $('table');

    if (qty) {
        let priceSelector = '[data-price-index="' + index + '"]';
        let totalSelector = '[data-total-index="' + index + '"]';
        // let totalInputSelector = '[data-total-input-index="' + index + '"]';
        let price = $(priceSelector).text();
        let total = (price * qty).toFixed(2);
        $(totalSelector).text(total);

        let data = table.data('table-data').map(function (val) {
            if (val.cartId === cartId) {
                val.qty = +qty;
                val.total = total;
            }
            return val;
        });
        table.data('table-data', data);
        // $(totalInputSelector).val(total);
        calculateTotals();

    }

}


/*
 * update gross and subtotal amounts.
 *
 */
function calculateTotals() {

    let subtotal = calculateSubtotal();
    let shipping = $("#shipping").text();

    calculateGross(subtotal, shipping);
}


/*
 * update subtotal amount
 *
 */
function calculateSubtotal() {
    let subtotal = 0;
    $('[data-total-index]').each(function (idx, el) {
        subtotal += +($(el).text());
    });

    let subTo2Dec = subtotal.toFixed(2);
    $("#sub-total").text(subTo2Dec);
    $("[data-sub-total]").val(subTo2Dec);
    return subTo2Dec;
}


/*
 * update gross amount
 *
 */
function calculateGross(subtotal, shipping) {
    let gross = (+(+shipping + +subtotal)).toFixed(2);
    $("#gross-total").text(gross);
    $("[data-gross-total]").val(gross);
}


/*
 * Calculate shipping cost
 *
 */
function addShipping(event) {
    let cost = (+(event.target.value)).toFixed(2);
    $('#shipping').text(cost);
    $("[data-shipping]").val(cost);
    calculateTotals();
}


/*
 * Move order forward
 *
 */
function checkOut(event) {
    event.preventDefault();
    let requiredField = $('#shipping').text();
    let table = $('table');


    if (requiredField === undefined || requiredField === null || requiredField === '') {
        alert("Please choose a shipping method to proceed");
        return false;
    }
    let cart = table.data('table-data');
    let order = {
        subTotal: $('#sub-total').text(),
        shipping: $('#shipping').text(),
        gross: $('#gross-total').text(),
        ref: $('[data-ref]').val(),
    };

    let formData = {cart: cart, order: order};


    let url = API_URL + '/order/checkout';

    $.post(url, formData, function (res) {
        window.location.href = API_URL + "/order/review/" + res;
    });

}


/*
 * Confirm payment for order
 *
 */
function pay(ref) {
    let url = API_URL + '/order/pay';
    let data = {ref: ref};

    $.post(url, data).done(function (res) {

        if (res) {
            window.location.href = API_URL + '/order/receipt';
        } else {
            alert("insufficient funds in wallet");
        }


    })
}


/*
 * remove item from cart
 *
 */
function removeItem(event, param, index) {
    event.preventDefault();
    let params = JSON.parse(param);
    let table = $('table');


    let url = API_URL + '/cart/remove/' + params.cartId;
    let cartItemSelector = '[data-cart-id="' + params.cartId + '"]';

    $.ajax({
        method: "DELETE",
        url: url,
        success: function () {
            $(cartItemSelector).remove();

            let data = table.data('table-data');
            data.splice(index, 1);
            table.data('table-data', data);

            calculateTotals();
        },
    });
}


// product page

function rateProduct(event) {
    event.preventDefault();
    let rating = $('#input-id').val();
    let productId = $('#input-id').data('product-id');
    let data = {
        rating: rating,
        product: productId
    };

    let url = API_URL + '/product/rating';
    $.post(url, data, function (res) {
        closeRatingWindow();
        if (res){
            updateProductRatingAvg(productId);
        }else{
            setTimeout(()=>{
                alert("Oops! No more ratings allowed for this product. ");
            }, 450)

        }

    })

}


function openRatingWindow(event, id) {
    $("#exampleModalCenter").modal('show');
    $('#input-id').data('product-id', id);
}


function closeRatingWindow() {
    $('#input-id').rating('clear');
    $('#input-id').rating('reset');
    $("#exampleModalCenter").modal('hide');
}


function updateProductRatingAvg(productId) {
    let url = API_URL + '/product/rating/' + productId;
    $.get(url, function (res) {
        ratingId = '#rating-view-' + productId;
        ratingDisplayId = '#rating-view-display-' + productId;
        $(ratingId).rating('update', +res);
        $(ratingDisplayId).text(+res);
    });
}



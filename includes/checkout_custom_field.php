<?php
//Add input pickup on Checkout Page
add_action('woocommerce_checkout_order_review', 'add_pickup_location_field');

function add_pickup_location_field($checkout) {
    global $wpdb;

    $stores = $wpdb->get_results("SELECT * FROM fcs_data_store_available");

    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var storeId = localStorage.getItem('ID_Store');
            var pickupLocationName = document.getElementById('store-pickup');
            var pickupLocationAddress = document.getElementById('address-pickup');

            if (storeId) {
                var stores = <?php echo json_encode($stores); ?>;
                
                stores.forEach(function(store) {
                    if (store.id == storeId) {
                        pickupLocationName.textContent = 'Store: ' + store.name_store;
                        pickupLocationAddress.textContent = 'Address: ' + store.location_store ;
                    }
                });
            }
        });   
    </script>
    <?php
    
    echo '<div class="pickup_location_field"><h4>Store Pickup</h4>';
    echo '<p id="store-pickup"></p>';
    echo '<p id="address-pickup"></p>';
    echo '</div>';
}

//Save input pickup field in Checkout Page
add_action('woocommerce_checkout_update_order_meta', 'save_pickup_location_field');

function save_pickup_location_field($order_id) {
    if (!empty($_POST['pickup_location'])) {
        update_post_meta($order_id, '_pickup_location', );
    }
}

//Display input pickup on Order Details (Admin)
add_action('woocommerce_admin_order_data_after_billing_address', 'display_pickup_location_in_admin_order', 10, 1);

function display_pickup_location_in_admin_order($order) {
    $pickup_location = get_post_meta($order->get_id(), '_pickup_location', true);
    if ($pickup_location) {
        echo '<p><strong>' . __('Pickup Location') . ':</strong> ' . $pickup_location . '</p>';
    }
}

// Hiển thị thông tin cửa hàng trong chi tiết đơn hàng
add_action('woocommerce_admin_order_data_after_billing_address', 'display_pickup_location_in_order_details', 10, 1);

function display_pickup_location_in_order_details($order) {
    $pickup_store = get_post_meta($order->get_id(), '_pickup_store', true);
    $pickup_address = get_post_meta($order->get_id(), '_pickup_address', true);

    if (!empty($pickup_store)) {
        echo '<h2>Pickup Location:</h2>';
        echo '<p><strong>Store:</strong> ' . esc_html($pickup_store) . '</p>';
    }

    if (!empty($pickup_address)) {
        echo '<p><strong>Address:</strong> ' . esc_html($pickup_address) . '</p>';
    }
}

//Display input pickup on Email
add_filter('woocommerce_email_order_meta_keys', 'add_pickup_location_to_email');

function add_pickup_location_to_email($keys) {
    $keys[] = '_pickup_location';
    return $keys;
}


add_filter('woocommerce_checkout_fields', 'custom_remove_woo_checkout_fields');

function custom_remove_woo_checkout_fields($fields)
{

  unset($fields['billing']['billing_company']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_city']);
  unset($fields['billing']['billing_postcode']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);

  unset($fields['shipping']['shipping_last_name']);
  unset($fields['shipping']['shipping_company']);
  unset($fields['shipping']['shipping_address_1']);
  unset($fields['shipping']['shipping_address_2']);
  unset($fields['shipping']['shipping_city']);
  unset($fields['shipping']['shipping_postcode']);
  unset($fields['shipping']['shipping_country']);
  unset($fields['shipping']['shipping_state']);


  return $fields;
}
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


 
/*  
add_filter( 'woocommerce_add_cart_item_data', function ( $cartItemData, $productId, $variationId ) {
    $cartItemData['myCustomData'] = 'someCustomValue';
	$bookingtime = $cartItemData['booking']['_start_date'];
	$bookingdate = date_i18n('Y-m-d' , $bookingtime );
    $cartItemData['myCustomData2'] = $bookingdate;

    return $cartItemData;
}, 10, 3 ); 
*/

add_filter( 'woocommerce_get_cart_item_from_session', function ( $cartItemData, $cartItemSessionData, $cartItemKey ) {
    if ( isset( $cartItemSessionData['booking']['_start_date'] ) ) {
		$booking_date = $cartItemSessionData['booking']['_start_date'];
		$bookingdate = date_i18n('Y-m-d' , $booking_date );
		switch ($bookingdate) {
			// All the dates for Almere
			case "2016-04-30":
			case "2016-06-10":
			case "2016-07-23":
			case "2016-09-03":
			case "2016-10-15":
			case "2016-11-26":
			case "2017-01-07":
				$cartItemData['bookingLocation'] = "Almere</br><strong>Irma Hulscher PMU Specialisten</strong></br>Operetteweg 31, 1323 VK Almere-Stad</br>Tel.: 036-53.611.64";
				break;
			// All the dates for Amsterdam
			case "2016-07-30":
			case "2016-08-07":
			case "2016-10-29":
				$cartItemData['bookingLocation'] = "Amsterdam";
				break;
			// All the dates for Cambridge
			case "2016-05-24":
			case "2016-07-06":
			case "2016-08-15":
			case "2016-10-04":
			case "2016-11-15":
				$cartItemData['bookingLocation'] = "Cambridge";
				break;
			// All the dates for London
			case "2016-05-25":
			case "2016-07-07":
			case "2016-07-08":
			case "2016-08-17":
			case "2016-10-05":
			case "2016-11-16":
			case "2016-12-21":
				$cartItemData['bookingLocation'] = "Londen</br><strong>The Salon Baker St</strong></br>9 Melcombe St, London NW1 6AE (Opposite Baker St station)";
				break;
			// All the dates for Manchester
			case "2016-07-09":
			case "2016-07-10":
				$cartItemData['bookingLocation'] = "Manchester";
				break;
}
		
        
    }

    return $cartItemData;
}, 10, 3 );
add_filter( 'woocommerce_get_item_data', function ( $data, $cartItem ) {
    if ( isset($cartItem['bookingLocation'] ) ) {
		$data[] = array(
            'name' => 'Location',
            'value' => $cartItem['bookingLocation']
        );
    }

    return $data;
}, 10, 2 );
add_action( 'woocommerce_add_order_item_meta', function ( $itemId, $values, $key ) {
    if ( isset( $values['bookingLocation'] ) ) {
        wc_add_order_item_meta( $itemId, 'bookingLocation', $values['bookingLocation'] );
    }
}, 10, 3 );
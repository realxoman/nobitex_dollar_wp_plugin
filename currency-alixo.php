<?php

/*
Plugin Name: ارز های دیجیتال ساخته علی اسماعیلی
Plugin URI: https://aliesm.com
Description: این پلاگین برای دریافت قیمت لحظه‌ای دلار از نوبیتکس تهیه شده است.
Version: 1.0.0
Author: علی اسماعیلی
Author URI: https://aliesm.com
WC requires at least: 3.6.0
WC tested up to: 4.6.1
*/


/*
 * ShortCodes For Use in All Over the Template
 * 
 * USD : [androdollar]
 * Pond : [andropond]
 * Euro : [androeuro]
 * 
 * */


/* متغیر های دلار */

$dollar_percent = 0.975; /* درصدی که باید در دلار ضرب شود */
$dollar_minus = 300; /* عددی  که باید از دلار کم شود */


/* متغیر های پوند */

$pond_percent = 1.385; /* درصدی که باید در پوند ضرب شود */
$pond_minus = 500; /* عددی  که باید از پوند کم شود */

/* متغیر های یورو */

$euro_percent = 1.185; /* درصدی که باید در یورو ضرب شود */
$euro_minus = 400; /* عددی  که باید از یورو کم شود */



/* 
 * $var='' در بخش ای پی آی نوع مورد نظرتان را وارد کنید
 * $to='' انتخاب کنید که ارز به دلار تبدیل بشه یا به ریا ل rls (rial) usdt(dollar)
 *  */

function Coin($coin,$to='rls',$var='dayLow') {

    $data = array(
        'srcCurrency' => $coin,
        "dstCurrency" => $to
    );
    $cointo=$coin."-".$to;
    $url = 'https://api.nobitex.ir/market/stats';
    $ch = curl_init($url);
    $postString = http_build_query($data, '', '&');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($response,true);
    return round($obj['stats'][$cointo][$var],3);
    }

/* 
 * تابع
 * Coin 
 * را صدا میزنیم و نام ارز مورد نظرمان را داخل دو سینگل کوتیشن قرار میدهیم. 
 *  *  */   

        $pattern = Coin('usdt');
        $pattern2 = substr($pattern, 0, -1);
/* بخش دلاری */
	$dollar = $pattern2 * $dollar_percent;

			
    function andro_dollar() {
        global $pattern, $pattern2,$dollar,$dollar_minus;
		$dollar_return = $dollar-$dollar_minus;
		$dollar_return = number_format($dollar_return , 0 , ' ' ,',');
        return $dollar_return;
    }

/* بخش پوند */

	$pond = $dollar * $pond_percent;

			
    function andro_pond() {
        global $pattern, $pattern2,$pond,$pond_minus;
		$pond_return = $pond-$pond_minus;
		$pond_return = number_format($pond_return , 0 , ' ' ,',');
        return $pond_return;
    }

/* بخش یورو */

	$euro = $dollar * $euro_percent;

    function andro_euro() {
        global $pattern, $pattern2,$euro,$euro_minus;
		$euro_return = $euro-$euro_minus;
		$euro_return = number_format($euro_return , 0 , ' ' ,',');
        return $euro_return;
    }
			

    add_shortcode( 'androdollar', 'andro_dollar' );
    add_shortcode( 'andropond', 'andro_pond' );
    add_shortcode( 'androeuro', 'andro_euro' );
<?php
// Trả về data cho VNPAY
// https://sandbox.vnpayment.vn/apis/docs/faqs/
ob_start();
include 'lib/session.php';
Session::init();
include 'lib/database.php';
spl_autoload_register(function ($class) {
    include_once "classes/" . $class . ".php";
});
$ct = new cart();

header('Content-type: application/json');

require './lib/VNPay.php';

$amount = $ct->getTotalPrice();
if ($_GET['vnp_Amount'] != $amount) {
    echo json_encode([
        'RspCode' => '04',
        'Message' => 'invalid amount'
    ]);
    return;
}
$cartId = $_GET['vnp_TxnRef'];
$cart = $ct->check_cart();
if (! $cart || empty($dataCart = $cart->fetch_assoc()) || $dataCart['cartId'] != $cartId) {
    echo json_encode([
        'RspCode' => '01',
        'Message' => 'Order not found'
    ]);
    return;
}

if ($_GET['vnp_ResponseCode'] != '00') {
  //  lý khi giao dịch thất bại. Hiện tại không làm gì cả
    echo json_encode([]);
    return;
}

// Trường hợp sử dụng production thì dùng VNPay::production();
$vnpay = VNPay::make(VNP_SECRET, VNP_TMN_CODE);
$createDate = new datetime();
$data = $vnpay->checkTx($_GET);
if ($data['RspCode'] == '00') {
    // Xử lý cập nhât trạng thái đơn hàng
    // đảm bảo url được gọi từ vnpay
    if (isset($_SERVER['HTTP_REFERER'])&&str_starts_with($_SERVER['HTTP_REFERER'], $vnpay->getHost())) {
        $ct->purchaseSuccessful();
    }
}

echo json_encode($data);

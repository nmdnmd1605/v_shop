<?php
// Hiển thị kết quả giao dịch
// https://sandbox.vnpayment.vn/apis/docs/faqs/
ob_start();
include 'lib/session.php';
Session::init();
include 'lib/database.php';
spl_autoload_register(function ($class) {
    include_once "classes/" . $class . ".php";
});
$ct = new cart();

require './lib/VNPay.php';

$amount = $ct->getTotalPrice();
$cartId = $_GET['vnp_TxnRef'];
$cart = $ct->check_cart();

if (!$cart || empty($dataCart = $cart->fetch_assoc()) || $dataCart['cartId'] != $cartId) {
    $_SESSION['message'] = 'Giao dịch không thành công do: Không tìm thấy giỏ hàng';
    header('Location: tx-cancel.php');
    return;
}

if ($_GET['vnp_ResponseCode'] != '00') {
    //  lý khi giao dịch thất bại. Hiện tại không làm gì cả
    $_SESSION['message'] = match ($_GET['vnp_ResponseCode']) {
        '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
        '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
        '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
        '11' => 'Giao dịch không thành công do: Đã hết hạn chờ thanh toán. Xin quý khách vui lòng thực hiện lại giao dịch.',
        '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
        '13' => 'Giao dịch không thành công do Quý khách nhập sai mật khẩu xác thực giao dịch (OTP). Xin quý khách vui lòng thực hiện lại giao dịch.',
        '24' => 'Giao dịch không thành công do: Khách hàng hủy giao dịch',
        '51' => 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
        '65' => 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
        '75' => 'Ngân hàng thanh toán đang bảo trì.',
        '79' => 'Giao dịch không thành công do: KH nhập sai mật khẩu thanh toán quá số lần quy định. Xin quý khách vui lòng thực hiện lại giao dịch',
        default => 'Giao dịch không thành công do: Giao dịch thất bại'
    };
    header('Location: tx-cancel.php');
    return;
}

// Trường hợp sử dụng production thì dùng VNPay::production();
$vnpay = VNPay::make(VNP_SECRET, VNP_TMN_CODE);
$createDate = new datetime();
$data = $vnpay->checkTx($_GET);
if ($data['RspCode'] == '00') {
    // trường hợp trên localhost hoặc dùng http VNPAY không thể gọi đến file IPN.php thì có thể mở comment code sau để demo
    // đảm bảo url được gọi từ vnpay
    if (isset($_SERVER['HTTP_REFERER']) && str_starts_with($_SERVER['HTTP_REFERER'], $vnpay->getHost())) {
        $ct->purchaseSuccessful();
    }
}
$_SESSION['total_amount'] = $amount;
header('Location: success.php');

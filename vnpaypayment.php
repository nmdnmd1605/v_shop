<?php
ob_start();
include 'inc/header.php';

// header('Content-type: text/html; charset=utf-8');

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

$amount = $ct->getTotalPrice();

// VNPAY: Xử lý mua hàng
if (! empty($_GET) && isset($_GET['orderid']) && ($_GET['orderid'] == 'order')) {

    require './lib/VNPay.php';
    $cart = $ct->check_cart();
    $dataCart = $cart->fetch_assoc();
    $orderId = $dataCart['cartId'];
    // Trường hợp sử dụng production thì dùng VNPay::production();
    $vnpay = VNPay::make(VNP_SECRET, VNP_TMN_CODE);
    $purchaseUrl = $vnpay->setParams([
        'vnp_Amount' => $amount,// Tổng số tiền cần chuyển phải >= 5000VND
        'vnp_OrderInfo' => 'Thanh toán đơn hàng #' . $orderId,
        'vnp_TxnRef' => $orderId,// Mã đơn hàng
        'vnp_ReturnUrl' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/vnpaypayment-callback.php'// Callback url sẽ được gọi lại sau khi thanh toán thành công
    ])->purchase();
    header('Location: ' . $purchaseUrl);
}

ob_end_flush();
?>
<style type="text/css">
    .payment-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .box_left {
        width: 100%;
        border: 1px solid #666;
        float: left;
        padding: 4px;
        margin-bottom: 20px;
    }

    .box_right {
        width: 100%;
        border: 1px solid #666;
        float: right;
        padding: 4px;
    }

    .box_right + .box_right {
        margin-top: 20px;
    }

    a.a_order {
        background: red;
        padding: 7px 20px;
        color: #fff;
        font-size: 21px;
    }
</style>
<form action="" method="GET">
  <div class="main">
    <div class="content">
      <div class="section group payment-content">
        <div class="heading">
          <h3>Thanh toán qua VNPAY</h3>
        </div>

        <div class="clear"></div>
        <div class="box_left">
          <div class="cartpage">

              <?php
              if (isset($update_quantity_cart)) {
                  echo $update_quantity_cart;
              }
              ?>
              <?php
              if (isset($delcart)) {
                  echo $delcart;
              }
              ?>
            <table class="tblone">
              <tr>
                <th width="5%">STT</th>
                <th width="20%">Tên SP</th>
                <th width="15%">Giá</th>
                <th width="25%">SL</th>
                <th width="15%">Tổng</th>

              </tr>
                <?php
                $get_product_cart = $ct->get_product_cart();
                if ($get_product_cart) {
                    $subtotal = 0;
                    $qty = 0;
                    $i = 0;
                    while ($result = $get_product_cart->fetch_assoc()) {
                        $i++;
                        ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['productName'] ?></td>

                        <td><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></td>
                        <td>
                            <?php echo $result['quantity'] ?>
                        </td>
                        <td><?php
                            $total = $result['price'] * $result['quantity'];
                            echo $fm->format_currency($total) . ' ' . 'VNĐ';
                            ?></td>

                      </tr>
                        <?php
                        $subtotal += $total;
                        $qty = $qty + $result['quantity'];
                    }
                }
                ?>

            </table>
              <?php
              $check_cart = $ct->check_cart();
              if ($check_cart) {
                  ?>
                <table style="float:right;text-align:left;margin:5px" width="40%">
                  <tr>
                    <th>Tạm tính :</th>
                    <td><?php

                        echo $fm->format_currency($subtotal) . ' ' . 'VNĐ';
                        Session::set('sum', $subtotal);
                        Session::set('qty', $qty);
                        ?></td>
                  </tr>
                  <tr>
                    <th>VAT :</th>
                    <td>10% (<?php echo $fm->format_currency($vat = $subtotal * 0.1) . ' ' . 'VNĐ'; ?>)</td>
                  </tr>
                  <tr>
                    <th>Thành tiền :</th>
                    <td><?php

                        $vat = $subtotal * 0.1;
                        $gtotal = $subtotal + $vat;
                        echo $fm->format_currency($gtotal) . ' ' . 'VNĐ';
                        ?></td>
                  </tr>

                </table>
                  <?php
              } else {
                  echo 'Giỏ hàng trống!!!';
              }
              ?>
          </div>
        </div>

        <div class="box_right">
          <table class="tblone">
              <?php
              $id = Session::get('customer_id');
              $get_customers = $cs->show_customers($id);
              if ($get_customers) {
                  while ($result = $get_customers->fetch_assoc()) {
                      ?>
                    <tr>
                      <td>Tên</td>
                      <td>:</td>
                      <td><?php echo $result['name'] ?></td>
                    </tr>
                    <tr>
                      <td>Số điện thoại</td>
                      <td>:</td>
                      <td><?php echo $result['phone'] ?></td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td><?php echo $result['email'] ?></td>
                    </tr>
                    <tr>
                      <td>Địa chỉ</td>
                      <td>:</td>
                      <td><?php echo $result['address'] ?></td>
                    </tr>
                    <tr>
                      <td colspan="3"><a href="editprofile.php">Cập nhật</a></td>

                    </tr>
                      <?php
                  }
              }
              ?>
          </table>
        </div>
      </div>
    </div>
    <center><a href="?orderid=order" class="a_order">Hoàn tất</a></center>
    <br>
  </div>
</form>
<?php
include 'inc/footer.php';
?>

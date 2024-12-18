<?php
ob_start();
include 'inc/header.php';
// header('Content-type: text/html; charset=utf-8');

if (isset($_GET['extraData']) && $_GET['extraData'] == session_id()) {
	$customer_id = Session::get('customer_id');
	$insertOrder = $ct->insertOrder($customer_id);
	$delCart = $ct->del_all_data_cart();
	echo "<script>window.location ='success.php'</script>";
}

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

$get_product_cart = $ct->get_product_cart();
if ($get_product_cart) {
	$subtotal = 0;
	$qty = 0;
	$i = 0;
	while ($result = $get_product_cart->fetch_assoc()) {
		$i++;
		$total = $result['price'] * $result['quantity'];
		$subtotal += $total;
	}

	if (!empty($_GET) && isset($_GET['orderid']) && ($_GET['orderid'] == 'order')) {
		try {
			$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
			$partnerCode = 'MOMOBKUN20180529'; // Thông tin định danh của đối tác với MoMo. Là mã đối tác của đối tác với MoMo.
			$accessKey = 'klm05TvNBzhg7h7j'; // Cấp quyền truy cập hệ thống của đối tác với MoMo. Là khóa bí mật giữa MoMo và đối tác.
			$serectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa'; // Dùng tạo chữ ký điện tử
			$orderId = md5(session_id() . time()); // Mã đơn hàng
			$orderInfo = "Thanh toán qua MoMo";
			$amount = $subtotal + $subtotal * 0.1;
			$ipnUrl = "http://localhost/v_shop/onlinepayment.php"; // URL
			$redirectUrl = "http://localhost/v_shop/onlinepayment.php"; // URL
			$extraData = session_id();

			$requestId = time() . "";
			$requestType = "captureWallet";
			//before sign HMAC SHA256 signature
			$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
			$signature = hash_hmac("sha256", $rawHash, $serectkey);
			$data = array(
				'partnerCode' => $partnerCode,
				'partnerName' => "Test",
				"storeId" => "MomoTestStore",
				'requestId' => $requestId,
				'amount' => $amount,
				'orderId' => $orderId,
				'orderInfo' => $orderInfo,
				'redirectUrl' => $redirectUrl,
				'ipnUrl' => $ipnUrl,
				'lang' => 'vi',
				'extraData' => $extraData,
				'requestType' => $requestType,
				'signature' => $signature
			);
			$result = execPostRequest($endpoint, json_encode($data));
			$jsonResult = json_decode($result, true);  // decode json


			if (isset($jsonResult['payUrl']))
				header('Location: ' . $jsonResult['payUrl']);
		} catch (Exception $e) {
		}
	}
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

	a.a_order {
		background: red;
		padding: 7px 20px;
		color: #fff;
		font-size: 21px;
	}
</style>
<form action="" method="POST">
	<div class="main">
		<div class="content">
			<div class="section group payment-content">
				<div class="heading">
					<h3>Thanh toán qua Momo</h3>
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
									<th>Tạm tính : </th>
									<td><?php

										echo $fm->format_currency($subtotal) . ' ' . 'VNĐ';
										Session::set('sum', $subtotal);
										Session::set('qty', $qty);
										?></td>
								</tr>
								<tr>
									<th>VAT : </th>
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
		<center><a href="?orderid=order" class="a_order">Hoàn tất</a></center><br>
	</div>
</form>
<?php
include 'inc/footer.php';
?>
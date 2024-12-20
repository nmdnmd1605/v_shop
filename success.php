<?php
include 'inc/header.php';

// Thiếu code lấy tổng số tiền giao dịch
if (!isset($amount)) {
	$amount = $_SESSION['total_amount'] ?? 0;
}
?>

<style type="text/css">
	h2.success_order {
		text-align: center;
		color: red;
	}

	p.success_note {
		text-align: center;
		padding: 8px;
		font-size: 17px;
	}
</style>
<form action="" method="POST">
	<div class="main">
		<div class="content">
			<div class="section group">
				<h2 class="success_order">Đặt hàng thành công</h2>
				<?php
				$customer_id = Session::get('customer_id');
				$get_amount = $ct->getAmountPrice($customer_id);
				if ($get_amount) {
					$amount = 0;
					while ($result = $get_amount->fetch_assoc()) {
						$price = $result['price'];
						$amount += $price;
					}
				}
				?>
				<p class="success_note">Tổng tiền đơn hàng bạn đã đặt mua:
					<?php
					$vat = $amount * 0.1;
					$total = $vat + $amount;
					echo $fm->format_currency($total) . ' VNĐ';
					?>
				</p>
				<p class="success_note">Cảm ơn bạn đã tin dùng sản phẩm, xem chi tiết đơn hàng của bạn <a href="orderdetails.php">tại đây</a></p>
			</div>
		</div>
	</div>
</form>
<?php
include 'inc/footer.php';

?>
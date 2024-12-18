<?php
include 'inc/header.php';
$amount = $ct->getTotalPrice();
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
				<h2 class="success_order">Thanh toán thất bại</h2>
				<p class="success_note">Tổng tiền đơn hàng bạn đã đặt mua:
					<?php
					echo $fm->format_currency($amount) . ' VNĐ';
					?> </p>
				<p class="success_note"><?=$_SESSION['message']??'Giao dịch không thành công do: Giao dịch thất bại'?></p>
			</div>

		</div>

	</div>
</form>
<?php
include 'inc/footer.php';

?>

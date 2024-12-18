<?php
include 'inc/header.php';
?>
<?php

$login_check = Session::get('customer_login');
if ($login_check == false) {
	echo '<h2><a href="login.php ">Hãy đăng nhập</a></h2>';
}

?>
<style>
	.order_page {
		font-size: 30px;
		font-weight: bold;
		color: red;
	}
</style>
<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<div class="order_page">
					<h3> Đơn hàng của bạn</h3>
				</div>
			</div>

		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include 'inc/footer.php';

?>
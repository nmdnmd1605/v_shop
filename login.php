<?php
include 'inc/header.php';
?>
<?php
$login_check = Session::get('customer_login');
if ($login_check) {
	echo "<script>window.location ='index.php'</script>";
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
	$insertCustomers = $cs->insert_customers($_POST);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
	$login_Customers = $cs->login_customers($_POST);
}
?>
<div class="main">
	<div class="form_login_register">
		<div class="login_panel">
			<h3>Đăng nhập</h3>
			<?php
			if (isset($login_Customers)) {
				echo $login_Customers;
			}
			?>
			<form action="" method="post">
				<input type="text" name="email" class="field" placeholder="Email...">
				<input type="password" name="password" class="field" placeholder="Mật khẩu...">

				<p class="note"><a href="#">Quên mật khẩu</a></p>
				<div class="buttons">
					<input type="submit" name="login" class="grey" value="Đăng nhập">
				</div>
			</form>
		</div>

		<div class="register_account">
			<h3>Đăng ký tài khoản</h3>
			<?php
			if (isset($insertCustomers)) {
				echo $insertCustomers;
			}
			?>
			<form action="" method="POST">
				<table>
					<tbody>
						<tr>
							<td>
								<div>
									<input class="form-control" type="text" name="name" placeholder="Họ và tên">
								</div>
								<div>
									<input class="form-control" type="text" name="phone" placeholder="Số điện thoại">
								</div>
								<div>
									<input class="form-control" type="text" name="address" placeholder="Địa chỉ">
								</div>
							</td>

							<td style="padding: 0 10px;">
								<div>
									<input class="form-control" type="text" name="email" placeholder="Email">
								</div>
								<div>
									<input class="form-control" type="password" name="password" placeholder="Mật khẩu">
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="buttons">
					<div><input type="submit" name="submit" class="grey" value="Đăng ký"></div>
				</div>
				<p class="terms">Bằng việc "Đăng ký", bạn đã đồng ý về <a href="#">điều khoản dịch vụ &amp; chính sách bảo mật</a>.</p>
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php
include 'inc/footer.php';
?>
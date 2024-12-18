<?php
include 'inc/header.php';
include 'inc/sidebar.php';

$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/cart.php');
include_once($filepath . '/../helpers/format.php');

$ct = new cart();
if (isset($_GET['shiftid'])) {
	$id = $_GET['shiftid'];
	$time = $_GET['time'];
	$price = $_GET['price'];
	$ct->shifted($id, $time, $price);
}

if (isset($_GET['delid'])) {
	$id = $_GET['delid'];
	$time = $_GET['time'];
	$price = $_GET['price'];
	$del_shifted = $ct->del_shifted($id, $time, $price);
}
?>

<div class="grid_10">
	<div class="box round first grid">
		<h2>DANH SÁCH ĐƠN HÀNG</h2>
		<div class="block admin-table">
			<?php
			if (isset($shifted)) {
				echo $shifted;
			}
			?>

			<?php
			if (isset($del_shifted)) {
				echo $del_shifted;
			}
			?>
			<form class="form_excel" method="post" action="export.php">
				<select class="select-excel" name="status">
					<option value="0">Chờ xử lý</option>
					<option value="1">Đang vận chuyển</option>
					<option value="2">Hoàn thành</option>
				</select>
				<button class="but-excel" type="submit">Xuất Excel</button>
			</form>
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>STT</th>
						<th>Sản phẩm</th>
						<th>Mã khách hàng</th>
						<th>Thời gian</th>
						<th>Số lượng</th>
						<th>Thanh toán</th>
						<th>Trạng thái</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$ct = new cart();
					$fm = new Format();
					$get_inbox_cart = $ct->get_grouped_inbox_cart();
					if ($get_inbox_cart) {
						$i = 0;
						while ($result = $get_inbox_cart->fetch_assoc()) {
							$i++;
							echo '<tr class="odd gradeX">';
							echo '<td>' . $i . '</td>';
							echo '<td>' . $result['productName'] . '</td>';
							echo '<td>' . $result['customer_id'] . '</td>';
							echo '<td>' . $fm->formatDate($result['date_order']) . '</td>';
							$get_amount = $ct->getTotalPriceByTime($result['date_order']);
							echo '<td>' . $result['total_quantity'] . '</td>';
							echo '<td>' . $get_amount . '</td>';
							echo '<td>';
							if ($result['status'] == 0) {
								echo '<a href="?shiftid=' . $result['id'] . '&price=' . $result['price'] . '&time=' . $result['date_order'] . '">Chờ xử lý</a>';
							} elseif ($result['status'] == 1) {
								echo 'Đang vận chuyển...';
							} elseif ($result['status'] == 2) {
								echo 'Hoàn thành | <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')" href="?delid=' . $result['id'] . '&price=' . $result['price'] . '&time=' . $result['date_order'] . '">Xóa</a>';
							}
							echo '</td>';
							echo '</tr>';
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		setupLeftMenu();

		$('.datatable').dataTable();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>
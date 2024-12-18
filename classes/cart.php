<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
include_once($filepath . '/../carbon/autoload.php');

use Carbon\Carbon;
use Carbon\CarbonInterval;
?>

<?php

class cart
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	// hàm thêm sản phẩm vào giỏ hàng
	public function add_to_cart($quantity, $id)
	{
		$quantity = $this->fm->validation($quantity);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$id = mysqli_real_escape_string($this->db->link, $id);
		$sId = session_id();

		// Kiểm tra sản phẩm trong giỏ
		$check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId ='$sId'";
		$result_check_cart = $this->db->select($check_cart);

		// Check available stock
		$query = "SELECT quantity FROM tbl_product WHERE productId = '$id'";
		$product = $this->db->select($query)->fetch_assoc();
		$available_quantity = $product['quantity'];

		// Calculate total quantity if the product is already in the cart
		$total_quantity = $quantity; // Start with the new quantity
		if ($result_check_cart) {
			$cart = $result_check_cart->fetch_assoc();
			$total_quantity += $cart['quantity']; // Add existing quantity in the cart
		}

		if ($total_quantity > $available_quantity) {
			$msg = "<span class='error'>Số lượng yêu cầu vượt quá số lượng có sẵn</span>";
			return $msg;
		}

		if ($result_check_cart) {
			// Nếu sản phẩm đã có trong giỏ, cập nhật số lượng
			$new_quantity = $cart['quantity'] + $quantity; // Tăng số lượng lên
			$update_cart = "UPDATE tbl_cart SET quantity = '$new_quantity' WHERE cartId = '" . $cart['cartId'] . "'";
			$this->db->update($update_cart);
			$msg = "<span class='success'>Cập nhật số lượng sản phẩm thành công</span>";
			return $msg;
		} else {
			// Nếu sản phẩm chưa có trong giỏ, thêm mới sản phẩm vào giỏ
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$result = $this->db->select($query)->fetch_assoc();

			$image = $result["image"];
			$price = $result["price"];
			$productName = $result["productName"];

			$query_insert = "INSERT INTO tbl_cart(productId,quantity,sId,image,price,productName) 
                        VALUES('$id','$quantity','$sId','$image','$price','$productName')";
			$insert_cart = $this->db->insert($query_insert);
			if ($insert_cart) {
				$msg = "<span class='success'>Thêm sản phẩm thành công</span>";
				return $msg;
			}
		}
	}
	// hàm lấy tất cả sản phẩm trong giỏ hàng
	public function get_product_cart()
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	// hàm cập nhật số lượng sản phẩm trong giỏ hàng
	public function update_quantity_cart($quantity, $cartId)
	{
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$cartId = mysqli_real_escape_string($this->db->link, $cartId);

		// Lấy thông tin sản phẩm từ giỏ hàng
		$query_cart = "SELECT * FROM tbl_cart WHERE cartId = '$cartId'";
		$cart_item = $this->db->select($query_cart)->fetch_assoc();
		$productId = $cart_item['productId'];

		// Kiểm tra số lượng có sẵn
		$query_product = "SELECT quantity FROM tbl_product WHERE productId = '$productId'";
		$product = $this->db->select($query_product)->fetch_assoc();
		$available_quantity = $product['quantity'];

		if ($quantity > $available_quantity) {
			return "<span class='error'>Số lượng yêu cầu vượt quá số lượng có sẵn</span>";
		}

		$query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
		$result = $this->db->update($query);
		if ($result) {
			$msg = "<span class='success'>Cập nhật thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Cập nhật không thành công</span>";
			return $msg;
		}
	}
	// hàm xóa sản phẩm trong giỏ hàng
	public function del_product_cart($cartid)
	{
		$cartid = mysqli_real_escape_string($this->db->link, $cartid);
		$query = "DELETE FROM tbl_cart WHERE cartId = '$cartid'";
		$result = $this->db->delete($query);
		if ($result) {
			$msg = "<span class='success'>Xóa sản phẩm thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Xóa sản không phẩm thành công</span>";
			return $msg;
		}
	}
	// hàm lấy thông tin trong giỏ hàng
	public function check_cart()
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;
	}
	// hàm lấy thông tin sản phẩm trong giỏ hàng với id người dùng
	public function check_order($customer_id)
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
		$result = $this->db->select($query);
		return $result;
	}
	// hàm xóa tất cả sản phẩm trong giỏ hàng
	public function del_all_data_cart()
	{
		$sId = session_id();
		$query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->delete($query);
	}
	// hàm xóa tất cả sản phẩm trong giỏ hàng với id người dùng
	public function purchaseSuccessful(): void
	{
		// Xử lý cập nhât trạng thái đơn hàng
		$customer_id = Session::get('customer_id');
		$ids = $this->insertOrder($customer_id);
		$this->del_all_data_cart();
		// Có thể thêm các thông tin về vnp vào database tại đây
		foreach ($ids as $id) {
			$this->shiftedById($id);
		}
	}
	// hàm thêm đơn hàng
	public function insertOrder($customer_id)
	{
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$get_product = $this->db->select($query);
		$ids = [];
		if ($get_product) {
			while ($result = $get_product->fetch_assoc()) {
				$productid = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];
				$customer_id = $customer_id;

				// Thêm vào bảng tbl_order
				$query_order = "INSERT INTO tbl_order(productId,productName,quantity,price,image,customer_id) 
                            VALUES('$productid','$productName','$quantity','$price','$image','$customer_id')";
				$this->db->insert($query_order);
				$ids[] = mysqli_insert_id($this->db->link);

				// Trừ số lượng sản phẩm trong tbl_product
				$query_update_product = "UPDATE tbl_product 
                                     SET quantity = quantity - $quantity 
                                     WHERE productId = '$productid'";
				$this->db->update($query_update_product);
			}
		}
		return $ids;
	}
	// hàm tính toán tổng tiền
	public function getAmountPrice($customer_id)
	{
		$query = "SELECT price FROM tbl_order WHERE customer_id = '$customer_id'";
		$get_price = $this->db->select($query);
		return $get_price;
	}
	// hàm lấy danh sách đơn hàng của khách hàng
	public function get_cart_ordered($customer_id)
	{
		$query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id' ORDER BY date_order DESC";
		$get_cart_ordered = $this->db->select($query);
		return $get_cart_ordered;
	}
	// hàm lấy danh sách đơn hàng của admin
	public function get_inbox_cart()
	{
		$query = "SELECT * FROM tbl_order ORDER BY date_order DESC";
		$get_inbox_cart = $this->db->select($query);
		return $get_inbox_cart;
	}
	// hàm lấy tất cả các sản phẩm trong 1 đơn hàng có cùng thời gian mua
	public function get_grouped_inbox_cart()
	{
		$query = "SELECT 
					id,
					GROUP_CONCAT(productName SEPARATOR ', ') AS productName,
					customer_id,
					SUM(quantity) AS total_quantity,
					price,
					status,
					date_order
				FROM 
					tbl_order
				GROUP BY 
					date_order, customer_id
				ORDER BY 
					date_order DESC";
		$get_grouped_inbox_cart = $this->db->select($query);
		return $get_grouped_inbox_cart;
	}
	// hàm cập nhật trạng thái đơn hàng
	public function shifted($id, $time, $price)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$time = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);
		$query = "UPDATE tbl_order SET
					status = '1'
					WHERE date_order='$time'";
		$result = $this->db->update($query);
		if ($result) {
			$msg = "<span class='success'>Cập nhật đơn hàng thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Cập nhật đơn hàng không thành công</span>";
			return $msg;
		}
	}
	// hàm tổng tiền các sản phẩm trong giỏ hàng
	public function getTotalPrice()
	{
		$get_product_cart = $this->get_product_cart();
		$amount = 0;
		if ($get_product_cart) {
			$subtotal = 0;
			while ($result = $get_product_cart->fetch_assoc()) {
				$total = $result['price'] * $result['quantity'];
				$subtotal += $total;
			}
			$amount = $subtotal + $subtotal * 0.1;
		}
		return $amount;
	}
	// hàm tổng tiền các sản phẩm trong 1 đơn hàng có cùng thời gian mua
	public function getTotalPriceByTime($time)
	{
		$time = mysqli_real_escape_string($this->db->link, $time);
		$query = "SELECT price FROM tbl_order WHERE date_order = '$time'";
		$get_price = $this->db->select($query);
		$amount = 0;
		if ($get_price) {
			$subtotal = 0;
			while ($result = $get_price->fetch_assoc()) {
				$subtotal += $result['price'];
			}
			$amount = $subtotal + $subtotal * 0.1;
		}
		return $amount;
	}
	// hàm cập nhật trạng thái đơn hàng
	public function shiftedById($id)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$query = "UPDATE tbl_order SET status = '0' WHERE id = '$id'";
		return $this->db->update($query);
	}
	// hàm xóa đơn hàng
	public function del_shifted($id, $time, $price)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$time = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);
		$query = "DELETE FROM tbl_order 
					WHERE id = '$id' AND date_order='$time' AND price ='$price'";
		$result = $this->db->delete($query);
		if ($result) {
			$msg = "<span class='success'>Xóa đơn hàng thành công</span>";
			return $msg;
		} else {
			$msg = "<span class='error'>Xóa đơn hàng không thành công</span>";
			return $msg;
		}
	}
	// hàm cập nhật trạng thái đơn hàng
	public function shifted_confirm($id, $time, $price)
	{
		$id = mysqli_real_escape_string($this->db->link, $id);
		$time = mysqli_real_escape_string($this->db->link, $time);
		$price = mysqli_real_escape_string($this->db->link, $price);
		$query = "UPDATE tbl_order SET
					status = '2'
					WHERE customer_id = '$id' AND date_order='$time' AND price ='$price'";
		$result = $this->db->update($query);
		return $result;
	}
	// hàm cập nhật trạng thái đơn hàng
	public function done($price, $quantity)
	{
		$price = mysqli_real_escape_string($this->db->link, $price);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
		$sql_check = "SELECT * FROM tbl_thongke WHERE created_date = '$now'";
		$check = $this->db->select($sql_check);
		if (!$check) {
			$sql_done = "INSERT INTO tbl_thongke(created_date, orders, sales, quantity) VALUES('$now','1','$price','$quantity')";
			$result = $this->db->insert($sql_done);
		} else {
			while ($row = $check->fetch_assoc()) {
				$doanhthu = $row['sales'] + $price;
				$soluong = $row['quantity'] + $quantity;
				$donhang = $row['orders'] + 1;
				$sql_done = "UPDATE tbl_thongke SET orders = '$donhang', sales = '$doanhthu', quantity = '$soluong' WHERE created_date = '$now'";
				$result = $this->db->update($sql_done);
			}
		}
		return true;
	}
}
?>

<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class customer
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	//hàm thêm bình luận
	public function insert_cmt()
	{
		$product_id = $_POST['product_id_cmt'];
		$cmtName = $_POST['cmtName'];
		$cmt = $_POST['cmt'];
		if ($cmtName == '' || $cmt == '') {
			$alert = "<span class='error'>Điền thông tin</span>";
			return $alert;
		} else {
			$query = "INSERT INTO tbl_comments(cmtName,cmt,product_id) VALUES('$cmtName','$cmt','$product_id')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class='success'>Bình luận đã gửi</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Bình luận không thành công</span>";
				return $alert;
			}
		}
	}
	//hàm xóa bình luận
	public function del_comment($id)
	{
		$query = "DELETE FROM tbl_comments where cmtId = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<span class='success'>Xóa bình luận thành công</span>";
			return $alert;
		} else {
			$alert = "<span class='error'>Xóa bình luận không thành công</span>";
			return $alert;
		}
	}
	//hàm hiển thị bình luận
	public function show_comment()
	{
		$query = "SELECT * FROM tbl_comments order by cmtId desc";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm hiển thị bình luận theo id sản phẩm
	public function show_comment_by_id($id)
	{
		$query = "SELECT * FROM tbl_comments where product_id = '$id' order by cmtId desc";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm đăng ký khách hàng
	public function insert_customers($data)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		if ($name == "" || $email == "" || $address == "" || $phone == "" || $password == "") {
			$alert = "<span class='error'>Fields must be not empty</span>";
			return $alert;
		} else {
			$check_email = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
			$result_check = $this->db->select($check_email);
			if ($result_check) {
				$alert = "<span class='error'>Đã có tài khoản đăng ký với email này</span>";
				return $alert;
			} else {
				$query = "INSERT INTO tbl_customer(name,email,address,phone,password) VALUES('$name','$email','$address','$phone','$password')";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "<span class='success'>Đăng ký thành công</span>";
					return $alert;
				} else {
					$alert = "<span class='error'>Đăng ký không thàng công</span>";
					return $alert;
				}
			}
		}
	}
	//hàm đăng nhập khách hàng
	public function login_customers($data)
	{
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$password = mysqli_real_escape_string($this->db->link, md5($data['password']));
		if ($email == '' || $password == '') {
			$alert = "<span class='error'>Nhập email và mật khẩu </span>";
			return $alert;
		} else {
			$check_login = "SELECT * FROM tbl_customer WHERE email='$email' AND password='$password'";
			$result_check = $this->db->select($check_login);
			if ($result_check) {
				$value = $result_check->fetch_assoc();
				Session::set('customer_login', true);
				Session::set('customer_id', $value['id']);
				Session::set('customer_name', $value['name']);
				$alert = "<span class='success'>Đăng nhập thành công</span>";
				echo "<script>window.location ='index.php'</script>";
				return $alert;
			} else {
				$alert = "<span class='error'>Email hoặc mật khẩu không đúng</span>";
				return $alert;
			}
		}
	}
	//hàm hiển thị thông tin khách hàng
	public function show_customers($id)
	{
		$query = "SELECT * FROM tbl_customer WHERE id='$id'";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm cập nhật thông tin khách hàng
	public function update_customers($data, $id)
	{
		$name = mysqli_real_escape_string($this->db->link, $data['name']);
		$email = mysqli_real_escape_string($this->db->link, $data['email']);
		$address = mysqli_real_escape_string($this->db->link, $data['address']);
		$phone = mysqli_real_escape_string($this->db->link, $data['phone']);

		if ($name == "" || $email == "" || $address == "" || $phone == "") {
			$alert = "<span class='error'>Không thể bỏ trống</span>";
			return $alert;
		} else {
			$query = "UPDATE tbl_customer SET name='$name',email='$email',address='$address',phone='$phone' WHERE id ='$id'";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class='success'>Cập nhật thông tin thành công</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Cập nhật không thành công</span>";
				return $alert;
			}
		}
	}
	//hàm đổi mật khẩu
	public function change_pass($id, $oldpass, $newpass)
	{
		$oldpass =  mysqli_real_escape_string($this->db->link, md5($oldpass));
		$newpass =  mysqli_real_escape_string($this->db->link, md5($newpass));

		$checkoldpass = "SELECT * FROM tbl_customer WHERE id = '$id' AND password = '$oldpass'";
		$checkresult = $this->db->select($checkoldpass);
		if ($checkresult) {
			$query = "UPDATE tbl_customer SET password = '$newpass' WHERE id ='$id'";
			$result = $this->db->update($query);
			if ($result) {
				$alert = "<span class='success'>Đổi mật khẩu thành công</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Đổi mật khẩu không thành công</span>";
				return $alert;
			}
		} else {
			$alert = "<span class='error'>Mật khẩu cũ không đúng</span>";
			return $alert;
		}
	}
}
?>
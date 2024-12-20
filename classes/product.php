<?php

$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../lib/database.php');
include_once($filepath . '/../helpers/format.php');
?>

<?php
class product
{
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
	//hàm thêm slider
	public function insert_slider($data, $files)
	{
		$sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
		$type = mysqli_real_escape_string($this->db->link, $data['type']);
		//Kiểm tra hình ảnh và lấy hình ảnh cho vào folder upload
		$permited  = array('jpg', 'jpeg', 'png', 'gif');

		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		if ($sliderName == "" || $type == "") {
			$alert = "<span class='error'>Điền đủ thông tin.</span>";
			return $alert;
		} else {
			if (!empty($file_name)) {
				//Nếu người dùng chọn ảnh
				if ($file_size > 2048000) {
					$alert = "<span class='success'>Ảnh phải nhỏ hơn 2MB!</span>";
					return $alert;
				} elseif (in_array($file_ext, $permited) === false) {
					$alert = "<span class='success'>Chỉ được chọn :-" . implode(', ', $permited) . "</span>";
					return $alert;
				}
				move_uploaded_file($file_temp, $uploaded_image);
				$query = "INSERT INTO tbl_slider(sliderName,type,slider_image) VALUES('$sliderName','$type','$unique_image')";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "<span class='success'>Thêm slider thành công</span>";
					return $alert;
				} else {
					$alert = "<span class='error'>Thêm silder không thành công</span>";
					return $alert;
				}
			}
		}
	}
	//hàm hiển thị các slider hoạt động 
	public function show_slider()
	{
		$query = "SELECT * FROM tbl_slider where type='1' order by sliderId desc";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm hiển thị danh sách slider
	public function show_slider_list()
	{
		$query = "SELECT * FROM tbl_slider order by sliderId desc";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm cập nhật loại slider
	public function update_type_slider($id, $type)
	{
		$type = mysqli_real_escape_string($this->db->link, $type);
		$query = "UPDATE tbl_slider SET type = '$type' where sliderId='$id'";
		$result = $this->db->update($query);
		return $result;
	}
	//hàm xóa slider
	public function del_slider($id)
	{
		$query = "DELETE FROM tbl_slider where sliderId = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<span class='success'>Slider Deleted Successfully</span>";
			return $alert;
		} else {
			$alert = "<span class='error'>Slider Deleted Not Success</span>";
			return $alert;
		}
	}
	//hàm tìm kiếm sản phẩm
	public function search_product($tukhoa)
	{
		$tukhoa = $this->fm->validation($tukhoa);
		$query = "SELECT * FROM tbl_product WHERE productName LIKE '%$tukhoa%'";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm hiển thị sản phẩm
	public function show_product()
	{
		$query = "
			SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
			INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId 
			order by tbl_product.productId desc";

		$result = $this->db->select($query);
		return $result;
	}
	//hàm thêm sản phẩm
	public function insert_product($data, $files)
	{
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$brand = mysqli_real_escape_string($this->db->link, $data['brand']);
		$category = mysqli_real_escape_string($this->db->link, $data['category']);
		$product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
		$price = mysqli_real_escape_string($this->db->link, $data['price']);
		$quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
		$type = mysqli_real_escape_string($this->db->link, $data['type']);
		//Kiem tra hình ảnh và lấy hình ảnh cho vào folder upload
		$permited  = array('jpg', 'jpeg', 'png', 'gif');
		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		if ($productName == "" || $brand == "" || $category == "" || $product_desc == "" || $price == "" || $type == "" || $file_name == "") {
			$alert = "<span class='error'>Hãy điền đủ thông tin sản phẩm</span>";
			return $alert;
		} else {
			move_uploaded_file($file_temp, $uploaded_image);
			$query = "INSERT INTO tbl_product(productName,brandId,catId,product_desc,price,quantity,type,image) VALUES('$productName','$brand','$category','$product_desc','$price','$quantity','$type','$unique_image')";
			$result = $this->db->insert($query);
			if ($result) {
				$alert = "<span class='success'>Thêm sản phẩm thành công</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Thêm sản phẩm không thành công</span>";
				return $alert;
			}
		}
	}
	//hàm cập nhật sản phẩm
	public function update_product($data, $files, $id)
	{
		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$brand = mysqli_real_escape_string($this->db->link, $data['brand']);
		$category = mysqli_real_escape_string($this->db->link, $data['category']);
		$product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
		$price = mysqli_real_escape_string($this->db->link, $data['price']);
		$quantity = mysqli_real_escape_string($this->db->link, $data['quantity']);
		$type = mysqli_real_escape_string($this->db->link, $data['type']);
		//Kiem tra hình ảnh và lấy hình ảnh cho vào folder upload
		$permited  = array('jpg', 'jpeg', 'png', 'gif');

		$file_name = $_FILES['image']['name'];
		$file_size = $_FILES['image']['size'];
		$file_temp = $_FILES['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
		$uploaded_image = "uploads/" . $unique_image;

		if ($productName == "" || $brand == "" || $category == "" || $product_desc == "" || $price == "" || $quantity == "" || $type == "") {
			$alert = "<span class='error'>Điền đủ thông tin</span>";
			return $alert;
		} else {
			if (!empty($file_name)) {
				//Nếu người dùng chọn ảnh
				if ($file_size > 2097152) {
					$alert = "<span class='success'>Ảnh phải nhỏ hơn 2MB!</span>";
					return $alert;
				} elseif (in_array($file_ext, $permited) === false) {
					$alert = "<span class='success'>Chỉ được chọn:-" . implode(', ', $permited) . "</span>";
					return $alert;
				}
				move_uploaded_file($file_temp, $uploaded_image);
				$query = "UPDATE tbl_product SET
					productName = '$productName',
					brandId = '$brand',
					catId = '$category', 
					type = '$type', 
					price = '$price', 
					image = '$unique_image',
					product_desc = '$product_desc'
					WHERE productId = '$id'";
			} else {
				//Nếu người dùng không chọn ảnh
				$query = "UPDATE tbl_product SET
					productName = '$productName',
					brandId = '$brand',
					catId = '$category', 
					type = '$type', 
					price = '$price', 
					quantity = '$quantity',
					product_desc = '$product_desc'
					WHERE productId = '$id'";
			}
			$result = $this->db->update($query);
			if ($result) {
				$alert = "<span class='success'>Cập nhật sản phẩm thành công</span>";
				return $alert;
			} else {
				$alert = "<span class='error'>Cập nhật sản phẩm không thành công</span>";
				return $alert;
			}
		}
	}
	//hàm xóa sản phẩm
	public function del_product($id)
	{
		$query = "DELETE FROM tbl_product where productId = '$id'";
		$result = $this->db->delete($query);
		if ($result) {
			$alert = "<span class='success'>Xóa sản phẩm thành công</span>";
			return $alert;
		} else {
			$alert = "<span class='error'>Xóa sản phẩm không thành công</span>";
			return $alert;
		}
	}
	//hàm lấy sản phẩm theo id
	public function getproductbyId($id)
	{
		$query = "SELECT * FROM tbl_product where productId = '$id'";
		$result = $this->db->select($query);
		return $result;
	}
	// hàm lấy sản phẩm nổi bật
	public function getproduct_feathered()
	{
		$query = "SELECT * FROM tbl_product where type = '0' order by Rand() LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm lấy sản phẩm mới nhất
	public function getproduct_new()
	{
		$sp_tungtrang = 4;
		if (!isset($_GET['trang'])) {
			$trang = 1;
		} else {
			$trang = $_GET['trang'];
		}
		$tung_trang = ($trang - 1) * $sp_tungtrang;
		$query = "SELECT * FROM tbl_product order by productId desc LIMIT $tung_trang,$sp_tungtrang";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm lấy sản phẩm theo danh mục
	public function getproductby_cat($id)
	{
		$sp_tungtrang = 4;
		if (!isset($_GET['trang'])) {
			$trang = 1;
		} else {
			$trang = $_GET['trang'];
		}
		$tung_trang = ($trang - 1) * $sp_tungtrang;
		$query = "SELECT * FROM tbl_product where catId = '$id' order by productId desc LIMIT $tung_trang,$sp_tungtrang";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm lấy tất cả sản phẩm
	public function get_all_product()
	{
		$query = "SELECT * FROM tbl_product";
		$result = $this->db->select($query);
		return $result;
	}
	//hàm lấy chi tiết sản phẩm
	public function get_details($id)
	{
		$query = "
			SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
			INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId WHERE tbl_product.productId = '$id'
			";
		$result = $this->db->select($query);
		return $result;
	}
}
?>
<?php
include 'inc/header.php';
?>
<?php

if (!isset($_GET['proid']) || $_GET['proid'] == NULL) {
	echo "<script>window.location ='404.php'</script>";
} else {
	$id = $_GET['proid'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
	$quantity = $_POST['quantity'];
	$insertCart = $ct->add_to_cart($quantity, $id);
}
if (isset($_POST['cmt_submit'])) {
	$cmt_insert = $cs->insert_cmt();
}
?>
<div class="main">
	<div class="content">
		<div class="section group">
			<?php
			$get_product_details = $product->get_details($id);
			if ($get_product_details) {
				while ($result_details = $get_product_details->fetch_assoc()) {
			?>
					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="admin/uploads/<?php echo $result_details['image'] ?>" alt="Ảnh sản phẩm" style="height: 100%" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result_details['productName'] ?></h2>
							<p><?php echo $fm->textShorten($result_details['product_desc'], 150) ?></p>
							<div class="price">
								<p>Giá bản lẻ: <span><?php echo $fm->format_currency($result_details['price']) . " " . "đ" ?></span></p>
								<p>Danh mục: <span><?php echo $result_details['catName'] ?></span></p>
								<p>Thương hiệu:<span><?php echo $result_details['brandName'] ?></span></p>
								<p>Số lượng:<span><?php echo $result_details['quantity'] ?></span></p>
							</div>
							<div class="add-cart">
								<form action="" method="post">
									<input type="number" class="buyfield" name="quantity" value="1" min="1" />
									<input type="submit" class="buysubmit" name="submit" value="Thêm vào giỏ" />
								</form>
								<?php
								if (isset($insertCart)) {
									echo $insertCart;
								}
								?>
							</div>
						</div>
						<div class="product-desc">
							<h2>Mô tả sản phẩm</h2>
							<?php echo $result_details['product_desc'] ?>
						</div>

					</div>
			<?php
				}
			}
			?>
			<div class="rightsidebar span_3_of_1">
				<h2>Danh mục</h2>
				<ul>
					<?php
					$getall_category = $cat->show_category_fontend();
					if ($getall_category) {
						while ($result_allcat = $getall_category->fetch_assoc()) {
					?>
							<li><a href="productbycat.php?catid=<?php echo $result_allcat['catId'] ?>"><?php echo $result_allcat['catName'] ?></a></li>
					<?php
						}
					}
					?>
				</ul>

			</div>
		</div>
		<div class="cmt">
			<div class="row flex-column">
				<div class="col-md-4 cmt-container">
					<h4>Tất cả bình luận</h4>
					<?php
					$get_cmt = $cs->show_comment_by_id($id);
					if ($get_cmt) {
						while ($result_cmt = $get_cmt->fetch_assoc()) {
					?>
							<div class="cmt-item">
								<p><i class="far fa-user" style="color: #0a398a;"></i><b><?php echo $result_cmt['cmtName'] ?></b></p>
								<p><i class="far fa-comment-alt" style="color: #0a398a;"></i><?php echo $result_cmt['cmt'] ?></p>
							</div>
					<?php
						}
					}
					?>
				</div>
				<div class="col-md-8">
					<h4>Bình luận của bạn</h4>
					<?php
					if (isset($cmt_insert)) {
						echo $cmt_insert;
					}
					?>
					<form action="" method="POST">
						<p><input type="hidden" value="<?php echo $id ?>" name="product_id_cmt"></p>
						<p><input type="text" placeholder="Điền tên" class="form-control" name="cmtName"></p>
						<p><textarea rows="5" style="resize: none;" placeholder="Bình luận...." class="form-control" name="cmt"></textarea></p>
						<p><input type="submit" name="cmt_submit" class="btn btn-success" value="Gửi bình luận"></p>
					</form>
				</div>
			</div>
			</textarea>
		</div>
	</div>
</div>

<?php
include 'inc/footer.php';

?>
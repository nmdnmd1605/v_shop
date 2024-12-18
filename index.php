<?php
include 'inc/header.php';
include 'inc/slider.php';
?>
<div class="main">
	<div class="content">
		<!-- sản phẩm bán chạy -->
		<div class="content_top">
			<div class="heading">
				<h3>Sản phẩm nổi bật</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_feathered = $product->getproduct_feathered();
			if ($product_feathered) {
				while ($result = $product_feathered->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result['image'] ?>" width="150px" alt="" /></a>
						<h2><?php echo $result['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>
		<!-- sản phẩm mới nhất -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Sản phẩm mới nhất</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div style="margin-bottom: 50px;" class="section group">
			<?php
			$product_new = $product->getproduct_new();
			if ($product_new) {
				while ($result_new = $product_new->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_new['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_new['image'] ?>" alt="" /></a>
						<h2><?php echo $result_new['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_new['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_new['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_new['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- sản phẩm có danh mục là id = 1 -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Rau, thịt, hoa quả</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_cat = $product->getproductby_cat(1);
			if ($product_cat) {
				while ($result_cat = $product_cat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_cat['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_cat['image'] ?>" alt="" /></a>
						<h2><?php echo $result_cat['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_cat['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_cat['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_cat['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- sản phẩm có danh mục là id = 2 -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Đồ uống</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_cat = $product->getproductby_cat(2);
			if ($product_cat) {
				while ($result_cat = $product_cat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_cat['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_cat['image'] ?>" alt="" /></a>
						<h2><?php echo $result_cat['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_cat['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_cat['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_cat['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- sản phẩm có danh mục là id = 3 -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Gạo</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_cat = $product->getproductby_cat(3);
			if ($product_cat) {
				while ($result_cat = $product_cat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_cat['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_cat['image'] ?>" alt="" /></a>
						<h2><?php echo $result_cat['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_cat['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_cat['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_cat['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- sản phẩm có danh mục là id = 4 -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Thực phẩm khô</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_cat = $product->getproductby_cat(4);
			if ($product_cat) {
				while ($result_cat = $product_cat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_cat['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_cat['image'] ?>" alt="" /></a>
						<h2><?php echo $result_cat['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_cat['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_cat['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_cat['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- sản phẩm có danh mục là id = 5 -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Chăm sóc cá nhân</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_cat = $product->getproductby_cat(5);
			if ($product_cat) {
				while ($result_cat = $product_cat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_cat['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_cat['image'] ?>" alt="" /></a>
						<h2><?php echo $result_cat['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_cat['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_cat['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_cat['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<!-- sản phẩm có danh mục là id = 6 -->
		<div class="content_bottom">
			<div class="heading">
				<h3>Đồ gia dụng</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$product_cat = $product->getproductby_cat(6);
			if ($product_cat) {
				while ($result_cat = $product_cat->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $result_cat['productId'] ?>"><img class="img_product" src="admin/uploads/<?php echo $result_cat['image'] ?>" alt="" /></a>
						<h2><?php echo $result_cat['productName'] ?></h2>
						<p><?php echo $fm->textShorten($result_cat['product_desc'], 50) ?></p>
						<p>Đơn vị tính: Gam</p>
						<p>Ưu đãi: Tặng 1 sản phẩm bất kỳ</p>
						<p><span class="price"><?php echo $fm->format_currency($result_cat['price']) . " " . "VNĐ" ?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $result_cat['productId'] ?>" class="details">Chi tiết</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>

		<style type="text/css">
			.img_product {
				min-width: 160px;
				height: 180px;
			}

			a.phantrang {
				border: 1px solid #ddd;
				padding: 5px 10px;
				border-radius: 3px;
				background: #ff6d39;
				color: #fff;
				cursor: pointer;
				margin: 5px;
			}

			a.phantrang:hover {
				opacity: 0.8;
			}

			.panigation {
				text-align: center;
				padding: 10px;
			}
		</style>

		<div class="panigation">
			<?php
			if (isset($_GET['trang'])) {
				$trang = $_GET['trang'];
			} else {
				$trang = 1;
			}
			$product_all = $product->get_all_product();
			if ($product_all) {
				$product_count = mysqli_num_rows($product_all);
				$product_button = ceil($product_count / 4);
				$i = 1;
				for ($i = 1; $i <= $product_button; $i++) {
			?>
					<a class="phantrang" <?php if ($i == $trang) {
												echo 'style="background:red"';
											} ?> href="index.php?trang=<?php echo $i ?>"><?php echo $i ?></a>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>

<?php
include 'inc/footer.php';
?>
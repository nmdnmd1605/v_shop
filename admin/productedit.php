<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>
<?php
$pd = new product();

if (!isset($_GET['productid']) || $_GET['productid'] == NULL) {
    echo "<script>window.location ='productlist.php'</script>";
} else {
    $id = $_GET['productid'];
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

    $updateProduct = $pd->update_product($_POST, $_FILES, $id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>SỬA SẢN PHẨM</h2>
        <div class="block admin-table">
            <?php
            if (isset($updateProduct)) {
                echo $updateProduct;
            }
            ?>
            <?php
            $get_product_by_id = $pd->getproductbyId($id);
            if ($get_product_by_id) {
                while ($result_product = $get_product_by_id->fetch_assoc()) {
            ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <table class="form">
                            <tr>
                                <td>
                                    <label>Tên</label>
                                </td>
                                <td>
                                    <input type="text" name="productName" value="<?php echo  $result_product['productName'] ?>"  />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Danh mục</label>
                                </td>
                                <td>
                                    <select id="select" name="category">
                                        <option>Chọn danh mục</option>
                                        <?php
                                        $cat = new category();
                                        $catlist = $cat->show_category();

                                        if ($catlist) {
                                            while ($result = $catlist->fetch_assoc()) {
                                        ?>
                                                <option
                                                    <?php
                                                    if ($result['catId'] == $result_product['catId']) {
                                                        echo 'selected';
                                                    }
                                                    ?>
                                                    value="<?php echo $result['catId'] ?>"><?php echo $result['catName'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Thương hiệu</label>
                                </td>
                                <td>
                                    <select id="select" name="brand">
                                        <option>Chọn thương hiệu</option>
                                        <?php
                                        $brand = new brand();
                                        $brandlist = $brand->show_brand();

                                        if ($brandlist) {
                                            while ($result = $brandlist->fetch_assoc()) {
                                        ?>
                                                <option

                                                    <?php
                                                    if ($result['brandId'] == $result_product['brandId']) {
                                                        echo 'selected';
                                                    }
                                                    ?>

                                                    value="<?php echo $result['brandId'] ?>"><?php echo $result['brandName'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td style="vertical-align: top; padding-top: 9px;">
                                    <label>Mô tả</label>
                                </td>
                                <td>
                                    <textarea name="product_desc" class="tinymce"><?php echo $result_product['product_desc'] ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Giá</label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $result_product['price'] ?>" name="price"  />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Số lượng</label>
                                </td>
                                <td>
                                    <input type="text" value="<?php echo $result_product['quantity'] ?>" name="quantity"  />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Hình ảnh</label>
                                </td>
                                <td>
                                    <img src="uploads/<?php echo $result_product['image'] ?>" width="90"><br>
                                    <input type="file" name="image" />
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label>Loại</label>
                                </td>
                                <td>
                                    <select id="select" name="type">
                                        <option>Chọn loại</option>
                                        <?php
                                        if ($result_product['type'] == 0) {
                                        ?>
                                            <option selected value="0">Nổi bật</option>
                                            <option value="1">Bình thường</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="0">Nôi bật</option>
                                            <option selected value="1">BÌnh thường</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <input type="submit" name="submit" value="Cập nhật" />
                                </td>
                            </tr>
                        </table>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php'; ?>
<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php' ?>
 <?php
    $brand = new brand();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $brandName = $_POST['brandName'];
        $insertBrand = $brand->insert_brand($brandName);
        
    }
?> 
<?php  ?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>THÊM THƯƠNG HIỆU</h2>

               <div class="block admin-table"> 
                <?php
                if(isset($insertBrand)){
                    echo $insertBrand;
                }
                ?> 
                 <form action="brandadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brandName" placeholder="Nhập tên thương hiệu"  />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Thêm" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>
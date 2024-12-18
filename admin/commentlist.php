<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/brand.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/product.php';?>
<?php include '../classes/customer.php';?>
<?php include_once '../helpers/format.php';?>
<?php
	$cs = new customer();
	$fm = new Format();
	if(isset($_GET['cmtId'])){
        $id = $_GET['cmtId']; 
        $delcomment = $cs->del_comment($id);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>DANH SÁCH BÌNH LUẬN</h2>
        <div class="block admin-table"> 
        <?php
        if(isset($delcomment)){
        	echo $delcomment;
        }
        ?> 
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>STT</th>
					<th>Tên người dùng</th>
					<th>Nội dung</th>
					<th>Sản phẩm</th>
					<th>Thao tác</th>
				</tr>
			</thead>
			<tbody>
				<?php
			
				$cmlist = $cs->show_comment();
				if($cmlist){
					$i = 0;
					while($result = $cmlist->fetch_assoc()){
						$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i ?></td>
					<td><?php echo $result['cmtName'] ?></td>
					<td><?php echo $result['cmt'] ?></td>
					<td><?php echo $result['product_id'] ?></td>
					<td><a href="?cmtId=<?php echo $result['cmtId'] ?>">Xóa</a></td>
				</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>

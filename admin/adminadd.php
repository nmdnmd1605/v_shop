<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/admin.php' ?>
<?php
$admin = new admin();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminName = $_POST['adminName'];
    $adminEmail = $_POST['adminEmail'];
    $adminUser = $_POST['adminUser'];
    $adminPass = md5($_POST['adminPass']);
    
    // Validate email
    if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
        $insertAdmin = "Email không hợp lệ.";
    } else {
        if (isset($_POST['level'])) {
            $level = $_POST['level'];
        } else {
            $level = 1;
        }
        $insertAdmin = $admin->insert_admin($adminName,  $adminEmail, $adminUser, $adminPass, $level);
    }
}
?>
<?php  ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>THÊM NHÂN VIÊN</h2>

        <div class="block admin-table">
            <?php
            if (isset($insertAdmin)) {
                echo $insertAdmin;
            }
            ?>
            <form action="adminadd.php" method="post">
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="adminName" placeholder="Họ và tên" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="adminEmail" placeholder="Email" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" name="adminUser" placeholder="Tài khoản" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" name="adminPass" placeholder="Mật khẩu" required />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Quyền Admin<input type="checkbox" name="level" value="0">
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
<?php include 'inc/footer.php'; ?>
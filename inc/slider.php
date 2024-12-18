<?php
$connect = mysqli_connect("localhost", "root", "", "v_shop");

function make_slides($connect)
{
    $output = '';
    $count = 0;
    $query = "SELECT * FROM tbl_slider WHERE type = '1' ORDER BY sliderId DESC";

    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($result)) {
        if ($count == 0) {
            $output .= '<div class="item active">';
        } else {
            $output .= '<div class="item">';
        }
        $output .= '<img src="admin/uploads/' . $row["slider_image"] . '" />';
        // Thêm phần mô tả
        $output .= '<div class="slide-description">';
        $output .= '<h4>Siêu thị V Shop</h4>';
        $output .= '<p>Mua sắm tiện lợi với đa dạng sản phẩm</p>';
        $output .= '</div>';
        $output .= '</div>';
        $count++;
    }
    return $output;
}
?>


<div class="container slide-banner" style="width: 100%;">
    <div id="dynamic_slide_show" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php echo make_slides($connect); ?>
        </div>
        <a class="left carousel-control" href="#dynamic_slide_show" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>

        <a class="right carousel-control" href="#dynamic_slide_show" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
    <div class="banner">
        <img src="./admin/img/Designer.jpg" alt="banner1" />
        <img src="./admin/img/Designer2.jpg" alt="banner2">
    </div>
</div>
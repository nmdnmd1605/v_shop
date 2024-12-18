<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>QUẢN LÝ THỐNG KÊ</h2>
        <div class="block admin-table">
            <p>Thống kê theo: <span id="text-date"></span></p>
            <p>
                <select class="select-date">
                    <option value="">chọn</option>
                    <option value="7ngay">7 ngày qua</option>
                    <option value="28ngay">28 ngày qua</option>
                    <option value="90ngay">90 ngày qua</option>
                    <option value="365ngay">365 ngày qua</option>
                </select>
            </p>
            <div id="chart" style="height: 250px;"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        thongke();
        var char = new Morris.Area({
            element: 'chart',
            xkey: 'date',
            ykeys: ['total', 'order', 'quantity'],
            labels: ['Doanh thu', 'Đơn hàng', 'Số lượng']
        })
        $('.select-date').change(function() {
            var thoigian = $(this).val();
            if (thoigian == '7ngay') {
                var text = '7 ngày qua';
            } else if (thoigian == '28ngay') {
                var text = '28 ngày qua';
            } else if (thoigian == '90ngay') {
                var text = '90 ngày qua';
            } else if (thoigian == '365ngay') {
                var text = '365 ngày qua';
            };

            $.ajax({
                url: "thongke.php",
                method: "POST",
                dataType: "JSON",
                data:{thoigian:thoigian},
                success: function(data){
                    char.setData(data);
                    $('#text-date').text(text);
                }
            });
        })

        function thongke(){
            var text = '7 ngày qua';
            $.ajax({
                url: "thongke.php",
                method: "POST",
                dataType: "JSON",

                success: function(data){
                    char.setData(data);
                    $('#text-date').text(text);
                }
            });
        }
    });
</script>
<?php include 'inc/footer.php'; ?>
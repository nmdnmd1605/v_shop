<div class="grid_2 no-margin">
    <div class="sidebar-menu" id="section-menu">
        <ul class="sidebar-list">
            <li><a class="sidebar-item">Slider<i class="fa-solid fa-chevron-down"></i></a>
                <ul class="submenu">
                    <li><a href="slideradd.php">Thêm slider</a></li>
                    <li><a href="sliderlist.php">Danh sách slider</a></li>
                </ul>
            </li>
            <li><a class="sidebar-item">Danh mục<i class="fa-solid fa-chevron-down"></i></a>
                <ul class="submenu">
                    <li><a href="catadd.php">Thêm danh mục</a></li>
                    <li><a href="catlist.php">Danh sách danh mục</a></li>
                </ul>
            </li>
            <li><a class="sidebar-item">Thương hiệu<i class="fa-solid fa-chevron-down"></i></a>
                <ul class="submenu">
                    <li><a href="brandadd.php">Thêm thương hiệu</a></li>
                    <li><a href="brandlist.php">Danh sách thương hiệu</a></li>
                </ul>
            </li>
            <li><a class="sidebar-item">Sản phẩm<i class="fa-solid fa-chevron-down"></i></a>
                <ul class="submenu">
                    <li><a href="productadd.php">Thêm sản phẩm</a></li>
                    <li><a href="productlist.php">Danh sách sản phẩm</a></li>
                </ul>
            </li>
            <li><a class="sidebar-item">Đơn hàng<i class="fa-solid fa-chevron-down"></i></a>
                <ul class="submenu">
                    <li><a href="inbox.php">Danh sách đơn hàng</a></li>
                </ul>
            </li>
            <li><a class="sidebar-item">Bình luận<i class="fa-solid fa-chevron-down"></i></a>
                <ul class="submenu">
                    <li><a href="commentlist.php">Danh sách bình luận</a></li>
                </ul>
            </li>
            <?php
            if (Session::get('level') == 0)
                echo '<li><a class="sidebar-item">Nhân viên<i class="fa-solid fa-chevron-down"></i></a>
                                <ul class="submenu">
                                <li><a href="adminadd.php">Thêm nhân viên</a></li>
                                    <li><a href="adminlist.php">Danh sách nhân viên</a></li>
                                </ul>
                            </li>';
            ?>
        </ul>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarItems = document.querySelectorAll('.sidebar-item');

        sidebarItems.forEach(item => {
            item.addEventListener('click', function(event) {
                event.preventDefault();
                const submenu = this.nextElementSibling;
                const icon = this.querySelector('i');

                // Đóng/mở submenu
                if (submenu) {
                    submenu.classList.toggle('active');
                    if (submenu.classList.contains('active')) {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    } else {
                        submenu.style.maxHeight = null;
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                }
            });
        });

        // Set trạng thái active dựa trên URL hiện tại
        const links = document.querySelectorAll('.submenu a');
        const currentUrl = window.location.pathname;

        links.forEach(link => {
            const linkUrl = link.getAttribute('href');
            if (currentUrl.includes(linkUrl)) {
                link.classList.add('active');
                const parentSubmenu = link.closest('.submenu');
                if (parentSubmenu) {
                    parentSubmenu.style.maxHeight = parentSubmenu.scrollHeight + "px";
                    const parentItem = parentSubmenu.previousElementSibling;
                    if (parentItem) {
                        parentItem.classList.add('active');
                        const icon = parentItem.querySelector('i');
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }
            }
        });
    });
</script>
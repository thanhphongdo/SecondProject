            <nav class="navbar navbar-default">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Danh mục
                            <span class="glyphicon glyphicon-th-list" />
                        </a>
                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                            <li class="danhmuc"><a id="publisher" href="publisher.php" tabindex="-1">Nhà xuất bản</a></li>
                            <li class="danhmuc"><a id="author" href="author.php" tabindex="-1">Tác giả</a></li>
                            <li class="danhmuc"><a id="category" href="category.php" tabindex="-1">Thể loại</a></li>
                            <li class="danhmuc"><a id="book" href="book.php" tabindex="-1">Sách</a></li>
                        </ul>
                    </li>
                    <li id="menu-hoadon">
                        <a href="hoadon.php">
                            Đơn hàng
                            <span class="glyphicon glyphicon-shopping-cart"/>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Quản lí
                            <span class="glyphicon glyphicon-user" />
                        </a>
                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                            <li><a href="thanhvien.php" tabindex="-1">Khách hàng</a></li>
                            <li><a href="" tabindex="-1">Nhân viên</a></li>
                        </ul>
                    </li>
                </ul>
                <ul id="login" class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <?php echo 'Xin chào: ' . $_SESSION['adminUsername']; ?>
                            <span class="glyphicon glyphicon-cog" />
                        </a>
                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                            <li><a id="changePassword" href="changepassword.php" tabindex="-1">Đổi mật khẩu</a></li>
                            <li><a href="logout.php" tabindex="-1">Đăng xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
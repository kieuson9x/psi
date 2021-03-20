<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="/">
            <img src="https://kangaroo.vn/wp-content/uploads/logo-kangaroo.png" alt="logo"> </a>
        <a class="navbar-brand brand-logo-mini" href="/">
            <img src="https://kangaroo.vn/wp-content/uploads/favicon.png" alt="logo"> </a>
    </div>
    <div class="navbar-menu-wrapper align-items-center">
        <ul class="navbar-nav w-100 h-100">
            <li class="nav-item w-20  mr-auto">
                <button class="navbar-toggler" type="button" data-toggle="offcanvas">
                    <i class="material-icons" style="font-size: 18px">reorder</i>
                </button>
            </li>


            <?php if (isset($_SESSION['user_name'])) : ?>
                <li class="nav-item dropdown flex items-center">
                    <span class="mr-3">Xin chào, <?php echo ($_SESSION['full_name']) ?></span>

                    <a class="nav-link dropdown-toggle" href="#" id="avatar-dropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="/public/img/avatar.svg" class="rounded-circle w-8">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="avatar-dropdown">

                        <a class="dropdown-item" href="#t">Xin chào, <?php echo ($_SESSION['full_name']) ?></a>
                        <a class="dropdown-item" href="/employees/logout">Đăng xuất</a>
                    </div>
                </li>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/employees/login">Đăng nhập</a>
            <?php endif; ?>
        </ul>
    </div>
</nav>
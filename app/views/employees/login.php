<?php
require APPROOT . '/views/base/head.php';
?>

<?php
require APPROOT . '/views/base/nav.php';
?>

<div class="container-fluid page-body-wrapper">
    <?php
    require APPROOT . '/views/base/sidebar.php';
    ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="container-login">
                <div class="wrapper-login">
                    <h2>Sign in</h2>

                    <form action="<?php echo URLROOT; ?>/employees/login" method="POST">
                        <input type="text" placeholder="Tên đăng nhập *" name="user_name">
                        <span class="invalidFeedback">
                            <?php echo $data['user_nameError']; ?>
                        </span>

                        <input type="password" placeholder="Mật khẩu *" name="password">
                        <span class="invalidFeedback">
                            <?php echo $data['passwordError']; ?>
                        </span>

                        <button id="submit" type="submit" value="submit">Submit</button>

                        <p class="options">Chưa đăng ký? <a href="<?php echo URLROOT; ?>/employees/register">Tạo tài khoản mới!</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require APPROOT . '/views/base/script.php';
?>
<?php
require APPROOT . '/views/base/footer.php';
?>
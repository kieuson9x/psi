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
        <div class="content-wrapper container-login d-flex align-items-center auth register-bg-1 theme-one">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <h2 class="text-center mb-4">Đăng ký</h2>
                    <div class="auto-form-wrapper">
                        <form id="register-form" method="POST" action="<?php echo URLROOT; ?>/employees/register">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tên đăng nhập *" name="user_name">
                                    <span class="invalidFeedback">
                                        <?php echo $data['user_nameError']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Họ tên *" name="full_name">
                                    <span class="invalidFeedback">
                                        <?php echo $data['user_nameError']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Mật khẩu *" name="password">
                                    <span class="invalidFeedback">
                                        <?php echo $data['passwordError']; ?>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Xác nhận lại mật khẩu *" name="confirmPassword">
                                    <span class="invalidFeedback">
                                        <?php echo $data['confirmPasswordError']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <button id="submit" type="submit" value="submit" class="btn btn-primary submit-btn btn-block">Đăng ký</button>
                            </div>
                            <div class="text-block text-center my-3">
                                <span class="text-small font-weight-semibold">Đã có tài khoản ?</span>
                                <a href="<?php echo URLROOT; ?>/employees/login">Đăng nhập</a>
                            </div>
                        </form>
                    </div>
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
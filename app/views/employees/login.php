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
    <div class="main-panel page-body-wrapper full-page-wrapper">
        <div class="content-wrapper container-login d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-4 mx-auto">
                    <div class="auto-form-wrapper">
                        <form action="<?php echo URLROOT; ?>/employees/login" method="POST">
                            <div class="form-group">
                                <label class="label">Tên đăng nhập: *</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="user_name">
                                    <span class="invalidFeedback">
                                        <?php echo $data['user_nameError']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label">Mật khẩu</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password">
                                    <span class="invalidFeedback">
                                        <?php echo $data['passwordError']; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <button id="submit" type="submit" value="submit" class="btn btn-primary submit-btn btn-block">Đăng nhập</button>
                            </div>

                            <div class="text-block text-center my-3">
                                <span class="text-small font-weight-semibold">Chưa đăng ký?</span>
                                <a href="<?php echo URLROOT; ?>/employees/register" class="text-black text-small">Tạo tài khoản mới!</a>
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
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
                    <h2>Register</h2>

                    <form id="register-form" method="POST" action="<?php echo URLROOT; ?>/employees/register">
                        <input type="text" placeholder="Tên đăng nhập *" name="user_name">
                        <span class="invalidFeedback">
                            <?php echo $data['user_nameError']; ?>
                        </span>

                        <input type="text" placeholder="Họ tên *" name="full_name">
                        <span class="invalidFeedback">
                            <?php echo $data['user_nameError']; ?>
                        </span>

                        <input type="password" placeholder="Password *" name="password">
                        <span class="invalidFeedback">
                            <?php echo $data['passwordError']; ?>
                        </span>

                        <input type="password" placeholder="Confirm Password *" name="confirmPassword">
                        <span class="invalidFeedback">
                            <?php echo $data['confirmPasswordError']; ?>
                        </span>

                        <button id="submit" type="submit" value="submit">Submit</button>

                        <p class="options">Not registered yet? <a href="<?php echo URLROOT; ?>/employees/register">Create an account!</a></p>
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
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
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="p-4 border-bottom bg-light">
                            <h4 class="card-title mb-0">Nhân viên <?php
                                                                    $i = array_search($data['chuc_vu'] ?? null, array_column($_SESSION['employeeLevelOptions'], 'value'));
                                                                    $element = ($i !== false ? $_SESSION['employeeLevelOptions'][$i] : null);
                                                                    echo data_get($element, 'title');
                                                                    ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table_employees">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Tên đăng nhập</td>
                                        <td>Mã KR</td>
                                        <td>Họ tên</td>
                                        <td>Chức vụ</td>
                                        <td>Đơn vị kinh doanh</td>
                                        <td>Kênh phân phối</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['users'] as $user) : ?>
                                        <tr>
                                            <th><?php echo $user->id ?></th>
                                            <th><?php echo $user->user_name ?></th>
                                            <th><?php echo $user->user_code ?></th>
                                            <th><?php echo $user->full_name ?></th>
                                            <th><?php
                                                $i = array_search($user->level_id, array_column($_SESSION['employeeLevelOptions'], 'value'));
                                                $element = ($i !== false ? $_SESSION['employeeLevelOptions'][$i] : null);
                                                echo $element['title'] ?? null;
                                                ?></th>

                                            <th><?php echo $user->business_unit_id ?></th>
                                            <th><?php echo $user->channel_id ?></th>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
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
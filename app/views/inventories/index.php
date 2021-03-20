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
                            <h4 class="card-title mb-0">Bảng nhập sản phẩm</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table_employees">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Mã vật tư</td>
                                        <td>Tên vật tư</td>
                                        <td>Model</td>
                                        <td>Đơn vị kinh doanh</td>
                                        <td>Ngành hàng</td>
                                        <td>Nhóm hàng</td>
                                        <th data-editable="true">Tháng 1</th>
                                        <th data-editable="true">Tháng 2</th>
                                        <th data-editable="true">Tháng 3</th>
                                        <th data-editable="true">Tháng 4</th>
                                        <th data-editable="true">Tháng 5</th>
                                        <th data-editable="true">Tháng 6</th>
                                        <th data-editable="true">Tháng 7</th>
                                        <th data-editable="true">Tháng 8</th>
                                        <th data-editable="true">Tháng 9</th>
                                        <th data-editable="true">Tháng 10</th>
                                        <th data-editable="true">Tháng 11</th>
                                        <th data-editable="true">Tháng 12</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['inventories'] as $inventory) : ?>
                                        <tr>
                                            <th><?php echo $inventory->id ?></th>
                                            <th><?php echo $inventory->product_code ?></th>
                                            <th><?php echo $inventory->name ?></th>
                                            <th><?php echo $inventory->model ?></th>
                                            <th><?php echo $inventory->business_unit_id ?></th>
                                            <th><?php echo $inventory->industry_id ?></th>
                                            <th><?php echo $inventory->product_type_id ?></th>
                                            <?php for ($i = 0; $i < 12; $i++) : ?>

                                            <?php endfor ?>
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
require APPROOT . '/views/base/footer.php';
?>
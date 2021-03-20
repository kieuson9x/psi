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
                            <h4 class="card-title mb-0">Danh sách đại lý</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table_employees">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Tên đại lý</td>
                                        <td>Tỉnh</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['agencies'] as $agency) : ?>
                                        <tr>
                                            <th><?php echo $agency->id ?></th>
                                            <th><?php echo $agency->name ?></th>
                                            <th><?php echo $agency->province ?></th>
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
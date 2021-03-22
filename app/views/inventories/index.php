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
                            <form id="year-selection" method="GET" action="<?php echo URLROOT; ?>/inventories/index">
                                <div class="form-group row">
                                    <label for="year" class="col-xs-2 col-form-label mr-2">Năm</label>
                                    <div class="col-xs-4 mr-2">
                                        <select id="year-selection" class="form-control" id="year" name="year">
                                            <?php for ($i = date('Y') - 1; $i <= date('Y') + 2; $i++) : ?>
                                                <option value="<?php echo $i ?>" <?php if ($i === $data['year']) echo "selected" ?>><?php echo $i ?></option>
                                            <?php endfor ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-1 w-40  flex items-center justify-center">
                                        <i class="material-icons">filter_alt</i>
                                        Lọc
                                    </button>

                                    <div class="col-xs-4">
                                        <a href="#addProductPlanModal" class="btn btn-success flex items-center justify-center" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Thêm/Cập nhật kế hoạch
                                                mới</span></a>
                                    </div>
                                </div>

                            </form>

                            <table class="table table-striped" id="table_inventories">
                                <thead>
                                    <tr>
                                        <td rowspan="2">ID</td>
                                        <td rowspan="2">Mã vật tư</td>
                                        <td rowspan="2">Tên vật tư</td>
                                        <td rowspan="2">Model</td>
                                        <td rowspan="2">Đơn vị kinh doanh</td>
                                        <td rowspan="2">Ngành hàng</td>
                                        <td rowspan="2">Nhóm hàng</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <th data-editable="true" colspan="3"><?php echo "Tháng {$i}"; ?></th>

                                        <?php endfor ?>
                                    </tr>

                                    <tr>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <th data-editable="true">P</th>
                                            <th>S</th>
                                            <th data-editable="true">I</th>
                                        <?php endfor ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['inventories'] as $inventory) : ?>
                                        <tr>
                                            <td class="not-editable"><?php echo data_get($inventory, '0.product_id') ?></th>
                                            <td class="not-editable"><?php echo data_get($inventory, '0.product_code') ?></th>
                                            <td class="not-editable"><?php echo data_get($inventory, '0.name') ?></th>
                                            <td class="not-editable"><?php echo data_get($inventory, '0.model') ?></th>
                                            <td class="not-editable"><?php
                                                                        $value = data_get($inventory, '0.business_unit_id');
                                                                        $key = array_search($value, array_column($_SESSION['businessUnitOptions'], 'value'));
                                                                        echo data_get($_SESSION, "businessUnitOptions.{$key}.title");
                                                                        ?></th>
                                            <td class="not-editable"><?php
                                                                        $value = data_get($inventory, '0.industry_id');
                                                                        $key = array_search($value, array_column($_SESSION['industryOptions'], 'value'));
                                                                        echo data_get($_SESSION, "industryOptions.{$key}.title");
                                                                        ?></th>
                                            <td class="not-editable"><?php
                                                                        $value = data_get($inventory, '0.product_type_id');
                                                                        $key = array_search($value, array_column($_SESSION['productTypeOptions'], 'value'));
                                                                        echo data_get($_SESSION, "productTypeOptions.{$key}.title");
                                                                        ?></th>
                                                <?php for ($i = 0; $i < 12; $i++) : ?>
                                            <td data-type="text" data-state="purchase" data-name="<?php echo $i + 1 ?>" data-pk="<?php echo data_get($inventory, '0.product_id') ?>"><?php
                                                                                                                                                                                        $key = array_search($i + 1, array_column($inventory, 'month'));
                                                                                                                                                                                        if ($key !== false) {
                                                                                                                                                                                            echo data_get($inventory, "{$key}.number_of_imported_goods", 0);
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo 0;
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>
                                                </th>
                                            <td class="not-editable" data-state="sale"><?php
                                                                                        $key = array_search($i + 1, array_column($inventory, 'month'));
                                                                                        if ($key !== false) {
                                                                                            echo data_get($inventory, "{$key}.number_of_sale_goods", 0);
                                                                                        } else {
                                                                                            echo 0;
                                                                                        }
                                                                                        ?>
                                                </th>
                                            <td data-type="text" data-state="inventory" data-name="<?php echo $i + 1 ?>" data-pk="<?php echo data_get($inventory, '0.product_id') ?>"><?php
                                                                                                                                                                                        $key = array_search($i + 1, array_column($inventory, 'month'));
                                                                                                                                                                                        if ($key !== false) {
                                                                                                                                                                                            echo data_get($inventory, "{$key}.number_of_remaining_goods", 0);
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo 0;
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>
                                                </th>
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

    {{-- Thêm mới --}}
    <div id="addProductPlanModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="add_inventory" method="POST" action="<?php echo URLROOT; ?>/inventories/create" class="form-horizontal">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm/cập nhật mới kế hoạch</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Sản phẩm</label>
                            <select id="product-selection" class="form-control" name="product_id" data-live-search="true" style="width: 100%"></select>
                        </div>

                        <div class="form-group row">
                            <label>Năm</label>
                            <select id="year-selection_create" class="form-control" id="year" name="year">
                                <?php for ($i = date('Y') - 1; $i <= date('Y') + 2; $i++) : ?>
                                    <option value="<?php echo $i ?>" <?php if ($i === $data['year']) echo "selected" ?>><?php echo $i ?></option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label>Tháng</label>
                            <div class="form-group">
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="months[]" value="<?php echo $i ?>">
                                        <label class="form-check-label" for="month_<?php echo $i ?>">Tháng <?php echo $i ?></label>
                                    </div>
                                <?php endfor ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label>Số lượng nhập</label>
                            <input type="text" class="form-control" name="number_of_imported_goods">
                        </div>

                        <!-- <div class="form-group row">
                            <label>Số lượng tồn</label>
                            <input type="text" class="form-control" name="number_of_remaining_goods">
                        </div> -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="add_inventory" class="btn btn-success" data-dismiss="modal">Thêm</button>
                        <button type="button" id="cancel_add_inventory" class="btn btn-secondary mr-1" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        require APPROOT . '/views/base/script.php';
        ?>

        <script>
            $(function() {
                // var toast = new Toasty();
                $('#table_inventories').DataTable({
                    responsive: true,
                    ordering: false,
                });

                $('#table_inventories tbody tr td:not(.not-editable)').editable({
                    send: 'always',
                    type: 'text',
                    url: "<?php echo URLROOT; ?>" + "/inventories/update",
                    params: function(params) {
                        var state = $(this).attr('data-state');
                        params.year = 2021;
                        params.state = state;

                        return params;
                    },
                    validate: function(value) {
                        if (!Number.isInteger(parseFloat(value))) {
                            return 'Chỉ nhập số nguyên';
                        }
                    },
                    success: function(response, newValue) {
                        if (response && response.success) {
                            toastr.success("Cập nhật thành công!");
                        } else {
                            toastr.error("Cập nhật không thành công!");
                        }
                    },
                    ajaxOptions: {
                        type: 'POST',
                        dataType: 'json',
                    }
                });

                $('#product-selection').select2({
                    placeholder: 'Chọn sản phẩm',
                    ajax: {
                        url: "/products/search",
                        dataType: 'json',
                        delay: 250,
                        type: "POST",
                        data: function(data) {
                            return {
                                query: data.term // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response
                            };
                        },
                    }
                });

                $('#add_inventory').on('click', function(e) {
                    e.preventDefault();
                    var data = $("form[name=add_inventory]").serialize();


                    $.ajax({
                        url: "<?php echo URLROOT; ?>/inventories/create",
                        type: "POST",
                        data: data,
                        success: function(response) {
                            var response = JSON.parse(response);
                            if (response.success) {
                                location.reload();
                                toastr.success("Cập nhật thành công!");
                                $("form[name=add_inventory]").trigger("reset");
                            } else {
                                toastr.error("Cập nhật không thành công!");
                            }
                        }
                    });
                })

                $('#cancel_add_inventory').on('click', function(e) {
                    e.preventDefault();
                    $("form[name=add_inventory]").trigger("reset");
                })



            });
        </script>

        <?php
        require APPROOT . '/views/base/footer.php';
        ?>
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
                            <h4 class="card-title mb-0">Bảng nhập sale theo sản phẩm</h4>
                        </div>
                        <div class="card-body">
                            <form id="year-selection" method="GET" action="<?php echo URLROOT; ?>/employee-sales/index">
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
                                        <a href="#addSaleModal" class="btn btn-success flex items-center justify-center" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Thêm/Cập nhật số sale
                                                mới</span></a>
                                    </div>
                                </div>

                            </form>

                            <table class="table table-striped" id="table_agency_sales">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <!-- <td>Mã vật tư</td> -->
                                        <td>Tên vật tư</td>
                                        <!-- <td>Model</td> -->
                                        <!-- <td>Đơn vị kinh doanh</td> -->
                                        <!-- <td>Ngành hàng</td> -->
                                        <!-- <td>Nhóm hàng</td> -->
                                        <td>Đại lý</td>
                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                            <th data-editable="true"><?php echo "Tháng {$i}"; ?></th>
                                        <?php endfor ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['agency_sales'] as $sale) : ?>
                                        <tr>
                                            <td class="not-editable"><?php echo data_get($sale, '0.product_id') ?></th>
                                                <!-- <td class="not-editable"><?php echo data_get($sale, '0.product_code') ?></th> -->
                                            <td class="not-editable"><?php echo data_get($sale, '0.name') ?></th>
                                                <!-- <td class="not-editable"><?php echo data_get($sale, '0.model') ?></th> -->
                                                <!-- <td class="not-editable"><?php
                                                                                $value = data_get($sale, '0.business_unit_id');
                                                                                $key = array_search($value, array_column($_SESSION['businessUnitOptions'], 'value'));
                                                                                echo data_get($_SESSION, "businessUnitOptions.{$key}.title");
                                                                                ?></th>
                                            <td class="not-editable"><?php
                                                                        $value = data_get($sale, '0.industry_id');
                                                                        $key = array_search($value, array_column($_SESSION['industryOptions'], 'value'));
                                                                        echo data_get($_SESSION, "industryOptions.{$key}.title");
                                                                        ?></th>
                                            <td class="not-editable"><?php
                                                                        $value = data_get($sale, '0.product_type_id');
                                                                        $key = array_search($value, array_column($_SESSION['productTypeOptions'], 'value'));
                                                                        echo data_get($_SESSION, "productTypeOptions.{$key}.title");
                                                                        ?></th> -->
                                            <td class="not-editable"><?php
                                                                        $value = data_get($sale, '0.agency_id');
                                                                        $key = array_search($value, array_column($_SESSION['agencyOptions'], 'value'));
                                                                        echo data_get($_SESSION, "agencyOptions.{$key}.title");
                                                                        ?></th>
                                                <?php for ($i = 0; $i < 12; $i++) : ?>
                                            <td data-state="sale" data-agency-id="<?php echo data_get($sale, '0.agency_id') ?>" data-name="<?php echo $i + 1 ?>" data-pk="<?php echo data_get($sale, '0.product_id') ?>"><?php
                                                                                                                                                                                                                            $key = array_search($i + 1, array_column($sale, 'month'));
                                                                                                                                                                                                                            if ($key !== false) {
                                                                                                                                                                                                                                echo data_get($sale, "{$key}.number_of_sale_goods", 0);
                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                echo 0;
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            ?>
                                                </th>
                                            <?php endfor ?>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addSaleModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="add_agency_sales" method="POST" action="<?php echo URLROOT; ?>/employee-sales/create" class="form-horizontal">
                    <div class="modal-header">
                        <h4 class="modal-title">Thêm/cập nhật mới số sales</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label>Sản phẩm</label>
                            <select id="product-selection" class="form-control" required name="product_id" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>

                        <div class="form-group row">
                            <label>Đại lý</label>
                            <select id="agency-selection" class="form-control" required name="agency_id" data-live-search="true" style="width: 100%"></select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>

                        <div class="form-group row">
                            <label>Năm</label>
                            <select id="year-selection_create" class="form-control" id="year" name="year" required>
                                <?php for ($i = date('Y') - 1; $i <= date('Y') + 2; $i++) : ?>
                                    <option value="<?php echo $i ?>" <?php if ($i === $data['year']) echo "selected" ?>><?php echo $i ?></option>
                                <?php endfor ?>
                            </select>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
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
                            <label>Số lượng sales</label>
                            <input type="number" class="form-control" name="number_of_sale_goods" required>
                            <div class="invalid-feedback">
                                Trường này bắt buộc nhập!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="add_agency_sale" class="btn btn-success" data-dismiss="modal">Thêm</button>
                        <button type="button" id="cancel_add_agency_sale" class="btn btn-secondary mr-1" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        require APPROOT . '/views/base/script.php';
        ?>

        <script>
            $(function() {
                $('#table_agency_sales').DataTable({
                    responsive: true,
                    ordering: false,
                });

                $('#table_agency_sales tbody tr td:not(.not-editable)').editable({
                    send: 'always',
                    type: 'text',
                    url: "<?php echo URLROOT; ?>/employee-sales/update",
                    params: function(params) {
                        var state = $(this).attr('data-state');
                        var agencyId = $(this).attr('data-agency-id');
                        params.year = 2021;
                        params.state = state;
                        params.agency_id = agencyId;

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

                $('#agency-selection').select2({
                    placeholder: 'Chọn đại lý',
                    ajax: {
                        url: "/agencies/search",
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

                $('#add_agency_sale').on('click', function(e) {
                    e.preventDefault();

                    //Fetch form to apply custom Bootstrap validation
                    var form = $("form[name=add_agency_sales]");

                    if (form[0].checkValidity() === false) {
                        e.stopPropagation()
                    }

                    form.addClass('was-validated');

                    var data = form.serialize();

                    if (form[0].checkValidity()) {
                        $.ajax({
                            url: "<?php echo URLROOT; ?>/employee-sales/create",
                            data: data,
                            type: 'post',
                            success: function(response) {
                                var response = JSON.parse(response);
                                if (response.success) {
                                    location.reload();
                                    toastr.success("Cập nhật thành công!");
                                    $("form[name=add_agency_sales]").trigger("reset");
                                } else {
                                    toastr.error("Cập nhật không thành công!");
                                }
                            }
                        });
                    }

                })

                $('#cancel_add_agency_sale').on('click', function(e) {
                    e.preventDefault();
                    $("form[name=add_agency_sales]").trigger("reset");
                })



            });
        </script>

        <?php
        require APPROOT . '/views/base/footer.php';
        ?>
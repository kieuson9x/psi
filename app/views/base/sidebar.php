<nav class="sidebar active" id="sidebar">
        <ul class="nav">
                <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>">
                                <i class="material-icons" style="font-size: 13px">
                                        dashboard
                                </i>
                                Trang chủ
                        </a>
                </li>


                <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#employees" aria-expanded="false" aria-controls="employees">
                                <i class="material-icons" style="font-size: 13px">person</i>
                                <span class="menu-title">Nhân viên</span>
                                <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="employees">
                                <ul class="nav flex-column sub-menu">
                                        <ul class="nav flex-column sub-menu">
                                                <li class="nav-item"><a class="nav-link" href="<?php
                                                                                                $i = array_search("Quản lý khu vực", array_column($data['employeeLevelOptions'], 'title'));
                                                                                                $element = ($i !== false ? $data['employeeLevelOptions'][$i] : null);
                                                                                                $id = data_get($element, 'value');

                                                                                                echo URLROOT . '/employees?level_id=' . $id
                                                                                                ?>" departmentId="1">Nhân viên Quản lý khu vực</a>
                                                </li>
                                        </ul>
                                </ul>
                        </div>
                </li>

                <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT; ?>">
                                <i class="material-icons" style="font-size: 13px">business_center</i>
                                Danh sách đại lý
                        </a>
                </li>
        </ul>
</nav>
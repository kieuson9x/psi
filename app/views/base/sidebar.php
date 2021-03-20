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

                <?php if (isset($_SESSION['user_id'])) : ?>
                        <?php
                        $i = array_search($_SESSION['level_id'], array_column($_SESSION['employeeLevelOptions'], 'value'));
                        $element = ($i !== false ? $_SESSION['employeeLevelOptions'][$i] : null);
                        $title = data_get($element, 'title');

                        if ($title == 'Quản lý khu vực' || $title == 'Admin') :
                        ?>
                                <li class="nav-item">
                                        <a class="nav-link" href="<?php echo URLROOT . "/agencies" ?>">
                                                <i class="material-icons" style="font-size: 13px">business_center</i>
                                                Danh sách đại lý
                                        </a>
                                </li>
                        <?php endif; ?>
                <?php endif; ?>
        </ul>
</nav>
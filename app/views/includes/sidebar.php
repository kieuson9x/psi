<nav class="sidebar active" id="sidebar">
        <ul class="nav">
                <li class="nav-item">
                        <a class="nav-link {{ (request()->routeIs('employees*')) ? 'active' : '' }}" href="/">
                                <i class="material-icons" style="font-size: 13px">
                                        dashboard
                                </i>
                                Trang chủ
                        </a>
                </li>


                <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#departments" aria-expanded="false" aria-controls="product_plans">
                                <i class="material-icons" style="font-size: 13px">doorbell</i>
                                <span class="menu-title">Bộ phận</span>
                                <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="departments">
                                <ul class="nav flex-column sub-menu">
                                        <ul class="nav flex-column sub-menu">
                                                <li class="nav-item"><a class="nav-link" href="/departments/1" departmentId="1">Ban Giám đốc</a>
                                                </li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/2" departmentId="2">Phòng Hành
                                                                chính-Nhân sự</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/3" departmentId="3">Phòng Tài
                                                                chính-Kế toán</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/4" departmentId="4">Kế hoạch điều độ
                                                                nhà máy</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/5" departmentId="5">Phòng Kỹ thuật
                                                                nhà máy</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/6" departmentId="6">Phòng kho linh
                                                                kiện vật tư sản xuất</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/7" departmentId="7">Phòng Cung ứng
                                                                Nhà máy</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/8" departmentId="8">Phòng QC Nhà
                                                                máy</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/9" departmentId="9">Phân xưởng
                                                                BNN</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/10" departmentId="10">Phân xưởng
                                                                RO</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/11" departmentId="11">Phân xưởng
                                                                Inox</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/12" departmentId="12">Phân xưởng
                                                                NLMT</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/13" departmentId="13">Phân xưởng Điện
                                                                lạnh</a></li>
                                                <li class="nav-item"><a class="nav-link" href="/departments/14" departmentId="14">Phân xưởng Bếp
                                                                Điện từ</a></li>
                                        </ul>
                                </ul>
                        </div>
                </li>
        </ul>
</nav>
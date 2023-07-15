<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>
                @if (Auth::user()->id_roles == 1)
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-dashboards">Admin</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin/portofoliobeli" key="t-default">Portofolio User</a></li>
                        <li><a href="/admin/post" key="t-saas">Analyst Post</a></li>
                        <li><a href="/admin/emiten" key="t-crypto">List Emiten</a></li>
                        <li><a href="/admin/sekuritas" key="t-crypto">Data Sekuritas</a></li>
                    </ul>
                </li>
                @else
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/portofoliobeli" key="t-default">Portofolio</a></li>
                        <li><a href="/report" key="t-saas">Report</a></li>
                        <li><a href="/reportporto" key="t-crypto">Rekapitulasi Range</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-layout"></i>
                        <span key="t-dashboards">Other Menu</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/search" key="t-default">Emiten</a></li>
                        <li><a href="/post" key="t-saas">Analyst Post</a></li>
                        @if (Auth::user()->id_roles == 2)
                        <li><a href="/post/manage" key="t-saas">Manage Your Post</a></li>
                        <li><a href="/plan/manage" key="t-saas">Manage Your Subscription Plan</a></li>
                        @endif
                    </ul>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
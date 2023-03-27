<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="/portofoliobeli/{{Auth::id()}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Portofolio</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/reportbeli/{{Auth::id()}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Report dan Rekapitulasi</p>
          </a>
        </li>
      </ul>
    </li>
    <li class="nav-item">
      <a href="/stock" class="nav-link">
        <i class="fas fa-line-chart nav-icon"></i>
        <p>Emiten Saham</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="/post" class="nav-link">
        <i class="fas fa-circle nav-icon"></i>
        <p>Analyst Post</p>
      </a>
    </li>

</nav>
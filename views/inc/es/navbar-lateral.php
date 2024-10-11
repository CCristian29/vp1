  <ul class="navbar-nav nav-lateral sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo SERVERURL . DASHBOARD; ?>/home/">
          <div class="sidebar-brand-icon rotate-n-15">
              <img class="ml-1" src="<?= SERVERURL; ?>views/assets/img/LOGOPEDCER.png" width="30px">

          </div>
          <div class="sidebar-brand-text mx-3">virtualpedcer</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
          <a class="nav-link" href="<?php echo SERVERURL . DASHBOARD; ?>/home/">
              <i class="fas fa-fw fa-tachometer-alt"></i>
              <span>INICIO</span>
          </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          Interface
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <?php if ($_SESSION['rol_virtual'] == 1) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                  <i class="fas fa-user-secret fa-fw "></i>
                  <span>Administrador</span>
              </a>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Opciones:</h6>
                      <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/new-user/">Agregar administrador</a>
                      <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/lista-administradores/">Lista de administradores</a>
                  </div>
              </div>
          </li>
      <?php } ?>

      <!-- Nav Item - Utilities Collapse Menu -->
      <?php if ($_SESSION['rol_virtual'] == 1) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                  <i class="fas fa-user fa-user"></i>
                  <span>Clientes</span>
              </a>
              <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Opciones:</h6>
                      <a class="collapse-item" href="<?php echo SERVERURL . DASHBOARD; ?>/lista-clientes/">ver lista de clientes</a>
                  </div>
              </div>
          </li>
      <?php } ?>

      <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitie" aria-expanded="true" aria-controls="collapseUtilitie">
              <i class="fas fa-box"></i>
              <span>Productos</span>
          </a>

          <div id="collapseUtilitie" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <h6 class="collapse-header">Opciones:</h6>
                  <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/ver-producto/">ver productos</a>
                  <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/new-product/">Agregar productos</a>
              </div>
          </div>
      </li>

      <!-- categorias -->
      <?php if ($_SESSION['rol_virtual'] == 1 && 2) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categoria" aria-expanded="true" aria-controls="categoria">
                  <i class="fa-solid fa-tags"></i>
                  <span>Categorias</span>
              </a>
              <div id="categoria" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Opciones:</h6>
                      <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/category-new/">Nueva categoria</a>
                      <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/category-list/">Lista de categorias</a>
                  </div>
              </div>
          </li>
      <?php } ?>

      <!-- PQRS -->
      <?php if ($_SESSION['rol_virtual'] == 1) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pqrs" aria-expanded="true" aria-controls="pqrs">
                  <i class="fas fa-comments"></i>
                  <span>PQRS</span>
              </a>
              <div id="pqrs" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Opciones:</h6>
                      <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/ver-pqrs/">Ver pqrs</a>
                  </div>
              </div>
          </li>
      <?php } ?>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
          mas
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <?php if ($_SESSION['rol_virtual'] == 1) { ?>
          <li class="nav-item">
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                  <i class="fa-solid fa-gear"></i>
                  <span>Configuraciones</span>
              </a>
              <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                  <div class="bg-white py-2 collapse-inner rounded">
                      <h6 class="collapse-header">Opciones:</h6>
                      <a class="collapse-item" href="<?= SERVERURL . DASHBOARD; ?>/empresa/">Empresa</a>
                  </div>
              </div>
          </li>
      <?php } ?>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
          <a class="nav-link" href="<?= SERVERURL; ?>index/">
              <i class="fa-solid fa-house"></i>
              <span>Pagina principal</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
  </ul>
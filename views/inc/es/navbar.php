 <nav class="navbar navbar-expand-lg fixed-top">
     <div class="container-fluid">
         <a href="<?= SERVERURL; ?>index/">
             <img class="navbar-brand" src="<?= SERVERURL; ?>views/assets/img/LOGOPEDCER.png" width="20px">
         </a>
         <div class="offcanvas offcanvas-end bg-black" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
             <div class="offcanvas-header">
                 <h5 class="offcanvas-title text-white" id="offcanvasNavbarLabel">PEDCER</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-square-xmark fa-xl text-white"></i></button>
             </div>
             <div class="offcanvas-body">
                 <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                     <li class="nav-item">
                         <a class="nav-link nav-li mx-lg-2" href="<?= SERVERURL; ?>index/">INICIO</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link nav-li mx-lg-2" href="<?= SERVERURL; ?>productos/">PRODUCTOS</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link nav-li mx-lg-2" href="<?= SERVERURL; ?>pqrs-usuario/">PQRS</a>
                     </li>
                 </ul>
             </div>

         </div>
         <div class="d-flex align-items-center">
             <a href="<?php echo SERVERURL; ?>carrito/" class="nav-link  header-button position-relative me-2 text-center" title="Carrito">
                 <i class="fas fa-shopping-cart fa-fw"></i>
                 <span class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger text-white">
                     2
                 </span>
             </a>

             <?php if (isset($_SESSION['id_virtual']) && $_SESSION['id_virtual'] == true) { ?>
                 <ul class="list-unstyled mb-0 m-2">
                     <li class="nav-item dropdown no-arrow">
                         <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <img class="img-profile rounded-circle" src="<?= SERVERURL; ?>/views/assets/img/admin.jpg" width="30px">
                         </a>
                         <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                             <?php if ($_SESSION['rol_virtual'] == 1 || $_SESSION['rol_virtual'] == 2) { ?>
                                 <a class="dropdown-item" href="<?php echo SERVERURL . DASHBOARD; ?>/perfil-admin/">
                                     <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Perfil
                                 </a>

                                 <a class="dropdown-item" href="<?= SERVERURL . DASHBOARD; ?>/home/">
                                     <i class="fas fa-user-secret fa-fw text-gray-400 "></i> Dashboard
                                 </a>
                             <?php } else { ?>
                                 <a class="dropdown-item" href="<?php echo SERVERURL; ?>perfil/">
                                     <i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i> Perfil
                                 </a>
                             <?PHP } ?>
                             <div class="dropdown-divider"></div>
                             <a class="btn-exit-system dropdown-item" href="#">
                                 <i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i> Cerrar Sesión
                             </a>
                         </div>
                     </li>
                 </ul>
             <?php } else { ?>
                 <a href="<?= SERVERURL; ?>singin/"><button class="btn btn-primary">Ingresar</button></a>
             <?php } ?>

             <button class="btn btn-white navbar-toggler m-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                 <i class="fa-solid fa-bars"></i>
             </button>
         </div>
     </div>

 </nav>
  <div class="main-panel">
      <div class="main-header">
          <div class="main-header-logo">
              <!-- Logo Header -->
              <div class="logo-header" data-background-color="dark">
                  <a href="index.html" class="logo">
                      <img
                          src="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/logo_light.svg"
                          alt="navbar brand"
                          class="navbar-brand"
                          height="20" />
                  </a>
                  <div class="nav-toggle">
                      <button class="btn btn-toggle toggle-sidebar">
                          <i class="gg-menu-right"></i>
                      </button>
                      <button class="btn btn-toggle sidenav-toggler">
                          <i class="gg-menu-left"></i>
                      </button>
                  </div>
                  <button class="topbar-toggler more">
                      <i class="gg-more-vertical-alt"></i>
                  </button>
              </div>
              <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
              class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
              <div class="container-fluid">
                  <span id="datetime" class="fw-bold text-dark" style="font-size: 20px;"></span>
                  <!-- Tombol Dark Mode -->
                  <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                      <li class="nav-item me-3">
                          <button id="darkModeToggle" class="btn btn-sm btn-secondary">
                              🌙 Dark Mode
                          </button>
                      </li>
                      <li class="nav-item topbar-user dropdown hidden-caret">
                          <a
                              class="dropdown-toggle profile-pic"
                              data-bs-toggle="dropdown"
                              href="#"
                              aria-expanded="false">
                              <div class="avatar-sm">
                                  <img
                                      src="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/orang.png"
                                      alt="..."
                                      class="avatar-img rounded-circle" />
                              </div>
                          </a>
                          <ul class="dropdown-menu dropdown-user animated fadeIn">
                              <div class="dropdown-user-scroll scrollbar-outer">
                                  <li class="d-flex align-items-center gap-1 ps-3"> <!-- gap lebih besar + padding kiri -->
                                      <?php if ($_SESSION['level'] === 'siswa'): ?>
                                          <i class="fas fa-user-graduate text-success fs-5"></i>
                                          <span class="fw-bold">Siswa:</span>
                                          <span><?= htmlspecialchars($_SESSION['nama']) ?></span>

                                      <?php elseif ($_SESSION['level'] === 'petugas'): ?>
                                          <i class="fas fa-user-tie text-primary fs-5"></i>
                                          <span class="fw-bold">Petugas:</span>
                                          <span><?= htmlspecialchars($_SESSION['nama_petugas']) ?></span>

                                      <?php elseif ($_SESSION['level'] === 'admin'): ?>
                                          <i class="fas fa-user-shield text-danger fs-5"></i>
                                          <span class="fw-bold">Admin:</span>
                                          <span><?= htmlspecialchars($_SESSION['nama_petugas']) ?></span>
                                      <?php endif; ?>
                                  </li>

                              </div>
                          </ul>
                      </li>
                      <style>
                          /* Nonaktifkan hover pada profile dropdown */
                          .topbar-user.dropdown .profile-pic:hover,
                          .topbar-user.dropdown .profile-pic:focus {
                              background-color: transparent !important;
                              /* tidak berubah warna */
                              color: inherit !important;
                              /* tetap warna default */
                              box-shadow: none !important;
                              /* hilangkan efek bayangan */
                          }
                      </style>
                  </ul>
              </div>
          </nav>
          <script>
              function updateDateTime() {
                  const now = new Date();

                  // Format tanggal (contoh: Kamis, 11 September 2025)
                  const options = {
                      weekday: 'long',
                      year: 'numeric',
                      month: 'long',
                      day: 'numeric'
                  };
                  const date = now.toLocaleDateString('id-ID', options);

                  // Format jam (contoh: 08:45:12)
                  const time = now.toLocaleTimeString('id-ID');

                  // Gabungkan hasil
                  document.getElementById('datetime').innerHTML = date + " - " + time;
              }

              // Jalankan tiap detik
              setInterval(updateDateTime, 1000);
              updateDateTime();
          </script>
          <script>
              const toggle = document.getElementById("darkModeToggle");
              toggle.addEventListener("click", function() {
                  document.body.classList.toggle("dark-mode");
                  if (document.body.classList.contains("dark-mode")) {
                      toggle.innerHTML = "☀️ Light Mode";
                  } else {
                      toggle.innerHTML = "🌙 Dark Mode";
                  }
              });
          </script>

          <style>
              /* ======== GLOBAL DARK MODE ======== */
              body.dark-mode {
                  background-color: #121212 !important;
                  color: #f1f1f1 !important;
              }

              /* ======== NAVBAR ======== */
              body.dark-mode .navbar,
              body.dark-mode .main-header,
              body.dark-mode .logo-header {
                  background-color: #1e1e1e !important;
                  border-bottom: 1px solid #333 !important;
              }

              /* ======== SIDEBAR ======== */
              body.dark-mode .sidebar,
              body.dark-mode .sidebar .nav,
              body.dark-mode .sidebar .nav-item,
              body.dark-mode .sidebar .nav-link {
                  background-color: #1e1e1e !important;
                  color: #f1f1f1 !important;
              }

              body.dark-mode .sidebar .nav-link.active,
              body.dark-mode .sidebar .nav-link:hover {
                  background-color: #2a2a2a !important;
                  color: #ffffff !important;
              }

              /* ======== FOOTER ======== */
              body.dark-mode footer,
              body.dark-mode .footer {
                  background-color: #1e1e1e !important;
                  color: #f1f1f1 !important;
                  border-top: 1px solid #333 !important;
              }

              /* ======== DROPDOWN ======== */
              body.dark-mode .dropdown-menu {
                  background-color: #2a2a2a !important;
                  color: #fff !important;
              }

              body.dark-mode .dropdown-menu .dropdown-item {
                  color: #f1f1f1 !important;
              }

              body.dark-mode .dropdown-menu .dropdown-item:hover {
                  background-color: #444 !important;
                  color: #fff !important;
              }

              /* ======== PROFILE TEXT ======== */
              body.dark-mode .profile-username,
              body.dark-mode .profile-username .op-7,
              body.dark-mode .profile-username .fw-bold,
              body.dark-mode .u-text h4,
              body.dark-mode .u-text p {
                  color: #f1f1f1 !important;
              }

              /* ======== DATETIME ======== */
              body.dark-mode #datetime {
                  color: #f1f1f1 !important;
              }

              /* ======== CARD ======== */
              body.dark-mode .card {
                  background-color: #2a2a2a !important;
                  color: #f1f1f1 !important;
                  border: 1px solid #333 !important;
              }

              body.dark-mode .card-header {
                  background-color: #1e1e1e !important;
                  border-bottom: 1px solid #444 !important;
                  color: #f1f1f1 !important;
              }

              body.dark-mode .card-body,
              body.dark-mode .card-body * {
                  color: #f1f1f1 !important;
              }

              /* ======== TABLE FORM INPUT / EDIT DARK MODE ======== */
              body.dark-mode input,
              body.dark-mode select,
              body.dark-mode textarea {
                  background-color: #2a2a2a !important;
                  color: #f1f1f1 !important;
                  border: 1px solid #444 !important;
              }

              body.dark-mode input::placeholder,
              body.dark-mode textarea::placeholder {
                  color: #999 !important;
                  opacity: 1;
              }

              body.dark-mode select option {
                  background-color: #2a2a2a !important;
                  color: #f1f1f1 !important;
              }

              /* ======== TABLE DARK MODE ======== */
              body.dark-mode table,
              body.dark-mode table thead,
              body.dark-mode table tbody,
              body.dark-mode table tfoot,
              body.dark-mode table th,
              body.dark-mode table td {
                  background-color: #1e1e1e !important;
                  color: #f1f1f1 !important;
                  border-color: #333 !important;
              }

              body.dark-mode table thead th {
                  background-color: #1e1e1e !important;
                  color: #ffffff !important;
                  border-color: #444 !important;
              }

              body.dark-mode table tbody tr:nth-of-type(odd) {
                  background-color: #2a2a2a !important;
              }

              body.dark-mode table tbody tr:nth-of-type(even) {
                  background-color: #1e1e1e !important;
              }

              body.dark-mode table tbody tr:hover {
                  background-color: #3a3a3a !important;
                  color: #ffffff !important;
              }

              /* ======== PAGINATION DARK MODE ======== */
              body.dark-mode .pagination .page-link {
                  background-color: #2a2a2a !important;
                  color: #f1f1f1 !important;
                  border: 1px solid #444 !important;
              }

              body.dark-mode .pagination .page-link:hover,
              body.dark-mode .pagination .page-link:focus {
                  background-color: #3a3a3a !important;
                  color: #ffffff !important;
              }

              body.dark-mode .pagination .page-item.disabled .page-link {
                  color: #999 !important;
                  background-color: #2a2a2a !important;
                  border-color: #444 !important;
              }

              /* ======== BUTTON ======== */
              body.dark-mode .btn-primary {
                  background-color: #1976d2 !important;
                  border-color: #1976d2 !important;
              }

              body.dark-mode .btn-warning {
                  background-color: #f57c00 !important;
                  border-color: #f57c00 !important;
                  color: #fff !important;
              }

              body.dark-mode .btn-danger {
                  background-color: #d32f2f !important;
                  border-color: #d32f2f !important;
                  color: #fff !important;
              }

              body.dark-mode .btn-secondary {
                  background-color: #555 !important;
                  border-color: #555 !important;
                  color: #fff !important;
              }

              body.dark-mode .table-data-title {
                  color: #ffffff !important;
              }
          </style>
          <!-- End Navbar -->
      </div>
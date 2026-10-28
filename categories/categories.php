<?php
session_start(); // Panggil session di awal halaman
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" href="../assets/icon.png" />
    <link rel="stylesheet" href="../css/admin.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catshop Admin | Categories</title>
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class="bx bx-category"></i>
            <span class="logo_name">CatShop</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="../admin.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../categories/categories.php" class="active">
                    <i class="bx bx-box"></i>
                    <span class="links_name">Categories</span>
                </a>
            </li>
            <li>
                <a href="../transaction/transaction.php">
                    <i class="bx bx-list-ul"></i>
                    <span class="links_name">Transaction</span>
                </a>
            </li>
            <li>
                <a href="../login.php">
                    <i class="bx bx-log-out"></i>
                    <span class="links_name">Log out</span>
                </a>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class="bx bx-menu sidebarBtn"></i>
            </div>
            <div class="profile-details">
                <span class="admin_name">Catshop Admin</span>
            </div>
        </nav>
        <div class="home-content">
            <h3>Categories</h3>
            <button type="button" class="btn btn-tambah">
                <a href="categories-entry.php">Tambah Data</a>
            </button>
            <table class="table-data">
                <thead>
                    <tr>
                        <th scope="col" style="width: 20%">Photo</th>
                        <th>Categories</th>
                        <th scope="col" style="width: 20%">Description</th>
                        <th scope="col" style="width: 15%">Price</th>
                        <th scope="col" style="width: 30%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data bawaan statis -->
                    <tr>
                        <td><img src="../assets/thumbnail/anggora.png" alt="" /></td>
                        <td>Anggora</td>
                        <td>Anggora turki adalah salah satu ras kucing domestik alami tertua. Ras ini berasal dari Ankara, Turki. Kucing ini sangat populer dan terkenal di Indonesia.</td>
                        <td>450,000</td>
                        <td>
                            <button class="btn-edit" onclick="editCategory()">Edit</button>
                            <button class="btn-delete" onclick="deleteCategory()">Hapus</button>
                        </td>
                    </tr>

                    <!-- Data dinamis dari hasil Input Form (Session) -->
                    <?php if (isset($_SESSION['category_data'])): ?>
                    <tr>
                        <td>
                            <img src="../assets/thumbnail/<?= htmlspecialchars($_SESSION['category_data']['photo']); ?>" alt="Foto" width="80" />
                        </td>
                        <td><?= htmlspecialchars($_SESSION['category_data']['categories']); ?></td>
                        <td><?= htmlspecialchars($_SESSION['category_data']['description']); ?></td>
                        <td><?= htmlspecialchars($_SESSION['category_data']['price']); ?></td>
                        <td>
                            <button class="btn-edit" onclick="editCategory()">Edit</button>
                            <button class="btn-delete" onclick="deleteCategory()">Hapus</button>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".sidebarBtn");
        sidebarBtn.onclick = function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        };
    </script>
</body>
</html>
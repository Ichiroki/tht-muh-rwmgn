<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | Role</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/rapb.css">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="/">Dashboard</a>
        <button type="button" class="dropdown-btn" onclick="toggleDropdown('management-dropdown')">
        <span>Manajemen</span>
        <i class="fa fa-chevron-down"></i></button>
        <div class="dropdown" id="management-dropdown">
            <a href="users">Users</a>
            <a href="roles">Roles</a>
            <a href="units">Units</a>
        </div>
        <a href="/rapb">RAPB</a>
        <a href="/cashflow">Cashflow</a>
        <a href="/settings">Settings</a>
        <a href="#">Tata Cara</a>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </div>


    <main class="content">
        <a href="/roles/create" class="btn btn-green">Buat Role Baru</a>
        <table class="rwd-table">
            <tr>
                <th>No</th>
                <th>Nama Role</th>
                <th>Aksi</th>
            </tr>
            <?php if(empty($roles)) : ?>
                <p>Tidak ada data yang ditemukan.</p>
            <?php else :?>
                <?php $no = 1; ?>
                <?php foreach ($roles as $role) : ?>
                <tr>
                    <td data-th="No"><?= $no++ ?></td>
                    <td data-th="Nama Role"><?= esc($role['role_name']) ?></td>
                    <td data-th="Aksi">
                        <a href="/roles/edit/<?= $role['id'] ?>" class="btn btn-blue">Edit</a>
                        <form action="/roles/delete/<?= $role['id'] ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-red">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
            <?php endif ?>
        </table>
    </main>

    <script src="/js/app.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | RAPB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/rapb.css">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="/">Dashboard</a>
        <button type="button" class="dropdown-btn" onclick="toggleDropdown('management-dropdown')">
        <span>Management</span>
        <i class="fa fa-chevron-down"></i></button>
        <div class="dropdown" id="management-dropdown">
            <a href="/users">Users</a>
            <a href="/roles">Roles</a>
            <a href="/units">Roles</a>
        </div>
        <a href="/rapb">RAPB</a>
        <a href="/cashflow">Cashflow</a>
        <a href="/settings">Settings</a>
        <a href="#">Tata Cara</a>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </div>

    <main class="content">
        <a href="/users/create" class="btn btn-green">Buat User Baru</a>
        <table class="rwd-table">
            <tr>
                <th>No</th>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
                <th>Email</th>
                <th>Unit</th>
                <th>Role</th>
            </tr>
            <?php if(empty($users)) : ?>
                <p>Tidak ada data yang ditemukan.</p>
            <?php else :?>
                <?php $no = 1; ?>
                <?php foreach ($users as $r) : ?>
                <tr>
                    <td data-th="No"><?= $no++ ?></td>
                    <td data-th="Nama Depan"><?= esc($r['first_name']) ?></td>
                    <td data-th="Nama Belakang"><?= esc($r['last_name']) ?></td>
                    <td data-th="Email"><?= esc(strtoupper($r['email'])) ?></td>
                    <td data-th="Unit"><?= esc(strtoupper($r['unit_name'])) ?></td>
                    <td data-th="Role"><?= esc(strtoupper($r['role_name'])) ?></td>
                    <td data-th="Aksi">
                        <a href="/users/edit/<?= $r['id'] ?>" class="btn btn-blue">Edit</a>
                        <form action="/users/delete/<?= $r['id'] ?>" method="POST">
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
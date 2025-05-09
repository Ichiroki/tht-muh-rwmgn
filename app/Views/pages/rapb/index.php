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
        </div>
        <a href="/rapb">RAPB</a>
        <a href="/cashflow">Cashflow</a>
        <a href="/settings">Settings</a>
        <a href="#">Tata Cara</a>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </div>


    <main class="content">
        <a href="/rapb/create" class="btn btn-green">Buat RAPB Baru</a>
        <table class="rwd-table">
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <?php if($isAdmin) : ?>
                    <th>Unit</th>
                <?php endif ?>
                <th>Kategori</th>
                <th>Anggaran Awal</th>
                <th>Anggaran Akhir</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
            <?php if(empty($rapb)) : ?>
                <p>Tidak ada data yang ditemukan.</p>
            <?php else :?>
                <?php $no = 1; ?>
                <?php foreach ($rapb as $r) : ?>
                <tr>
                    <td data-th="No"><?= $no++ ?></td>
                    <td data-th="Nama Kegiatan"><?= esc($r['activity_name']) ?></td>
                    <?php if($isAdmin) : ?>
                        <td data-th="Unit"><?= esc(strtoupper($r['unit'])) ?></td>
                    <?php endif ?>
                    <td data-th="Kategori"><?= esc(strtoupper($r['category'])) ?></td>
                    <td data-th="Anggaran"><?= number_format($r['amount'], 0, ',', '.') ?></td>
                    <td data-th="Anggaran"><?= number_format($r['exact_amount'], 0, ',', '.') ?></td>
                    <td data-th="Tahun"><?= esc($r['year']) ?></td>
                    <td data-th="Aksi" class="aksi">
                        <a href="/rapb/edit/<?= $r['id'] ?>" class="btn btn-yellow">Edit</a>
                        <form action="/rapb/delete/<?= $r['id'] ?>" method="POST">
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
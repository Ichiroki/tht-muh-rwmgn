<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | Cashflow</title>
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
            <a href="/units">Units</a>
        </div>
        <a href="/rapb">RAPB</a>
        <a href="/cashflow">Cashflow</a>
        <a href="/settings">Settings</a>
        <a href="#">Tata Cara</a>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </div>


    <main class="content">
        <a href="/cashflow/create" class="btn btn-green">Buat Transaksi Baru</a>
        <table class="rwd-table">
            <tr>
                <th>No</th>
                <?php if($isAdmin) : ?>
                    <th>Unit</th>
                <?php endif ?>
                <th>RAPB</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
            </tr>
            <?php if(empty($cashflows)) : ?>
                <p>Tidak ada data yang ditemukan.</p>
            <?php else :?>
                <?php $no = 1; ?>
                <?php foreach ($cashflows as $r) : ?>
                <tr>
                    <td data-th="No"><?= $no++ ?></td>
                    <?php if($isAdmin) : ?>
                        <td data-th="Nama Unit"><?= esc($r['unit_name']) ?></td>
                    <?php endif ?>
                    <td data-th="Nama Kegiatan"><?= esc($r['activity_name']) ?></td>
                    <td data-th="Kategori"><?= esc($r['category']) ?></td>
                    <td data-th="Anggaran"><?= number_format($r['amount'], 0, ',', '.') ?></td>
                    <td data-th="Tahun"><?= esc($r['date']) ?></td>
                    <td data-th="Aksi">
                        <a href="/cashflow/edit/<?= $r['id'] ?>" class="btn btn-blue">Edit</a>
                        <form action="/cashflow/delete/<?= $r['id'] ?>" method="POST">
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
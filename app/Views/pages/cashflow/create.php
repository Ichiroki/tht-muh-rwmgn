<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | RAPB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/cashflow.css">
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
        <form action="<?= site_url('cashflow/create') ?>" method="POST" class="form form-input">
            <?= csrf_field() ?>
            <div class="form__field">
                <label for="unit_id">
                    <span>Unit</span>
                </label>
                <select name="unit_id" id="" class="form__input">
                    <option value="">Pilih Unit</option>
                    <?php foreach($units as $unit) : ?>
                    <option value="<?= $unit['id'] ?>"><?= $unit['unit_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form__field">
                <label for="rapb_id">
                    <span>RAPB</span>
                </label>
                <select name="rapb_id" id="" class="form__input">
                    <option value="">Pilih RAPB</option>
                    <?php foreach($rapbs as $rapb) : ?>
                    <option value="<?= $rapb['id'] ?>"><?= $rapb['activity_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form__field">
                <label for="category">
                    <span>Kategori</span>
                </label>
                <select name="category" id="" class="form__input">
                    <option value="">Pilih Kategori</option>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>

            <div class="form__field">
                <label for="amount">
                    <span>Biaya</span>
                </label>
                <input autocomplete="off" id="amount" type="text" name="amount" value="<?= old('amount') ?>" class="form__input" placeholder="Masukkan angka biaya" required>
            </div>

            <div class="form__field">
                <label for="information">
                    <span>Deskripsi</span>
                </label>
                <textarea id="information" type="text" name="information" class="form__input" rows="15" cols="10" placeholder="Jelaskan maksud dari kegiatan ini" required><?= esc(old('information')) ?></textarea>
            </div>

            <div class="form__field">
                <label for="date">
                    <span>Tanggal</span>
                </label>
                <input autocomplete="off" id="date" type="date" name="date" value="<?= old('date') ?>" class="form__input" placeholder="Masukkan jenis kategori" required>
            </div>

            <div class="form__field">
                <input type="submit" value="Sign In">
            </div>
        </form>
        
        <svg xmlns="http://www.w3.org/2000/svg" class="icons">
            <symbol id="icon-arrow-right" viewBox="0 0 1792 1792">
            <path d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293H245q-52 0-84.5-37.5T128 1024V896q0-53 32.5-90.5T245 768h704L656 474q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z" />
            </symbol>
            <symbol id="icon-lock" viewBox="0 0 1792 1792">
            <path d="M640 768h512V576q0-106-75-181t-181-75-181 75-75 181v192zm832 96v576q0 40-28 68t-68 28H416q-40 0-68-28t-28-68V864q0-40 28-68t68-28h32V576q0-184 132-316t316-132 316 132 132 316v192h32q40 0 68 28t28 68z" />
            </symbol>
            <symbol id="icon-user" viewBox="0 0 1792 1792">
            <path d="M1600 1405q0 120-73 189.5t-194 69.5H459q-121 0-194-69.5T192 1405q0-53 3.5-103.5t14-109T236 1084t43-97.5 62-81 85.5-53.5T538 832q9 0 42 21.5t74.5 48 108 48T896 971t133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5T896 896 624.5 783.5 512 512t112.5-271.5T896 128t271.5 112.5T1280 512z" />
            </symbol>
        </svg>
    </main>

    <script src="/js/app.js"></script>
</body>
</html>
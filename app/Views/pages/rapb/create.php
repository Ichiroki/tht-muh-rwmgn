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
        <a href="/dashboard">Dashboard</a>
        <button type="button" class="dropdown-btn" onclick="toggleDropdown('management-dropdown')">
        <span>Management</span>
        <i class="fa fa-chevron-down"></i></button>
        <div class="dropdown" id="management-dropdown">
            <a href="/users">Users</a>
            <a href="/roles">Roles</a>
        </div>
        <a href="/rapb">RAPB</a>
        <a href="/settings">Settings</a>
        <a href="#">Tata Cara</a>
        <a href="/logout">Logout</a>
    </div>

    <main class="content">
        <a href="/create" class="btn btn-green">Buat RAPB Baru</a>
        <?php if(empty($data['rapb'])) : ?>
            <p>Tidak ada data yang ditemukan.</p>
        <?php else :?>
            <p>Ada data yang ditemukan</p>
        <?php endif?>
    </main>

    <script src="/js/app.js"></script>
</body>
</html>
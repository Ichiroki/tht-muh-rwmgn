<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="/dashboard">Dashboard</a>
        <button type="button" class="dropdown-btn" onclick="toggleDropdown('management-dropdown')">
        <span>Management</span>
        <i class="fa fa-chevron-down"></i></button>
        <div class="dropdown" id="management-dropdown">
            <a href="Users">Users</a>
            <a href="Roles">Roles</a>
        </div>
        <a href="/rapb">RAPB</a>
        <a href="/cashflow">Cashflow</a>
        <a href="/settings">Settings</a>
        <a href="#">Tata Cara</a>
        <a href="<?= site_url('logout') ?>">Logout</a>
    </div>

    <div class="dashboard">
        asdfasdfij
    </div>

    <script src="/js/app.js"></script>
</body>
</html>
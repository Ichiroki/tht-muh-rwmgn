<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/howto.css">
</head>
<body>
    <section class="wrap">
        <aside class="sidebar">
            <h2>Tata Cara</h2>
            <button type="button" class="dropdown-btn" onclick="toggleDropdown('autentikasi-dropdown')">
            <span>Autentikasi</span>
            <i class="fa fa-chevron-down"></i></button>
            <div class="dropdown" id="autentikasi-dropdown">
                <a href="users">Login</a>
                <a href="roles">Register</a>
            </div>
            <button type="button" class="dropdown-btn" onclick="toggleDropdown('management-dropdown')">
            <span>Manajemen Aplikasi</span>
            <i class="fa fa-chevron-down"></i></button>
            <div class="dropdown" id="management-dropdown">
                <a href="users">Users</a>
                <a href="roles">Roles</a>
                <a href="units">Units</a>
            </div>
            <button type="button" class="dropdown-btn" onclick="toggleDropdown('keuangan-dropdown')">
            <span>Keuangan & Transaksi</span>
            <i class="fa fa-chevron-down"></i></button>
            <div class="dropdown" id="keuangan-dropdown">
                <button type="button" class="dropdown-btn" onclick="toggleDropdown('rapb-dropdown')">
                <span>RAPB</span>
                <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown" id="rapb-dropdown">
                    <a href="roles">Apa Itu RAPB</a>
                    <a href="units">Cara Kerja RAPB</a>
                </div>
                <button type="button" class="dropdown-btn" onclick="toggleDropdown('cashflow-dropdown')">
                <span>Cashflow</span>
                <i class="fa fa-chevron-down"></i></button>
                <div class="dropdown" id="cashflow-dropdown">
                    <a href="roles">Apa Itu Cashflow</a>
                    <a href="units">Cara Kerja Cashflow</a>
                    <a href="units">Cara menggunakan fitur ini</a>
                </div>
            </div>
        </aside>
    
        <main class="index">
            <div class="index-content">
                <h3>Cara Kerja RAPB</h3>
                <p style="padding-top: 3rem;">RAPB memiliki hubungan dengan Cashflow, artinya setiap penambahan data yang berkategori pengeluaran atau pemasukkan, angka anggaran RAPB akan berubah secara langsung. data RAPB memiliki banyak data Cashflow. Hasil dari representasinya seperti ini :</p>
                <img src="/img/contohRAPB.drawio.png" alt="">
                <p style="padding-top: .75rem;">Dari gambar diatas, terdapat sebuah diagram yang menjadi bukti bahwa RAPB saling berhubungan dengan Cashflow yang dibuat. Jika data RAPB dihapus, maka seluruh data Cashflow akan terhapus. Pikirkan kembali sebelum anda ingin menghapus data ini.</p>
                <p>Setiap Unit hanya dapat melihat RAPB-nya masing-masing, jika unit A memiliki RAPB A, RAPB B, dan unit B memiliki RAPB C, maka unit B tidak dapat melihat RAPB-nya unit A, dan unit A tidak dapat melihat RAPB unit B. dan Setiap unit hanya dapat melihat hasil rekapan besaran pengeluaran dan pemasukkan RAPB-nya masing - masing dalam bentuk grafik di halaman Dashboard.</p>
                <div class="next-page">
                    <a href="/tata-cara/apa-itu-rapb">Apa Itu RAPB</a>
                    <a href="/tata-cara/cara-kerja-rapb">Cara Kerja RAPB</a>
                </div>
            </div>
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
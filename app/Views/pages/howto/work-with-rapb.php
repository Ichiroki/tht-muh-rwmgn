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
                    <a href="/tata-cara/apa-itu-rapb">Apa Itu RAPB</a>
                    <a href="/tata-cara/cara-kerja-rapb">Cara Kerja RAPB</a>
                    <a href="/tata-cara/bekerja-dengan-rapb">Bekerja Dengan RAPB</a>
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
                <h3>Bekerja Dengan RAPB</h3>
                <p>Halaman ini akan memberikan anda sebuah pemahaman dan cara untuk menambahkan, mengubah, dan menghapus RAPB.</p>
                <div class="accordion-container">
                    <button class="accordion-btn" style="width: 100%;" onclick="toggleAccordion('menambahkan-data-rapb')">
                        <h4><a href="#menambahkan-data-rapb">Menambahkan Data RAPB</a></h4>
                        <i class="fa fa-chevron-right"></i></button>
                    </button>
                    <div id="menambahkan-data-rapb" class="accordion">
                        <p style="text-align: left; margin-left: 70px;">Menambahkan data RAPB sangatlah mudah, anda perlu masuk ke halaman RAPB</p>
                        <img src="/img/halamIndRAPB.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.3. Halaman Index RAPB</small>
                        <p style="text-align: left; margin-left: 70px; margin-top: 2rem;">Lalu, tekan tombol "Buat RAPB Baru". tampilan setelah menekan tombol akan bertampilan seperti ini</p>
                        <img src="/img/halamCRTRAPB.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.4. Halaman Membuat Data RAPB Baru</small>
                        <p style="text-align: left; margin-left: 70px; margin-top: 2rem;">Isi seluruh data untuk menambahkan data RAPB Baru</p>
                        <img src="/img/halamCRTRAPB2.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.5. Halaman Membuat Data RAPB Baru</small>
                        <p style="text-align: left; margin-left: 70px; margin-top: 2rem;">Jika seluruh data sudah terisi, anda boleh menekan tombol Tambahkan Data tepat dipaling bawah Form. Sistem akan otomatis menyimpan data RAPB anda dan langsung mengirimkannya ke tabel RAPB Anda.</p>
                        <img src="/img/halamIndRAPB2.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.6. Halaman Membuat Data RAPB Baru dengan data terisi</small>
                    </div>
                </div>
                <div class="accordion-container">
                    <button class="accordion-btn" style="width: 100%;" onclick="toggleAccordion('mengubah-data-rapb')">
                        <h4><a href="#mengubah-data-rapb">Mengubah Data RAPB</a></h4>
                        <i class="fa fa-chevron-right"></i></button>
                    </button>
                    <div id="mengubah-data-rapb" class="accordion">
                        <p style="text-align: left; margin-left: 70px;">Fitur mengubah data RAPB dapat dilakukan jika anda memilih salah satu data yang sudah ada di tabel</p>
                        <img src="/img/halamIndRAPB2.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.7. Halaman Index RAPB</small>
                        <p style="text-align: left; margin-left: 70px; margin-top: 2rem;">Ubah data yang ingin diubah. jika anda tidak sengaja mengosongkan salah satu data dan sistem menolak untuk menerima data tersebut, pastikan untuk refresh halaman untuk mengembalikkan data menjadi semula. Jika data sudah selesai diubah, silakan tekan tombol "Simpan Data"</p>
                        <img src="/img/halamEDTRAPB.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.8. Halaman Membuat Data RAPB Baru</small>
                        <p style="text-align: left; margin-left: 70px; margin-top: 2rem;">Sistem akan menampilkan data anda yang sudah anda ubah sebelumnya</p>
                        <img src="/img/halamIndRAPB3.png" alt="Halaman Index RAPB" style="width: 960px; border-radius: 10px; margin-bottom: 1rem;"/>
                        <small style="text-decoration: underline; text-align: center; width: 100%; display: block;">2.8. Halaman Membuat Data RAPB Baru</small>
                    </div>
                </div>

                <div class="accordion-container">
                    <button class="accordion-btn" style="width: 100%;" onclick="toggleAccordion('menghapus-data-rapb')">
                        <h4><a href="#menghapus-data-rapb">menghapus Data RAPB <span style="color: red;">(WARNING !)</span></a></h4>
                        <i class="fa fa-chevron-right"></i></button>
                    </button>
                    <div id="menghapus-data-rapb" class="accordion">
                        <p style="text-align: left; margin-left: 70px;">Fitur ini untuk menghapus data RAPB secara permanen, jika dirasa sudah tidak terpakai atau data sudah tidak relevan, anda dapat menghapus data ini dengan menekan tombol delete pada data RAPB yang anda pilih.
                        <br><br>
                        <span style="color: red;">Warning</span>, sebagai catatan. Data yang sudah terhapus permanen tidak dapat dikembalikan keawal
                        </p>
                    </div>
                </div>

                <div class="next-page">
                    <a href="/tata-cara/cara-kerja-rapb">Cara Kerja RAPB</a>
                    <a href="/tata-cara/cara-kerja-rapb">Apa itu Cashflow</a>
                </div>
            </div>
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
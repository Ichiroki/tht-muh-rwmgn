<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Home Test | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/pages/dashboard.css">
</head>
<body>
    <section class="wrap">
        <aside class="sidebar">
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
        </aside>
    
        <main class="dashboard">
            <div class="container py-4">
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white fw-bold">
                            Cashflow per Bulan
                        </div>
                        <div class="card-body">
                            <canvas id="monthChart"></canvas>
                        </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white fw-bold">
                            Kategori Cashflow
                        </div>
                        <div class="card-body">
                            <canvas id="categoryChart"></canvas>
                        </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow-sm h-100">
                        <div class="card-header bg-info text-white fw-bold">
                            Cashflow per Unit
                        </div>
                        <div class="card-body">
                            <canvas id="unitChart"></canvas>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Bar Chart (Kategori)
            fetch("<?= base_url('cashflow/category') ?>")
            .then(response => response.json())
            .then(data => {
                console.log(data)
                const labels = data.map(item => item.category);
                const values = data.map(item => item.total);

                const ctx = document.getElementById('categoryChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total (Rp)',
                            data: values,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 99, 132, 0.6)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

            // Line Chart (Per bulan)
            fetch("<?= base_url('cashflow/month') ?>")
            .then(res => res.json())
            .then(data => {
                const labels = [...new Set(data.map(item => item.bulan))];
                const pemasukan = labels.map(label => {
                    const item = data.find(d => d.bulan === label && d.category === 'pemasukan');
                    return item ? item.total : 0;
                });
                const pengeluaran = labels.map(label => {
                    const item = data.find(d => d.bulan === label && d.category === 'pengeluaran');
                    return item ? item.total : 0;
                });

                new Chart(document.getElementById('monthChart'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Pemasukan',
                                data: pemasukan,
                                borderColor: 'green',
                                backgroundColor: 'rgba(0,128,0,0.2)',
                                tension: 0.3
                            },
                            {
                                label: 'Pengeluaran',
                                data: pengeluaran,
                                borderColor: 'red',
                                backgroundColor: 'rgba(255,0,0,0.2)',
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });

            // Bar Chart (Per Unit)
            fetch("<?= base_url('cashflow/unit') ?>")
            .then(res => res.json())
            .then(data => {
                const labels = data.map(d => d.unit_name);
                const values = data.map(d => d.total);

                new Chart(document.getElementById('unitChart'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Cashflow',
                            data: values,
                            backgroundColor: '#2196f3'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        indexAxis: 'y'
                    }
                });
            });
        });
    </script>
    <script src="/js/app.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f3f4f6; /* bg-gray-100 */
      color: #1D3557;
    }
    .glass-box {
      background-color: #f3f4f6;
      border: 2px solid rgba(29, 53, 87, 0.2);
      border-radius: 1rem;
      padding: 1.5rem;
      box-shadow: 0 4px 6px rgb(29 53 87 / 0.1);
    }
    .btn-primary {
      background-color: #1D3557;
      color: white;
      padding: 0.5rem 1.25rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }
    .btn-primary:hover {
      background-color: #163047;
    }
    .btn-secondary {
      background-color: white;
      color: #1D3557;
      border: 2px solid #1D3557;
      padding: 0.5rem 1.25rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }
    .btn-secondary:hover {
      background-color: #e2e8f0;
    }
    table {
      border-collapse: collapse;
      width: 100%;
    }
    thead tr {
      background-color: #457B9D;
      color: white;
    }
    th, td {
      padding: 0.75rem 1rem;
      border: 1px solid #ddd;
      text-align: center;
    }
    .charts-wrapper {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 2rem;
    }
    .chart-box {
      flex: 1 1 400px;
      background: white;
      padding: 1rem;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    }
    @media (max-width: 768px) {
      .charts-wrapper {
        flex-direction: column;
        align-items: center;
      }
      .chart-box {
        width: 100%;
        max-width: 420px;
      }
    }

    /* Modal Styles */
    #modal-overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(0,0,0,0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    #modal-overlay.active {
      display: flex;
      opacity: 1;
    }
    #modal-content {
      background: white;
      border-radius: 1rem;
      padding: 2rem 2.5rem;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.3);
      position: relative;
      max-height: 80vh;
      overflow-y: auto;
    }
    #modal-close-btn {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: transparent;
      border: none;
      font-size: 1.8rem;
      font-weight: bold;
      color: #1D3557;
      cursor: pointer;
      line-height: 1;
      transition: color 0.3s ease;
    }
    #modal-close-btn:hover {
      color: #E63946;
    }
    #modal-title {
      margin-top: 0;
      margin-bottom: 1rem;
      font-size: 1.5rem;
      font-weight: 700;
      color: #1D3557;
    }
    #modal-text {
      white-space: pre-wrap;
      font-family: 'Courier New', Courier, monospace;
      color: #333;
      font-size: 1rem;
      line-height: 1.4;
    }

    /* Pagination Styles */
    .pagination {
      margin-top: 1rem;
      display: flex;
      justify-content: center;
      gap: 0.5rem;
    }
    .pagination button {
      background-color: #1D3557;
      color: white;
      border: none;
      padding: 0.4rem 0.75rem;
      border-radius: 0.4rem;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    .pagination button:hover:not(:disabled) {
      background-color: #163047;
    }
    .pagination button:disabled {
      background-color: #999;
      cursor: default;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="bg-[#A8DADB] text-white px-20 py-2 shadow-md flex justify-between items-center">
  <div class="flex items-center space-x-3">
    <img src="../assets/logo.png" alt="Logo" class="w-10 h-10 object-contain ml-2" />
  </div>
  <ul class="flex space-x-16 text-lg font-medium text-[#1D3557]">
    <li><a href="dashboard.php" class="hover:underline transition">Beranda</a></li>
    <li><a href="catatan.php" class="hover:underline transition">Catatan Kas</a></li>
    <li><a href="tambah-transaksi.php" class="hover:underline transition">Tambah Transaksi</a></li>
    <li><a href="laporan.html" class="hover:underline transition">Laporan</a></li>
  </ul>
  <div class="mr-2">
    <a href="logout.php" class="text-sm px-4 py-2 border border-[#1D3557] text-[#1D3557] rounded hover:bg-[#1D3557] hover:text-white transition">
      Logout
    </a>
  </div>
</nav>

<div class="container">
  <h2 style="text-align:center; margin-top: 20px;">Laporan Keuangan Kelas</h2>

<!-- Konten utama -->
<main class="max-w-6xl mx-auto p-6 glass-box mt-6">
  <div class="flex justify-center gap-4 mb-4">
  <select id="select-bulan" class="border rounded px-4 py-2">
    <option value="01">Januari</option>
    <option value="02">Februari</option>
    <option value="03">Maret</option>
    <option value="04">April</option>
    <option value="05">Mei</option>
    <option value="06">Juni</option>
    <option value="07">Juli</option>
    <option value="08">Agustus</option>
    <option value="09">September</option>
    <option value="10">Oktober</option>
    <option value="11" selected>November</option>
    <option value="12">Desember</option>
  </select>

  <select id="select-tahun" class="border rounded px-4 py-2">
    <!-- Auto-generate tahun lewat JS -->
  </select>

  <button class="btn-primary" onclick="tampilkanLaporan()">Tampilkan</button>
</div>

  <!-- Grafik di atas tabel -->
  <div class="charts-wrapper">
    <div class="chart-box">
      <canvas id="chart-line"></canvas>
    </div>
    <div class="chart-box">
      <canvas id="chart-pie"></canvas>
    </div>
  </div>

  <div class="overflow-x-auto">
    <table>  
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Pemasukan (Rp)</th>
          <th>Pengeluaran (Rp)</th>
          <th>Sisa Saldo (Rp)</th>
        </tr>
      </thead>
      <tbody id="tabel-laporan-body">
        <!-- Isi data dinamis -->
      </tbody>
    </table>
    <div id="pagination" style="margin-top: 10px; text-align:center;"></div>
  </div>

  <!-- Pagination controls -->
  <div class="pagination" id="pagination-controls"></div>

  <div class="flex justify-end gap-4 mt-4">
    <button id="btn-export-pdf" class="btn-primary">Export PDF</button>
    <button id="btn-export-excel" class="btn-secondary">Export Excel</button>
    <button id="btn-detail" class="btn-primary">Detail</button> <!-- Tombol detail di bawah tabel -->
  </div>

</main>

<!-- Modal Popup Detail -->
<div
  id="modal-overlay"
  role="dialog"
  aria-modal="true"
  aria-labelledby="modal-title"
  tabindex="-1"
>
  <div id="modal-content">
    <button id="modal-close-btn" aria-label="Tutup modal">&times;</button>
    <h3 id="modal-title">Detail Transaksi November 2024</h3>
    <pre id="modal-text" style="white-space: pre-wrap;"></pre>
  </div>
</div>

<script>
  const tahunSelect = document.getElementById('select-tahun');
  const tahunSekarang = new Date().getFullYear();
  for (let i = tahunSekarang; i >= tahunSekarang - 10; i--) {
    const option = document.createElement('option');
    option.value = i;
    option.textContent = i;
    if (i === tahunSekarang) option.selected = true;
    tahunSelect.appendChild(option);
  }

  const transaksiData = [
    { tanggal: '2024-11-01', pemasukan: 2000000, pengeluaran: 500000 },
    { tanggal: '2024-11-03', pemasukan: 1500000, pengeluaran: 200000 },
    { tanggal: '2024-11-05', pemasukan: 1000000, pengeluaran: 700000 },
    { tanggal: '2024-11-07', pemasukan: 2500000, pengeluaran: 400000 },
    { tanggal: '2024-11-10', pemasukan: 500000, pengeluaran: 100000 },
    { tanggal: '2024-11-15', pemasukan: 0, pengeluaran: 800000 },
    { tanggal: '2024-11-20', pemasukan: 3000000, pengeluaran: 1500000 },
  ];

  const rowsPerPage = 5;
  let currentPage = 1;

  function tampilkanLaporan() {
    renderTabel();
    renderCharts(transaksiData);
  }

  function renderTabel() {
    const tbody = document.getElementById('tabel-laporan-body');
    tbody.innerHTML = '';

    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const paginatedData = transaksiData.slice(startIndex, endIndex);

    let saldo = 0;
    for (let i = 0; i < startIndex; i++) {
      saldo += transaksiData[i].pemasukan - transaksiData[i].pengeluaran;
    }

    paginatedData.forEach((item, index) => {
      saldo += item.pemasukan - item.pengeluaran;

      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${startIndex + index + 1}</td>
        <td>${item.tanggal}</td>
        <td>${item.pemasukan.toLocaleString('id-ID')}</td>
        <td>${item.pengeluaran.toLocaleString('id-ID')}</td>
        <td>${saldo.toLocaleString('id-ID')}</td>
      `;
      tbody.appendChild(tr);
    });

    renderPagination();
  }

  function renderPagination() {
    const paginationDiv = document.getElementById('pagination');
    paginationDiv.innerHTML = '';

    const totalPages = Math.ceil(transaksiData.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement('button');
      btn.textContent = i;
      btn.style.margin = '0 3px';
      btn.style.padding = '5px 10px';
      btn.style.border = i === currentPage ? '2px solid #007BFF' : '1px solid #ccc';
      btn.style.backgroundColor = i === currentPage ? '#007BFF' : '#fff';
      btn.style.color = i === currentPage ? '#fff' : '#000';
      btn.style.cursor = 'pointer';

      btn.addEventListener('click', () => {
        currentPage = i;
        renderTabel();
      });

      paginationDiv.appendChild(btn);
    }
  }

  function renderCharts(data) {
    const labels = data.map(item => item.tanggal);
    const pemasukanData = data.map(item => item.pemasukan);
    const pengeluaranData = data.map(item => item.pengeluaran);

    if (window.lineChart) window.lineChart.destroy();
    if (window.pieChart) window.pieChart.destroy();

    const ctxLine = document.getElementById('chart-line').getContext('2d');
    window.lineChart = new Chart(ctxLine, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [
          {
            label: 'Pemasukan',
            data: pemasukanData,
            borderColor: '#2a9d8f',
            backgroundColor: 'rgba(42, 157, 143, 0.2)',
            tension: 0.3,
            fill: true
          },
          {
            label: 'Pengeluaran',
            data: pengeluaranData,
            borderColor: '#e76f51',
            backgroundColor: 'rgba(231, 111, 81, 0.2)',
            tension: 0.3,
            fill: true
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    const totalPemasukan = pemasukanData.reduce((a, b) => a + b, 0);
    const totalPengeluaran = pengeluaranData.reduce((a, b) => a + b, 0);

    const ctxPie = document.getElementById('chart-pie').getContext('2d');
    window.pieChart = new Chart(ctxPie, {
      type: 'pie',
      data: {
        labels: ['Pemasukan', 'Pengeluaran'],
        datasets: [{
          data: [totalPemasukan, totalPengeluaran],
          backgroundColor: ['#2a9d8f', '#e76f51']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  }

  document.addEventListener('DOMContentLoaded', () => {
    tampilkanLaporan();
  });
</script>

<!-- jsPDF autoTable plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

</body>
</html>

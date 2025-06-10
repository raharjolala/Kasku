<?php
include '../api/catatan.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catatan Keuangan Kelas</title>
  <script src="https://cdn.tailwindcss.com"></script>   
  <style>
    .active-pagination {
      background-color: #1D3557 !important;
      color: white !important;
    }
    .active-period-btn {
      background-color: #457B9D !important;
      color: white !important;
    }

    /* Modal Styling */
    #modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    #modal-content {
      background: white;
      padding: 20px;
      border-radius: 8px;
      width: 600px;
      max-height: 80vh;
      overflow-y: auto;
      position: relative;
    }
    #modal-close {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 20px;
      cursor: pointer;
      color: gray;
    }
  </style>
</head>
<body class="bg-gray-100 text-[#1D3557] font-sans">

<!-- Navbar -->
<nav class="bg-[#A8DADB] text-white px-20 py-2 shadow-md flex justify-between items-center">
  <div class="flex items-center space-x-3">
    <img src="../assets/logo.png" alt="Logo" class="w-10 h-10 object-contain ml-2">
  </div>
  <ul class="flex space-x-16 text-lg font-medium text-[#1D3557]">
    <li><a href="dashboard.php" class="hover:underline transition">Beranda</a></li>
    <li><a href="catatan.php" class="hover:underline transition active">Catatan Kas</a></li>
    <li><a href="tambah-transaksi.php" class="hover:underline transition">Tambah Transaksi</a></li>
    <li><a href="laporan.php" class="hover:underline transition">Laporan</a></li>
  </ul>
  <div class="mr-2">
    <a href="logout.php" class="text-sm px-4 py-2 border border-[#1D3557] text-[#1D3557] rounded hover:bg-[#1D3557] hover:text-white transition">
      Logout
    </a>
  </div>
</nav>

<!-- Judul -->
<div class="mt-6 mb-4 flex justify-center">
  <h1 class="text-3xl font-bold text-[#1D3557]">Catatan Keuangan Kelas</h1>
</div>

<!-- Box Container -->
<div class="bg-white rounded-xl shadow-md max-w-6xl mx-auto border border-gray-300 mb-8">
  <!-- Header Box -->
  <div class="flex justify-between items-center bg-[#1D3557] text-white px-6 py-3 rounded-t-xl">
    <div class="flex space-x-2">
      <button id="btn-harian" onclick="setActiveFilter('harian')" class="period-btn px-4 py-1.5 rounded transition active-period-btn">Harian</button>
      <button id="btn-mingguan" onclick="setActiveFilter('mingguan')" class="period-btn px-4 py-1.5 rounded transition">Mingguan</button>
      <button id="btn-bulanan" onclick="setActiveFilter('bulanan')" class="period-btn px-4 py-1.5 rounded transition">Bulanan</button>
    </div>
  </div>

  <!-- Filter Jenis -->
  <div class="flex justify-end px-6 pt-4">
    <select id="jenis-filter" class="border border-gray-300 rounded px-4 py-2 text-[#1D3557]" onchange="reloadTable()">
      <option value="semua">Semua</option>
      <option value="pemasukan">Pemasukan</option>
      <option value="pengeluaran">Pengeluaran</option>
    </select>
  </div>

  <!-- Tabel Catatan -->
  <div class="px-6 mt-4 overflow-x-auto">
    <table class="w-full text-center border border-black border-2 rounded">
      <thead>
        <tr class="bg-[#A8DADB] text-[#1D3557] font-semibold">
          <th class="border border-black px-4 py-2">No</th>
          <th class="border border-black px-4 py-2">Tanggal</th>
          <th class="border border-black px-4 py-2">Jenis Transaksi</th>
          <th class="border border-black px-4 py-2">Nominal</th>
          <th class="border border-black px-4 py-2">Keterangan</th>
          <th class="border border-black px-4 py-2">Opsi</th>
        </tr>
      </thead>
      <tbody class="bg-white" id="table-body"></tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="flex justify-center mt-6 pb-6 space-x-3">
    <button onclick="changePage('prev')" id="btn-prev" class="pagination-btn px-4 py-2 rounded border text-sm">Prev</button>
    <button id="page-1" onclick="setActivePage(1)" class="pagination-btn px-4 py-2 rounded border text-sm active-pagination">1</button>
    <button id="page-2" onclick="setActivePage(2)" class="pagination-btn px-4 py-2 rounded border text-sm">2</button>
    <button id="page-3" onclick="setActivePage(3)" class="pagination-btn px-4 py-2 rounded border text-sm">3</button>
    <button onclick="changePage('next')" id="btn-next" class="pagination-btn px-4 py-2 rounded border text-sm">Next</button>
  </div>
</div>

<!-- Modal Detail -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div id="modal-content" class="bg-white rounded-lg p-6 w-full max-w-2xl shadow-lg relative">
    <span id="modal-close" onclick="closeModal()" class="absolute top-2 right-2 text-2xl cursor-pointer">&times;</span>
    <h3 class="text-xl font-bold mb-4">Detail Transaksi</h3>
    <ul id="modal-list" class="space-y-2"></ul>
  </div>
</div>

<script>
  let currentFilter = 'harian';
  let currentPage = 1;
  const rowsPerPage = 5;
  let totalPages = 1; // buat global supaya bisa dipakai di changePage

  function setActiveFilter(filter) {
    currentFilter = filter;
    currentPage = 1;
    document.querySelectorAll('.period-btn').forEach(btn => {
      btn.classList.toggle('active-period-btn', btn.id === 'btn-' + filter);
    });
    reloadTable();
  }

  function reloadTable() {
    const jenis = document.getElementById('jenis-filter').value;
    fetch(`../api/catatan.php?filter=${currentFilter}&jenis=${jenis}&page=${currentPage}&rows=${rowsPerPage}`)
      .then(res => res.json())
      .then(result => {
        totalPages = result.totalPages || 1; // update totalPages global
        renderTable(result.data, totalPages);
      })
      .catch(err => {
        console.error('Error fetch data:', err);
        // Tetap render tabel kosong tanpa data saat error
        totalPages = 1;
        renderTable([], totalPages);
      });
  }

  function renderTable(data, totalPages) {
  const tbody = document.getElementById('table-body');
  tbody.innerHTML = ''; // Clear previous rows

  if (data.length === 0) {
    // Show a single row with a "no data" message
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td colspan="6" class="py-6 text-gray-500 italic">Tidak ada transaksi</td>
    `;
    tbody.appendChild(tr);
  } else {
    data.forEach((item, i) => {
      const rowNumber = (currentPage - 1) * rowsPerPage + i + 1;
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td class="border border-black px-4 py-2">${rowNumber}</td>
        <td class="border border-black px-4 py-2">${formatTanggal(item.tanggal)}</td>
        <td class="border border-black px-4 py-2">${item.jenis}</td>
        <td class="border border-black px-4 py-2">${formatRupiah(item.nominal)}</td>
        <td class="border border-black px-4 py-2">${item.keterangan}</td>
        <td class="border border-black px-4 py-2">
          <button class="bg-[#1D3557] text-white px-3 py-1 rounded hover:bg-[#457B9D] transition"
                  onclick='showDetail(${JSON.stringify(item).replace(/'/g, "&apos;")})'>Detail</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

    // Render pagination dan tombol page
    const paginationContainer = document.querySelector('.pagination-btn').parentNode;
    paginationContainer.innerHTML = '';

    // Prev button
    const btnPrev = document.createElement('button');
    btnPrev.textContent = 'Prev';
    btnPrev.className = 'pagination-btn px-4 py-2 rounded border text-sm';
    btnPrev.disabled = currentPage <= 1;
    btnPrev.onclick = () => { changePage('prev'); };
    paginationContainer.appendChild(btnPrev);

    // Tombol page dinamis
    let maxButtons = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
    let endPage = Math.min(totalPages, startPage + maxButtons -1);
    if(endPage - startPage < maxButtons -1) {
      startPage = Math.max(1, endPage - maxButtons +1);
    }

    for(let i = startPage; i <= endPage; i++) {
      const btnPage = document.createElement('button');
      btnPage.textContent = i;
      btnPage.className = 'pagination-btn px-4 py-2 rounded border text-sm';
      if(i === currentPage) btnPage.classList.add('active-pagination');
      btnPage.disabled = false;
      btnPage.onclick = () => setActivePage(i);
      paginationContainer.appendChild(btnPage);
    }

    // Next button
    const btnNext = document.createElement('button');
    btnNext.textContent = 'Next';
    btnNext.className = 'pagination-btn px-4 py-2 rounded border text-sm';
    btnNext.disabled = currentPage >= totalPages;
    btnNext.onclick = () => { changePage('next'); };
    paginationContainer.appendChild(btnNext);
  }

  function changePage(direction) {
    if(direction === 'prev' && currentPage > 1) {
      currentPage--;
    } else if(direction === 'next' && currentPage < totalPages) {
      currentPage++;
    }
    reloadTable();
  }

  function setActivePage(page) {
    currentPage = page;
    reloadTable();
  }

  // Modal
  const modal = document.getElementById('modal');
  const modalList = document.getElementById('modal-list');

  function showDetail(item) {
    modalList.innerHTML = `
      <li><strong>Tanggal:</strong> ${formatTanggal(item.tanggal)}</li>
      <li><strong>Jenis Transaksi:</strong> ${item.jenis}</li>
      <li><strong>Nominal:</strong> ${formatRupiah(item.nominal)}</li>
      <li><strong>Keterangan:</strong> ${item.keterangan}</li>
    `;
    modal.style.display = 'flex';
  }

  function closeModal() {
    modal.style.display = 'none';
  }

  window.onclick = function(event) {
    if(event.target === modal) {
      closeModal();
    }
  }

  // Inisialisasi tampilan
  setActiveFilter('harian');
</script>
</body>
</html>

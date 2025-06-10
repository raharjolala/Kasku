<?php
include '../api/catatan.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Transaksi</title>
  <script src="https://cdn.tailwindcss.com"></script>       
  <style>
    .active-period-btn {
      background-color: #457B9D !important;
      color: white !important;
    }

    /* Efek Glassmorphism (opsional) */
    .glass-box {
      background-color: #f3f4f6; /* Sama dengan bg-gray-100 */
      border: 2px solid rgba(0, 0, 0, 0.1); /* Border lebih tebal dan halus */
      border-radius: 1rem; /* Sudut membulat */
    }

    /* Tombol Simpan - lebih kecil, oval tapi agak kotak */
    .btn-simpan {
      background-color: #1D3557;
      color: white;
      padding: 0.4rem 1.2rem; /* tinggi lebih kecil */
      border-radius: 0.5rem; /* oval tapi lebih kecil radiusnya */
      box-shadow: 0 2px 5px rgba(29, 53, 87, 0.4);
      font-weight: 600;
      transition: background-color 0.3s;
      border: none;
    }
    .btn-simpan:hover {
      background-color: #12263b;
    }

    /* Tombol Kembali - putih dengan border & teks biru tua */
    .btn-kembali {
      background-color: #FFFFFF;
      color: #1D3557;
      padding: 0.4rem 1.2rem;
      border-radius: 0.5rem;
      box-shadow: 0 2px 5px rgba(29, 53, 87, 0.2);
      font-weight: 600;
      border: 2px solid #1D3557;
      transition: background-color 0.3s, color 0.3s;
      text-align: center;
      display: inline-block;
      text-decoration: none;
    }
    .btn-kembali:hover {
      background-color: #1D3557;
      color: white;
      box-shadow: 0 4px 10px rgba(29, 53, 87, 0.6);
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
    <li><a href="catatan.php" class="hover:underline transition">Catatan Kas</a></li>
    <li><a href="tambah-transaksi.php" class="hover:underline transition active">Tambah Transaksi</a></li>
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
  <h1 class="text-3xl font-bold text-[#1D3557]">Tambah Transaksi</h1>
</div>

<!-- Box Container - Form -->
<div class="rounded-xl shadow-md max-w-4xl mx-auto border border-gray-300 mb-8 p-6 glass-box">
  
  <!-- Form Tambah Transaksi -->
  <form id="form-tambah-transaksi" class="space-y-6 max-w-4xl mx-auto p-4">

    <!-- Tanggal -->
    <div class="relative">
      <label for="tanggal" class="absolute -top-2 left-4 bg-white px-2 text-sm text-gray-600 z-10">
        Tanggal
      </label>
      <input type="date" id="tanggal" name="tanggal"
        class="w-[35%] px-4 py-2 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none" />
    </div>

    <!-- Jenis Transaksi dan Nominal -->
    <div class="flex gap-4">
      <div class="relative w-[35%]">
        <label for="jenis" class="absolute -top-2 left-4 bg-white px-2 text-sm text-gray-600 z-10">
          Jenis Transaksi
        </label>
        <select id="jenis" name="jenis"
          class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
          <option value="" disabled selected>Pilih jenis</option>
          <option value="Pemasukan">Pemasukan</option>
          <option value="Pengeluaran">Pengeluaran</option>
        </select>
      </div>

      <div class="relative w-[35%]">
        <label for="nominal" class="absolute -top-2 left-4 bg-white px-2 text-sm text-gray-600 z-10">
          Nominal
        </label>
        <input type="number" id="nominal" name="nominal" placeholder="Rp"
          class="w-full px-4 py-2 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none" />
      </div>
    </div>

    <!-- Keterangan -->
    <div class="relative">
      <label for="keterangan" class="absolute -top-2 left-4 bg-white px-2 text-sm text-gray-600 z-10">
        Keterangan
      </label>
      <textarea id="keterangan" name="keterangan" rows="3"
        class="w-[35%] px-4 py-2 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
    </div>

    <!-- Tombol -->
    <div class="pt-4 flex space-x-4">
      <button type="submit" class="btn-simpan">
        Simpan Transaksi
      </button>
      <a href="catatan.php" class="btn-kembali">
        Kembali
      </a>
    </div>
  </form>

  <!-- Notifikasi Sukses/Error -->
  <div id="notif" class="hidden mt-4 p-3 rounded-md bg-green-500 text-white text-sm">
    Transaksi berhasil ditambahkan!
  </div>

</div>

<script>
  // Fungsi submit form
  document.getElementById("form-tambah-transaksi").addEventListener("submit", function (e) {
    e.preventDefault();

    const tanggal = document.getElementById("tanggal").value;
    const jenis = document.getElementById("jenis").value;
    const nominal = parseInt(document.getElementById("nominal").value);
    const keterangan = document.getElementById("keterangan").value;

    if (!tanggal || !jenis || isNaN(nominal) || !keterangan.trim()) {
      showNotification("Semua kolom harus diisi!", "bg-red-500");
      return;
    }

    // Simpan ke localStorage sebagai mock database
    let transaksi = JSON.parse(localStorage.getItem("transaksi")) || [];
    const newTransaksi = {
      id: Date.now(),
      tanggal,
      jenis,
      nominal,
      keterangan
    };
    transaksi.push(newTransaksi);
    localStorage.setItem("transaksi", JSON.stringify(transaksi));

    showNotification("Transaksi berhasil ditambahkan!", "bg-green-500");

    this.reset();
  });

  // Fungsi notifikasi
  function showNotification(message, bgColor = "bg-red-500") {
    const notif = document.getElementById("notif");
    notif.className = `${bgColor} hidden mt-4 p-3 rounded-md text-white text-sm`;
    notif.textContent = message;
    notif.classList.remove("hidden");

    setTimeout(() => {
      notif.classList.add("hidden");
    }, 3000);
  }
</script>

</body>
</html>

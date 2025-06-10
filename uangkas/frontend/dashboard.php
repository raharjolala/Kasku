<?php
include '../api/dashboard.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard | Keuangan Kelas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-[#A8DADB] text-white px-20 py-2 shadow-md flex justify-between items-center">
    <div class="flex items-center space-x-3">
      <img src="../assets/logo.png" alt="Logo" class="w-10 h-10 object-contain ml-2">
    </div>
    <ul class="flex space-x-16 text-lg font-medium text-[#1D3557]">
      <li><a href="dashboard.php" class="hover:underline transition">Beranda</a></li>
      <li><a href="catatan.php" class="hover:underline transition">Catatan Kas</a></li>
      <li><a href="tambah-transaksi.php" class="hover:underline transition">Tambah Transaksi</a></li>
      <li><a href="laporan.php" class="hover:underline transition">Laporan</a></li>
    </ul>
    <div class="mr-2">
      <a href="logout.php" class="text-sm px-4 py-2 border border-[#1D3557] text-[#1D3557] rounded hover:bg-[#1D3557] hover:text-white transition">
        Logout
      </a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-white py-12 px-8 flex flex-col md:flex-row items-center justify-between">
    <div class="max-w-xl text-[#1D3557] space-y-4">
      <h1 class="text-3xl md:text-4xl font-bold leading-snug">
        Kelola Keuangan Kas <br />
        dengan Mudah
      </h1>
      <p class="text-lg md:text-xl font-medium leading-snug">
        Akses Catatan Keuangan Kelas secara <br />
        Transparan dan Efisien
      </p>
      <div class="flex space-x-4 pt-4">
        <a href="catatan.php" class="px-6 py-3 bg-[#1D3557] text-white rounded-md shadow hover:bg-[#16324f] transition">Lihat Catatan Kas</a>
        <a href="tambah-transaksi.php" class="px-6 py-3 border border-[#1D3557] text-[#1D3557] rounded-md hover:bg-[#1D3557] hover:text-white transition">Tambah Transaksi</a>
      </div>
    </div>
    <div class="mt-8 md:mt-0 md:ml-10">
      <img src="../assets/dasboard.png" alt="Hero Image" class="w-[360px] h-auto ml-auto">
    </div>
  </section>

  <!-- Ringkasan Keuangan -->
  <section class="py-10 px-6 bg-white">
    <div class="flex flex-col md:flex-row justify-center items-center gap-16">
      <div class="bg-[#1D3557] rounded-2xl px-10 py-6 w-[340px] text-[#F0FAEF] shadow-md">
        <h3 class="text-lg font-semibold mb-2 text-left">Total Pemasukan</h3>
        <p class="text-3xl font-bold text-left"><?= formatRupiah($totalPemasukan) ?></p>
      </div>
      <div class="bg-[#1D3557] rounded-2xl px-10 py-6 w-[340px] text-[#F0FAEF] shadow-md">
        <h3 class="text-lg font-semibold mb-2 text-left">Total Pengeluaran</h3>
        <p class="text-3xl font-bold text-left"><?= formatRupiah($totalPengeluaran) ?></p>
      </div>
      <div class="bg-[#1D3557] rounded-2xl px-10 py-6 w-[340px] text-[#F0FAEF] shadow-md">
        <h3 class="text-lg font-semibold mb-2 text-left">Saldo Saat Ini</h3>
        <p class="text-3xl font-bold text-left"><?= formatRupiah($saldo) ?></p>
      </div>
    </div>
  </section>
  

  <!-- Tabel Transaksi Terbaru -->
  <section class="px-6 py-10 bg-white">
    <h2 class="text-2xl font-bold text-[#1D3557] mb-6 text-left max-w-6xl mx-auto">Daftar Transaksi Terbaru</h2>

    <div class="overflow-x-auto max-w-6xl mx-auto border border-black">
      <table class="min-w-full text-[#1D3557] border-collapse border border-black text-center">
        <thead class="bg-[#A8DADB] border border-black">
          <tr>
            <th class="px-6 py-4 text-md font-bold uppercase border border-black">Tanggal</th>
            <th class="px-6 py-4 text-md font-bold uppercase border border-black">Jenis Transaksi</th>
            <th class="px-6 py-4 text-md font-bold uppercase border border-black">Nominal</th>
            <th class="px-6 py-4 text-md font-bold uppercase border border-black">Keterangan</th>
          </tr>
        </thead>
        <tbody class="bg-white text-md">
          <?php while ($row = mysqli_fetch_assoc($queryTransaksi)) : ?>
            <tr class="hover:bg-gray-50 transition border border-black">
              <td class="px-6 py-3 border border-black"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
              <td class="px-6 py-3 border border-black"><?= $row['jenis'] ?></td>
              <td class="px-6 py-3 border border-black"><?= formatRupiah($row['nominal']) ?></td>
              <td class="px-6 py-3 border border-black"><?= $row['keterangan'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- Tombol Lihat Semua -->
    <div class="mt-6 max-w-6xl mx-auto flex justify-end">
      <a href="catatan.php"
        class="inline-block bg-[#1D3557] text-white px-4 py-2 rounded-md font-semibold hover:bg-[#163049] transition duration-200">
        Lihat Semua
      </a>
    </div>
  </section>

</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | Web Design</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    input::placeholder {
      color: #6b7280;
      font-weight: 500;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fadeIn {
      animation: fadeIn 1.2s ease-out both;
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-tr from-blue-700 via-purple-700 to-indigo-700 flex items-center justify-center font-sans p-6">

  <div class="bg-white rounded-3xl shadow-lg flex w-[920px] h-[560px] overflow-hidden">

    <!-- Box Form (Putih, kiri) -->
    <div class="p-12 flex-[2.5] flex flex-col justify-center">
      <!-- Logo dan Judul -->
      <div class="flex justify-center mb-4">
        <div class="flex items-center space-x-4">
          <img src="../assets/logo.png" alt="Logo" class="w-12 h-12 object-contain" />
          <h1 class="text-3xl font-bold text-gray-800 leading-tight">Login</h1>
        </div>
      </div>

      <!-- Login Sosial -->
      <div class="flex justify-center space-x-4 mb-4">
        <div class="border border-gray-300 p-3 rounded-lg cursor-pointer hover:shadow-md">
          <img src="../assets/googlelogo.png" alt="Google" class="w-8 h-8" />
        </div>
        <div class="border border-gray-300 p-3 rounded-lg cursor-pointer hover:shadow-md">
          <img src="../assets/githublogo.png" alt="GitHub" class="w-8 h-8" />
        </div>
        <div class="border border-gray-300 p-3 rounded-lg cursor-pointer hover:shadow-md">
          <img src="../assets/faceboklogo.png" alt="Facebook" class="w-8 h-8" />
        </div>
      </div>

      <!-- Teks separator -->
      <p class="text-center text-sm text-gray-500 mb-6">Atau Login menggunakan password akun anda</p>

      <!-- Formulir Login -->
      <form action="../API/login.php" method="POST" class="space-y-6">
        <input type="email" name="email" required placeholder="Email"
          class="w-full border border-gray-300 rounded-md px-5 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-blue-600" />

        <input type="password" name="password" required placeholder="Password"
          class="w-full border border-gray-300 rounded-md px-5 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-blue-600" />

        <div class="flex justify-center">
          <button type="submit"
            class="px-10 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-base transition">
            Login
          </button>
        </div>
      </form>
    </div>

    <!-- Box Biru (kanan) -->
    <div
      class="hidden md:flex flex-[2.5] rounded-l-[120px] overflow-hidden relative items-center justify-center bg-black/40 px-6 text-center text-white animate-fadeIn">
      <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=600&q=80"
        alt="Ilustrasi" class="h-full w-full object-cover absolute inset-0 z-0" />

      <div class="relative z-10 text-white text-center px-6 animate-fadeIn">
        <h2 class="text-4xl font-bold mb-2 drop-shadow-lg">Hai Semua 👋</h2>
        <p class="text-2xl font-medium drop-shadow-md">Daftarkan diri anda dan mulai gunakan layanan kami segera</p>

        <a href="register.php"
          class="inline-block mt-8 px-10 py-3 bg-blue-600 rounded-lg font-semibold hover:bg-blue-700 transition text-white">
          Daftar
        </a>
      </div>
    </div>

  </div>

</body>

</html>

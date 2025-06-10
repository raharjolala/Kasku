<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register | Web Design</title>

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

    <!-- Box Ilustrasi -->
    <div class="hidden md:flex flex-[2.5] rounded-r-[120px] overflow-hidden relative items-center justify-center bg-black/40">
      <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=600&q=80"
        alt="Ilustrasi" class="h-full w-full object-cover absolute inset-0 z-0" />
      <div class="relative z-10 text-white text-center px-6 animate-fadeIn">
        <h2 class="text-4xl font-bold mb-2 drop-shadow-lg">Selamat Datang</h2>
        <p class="text-2xl font-medium drop-shadow-md mb-4">Kembali 👋</p>
        <p class="text-lg font-medium drop-shadow-md">Sudah Punya Akun</p>
        <p class="text-base mb-6 drop-shadow-md">Silahkan Login ke Akun Anda</p>
        <a href="login.php" class="inline-block border border-white text-white font-semibold px-6 py-2 rounded-md hover:bg-white hover:text-blue-700 transition">
          Login
        </a>
      </div>
    </div>

    <!-- Box Formulir -->
    <div class="p-12 flex-[2.5] flex flex-col justify-center">
      <!-- Logo dan Judul -->
      <div class="flex justify-center mb-4">
        <div class="flex items-center space-x-4">
          <img src="../assets/logo.png" alt="Logo" class="w-12 h-12 object-contain" />
          <h1 class="text-3xl font-bold text-gray-800 leading-tight">Buat Akun Baru</h1>
        </div>
      </div>

      <!-- Sosial Media Login -->
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

      <p class="text-center text-sm text-gray-500 mb-6">Atau gunakan email untuk membuat akun</p>

      <!-- Form -->
      <form action="../api/register.php" method="POST" class="space-y-4" id="formRegister">
        <div>
          <input type="text" name="name" required placeholder="Nama Lengkap"
            class="w-full border border-gray-300 rounded-md px-5 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-blue-600" />
          <p class="text-red-500 text-sm mt-1 hidden" id="errorNama"></p>
        </div>

        <div>
          <input type="email" name="email" required placeholder="Email"
            class="w-full border border-gray-300 rounded-md px-5 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-blue-600" />
          <p class="text-red-500 text-sm mt-1 hidden" id="errorEmail"></p>
        </div>

        <div>
          <input type="password" name="password" required placeholder="Password"
            class="w-full border border-gray-300 rounded-md px-5 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-blue-600" />
          <p class="text-red-500 text-sm mt-1 hidden" id="errorPassword"></p>
        </div>

        <div class="flex justify-center">
          <button type="submit"
            class="px-10 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-base transition disabled:opacity-50 disabled:cursor-not-allowed"
            id="submitBtn">
            Daftar
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Validasi JavaScript -->
  <script>
    const form = document.getElementById("formRegister");
    const namaInput = form.name;
    const emailInput = form.email;
    const passwordInput = form.password;

    const errorNama = document.getElementById("errorNama");
    const errorEmail = document.getElementById("errorEmail");
    const errorPassword = document.getElementById("errorPassword");
    const submitBtn = document.getElementById("submitBtn");

    function validateNama() {
      const nama = namaInput.value.trim();
      const regex = /^[A-Za-z\s]+$/;
      if (!regex.test(nama)) {
        errorNama.textContent = "Nama hanya boleh huruf dan spasi.";
        errorNama.classList.remove("hidden");
        return false;
      }
      if (!/[A-Za-z]$/.test(nama)) {
        errorNama.textContent = "Nama tidak boleh diakhiri dengan spasi atau simbol.";
        errorNama.classList.remove("hidden");
        return false;
      }
      errorNama.classList.add("hidden");
      return true;
    }

    function validateEmail() {
      const email = emailInput.value.trim();
      if (!email.includes("@")) {
        errorEmail.textContent = "Email harus mengandung simbol '@'.";
        errorEmail.classList.remove("hidden");
        return false;
      }
      errorEmail.classList.add("hidden");
      return true;
    }

    function validatePassword() {
      const pw = passwordInput.value;
      const valid = pw.length >= 6 && pw.length <= 20 &&
        /[A-Z]/.test(pw) && /[a-z]/.test(pw) &&
        /[0-9]/.test(pw) && /[@!#$%&*]/.test(pw);
      if (!valid) {
        errorPassword.textContent = "Password harus 6-20 karakter, mengandung huruf besar, kecil, angka & simbol.";
        errorPassword.classList.remove("hidden");
        return false;
      }
      errorPassword.classList.add("hidden");
      return true;
    }

    function validateAll() {
      const valid = validateNama() && validateEmail() && validatePassword();
      submitBtn.disabled = !valid;
      return valid;
    }

    namaInput.addEventListener("input", validateAll);
    emailInput.addEventListener("input", validateAll);
    passwordInput.addEventListener("input", validateAll);

    form.addEventListener("submit", function (e) {
      if (!validateAll()) {
        e.preventDefault();
      }
    });

    // Inisialisasi tombol
    validateAll();
  </script>

</body>

</html>

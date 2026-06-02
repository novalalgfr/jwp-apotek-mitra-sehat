<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Apotek Mitra Sehat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:opsz,wght@6..72,400;6..72,500;6..72,600&display=swap" rel="stylesheet">
    <style>
        .font-serif { font-family: 'Newsreader', serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF9F6] min-h-screen flex items-center justify-center font-sans text-[#2D2A26] selection:bg-[#D97757] selection:text-white">

    <div class="w-full max-w-sm px-8 py-10">

        <div class="text-center mb-10">
            <h1 class="text-4xl font-serif font-medium tracking-tight mb-2 text-[#2D2A26]">Mitra Sehat.</h1>
            <p class="text-sm text-[#73706A]">Masuk ke portal administrasi apotek</p>
        </div>

        @if ($errors->any())
            <div class="bg-[#FDF6F5] border border-[#F3E1DE] text-[#B3412F] text-sm px-4 py-3 rounded-xl mb-6 font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf

            <div class="space-y-1.5">
                <label class="block text-sm font-medium text-[#5C5954]">Username</label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all"
                >
            </div>

            <div class="space-y-1.5">
				<label class="block text-sm font-medium text-[#5C5954]">Password</label>
				<div class="relative">
					<input
						type="password"
						name="password"
						id="password-input"
						class="w-full bg-[#F3F2EE] border border-transparent rounded-xl px-4 py-3 pr-11 text-sm focus:bg-white focus:border-[#D6D3CD] focus:outline-none focus:ring-4 focus:ring-[#F3F2EE] transition-all"
					>
					<button
						type="button"
						id="toggle-password"
						class="absolute inset-y-0 right-0 flex items-center pr-4 text-[#8F8C87] hover:text-[#2D2A26] transition-colors focus:outline-none"
					>
						<svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
						</svg>
						<svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
						</svg>
					</button>
				</div>
			</div>

            <button
                type="submit"
                class="w-full mt-2 bg-[#D97757] hover:bg-[#C6694C] text-white font-medium py-3 rounded-xl transition duration-200 shadow-sm"
            >
                Lanjutkan
            </button>
        </form>

    </div>

	<script>
		const togglePassword = document.getElementById('toggle-password');
		const passwordInput = document.getElementById('password-input');
		const eyeIcon = document.getElementById('eye-icon');
		const eyeSlashIcon = document.getElementById('eye-slash-icon');

		togglePassword.addEventListener('click', function () {
			const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
			passwordInput.setAttribute('type', type);
			
			eyeIcon.classList.toggle('hidden');
			eyeSlashIcon.classList.toggle('hidden');
		});
	</script>
</body>
</html>
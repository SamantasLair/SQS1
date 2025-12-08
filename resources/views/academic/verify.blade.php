<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            Verifikasi Akademisi
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="max-w-4xl w-full mx-4 sm:mx-6 lg:mx-8">
            
            @if(isset($rejected) && $rejected)
            <div class="mb-8 bg-red-900/20 border-l-4 border-red-500 p-6 rounded-r-xl shadow-lg animate-pulse">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-red-400">Pengajuan Ditolak</h3>
                        <div class="mt-2 text-red-200">
                            <p class="font-semibold">Alasan Admin:</p>
                            <p class="italic bg-red-900/40 p-2 rounded mt-1 border border-red-500/30">
                                "{{ $rejected->admin_notes }}"
                            </p>
                        </div>
                        <p class="text-sm text-red-400 mt-4">
                            Silakan perbaiki data Anda sesuai catatan di atas dan ajukan kembali formulir di bawah ini.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl p-8 lg:p-12">
                <div class="text-center mb-10">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Formulir Pengajuan Tier Akademisi</h3>
                    <p class="text-base text-gray-600 dark:text-gray-300">
                        Unggah bukti identitas (KTM, Kartu Pelajar, atau Surat Keterangan) untuk mendapatkan akses khusus tier Akademisi.
                        Pastikan data yang Anda masukkan benar dan dapat dipertanggungjawabkan.
                    </p>
                </div>

                <form action="{{ route('academic.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="space-y-2">
                        <x-input-label for="institution_name" value="Nama Institusi / Sekolah / Universitas" class="text-lg text-gray-800 dark:text-gray-200" />
                        <x-text-input id="institution_name" name="institution_name" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 border-gray-300 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 rounded-xl p-3 sm:text-base bg-gray-50 text-gray-800" required placeholder="Contoh: Universitas Gadjah Mada" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="id_number" value="Nomor Induk (NIM / NISN)" class="text-lg text-gray-800 dark:text-gray-200" />
                        <x-text-input id="id_number" name="id_number" type="text" class="mt-1 block w-full dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 border-gray-300 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 rounded-xl p-3 sm:text-base bg-gray-50 text-gray-800" required placeholder="Contoh: 1234567890" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="document" value="Foto Bukti Identitas (Max 2MB)" class="text-lg text-gray-800 dark:text-gray-200" />
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl bg-gray-50 dark:bg-gray-900 relative" id="drop-area">
                            <div class="space-y-1 text-center">
                                <svg id="upload-icon" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                
                                <div class="flex text-sm text-gray-600 dark:text-gray-300 justify-center items-center gap-1">
                                    <label for="document" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 p-1">
                                        <span id="file-label">Unggah file</span>
                                        <input id="document" name="document" type="file" class="sr-only" required accept=".jpg,.jpeg,.png,.pdf" onchange="updateFileName(this)">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p id="file-name-display" class="text-sm font-bold text-indigo-500 mt-2 hidden"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Format: JPG, PNG, PDF (Max 2MB)
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center pt-6">
                        <x-primary-button class="w-full sm:w-auto px-12 py-4 text-lg font-bold bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-400 rounded-xl transition duration-200 ease-in-out transform hover:scale-105">
                            Kirim Pengajuan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name-display');
            const uploadIcon = document.getElementById('upload-icon');
            
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = 'File terpilih: ' + input.files[0].name;
                fileNameDisplay.classList.remove('hidden');
                uploadIcon.classList.add('text-indigo-500');
            } else {
                fileNameDisplay.textContent = '';
                fileNameDisplay.classList.add('hidden');
                uploadIcon.classList.remove('text-indigo-500');
            }
        }

        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('document');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropArea.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
        }

        function unhighlight(e) {
            dropArea.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
        }

        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            updateFileName(fileInput);
        }
    </script>
</x-app-layout>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.employees.index') }}"
                class="group p-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-100 dark:hover:border-indigo-900 transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-500 dark:from-white dark:to-gray-400 bg-clip-text text-transparent mb-1">
                    Tambah Trainee Baru
                </h1>
                <p class="text-[10px] font-medium text-gray-500 dark:text-gray-400 uppercase tracking-widest">Input profil peserta ke database.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto
                            Trainee</label>
                        <div id="photoPreviewContainer" class="hidden mb-4">
                            <div class="relative inline-block">
                                <img id="photoPreview" src="" class="w-32 h-32 rounded-2xl object-cover border-2 border-indigo-500 shadow-md">
                                <button type="button" onclick="removePhoto()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-lg hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <p id="compressionNote" class="text-[10px] text-emerald-500 mt-1 font-bold italic hidden">✓ Terkompres otomatis (Max 2MB)</p>
                        </div>
                        <input type="file" name="photo" id="photoInput" accept="image/*"
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('photo') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                            Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', request('name')) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Nama trainee" required>
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">NPK</label>
                        <input type="text" name="npk" value="{{ old('npk', request('npk')) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="NPK" required>
                        @error('npk') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Opsional">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Departemen</label>
                        <input type="text" name="department" value="{{ old('department', request('department')) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Opsional">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sub
                            Company</label>
                        <input type="text" name="subco" value="{{ old('subco', request('subco')) }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Opsional">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                        Simpan Trainee
                    </button>
                    <a href="{{ route('admin.employees.index') }}"
                        class="px-5 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const photoInput = document.getElementById('photoInput');
        const photoPreview = document.getElementById('photoPreview');
        const photoPreviewContainer = document.getElementById('photoPreviewContainer');
        const compressionNote = document.getElementById('compressionNote');

        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Preview
            const reader = new FileReader();
            reader.onload = function(event) {
                photoPreview.src = event.target.result;
                photoPreviewContainer.classList.remove('hidden');
                
                // Compress if needed
                compressImage(file);
            };
            reader.readAsDataURL(file);
        });

        function removePhoto() {
            photoInput.value = '';
            photoPreview.src = '';
            photoPreviewContainer.classList.add('hidden');
            compressionNote.classList.add('hidden');
        }

        async function compressImage(file) {
            // Max size 2MB (2 * 1024 * 1024)
            const MAX_SIZE = 2 * 1024 * 1024;
            
            const img = new Image();
            img.src = URL.createObjectURL(file);
            
            img.onload = async () => {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;

                // Max resolution to 1000px width/height for better compression
                const MAX_RES = 1000;
                if (width > height) {
                    if (width > MAX_RES) {
                        height *= MAX_RES / width;
                        width = MAX_RES;
                    }
                } else {
                    if (height > MAX_RES) {
                        width *= MAX_RES / height;
                        height = MAX_RES;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                // Compress to JPEG with 0.7 quality
                canvas.toBlob((blob) => {
                    if (blob.size < file.size || file.size > MAX_SIZE) {
                        const compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });

                        // Set compressed file back to input using DataTransfer
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        photoInput.files = dataTransfer.files;
                        
                        compressionNote.classList.remove('hidden');
                        if (compressedFile.size > MAX_SIZE) {
                            alert('Warning: Foto masih lebih dari 2MB meskipun sudah dikompres. Silakan gunakan foto lain.');
                        }
                    }
                }, 'image/jpeg', 0.7);
            };
        }
    </script>
    @endpush
</x-admin-layout>
@extends('layouts.app')

@section('title', 'Tambah Transaksi Baru')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('transactions.index') }}" 
           class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium text-lg mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Transaksi
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Tambah Transaksi Baru</h1>
        <p class="text-slate-600 text-lg mt-1">Isi formulir di bawah untuk mencatat transaksi</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Date Field -->
            <div class="mb-6">
                <label for="date" class="block text-lg font-semibold text-slate-700 mb-2">
                    Tanggal Transaksi <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="date" 
                       name="date" 
                       value="{{ old('date', date('Y-m-d')) }}"
                       class="w-full px-4 py-3 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('date') border-red-500 @enderror"
                       required>
                @error('date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category Field -->
            <div class="mb-6">
                <label for="category_id" class="block text-lg font-semibold text-slate-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="category_id" 
                        name="category_id" 
                        class="w-full px-4 py-3 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('category_id') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type Field (Radio Buttons) -->
            <div class="mb-6">
                <label class="block text-lg font-semibold text-slate-700 mb-3">
                    Jenis Transaksi <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               name="type" 
                               value="debit" 
                               class="peer sr-only" 
                               {{ old('type', 'debit') == 'debit' ? 'checked' : '' }}
                               required>
                        <div class="px-6 py-4 text-center border-2 border-slate-300 rounded-lg peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 transition duration-200">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-lg font-semibold">Masuk (Debit)</span>
                            <p class="text-sm mt-1 opacity-75">Uang Masuk</p>
                        </div>
                    </label>
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               name="type" 
                               value="credit" 
                               class="peer sr-only" 
                               {{ old('type') == 'credit' ? 'checked' : '' }}
                               required>
                        <div class="px-6 py-4 text-center border-2 border-slate-300 rounded-lg peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition duration-200">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            <span class="text-lg font-semibold">Keluar (Credit)</span>
                            <p class="text-sm mt-1 opacity-75">Uang Keluar</p>
                        </div>
                    </label>
                </div>
                @error('type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount Field -->
            <div class="mb-6">
                <label for="amount_display" class="block text-lg font-semibold text-slate-700 mb-2">
                    Jumlah (Rp) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-500 text-lg font-semibold">Rp</span>
                    </div>
                    <input type="text" 
                           id="amount_display" 
                           value="{{ old('amount') ? number_format(old('amount'), 0, ',', '.') : '' }}"
                           placeholder="0"
                           class="w-full pl-14 pr-4 py-3 text-lg font-semibold border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('amount') border-red-500 @enderror"
                           required
                           autocomplete="off">
                    <input type="hidden" 
                           id="amount" 
                           name="amount" 
                           value="{{ old('amount') }}">
                </div>
                <p class="mt-2 text-sm text-slate-500">Masukkan angka, akan otomatis terformat (contoh: 1.500.000)</p>
                @error('amount')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Field -->
            <div class="mb-6">
                <label for="description" class="block text-lg font-semibold text-slate-700 mb-2">
                    Catatan
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          placeholder="Tambahkan catatan atau keterangan transaksi..."
                          class="w-full px-4 py-3 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Proof Image Field -->
            <div class="mb-8">
                <label for="proof_image" class="block text-lg font-semibold text-slate-700 mb-2">
                    Bukti Transaksi (Gambar) <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-teal-500 transition duration-200">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-base text-slate-600">
                            <label for="proof_image" class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-700 focus-within:outline-none">
                                <span>Unggah file</span>
                                <input id="proof_image" 
                                       name="proof_image" 
                                       type="file" 
                                       accept="image/*"
                                       class="sr-only"
                                       onchange="previewImage(event)"
                                       required>
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-sm text-slate-500">PNG, JPG, GIF hingga 5MB</p>
                    </div>
                </div>
                
                <!-- Image Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <img id="preview" src="" alt="Preview" class="max-w-full h-48 object-contain rounded-lg border border-slate-200">
                </div>
                
                @error('proof_image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 text-lg">
                    Simpan Transaksi
                </button>
                <a href="{{ route('transactions.index') }}" 
                   class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 px-6 rounded-lg transition duration-200 text-center text-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Format number with thousand separator
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Remove non-numeric characters
    function unformatNumber(str) {
        return str.replace(/\./g, '');
    }
    
    // Amount field auto-format
    const amountDisplay = document.getElementById('amount_display');
    const amountHidden = document.getElementById('amount');
    
    amountDisplay.addEventListener('input', function(e) {
        // Get raw value (remove dots)
        let value = unformatNumber(e.target.value);
        
        // Remove non-numeric characters
        value = value.replace(/\D/g, '');
        
        // Update hidden field with raw number
        amountHidden.value = value;
        
        // Format display with dots
        if (value === '') {
            e.target.value = '';
        } else {
            e.target.value = formatNumber(value);
        }
    });
    
    // Prevent non-numeric input
    amountDisplay.addEventListener('keypress', function(e) {
        // Allow only numbers
        if (e.key && !/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });
    
    // Image preview function
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection

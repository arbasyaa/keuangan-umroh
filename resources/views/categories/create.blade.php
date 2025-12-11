@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" 
           class="inline-flex items-center text-teal-600 hover:text-teal-700 font-medium text-lg mb-4">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Kategori
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Tambah Kategori Baru</h1>
        <p class="text-slate-600 text-lg mt-1">Buat kategori transaksi baru</p>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <!-- Name Field -->
            <div class="mb-8">
                <label for="name" class="block text-lg font-semibold text-slate-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       placeholder="Contoh: Visa, Tiket Pesawat, Akomodasi"
                       class="w-full px-4 py-3 text-base border border-slate-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror"
                       required
                       autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-slate-500">Masukkan nama kategori yang mudah dipahami dan deskriptif</p>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 text-lg">
                    Simpan Kategori
                </button>
                <a href="{{ route('categories.index') }}" 
                   class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold py-3 px-6 rounded-lg transition duration-200 text-center text-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

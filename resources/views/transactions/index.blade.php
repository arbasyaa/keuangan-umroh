@extends('layouts.app')

@section('title', 'Pencatatan Keuangan Umroh')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sm:p-6 mb-6">
        <div class="flex flex-col gap-4">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-1">Pencatatan Keuangan Umroh</h1>
                <p class="text-slate-600 text-base sm:text-lg">Kelola transaksi keuangan persiapan umroh</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center justify-center px-5 py-4 bg-purple-600 hover:bg-purple-700 active:bg-purple-800 text-white font-semibold rounded-lg shadow-md transition duration-200 text-base sm:text-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <span>Kelola Kategori</span>
                </a>
                <a href="{{ route('transactions.create') }}" 
                   class="inline-flex items-center justify-center px-5 py-4 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-semibold rounded-lg shadow-md transition duration-200 text-base sm:text-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Tambah Transaksi</span>
                </a>
                <a href="{{ route('transactions.export-pdf') }}" 
                   class="inline-flex items-center justify-center px-5 py-4 bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white font-semibold rounded-lg shadow-md transition duration-200 text-base sm:text-lg sm:col-span-2 lg:col-span-1">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>Download PDF</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-teal-50 border border-teal-200 text-teal-800 px-6 py-4 rounded-lg mb-6 text-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Mobile: Stack Cards -->
        <div class="block lg:hidden divide-y divide-slate-200">
            @forelse($transactions as $transaction)
            <div class="p-4 hover:bg-slate-50 transition">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <div class="text-sm text-slate-500 mb-1">{{ $transaction->date->format('d/m/Y') }}</div>
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                            {{ $transaction->category->name }}
                        </span>
                    </div>
                    <a href="{{ Storage::url($transaction->proof_image) }}" target="_blank" class="flex-shrink-0">
                        <img src="{{ Storage::url($transaction->proof_image) }}" 
                             alt="Bukti" 
                             class="h-16 w-16 object-cover rounded-lg shadow-sm border border-slate-200">
                    </a>
                </div>
                
                @if($transaction->description)
                <p class="text-sm text-slate-600 mb-3">{{ $transaction->description }}</p>
                @endif
                
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Masuk</div>
                        @if($transaction->type === 'debit')
                            <div class="text-base font-semibold text-green-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                        @else
                            <div class="text-slate-400">-</div>
                        @endif
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Keluar</div>
                        @if($transaction->type === 'credit')
                            <div class="text-base font-semibold text-red-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</div>
                        @else
                            <div class="text-slate-400">-</div>
                        @endif
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                    <div>
                        <div class="text-xs text-slate-500">Saldo</div>
                        <div class="text-lg font-bold text-slate-800">Rp {{ number_format($transaction->running_balance, 0, ',', '.') }}</div>
                    </div>
                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-100 hover:bg-red-200 active:bg-red-300 text-red-700 font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-slate-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-base font-medium">Belum ada transaksi</p>
                <p class="text-sm mt-1">Klik tombol "Tambah Transaksi" untuk memulai</p>
            </div>
            @endforelse
        </div>
        
        <!-- Desktop: Table View -->
        <div class="hidden lg:block overflow-x-auto relative">
            <table class="w-full">
                <thead class="bg-slate-100 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-base font-semibold text-slate-700">Tanggal</th>
                        <th class="px-6 py-4 text-left text-base font-semibold text-slate-700">Kategori</th>
                        <th class="px-6 py-4 text-left text-base font-semibold text-slate-700">Catatan</th>
                        <th class="px-6 py-4 text-center text-base font-semibold text-slate-700">Bukti</th>
                        <th class="px-6 py-4 text-right text-base font-semibold text-slate-700">Masuk</th>
                        <th class="px-6 py-4 text-right text-base font-semibold text-slate-700">Keluar</th>
                        <th class="px-6 py-4 text-right text-base font-semibold text-slate-700">Total</th>
                        <th class="px-6 py-4 text-center text-base font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        <td class="px-6 py-4 text-base text-slate-800">
                            {{ $transaction->date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-700">
                                {{ $transaction->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-base text-slate-700">
                            {{ $transaction->description ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ Storage::url($transaction->proof_image) }}" target="_blank" class="inline-block">
                                <img src="{{ Storage::url($transaction->proof_image) }}" 
                                     alt="Bukti" 
                                     class="h-16 w-16 object-cover rounded-lg shadow-sm border border-slate-200 hover:scale-110 transition duration-200">
                            </a>
                        </td>
                        <td class="px-6 py-4 text-right text-base font-semibold">
                            @if($transaction->type === 'debit')
                                <span class="text-green-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-base font-semibold">
                            @if($transaction->type === 'credit')
                                <span class="text-red-600">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-base font-bold text-slate-800">
                            Rp {{ number_format($transaction->running_balance, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-lg transition duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-lg font-medium">Belum ada transaksi</p>
                            <p class="text-base mt-1">Klik tombol "Tambah Transaksi Baru" untuk memulai</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($transactions->isNotEmpty())
    <!-- Summary Card -->
    <div class="mt-6 bg-gradient-to-br from-teal-600 to-teal-700 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg text-teal-100 mb-1">Saldo Akhir</p>
                <p class="text-4xl font-bold">Rp {{ number_format($transactions->last()->running_balance, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/20 rounded-full p-4">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

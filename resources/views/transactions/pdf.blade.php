<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Umroh</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #1e293b;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #0d9488;
        }
        
        .header h1 {
            font-size: 24px;
            color: #0d9488;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 14px;
            color: #64748b;
        }
        
        .meta-info {
            margin-bottom: 20px;
            font-size: 11px;
            color: #64748b;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #f1f5f9;
        }
        
        table th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            border-bottom: 2px solid #cbd5e1;
        }
        
        table td {
            padding: 8px;
            font-size: 11px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        table tbody tr:hover {
            background-color: #f8fafc;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-green {
            color: #059669;
            font-weight: 600;
        }
        
        .text-red {
            color: #dc2626;
            font-weight: 600;
        }
        
        .text-bold {
            font-weight: 700;
        }
        
        .summary {
            background-color: #f0fdfa;
            border: 2px solid #0d9488;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .summary h3 {
            font-size: 14px;
            color: #0d9488;
            margin-bottom: 5px;
        }
        
        .summary p {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .category-badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #f1f5f9;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 500;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Keuangan Umroh</h1>
        <p>Pencatatan Transaksi Keuangan</p>
    </div>

    <div class="meta-info">
        <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i:s') }}</p>
        <p><strong>Total Transaksi:</strong> {{ count($transactions) }} transaksi</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 30%;">Catatan</th>
                <th class="text-right" style="width: 14%;">Masuk</th>
                <th class="text-right" style="width: 14%;">Keluar</th>
                <th class="text-right" style="width: 15%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date->format('d/m/Y') }}</td>
                <td>
                    <span class="category-badge">{{ $transaction->category->name }}</span>
                </td>
                <td>{{ $transaction->description ?? '-' }}</td>
                <td class="text-right">
                    @if($transaction->type === 'debit')
                        <span class="text-green">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    @else
                        <span style="color: #cbd5e1;">-</span>
                    @endif
                </td>
                <td class="text-right">
                    @if($transaction->type === 'credit')
                        <span class="text-red">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    @else
                        <span style="color: #cbd5e1;">-</span>
                    @endif
                </td>
                <td class="text-right text-bold">
                    Rp {{ number_format($transaction->running_balance, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 30px;">Tidak ada transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($transactions) > 0)
    <div class="summary">
        <h3>Saldo Akhir</h3>
        <p>Rp {{ number_format($finalBalance, 0, ',', '.') }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh Sistem Pencatatan Keuangan Umroh</p>
    </div>
</body>
</html>

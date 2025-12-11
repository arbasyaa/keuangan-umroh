<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource with running balance.
     */
    public function index()
    {
        // Fetch all transactions ordered by date ascending
        $transactions = Transaction::with('category')
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Calculate running balance
        $runningBalance = 0;
        $transactionsWithBalance = $transactions->map(function ($transaction) use (&$runningBalance) {
            if ($transaction->type === 'debit') {
                $runningBalance += $transaction->amount;
            } else {
                $runningBalance -= $transaction->amount;
            }
            
            $transaction->running_balance = $runningBalance;
            return $transaction;
        });

        return view('transactions.index', [
            'transactions' => $transactionsWithBalance
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
        ], [
            'proof_image.required' => 'Bukti transaksi wajib diunggah.',
            'proof_image.image' => 'File harus berupa gambar.',
            'proof_image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'proof_image.max' => 'Ukuran gambar maksimal 5MB.'
        ]);

        // Handle image upload
        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('proofs', 'public');
            $validated['proof_image'] = $imagePath;
        }

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    /**
     * Export transactions to PDF.
     */
    public function exportPdf()
    {
        // Fetch all transactions ordered by date ascending
        $transactions = Transaction::with('category')
            ->orderBy('date', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // Calculate running balance
        $runningBalance = 0;
        $transactionsWithBalance = $transactions->map(function ($transaction) use (&$runningBalance) {
            if ($transaction->type === 'debit') {
                $runningBalance += $transaction->amount;
            } else {
                $runningBalance -= $transaction->amount;
            }
            
            $transaction->running_balance = $runningBalance;
            return $transaction;
        });

        $pdf = Pdf::loadView('transactions.pdf', [
            'transactions' => $transactionsWithBalance,
            'finalBalance' => $runningBalance
        ]);

        return $pdf->download('laporan-keuangan-umroh-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Delete the proof image from storage
        if ($transaction->proof_image && Storage::disk('public')->exists($transaction->proof_image)) {
            Storage::disk('public')->delete($transaction->proof_image);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterTransactionsRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Lista todas as transações do usuário com paginação.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->latest();

        // Aplica filtros se fornecidos
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->paginate(20);

        return view('transactions.modern', compact('transactions'));
    }

    /**
     * Exibe os detalhes de uma transação específica.
     */
    public function show(Transaction $transaction)
    {
        // Verifica se a transação pertence ao usuário autenticado
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para visualizar esta transação.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Filtra transações com base nos critérios fornecidos.
     */
    public function filter(FilterTransactionsRequest $request)
    {
        return $this->index($request);
    }

    /**
     * Limpa o histórico de transações do usuário.
     */
    public function clearHistory()
    {
        $user = Auth::user();
        
        // Deleta todas as transações do usuário
        $user->transactions()->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Histórico de transações limpo com sucesso!');
    }
}

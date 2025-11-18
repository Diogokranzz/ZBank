<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCardRequest;
use App\Models\Card;
use App\Services\CardService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    use AuthorizesRequests;
    public function __construct(private CardService $cardService)
    {
    }

    public function index()
    {
        $cards = Auth::user()->cards()->latest()->get();
        
        return view('cards.modern', compact('cards'));
    }

    public function create()
    {
        return view('cards.modern-create');
    }

    public function store(CreateCardRequest $request)
    {
        $user = Auth::user();
        
        $card = Card::create([
            'user_id' => $user->id,
            'card_number' => $this->cardService->generateCardNumber(),
            'card_holder' => strtoupper($user->name),
            'cvv' => $this->cardService->generateCvv(),
            'expiry_date' => $this->cardService->calculateExpiryDate(),
            'type' => $request->type,
            'brand' => $request->brand ?? 'visa',
            'limit' => $this->cardService->getLimitByType($request->type),
            'current_bill' => 0.00,
            'is_blocked' => false,
        ]);

        return redirect()->route('cards.index')
            ->with('success', 'Cartão criado com sucesso!');
    }

    public function show(Card $card)
    {
        $this->authorize('view', $card);
        
        return view('cards.show', compact('card'));
    }

    public function toggleBlock(Card $card)
    {
        $this->authorize('update', $card);
        
        $card->update([
            'is_blocked' => !$card->is_blocked,
        ]);

        $status = $card->is_blocked ? 'bloqueado' : 'desbloqueado';
        
        return back()->with('success', "Cartão {$status} com sucesso!");
    }

    public function destroy(Card $card)
    {
        $this->authorize('delete', $card);
        
        $card->delete();

        return redirect()->route('cards.index')
            ->with('success', 'Cartão removido com sucesso!');
    }

    public function bulkDelete(Request $request)
    {
        $cardIds = json_decode($request->input('card_ids'), true);
        
        if (empty($cardIds) || !is_array($cardIds)) {
            return back()->with('error', 'Nenhum cartão selecionado.');
        }

        $user = Auth::user();
        
        $deletedCount = Card::whereIn('id', $cardIds)
            ->where('user_id', $user->id)
            ->delete();

        return redirect()->route('cards.index')
            ->with('success', "{$deletedCount} cartão(ões) removido(s) com sucesso!");
    }
}

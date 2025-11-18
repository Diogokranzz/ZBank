<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateQrCodeRequest;
use App\Http\Requests\SendPixRequest;
use App\Services\PixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PixController extends Controller
{
    public function __construct(private PixService $pixService)
    {
    }

    /**
     * Exibe a página de PIX.
     */
    public function create()
    {
        $user = Auth::user();
        
        return view('pix.modern', compact('user'));
    }

    /**
     * Gera um QR Code PIX.
     */
    public function generateQrCode(GenerateQrCodeRequest $request)
    {
        $user = Auth::user();
        
        $payload = $this->pixService->generateQrCodePayload(
            $user->pix_key,
            $request->amount,
            $request->description
        );

        return response()->json([
            'success' => true,
            'payload' => $payload,
            'pix_key' => $user->pix_key,
        ]);
    }

    /**
     * Envia um PIX.
     */
    public function sendPix(SendPixRequest $request)
    {
        $user = Auth::user();

        try {
            $transaction = $this->pixService->processTransaction(
                $user,
                $request->recipient_key,
                $request->amount,
                $request->description
            );

            return redirect()->route('pix.create')
                ->with('success', 'PIX enviado com sucesso!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['amount' => $e->getMessage()]);
        }
    }

    /**
     * Exibe o histórico de transações PIX.
     */
    public function history()
    {
        $transactions = Auth::user()
            ->transactions()
            ->whereIn('type', ['pix_sent', 'pix_received'])
            ->latest()
            ->paginate(20);

        return view('pix.history', compact('transactions'));
    }
}

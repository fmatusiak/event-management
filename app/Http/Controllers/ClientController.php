<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected ClientRepository $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function searchClientsByKeywords(Request $request): JsonResponse
    {
        try {
            $keywords = $request->input('keywords');
            $clients = $this->clientRepository->searchClientsByKeywords($keywords);

            return response()->json($clients);
        } catch (Exception $e) {
            Log::error(__('messages.error_search_clients_by_keywords'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            return response()->json(['error' => __('messages.error_search_clients_by_keywords')]);
        }
    }
}

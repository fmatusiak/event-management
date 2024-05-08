<?php

namespace App\Http\Controllers;

use App\Repositories\AddressRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function searchAddressesByKeywords(Request $request): JsonResponse
    {
        try {
            $keywords = $request->input('keywords');
            $addresses = $this->addressRepository->searchAddressesByKeywords($keywords);

            return response()->json($addresses);
        } catch (Exception $e) {
            return response()->json(["error" => __('error_search_addresses_by_keywords')], 400);
        }
    }
}

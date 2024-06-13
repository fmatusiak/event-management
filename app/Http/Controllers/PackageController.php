<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Repositories\PackageRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class PackageController extends Controller
{
    private PackageRepository $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function paginate(Request $request): View
    {
        try {
            $filters = $request->input('filters', []);
            $columns = $request->input('columns', ['*']);
            $perPage = $request->input('per_page', 15);

            $paginator = $this->packageRepository->paginate($filters, $perPage, $columns);

            return view('packages.index', ['paginator' => $paginator]);
        } catch (Exception $e) {
            Log::error(__('messages.error_pagination'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            return view('packages.index', ['error' => __('messages.error_pagination')]);
        }
    }

    public function storePackage(StorePackageRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $package = $this->packageRepository->create($request->all());

            return redirect()->route('packages.create')->with('status', __('messages.created') . " " . $package->getName());
        } catch (Exception $e) {
            Log::error(__('messages.error_create'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            return back()->withInput()->with('error', __('messages.error_create'));
        }
    }

    public function createPackage(): View
    {
        return view('packages.create');
    }

    public function updatePackage(int $packageId, UpdatePackageRequest $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $this->packageRepository->update($packageId, $request->all());

            return redirect()->route('packages.edit', ['packageId' => $packageId])->with('status', __('messages.updated'));
        } catch (ModelNotFoundException) {
            return back()->withInput()->with('error', __('messages.not_found'));
        } catch (Exception $e) {
            Log::error(__('messages.error_update'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            return back()->withInput()->with('error', __('messages.error_update'));
        }
    }

    public function getPackage(int $packageId): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        try {
            $package = $this->packageRepository->get($packageId);

            return view('packages.edit', ['package' => $package]);
        } catch (ModelNotFoundException) {
            return back()->with('error', __('messages.not_found'));
        } catch (Exception $e) {
            Log::error(__('messages.error_retrieve'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            return back()->with('error', __('messages.error_retrieve'));
        }
    }

    public function deletePackage(int $packageId): JsonResponse
    {
        try {
            $this->packageRepository->delete($packageId);

            return response()->json(['status' => __('messages.deleted')]);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => __('messages.not_found')]);
        } catch (Exception $e) {
            Log::error(__('messages.error_delete'), [
                'error_message' => $e->getMessage(),
                'error' => $e,
            ]);

            return response()->json(['error' => __('messages.error_delete')]);
        }
    }
}

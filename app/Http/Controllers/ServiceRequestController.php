<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestStoreRequest;
use App\Http\Requests\ServiceRequestUpdateRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): View
    {
        $serviceRequests = ServiceRequest::latest()->get();

        return view('serviceRequest.index', [
            'serviceRequests' => $serviceRequests,
        ]);
    }

    public function create(Request $request): View
    {
        return view('serviceRequest.create');
    }

    public function store(ServiceRequestStoreRequest $request): RedirectResponse
    {
        ServiceRequest::create(array_merge(
            $request->validated(),
            [
                'user_id' => Auth::id(),
                'status' => 'new',
            ]
        ));

        return redirect()
            ->route('orders.mine')
            ->with('success', 'Servis je uspešno zakazan.');
    }

    public function show(Request $request, ServiceRequest $serviceRequest): View
    {
        return view('serviceRequest.show', [
            'serviceRequest' => $serviceRequest,
        ]);
    }

    public function edit(Request $request, ServiceRequest $serviceRequest): View
    {
        return view('serviceRequest.edit', [
            'serviceRequest' => $serviceRequest,
        ]);
    }

    public function update(ServiceRequestUpdateRequest $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->update($request->validated());

        return redirect()
            ->route('admin.service-requests.index')
            ->with('success', 'Servisni zahtev je ažuriran.');
    }

    public function destroy(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->delete();

        return redirect()
            ->route('admin.service-requests.index')
            ->with('success', 'Servisni zahtev je obrisan.');
    }

    public function mine(): View
    {
        $serviceRequests = ServiceRequest::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('serviceRequest.mine', [
            'serviceRequests' => $serviceRequests,
        ]);
    }
}

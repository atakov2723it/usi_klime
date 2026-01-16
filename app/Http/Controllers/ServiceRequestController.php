<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestStoreRequest;
use App\Http\Requests\ServiceRequestUpdateRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


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

    public function store(\App\Http\Requests\ServiceRequestStoreRequest $request)
{
    ServiceRequest::create([
        'user_id' => Auth::id(),
        'product_id' => $request->product_id,
        'phone' => $request->phone,
        'address' => $request->address,
        'preferred_date' => $request->preferred_date,
        'note' => $request->note,
        'status' => 'new', // ✅ DOZVOLJENO
    ]);

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

        $request->session()->flash('serviceRequest.id', $serviceRequest->id);

        return redirect()->route('service-requests.index');
    }

    public function destroy(Request $request, ServiceRequest $serviceRequest): RedirectResponse
    {
        $serviceRequest->delete();

        return redirect()->route('service-requests.index');
    }

    public function mine()
{
    $serviceRequests = ServiceRequest::where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('serviceRequest.mine', [
        'serviceRequests' => $serviceRequests,
    ]);
}
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestStoreRequest;
use App\Http\Requests\ServiceRequestUpdateRequest;
use App\Models\ServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index(Request $request): Response
    {
        $serviceRequests = ServiceRequest::all();

        return view('serviceRequest.index', [
            'serviceRequests' => $serviceRequests,
        ]);
    }

    public function create(Request $request): Response
    {
        return view('serviceRequest.create');
    }

    public function store(ServiceRequestStoreRequest $request): Response
    {
        $serviceRequest = ServiceRequest::create($request->validated());

        $request->session()->flash('serviceRequest.id', $serviceRequest->id);

        return redirect()->route('serviceRequests.index');
    }

    public function show(Request $request, ServiceRequest $serviceRequest): Response
    {
        return view('serviceRequest.show', [
            'serviceRequest' => $serviceRequest,
        ]);
    }

    public function edit(Request $request, ServiceRequest $serviceRequest): Response
    {
        return view('serviceRequest.edit', [
            'serviceRequest' => $serviceRequest,
        ]);
    }

    public function update(ServiceRequestUpdateRequest $request, ServiceRequest $serviceRequest): Response
    {
        $serviceRequest->update($request->validated());

        $request->session()->flash('serviceRequest.id', $serviceRequest->id);

        return redirect()->route('serviceRequests.index');
    }

    public function destroy(Request $request, ServiceRequest $serviceRequest): Response
    {
        $serviceRequest->delete();

        return redirect()->route('serviceRequests.index');
    }
}

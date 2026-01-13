<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceRequestController
 */
final class ServiceRequestControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $serviceRequests = ServiceRequest::factory()->count(3)->create();

        $response = $this->get(route('service-requests.index'));

        $response->assertOk();
        $response->assertViewIs('serviceRequest.index');
        $response->assertViewHas('serviceRequests', $serviceRequests);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('service-requests.create'));

        $response->assertOk();
        $response->assertViewIs('serviceRequest.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceRequestController::class,
            'store',
            \App\Http\Requests\ServiceRequestControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $phone = fake()->phoneNumber();
        $address = fake()->word();
        $preferred_date = Carbon::parse(fake()->date());
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('service-requests.store'), [
            'user_id' => $user->id,
            'phone' => $phone,
            'address' => $address,
            'preferred_date' => $preferred_date->toDateString(),
            'status' => $status,
        ]);

        $serviceRequests = ServiceRequest::query()
            ->where('user_id', $user->id)
            ->where('phone', $phone)
            ->where('address', $address)
            ->where('preferred_date', $preferred_date)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $serviceRequests);
        $serviceRequest = $serviceRequests->first();

        $response->assertRedirect(route('serviceRequests.index'));
        $response->assertSessionHas('serviceRequest.id', $serviceRequest->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $serviceRequest = ServiceRequest::factory()->create();

        $response = $this->get(route('service-requests.show', $serviceRequest));

        $response->assertOk();
        $response->assertViewIs('serviceRequest.show');
        $response->assertViewHas('serviceRequest', $serviceRequest);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $serviceRequest = ServiceRequest::factory()->create();

        $response = $this->get(route('service-requests.edit', $serviceRequest));

        $response->assertOk();
        $response->assertViewIs('serviceRequest.edit');
        $response->assertViewHas('serviceRequest', $serviceRequest);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceRequestController::class,
            'update',
            \App\Http\Requests\ServiceRequestControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $serviceRequest = ServiceRequest::factory()->create();
        $user = User::factory()->create();
        $phone = fake()->phoneNumber();
        $address = fake()->word();
        $preferred_date = Carbon::parse(fake()->date());
        $status = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('service-requests.update', $serviceRequest), [
            'user_id' => $user->id,
            'phone' => $phone,
            'address' => $address,
            'preferred_date' => $preferred_date->toDateString(),
            'status' => $status,
        ]);

        $serviceRequest->refresh();

        $response->assertRedirect(route('serviceRequests.index'));
        $response->assertSessionHas('serviceRequest.id', $serviceRequest->id);

        $this->assertEquals($user->id, $serviceRequest->user_id);
        $this->assertEquals($phone, $serviceRequest->phone);
        $this->assertEquals($address, $serviceRequest->address);
        $this->assertEquals($preferred_date, $serviceRequest->preferred_date);
        $this->assertEquals($status, $serviceRequest->status);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $serviceRequest = ServiceRequest::factory()->create();

        $response = $this->delete(route('service-requests.destroy', $serviceRequest));

        $response->assertRedirect(route('serviceRequests.index'));

        $this->assertModelMissing($serviceRequest);
    }
}

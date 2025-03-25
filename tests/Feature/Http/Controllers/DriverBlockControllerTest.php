<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Driver;
use App\Models\DriverBlock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DriverBlockController
 */
final class DriverBlockControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $driverBlocks = DriverBlock::factory()->count(3)->create();

        $response = $this->get(route('driver-blocks.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DriverBlockController::class,
            'store',
            \App\Http\Requests\DriverBlockControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $driver = Driver::factory()->create();
        $reason = fake()->text();
        $block_date = Carbon::parse(fake()->dateTime());
        $status = fake()->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->post(route('driver-blocks.store'), [
            'driver_id' => $driver->id,
            'reason' => $reason,
            'block_date' => $block_date->toDateTimeString(),
            'status' => $status,
            'user_id' => $user->id,
        ]);

        $driverBlocks = DriverBlock::query()
            ->where('driver_id', $driver->id)
            ->where('reason', $reason)
            ->where('block_date', $block_date)
            ->where('status', $status)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $driverBlocks);
        $driverBlock = $driverBlocks->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $driverBlock = DriverBlock::factory()->create();

        $response = $this->get(route('driver-blocks.show', $driverBlock));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DriverBlockController::class,
            'update',
            \App\Http\Requests\DriverBlockControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $driverBlock = DriverBlock::factory()->create();
        $driver = Driver::factory()->create();
        $reason = fake()->text();
        $block_date = Carbon::parse(fake()->dateTime());
        $status = fake()->randomElement(/** enum_attributes **/);
        $user = User::factory()->create();

        $response = $this->put(route('driver-blocks.update', $driverBlock), [
            'driver_id' => $driver->id,
            'reason' => $reason,
            'block_date' => $block_date->toDateTimeString(),
            'status' => $status,
            'user_id' => $user->id,
        ]);

        $driverBlock->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($driver->id, $driverBlock->driver_id);
        $this->assertEquals($reason, $driverBlock->reason);
        $this->assertEquals($block_date, $driverBlock->block_date);
        $this->assertEquals($status, $driverBlock->status);
        $this->assertEquals($user->id, $driverBlock->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $driverBlock = DriverBlock::factory()->create();

        $response = $this->delete(route('driver-blocks.destroy', $driverBlock));

        $response->assertNoContent();

        $this->assertModelMissing($driverBlock);
    }
}

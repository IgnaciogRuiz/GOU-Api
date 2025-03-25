<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Allow;
use App\Models\Allows;
use App\Models\Tag;
use App\Models\Trip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AllowsController
 */
final class AllowsControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $allows = Allows::factory()->count(3)->create();

        $response = $this->get(route('allows.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AllowsController::class,
            'store',
            \App\Http\Requests\AllowsControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $tag = Tag::factory()->create();
        $trip = Trip::factory()->create();

        $response = $this->post(route('allows.store'), [
            'tag_id' => $tag->id,
            'trip_id' => $trip->id,
        ]);

        $allows = Allow::query()
            ->where('tag_id', $tag->id)
            ->where('trip_id', $trip->id)
            ->get();
        $this->assertCount(1, $allows);
        $allow = $allows->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $allow = Allows::factory()->create();

        $response = $this->get(route('allows.show', $allow));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AllowsController::class,
            'update',
            \App\Http\Requests\AllowsControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $allow = Allows::factory()->create();
        $tag = Tag::factory()->create();
        $trip = Trip::factory()->create();

        $response = $this->put(route('allows.update', $allow), [
            'tag_id' => $tag->id,
            'trip_id' => $trip->id,
        ]);

        $allow->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($tag->id, $allow->tag_id);
        $this->assertEquals($trip->id, $allow->trip_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $allow = Allows::factory()->create();
        $allow = Allow::factory()->create();

        $response = $this->delete(route('allows.destroy', $allow));

        $response->assertNoContent();

        $this->assertModelMissing($allow);
    }
}

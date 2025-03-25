<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RatingController
 */
final class RatingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $ratings = Rating::factory()->count(3)->create();

        $response = $this->get(route('ratings.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RatingController::class,
            'store',
            \App\Http\Requests\RatingControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $rating = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('ratings.store'), [
            'rating' => $rating,
        ]);

        $ratings = Rating::query()
            ->where('rating', $rating)
            ->get();
        $this->assertCount(1, $ratings);
        $rating = $ratings->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->get(route('ratings.show', $rating));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RatingController::class,
            'update',
            \App\Http\Requests\RatingControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $rating = Rating::factory()->create();
        $rating = fake()->numberBetween(-10000, 10000);

        $response = $this->put(route('ratings.update', $rating), [
            'rating' => $rating,
        ]);

        $rating->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($rating, $rating->rating);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $rating = Rating::factory()->create();

        $response = $this->delete(route('ratings.destroy', $rating));

        $response->assertNoContent();

        $this->assertModelMissing($rating);
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Chat;
use App\Models\User1;
use App\Models\User2;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChatController
 */
final class ChatControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $chats = Chat::factory()->count(3)->create();

        $response = $this->get(route('chats.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChatController::class,
            'store',
            \App\Http\Requests\ChatControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $user1 = User1::factory()->create();
        $user2 = User2::factory()->create();
        $creation_date = Carbon::parse(fake()->dateTime());
        $user = User::factory()->create();

        $response = $this->post(route('chats.store'), [
            'user1_id' => $user1->id,
            'user2_id' => $user2->id,
            'creation_date' => $creation_date->toDateTimeString(),
            'user_id' => $user->id,
        ]);

        $chats = Chat::query()
            ->where('user1_id', $user1->id)
            ->where('user2_id', $user2->id)
            ->where('creation_date', $creation_date)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $chats);
        $chat = $chats->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $chat = Chat::factory()->create();

        $response = $this->get(route('chats.show', $chat));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChatController::class,
            'update',
            \App\Http\Requests\ChatControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $chat = Chat::factory()->create();
        $user1 = User1::factory()->create();
        $user2 = User2::factory()->create();
        $creation_date = Carbon::parse(fake()->dateTime());
        $user = User::factory()->create();

        $response = $this->put(route('chats.update', $chat), [
            'user1_id' => $user1->id,
            'user2_id' => $user2->id,
            'creation_date' => $creation_date->toDateTimeString(),
            'user_id' => $user->id,
        ]);

        $chat->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($user1->id, $chat->user1_id);
        $this->assertEquals($user2->id, $chat->user2_id);
        $this->assertEquals($creation_date, $chat->creation_date);
        $this->assertEquals($user->id, $chat->user_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $chat = Chat::factory()->create();

        $response = $this->delete(route('chats.destroy', $chat));

        $response->assertNoContent();

        $this->assertModelMissing($chat);
    }
}

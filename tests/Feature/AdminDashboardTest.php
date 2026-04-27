<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\Mission;
use App\Models\OfferRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_clients_search_and_filter_work(): void
    {
        $admin = $this->admin();
        Client::factory()->create(['full_name' => 'Alpha Client', 'type' => 'client']);
        Client::factory()->create(['full_name' => 'Beta Prospect', 'type' => 'prospect']);

        $response = $this->actingAs($admin)->get(route('admin.clients.index', ['search' => 'Alpha', 'type' => 'client']));
        $response->assertOk()->assertSee('Alpha Client')->assertDontSee('Beta Prospect');
    }

    public function test_offer_status_filtering_works(): void
    {
        $admin = $this->admin();
        OfferRequest::factory()->create(['title' => 'Offre A', 'status' => 'brouillon']);
        OfferRequest::factory()->create(['title' => 'Offre B', 'status' => 'terminee']);

        $response = $this->actingAs($admin)->get(route('admin.offers.index', ['status' => 'terminee']));
        $response->assertOk()->assertSee('Offre B')->assertDontSee('Offre A');
    }

    public function test_mission_status_update_creates_history(): void
    {
        $admin = $this->admin();
        $mission = Mission::factory()->create(['status' => 'assignee']);

        $this->actingAs($admin)->patch(route('admin.missions.status', $mission), ['status' => 'en_cours'])
            ->assertRedirect();

        $this->assertDatabaseHas('missions', ['id' => $mission->id, 'status' => 'en_cours']);
        $this->assertDatabaseHas('mission_status_histories', ['mission_id' => $mission->id, 'old_status' => 'assignee', 'new_status' => 'en_cours']);
    }

    public function test_client_delete_flow_soft_deletes_client(): void
    {
        $admin = $this->admin();
        $client = Client::factory()->create();

        $this->actingAs($admin)->delete(route('admin.clients.destroy', $client))->assertRedirect(route('admin.clients.index'));

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_chat_conversation_can_be_created(): void
    {
        $admin = $this->admin();
        $receiver = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.chat.store'), [
            'title' => 'CRM updates',
            'receiver_id' => $receiver->id,
        ]);

        $conversationId = ChatConversation::query()->where('title', 'CRM updates')->value('id');
        $response->assertRedirect(route('admin.chat.index', ['conversation' => $conversationId]));
        $this->assertDatabaseHas('chat_conversations', ['title' => 'CRM updates', 'sender_id' => $admin->id, 'receiver_id' => $receiver->id]);
    }

    public function test_chat_message_can_be_sent_in_conversation(): void
    {
        $admin = $this->admin();
        $receiver = User::factory()->create();
        $conversation = ChatConversation::factory()->create([
            'sender_id' => $admin->id,
            'receiver_id' => $receiver->id,
        ]);

        $this->actingAs($admin)->post(route('admin.chat.messages.store', $conversation), [
            'body' => 'Hello from admin',
        ])->assertRedirect(route('admin.chat.index', ['conversation' => $conversation->id]));

        $this->assertDatabaseHas('chat_messages', [
            'chat_conversation_id' => $conversation->id,
            'sender_id' => $admin->id,
            'body' => 'Hello from admin',
        ]);
    }
}

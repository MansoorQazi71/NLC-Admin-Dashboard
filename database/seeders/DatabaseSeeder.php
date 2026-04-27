<?php

namespace Database\Seeders;

use App\Models\AgendaEvent;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\Client;
use App\Models\Mission;
use App\Models\OfferRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $collaborator = User::factory()->create([
            'name' => 'Gabriel',
            'email' => 'gabriel@example.com',
        ]);

        $clients = Client::factory(20)->create();
        OfferRequest::factory(12)->make()->each(function ($offer) use ($clients) {
            $offer->client_id = $clients->random()->id;
            $offer->save();
        });
        Mission::factory(18)->make()->each(function ($mission) use ($clients, $admin) {
            $mission->client_id = $clients->random()->id;
            $mission->assignee_id = $admin->id;
            $mission->save();
        });
        AgendaEvent::factory(24)->create();
        $conversationA = ChatConversation::query()->create([
            'title' => 'Equipe administrative',
            'sender_id' => $admin->id,
            'receiver_id' => $collaborator->id,
            'last_message_at' => now(),
        ]);
        ChatMessage::query()->create([
            'chat_conversation_id' => $conversationA->id,
            'sender_id' => $collaborator->id,
            'body' => 'Hello, merci de mettre a jour le CRM.',
        ]);

        ChatConversation::query()->create([
            'title' => 'Suivi clients prioritaires',
            'sender_id' => $admin->id,
            'receiver_id' => $collaborator->id,
            'last_message_at' => now()->subHour(),
        ]);
    }
}

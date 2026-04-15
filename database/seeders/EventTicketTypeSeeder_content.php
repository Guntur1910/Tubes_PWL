<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;

class EventTicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil organizer atau buat jika tidak ada
        $organizer = User::where('role', 'organizer')->first();
        if (!$organizer) {
            $organizer = User::create([
                'name' => 'Organizer 1',
                'email' => 'organizer@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'organizer',
                'is_verified' => 1,
            ]);
        }

        // Event 1: Konser Coldplay
        $event1 = Event::create([
            'name' => 'Konser Coldplay',
            'description' => 'Live in Jakarta - Pengalaman konser spektakuler dengan band legendaris Coldplay',
            'date' => '2026-12-20',
            'location' => 'Jakarta International Stadium',
            'quota' => 5000,
            'price' => 1500000,
            'organizer_id' => $organizer->id,
        ]);

        // Tiket untuk Event 1
        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'VIP PLATINUM',
            'description' => 'Akses unlimited front row + meet & greet + merchandise eksklusif',
            'price' => 5000000,
            'quota' => 100,
            'sold' => 0,
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'VIP GOLD',
            'description' => 'Front row seating + complimentary drink + exclusive merchandise',
            'price' => 3500000,
            'quota' => 200,
            'sold' => 0,
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'REGULAR',
            'description' => 'Standard seating di area umum',
            'price' => 1500000,
            'quota' => 2000,
            'sold' => 0,
        ]);

        TicketType::create([
            'event_id' => $event1->id,
            'name' => 'EARLY BIRD',
            'description' => 'Diskon 30% untuk pembelian awal',
            'price' => 1050000,
            'quota' => 500,
            'sold' => 0,
        ]);

        // Event 2: Festival Musik Nusantara
        $event2 = Event::create([
            'name' => 'Festival Musik Nusantara',
            'description' => 'Perayaan musik tradisional Indonesia dengan artis-artis ternama',
            'date' => '2026-08-15',
            'location' => 'Ancol Beach Park, Jakarta',
            'quota' => 3000,
            'price' => 500000,
            'organizer_id' => $organizer->id,
        ]);

        TicketType::create([
            'event_id' => $event2->id,
            'name' => 'VIP',
            'description' => 'Area khusus dengan pemandangan terbaik',
            'price' => 1200000,
            'quota' => 300,
            'sold' => 0,
        ]);

        TicketType::create([
            'event_id' => $event2->id,
            'name' => 'STANDAR',
            'description' => 'Tiket reguler untuk area umum',
            'price' => 500000,
            'quota' => 2700,
            'sold' => 0,
        ]);

        // Event 3: Marathon Jakarta 2026
        $event3 = Event::create([
            'name' => 'Marathon Jakarta 2026',
            'description' => 'Lari marathon sejauh 42km melalui jalur ikonik Jakarta',
            'date' => '2026-10-05',
            'location' => 'Monas, Jakarta Pusat',
            'quota' => 2000,
            'price' => 350000,
            'organizer_id' => $organizer->id,
        ]);

        TicketType::create([
            'event_id' => $event3->id,
            'name' => 'HALF MARATHON',
            'description' => 'Berlari sejauh 21km',
            'price' => 350000,
            'quota' => 1000,
            'sold' => 0,
        ]);

        TicketType::create([
            'event_id' => $event3->id,
            'name' => 'FULL MARATHON',
            'description' => 'Berlari sejauh 42km',
            'price' => 500000,
            'quota' => 800,
            'sold' => 0,
        ]);

        TicketType::create([
            'event_id' => $event3->id,
            'name' => '5K RUN',
            'description' => 'Lari santai sejauh 5km untuk semua usia',
            'price' => 150000,
            'quota' => 200,
            'sold' => 0,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = Notification::factory()->count(1000)->make()->toArray();
        foreach ($notifications as $notification) {
            $notificationSave = new Notification();
            $notificationSave->title = $notification['title'];
            $notificationSave->icon = $notification['icon'];
            $notificationSave->save();
        }
    }
}

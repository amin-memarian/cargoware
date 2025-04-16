<?php

namespace Database\Seeders;

use App\Models\RejectionMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RejectionMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'title' => 'عدم تایید تخمین قیمت',
                'message' => 'تخمین قیمت شما به دلیل عدم تطابق با شرایط موجود رد شد.',
            ],
            [
                'title' => 'تأخیر در پردازش',
                'message' => 'پردازش تخمین قیمت شما به دلیل برخی مشکلات فنی به تأخیر افتاده است.',
            ],
            [
                'title' => 'عدم انطباق با معیارها',
                'message' => 'تخمین قیمت شما به دلیل عدم انطباق با معیارهای شرکت رد شد.',
            ],
            [
                'title' => 'عدم تایید مدارک',
                'message' => 'مدارک ارائه‌شده برای تأسیس تخمین قیمت ناقص بود و درخواست شما رد شد.',
            ],
        ];

        foreach ($messages as $message) {
            RejectionMessage::create($message);
        }
    }
}

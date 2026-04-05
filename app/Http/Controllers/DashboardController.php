<?php

namespace App\Http\Controllers;

use App\Models\SmsMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $last7Days = collect(range(6, 0))->map(function ($days) {
            $date = now()->subDays($days);
            return [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d/m'),
                'count' => SmsMessage::whereDate('received_at', $date->toDateString())->count(),
            ];
        });

        $totalMessages = SmsMessage::count();
        $lastMessage = SmsMessage::latest('received_at')->first();
        $topSenders = SmsMessage::whereNotNull('sender')
            ->select('sender', DB::raw('count(*) as total'))
            ->groupBy('sender')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $recentMessages = SmsMessage::latest('received_at')->take(50)->get();

        return view('dashboard', compact('last7Days', 'totalMessages', 'lastMessage', 'topSenders', 'recentMessages'));
    }
}

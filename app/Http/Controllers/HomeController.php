<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $senderBalance = User::first()->balance;
        $receiverBalance = User::orderByDesc('id')->first()->balance;

        return view('welcome', [
            'senderBalance' => $senderBalance,
            'receiverBalance' => $receiverBalance,
        ]);
    }

    public function sendToReceiver() {
        $amount = (int) request()->amount;
        $sender = User::first();
        $receiver = User::orderByDesc('id')->first();
        
        try {
            \DB::transaction(function () use ($amount, $sender, $receiver) {
                // if the amount to be send is more than the sender balance, 
                // it will throw error and no balance changed.
                // you can catch the SQL error with your own error handling

                $sender->update(['balance' => $sender->balance - $amount]);
                
                // for example we have a requirement 
                // that the receiver's balance should not exceed 200
                if ($receiver->balance + $amount > 200) {
                    throw new \Exception('Receiver\'s balance should not exceed 200');
                }

                $receiver->update(['balance' => $receiver->balance + $amount]);
            });
        } 
        catch (\Exception $e) {
            return back()->withInput()->with('notif', $e->getMessage());
        }

        return back();
    }
}

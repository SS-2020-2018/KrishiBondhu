<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Message;
use App\Models\User;
use App\Notifications\ProductReviewed;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $product = Product::findOrFail($id);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);
        $seller = User::find($product->user_id);
        if ($seller && $seller->id !== Auth::id()) {
            $seller->notify(new ProductReviewed(Auth::user()->name, $product->name));
        }

        return redirect()->back()->with('success', 'Review published and seller notified successfully!');
    }

    public function chatRoom($receiver_id)
    {
        $receiver = User::findOrFail($receiver_id);
        
        if (Auth::id() === $receiver->id) {
            return redirect()->route('marketplace.index')->with('error', 'You cannot initiate a chat room thread with yourself.');
        }

        return view('communication.chat', compact('receiver'));
    }

    public function fetchMessages($receiver_id)
    {
        $myId = Auth::id();
        
        // Fetch conversational streams passing between both users
        $messages = Message::where(function($q) use ($myId, $receiver_id) {
            $q->where('sender_id', $myId)->where('receiver_id', $receiver_id);
        })->orWhere(function($q) use ($myId, $receiver_id) {
            $q->where('sender_id', $receiver_id)->where('receiver_id', $myId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages, 'current_user' => $myId]);
    }

    public function sendMessage(Request $request, $receiver_id)
    {
        $request->validate(['message' => 'required|string']);

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver_id,
            'message' => $request->message
        ]);

        return response()->json(['status' => 'success', 'message' => $msg]);
    }

    public function clearNotifications()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function process(Request $r)
    {
        $u = Auth::user();

        $c = Cart::where('user_id', $u->id)->get();

        if ($c->count() == 0) {
            return redirect()->back()->with('error', 'Cart kosong');
        }

        $t = 0;
        foreach ($c as $i) {
            $t += $i->total_amount;
        }

        $o = Order::create([
            'user_id' => $u->id,
            'total_amount' => $t,
            'status' => 'pending',
            'payment_method' => 'QRIS',
            'first_name' => $r->first_name,
            'last_name' => $r->last_name,
            'phone' => $r->phone_number,
            'address' => $r->street_address,
        ]);

        // simpan item ke order_items
        foreach ($c as $i) {
            $o->items()->create([
                'event_id' => $i->event_id,
                'ticket_type_id' => $i->ticket_type_id,
                'quantity' => $i->quantity,
                'price' => $i->price,
            ]);
        }

        // kosongkan cart
        Cart::where('user_id', $u->id)->delete();

        return redirect()->route('user.payment.show', $o->id);
    }
}
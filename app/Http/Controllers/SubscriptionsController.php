<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{
    public function index()
    {
        $userPlan = auth()->user()->subscription->plan->name;
        return view('posts.subscription.index', [
            'plans' =>  Plan::all(),
            'userPlan' => $userPlan
        ]);
    }

    public function update($id)
    {

        auth()->user()->subscription->update([
            'plan_id' => $id
        ]);

        return back()->with('message', 'Subscriptions updated successfully');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        Auth::logout();
        return back();
    }
}

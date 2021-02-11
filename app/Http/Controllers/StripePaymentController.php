<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;

use App\Models\User;
use App\Models\Operator;
use App\Models\Transaction;
use App\Models\Withdrawal;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\Operator as OperatorResource;
use App\Http\Resources\Transaction as TransactionResource;
use App\Http\Resources\Withdrawal as WithdrawalResource;



class StripePaymentController extends Controller
{
    public function stripePost(Request $request)
    {        

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $amount = (float) $request->amount;
        if(
            $transaction = $stripe->charges->create([
            "amount" => $amount * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => $request->desc, 
          ])
        ) {
            $user = request()->user();

            $user->balance += $amount;
            $user->save();

            $new_t = $user->transactions()->create([
                'operator_id' => 1,
                'transaction_id' => $transaction->id,
                'amount' => $amount,
                // 'transaction_at' => time(),
                'transaction_at' => $transaction->created,
                
            ]);

            return new TransactionResource($new_t);

            // Session::flash('success', 'Payment successful!');
            // return back();
        }
        
    }

    public function stripeWithdraw(Request $request)
    {       

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $user = request()->user();
        $amount = (float) $request->amount;
                
        if($user->balance >  $amount) {
            // $withdrawal = $stripe->payouts->create([
            //     "amount" => $amount * 100,
            //     "currency" => "usd",
            //     // 'method' => 'instant',
            //     // 'destination' => 'card_xyz',
            // ]);
            // dd($withdrawal);
            $user->balance -= $amount;
            $user->save();

            $new_w = $user->withdrawals()->create([
                'operator_id' => 1,
                // 'transaction_id' => $withdrawal->id,
                'transaction_id' =>'wd_1IJaxKAGMiljVMuAJaolBhg5',
                'amount' => $amount,
                'transaction_at' => time(),
                // 'transaction_at' => $withdrawal->created,
                
            ]);
            
            return new WithdrawalResource($new_w);

            // Session::flash('success', 'Withdraw successful!');
            // return back();

        } else {
            return response()->json('Insufficient balance!');

            // Session::flash('danger', 'Insufficient balance!');
            // return back();
        }
  
    }

    public function users()
    {
        return UserResource::collection(User::all());
    }

    public function operators()
    {
        return OperatorResource::collection(Operator::all());
    }

    public function transactions()
    {
        return TransactionResource::collection(Transaction::all());
    }

     public function withdrawals()
    {
        return WithdrawalResource::collection(Withdrawal::all());
    }

    public function user_transactions()
    {
        $u_transactions = request()->user()->transactions;
        return TransactionResource::collection($u_transactions);
    }

    public function user_withdrawals()
    {
        $u_withdrawals = request()->user()->withdrawals;
        return WithdrawalResource::collection($u_withdrawals);
    }


}

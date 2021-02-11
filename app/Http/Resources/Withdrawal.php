<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Withdrawal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'operator_id' => $this->operator_id,
            'transaction_id' => $this->transaction_id,
            'amount' => $this->amount,
            'transaction_at' => $this->transaction_at,
        ];
    }
}

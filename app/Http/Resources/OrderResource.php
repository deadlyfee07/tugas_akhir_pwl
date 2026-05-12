<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_amount' => (float) $this->total_amount,
            'payment_status' => $this->payment_status,
            'notes' => $this->notes,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'payment' => new PaymentResource($this->whenLoaded('payment')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

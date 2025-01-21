<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AgreementResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'flight_date' =>  Carbon::parse($this->flight_date)->format('Y-m-d'),
            'duration_of_stay' => $this->duration_of_stay,
            'client_name' => $this->client_name,
            'client_relatives' => $this->client_relatives,
            'tariff_name' => $this->tariff_name,
            'room_type' => $this->room_type,
            'transportation' => $this->transportation,
            'exchange_rate' => $this->exchange_rate,
            'total_price' => $this->total_price,
            'payment_paid' => $this->payment_paid,
            'phone_numbers' => $this->phone_numbers,
            'previous_agreement_taken_away' => $this->previous_agreement_taken_away,
            'comments' => $this->comments,
            'responsible_user' => $this->whenLoaded('responsibleUser'),
            'created_by_id' => $this->whenLoaded('creator'),
            'customer_lists' => $this->whenLoaded('customerLists'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

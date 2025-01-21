<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_by_id',
        'responsible_user_id',
        'flight_date',
        'duration_of_stay',
        'client_name',
        'client_relatives',
        'tariff_name',
        'room_type',
        'transportation',
        'exchange_rate',
        'total_price',
        'payment_paid',
        'phone_numbers',
        'previous_agreement_taken_away',
        'comments',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'flight_date' => 'date',
        'phone_numbers' => 'array',
        'previous_agreement_taken_away' => 'boolean',
        'exchange_rate' => 'float',
        'total_price' => 'float',
        'payment_paid' => 'float',
    ];

    /**
     * Define the relationship to the User model (responsible user).
     *
     * An Agreement is managed by a responsible user.
     */
    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    /**
     * Define the relationship to the User model (creator).
     *
     * An Agreement is created by a specific user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Define the relationship to the CustomerList model.
     *
     * An Agreement can have multiple associated customer lists.
     */
    public function customerLists()
    {
        return $this->hasMany(CustomerList::class);
    }

    /**
     * Scope a query to only include agreements with a specific room type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $roomType
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRoomType($query, $roomType)
    {
        return $query->where('room_type', $roomType);
    }

    /**
     * Scope a query to only include agreements with unpaid balance.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUnpaidBalance($query)
    {
        return $query->whereRaw('total_price > payment_paid');
    }
}

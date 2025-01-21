<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agreement_id',
        'name',
        'room_type',
        'passport_issue_date',
        'passport_expire_date',
        'passport_number',
        'country_of_issue',
        'date_of_birth',
        'place_of_birth',
        'costume_size',
        'passport_image_type',
        'hotel',
        'visa_type',
        'transportation',
        'responsible_user_id',
        'comments',
        'status',
    ];

    /**
     * Define the relationship to the Agreement model.
     *
     * A CustomerList belongs to an Agreement.
     */
    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id');
    }

    /**
     * Define the relationship to the User model (responsible user).
     *
     * A CustomerList is managed by a responsible user.
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    /**
     * Scope a query to only include customers with a specific status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}

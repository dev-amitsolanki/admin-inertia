<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payout extends Model
{
    use HasFactory,SoftDeletes;

    protected $appends = ['total','invoice_ids'];

    protected $fillable = [
        'commission_percentage', 'currency', 'stripe_link', 'user_id', 'paid'
    ];
    /**
     * Get the user that owns the Payout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * Get all of the invoices for the Payout
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'payout_id', 'id');
    }

    public function getTotalAttribute()
    {
        $sum = (int)$this->invoices()->sum('amount_cents');
        return $sum * $this->commission_percentage / 100;
    }
    public function getInvoiceIdsAttribute()
    {
        return $this->invoices()->pluck('id')->toArray();
    }
}

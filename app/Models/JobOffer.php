<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    /**
     * Get the Company that owns the JobOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all of the occupation for the JobOffer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function occupation()
    {
        return $this->hasMany(Occupation::class);
    }
}

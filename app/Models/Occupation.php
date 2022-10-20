<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupation extends Model
{
    use HasFactory;

/**
 * Get all of the jobOffers for the Occupation
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function jobOffers()
{
    return $this->hasMany(JobOffer::class);
}
}

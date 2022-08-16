<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_types extends Model
{
    use HasFactory;

    public function customers() {

        return $this->hasMany(Customers::class);
    }

}

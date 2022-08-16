<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'address',
        'contact_no',
        'email_address',
        'tin',
        'customer_type_id'
    ];
}

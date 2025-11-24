<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'customer_code',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public static function generateCustomerCode()
    {
        $lastCustomer = self::orderBy('id', 'desc')->first();
        $number = $lastCustomer ? intval(substr($lastCustomer->customer_code, 4)) + 1 : 1;
        return 'CUST-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}

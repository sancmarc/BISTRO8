<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billing extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id','sold_to','delivery_date','billing_date','payment_date','processing','memo','cut_fee','final_price','usage','delivery_receipt','delivered_by'];

}

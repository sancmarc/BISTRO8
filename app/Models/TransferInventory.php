<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferInventory extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_id','quantity_stocks','from','to'];
}

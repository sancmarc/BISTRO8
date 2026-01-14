<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['part_name','part_area','weight','basic_unit_price','cost_price','unit_price','selling_price','arrival_date','expiration_date','storage_location','quantity_stocks','note'];
}

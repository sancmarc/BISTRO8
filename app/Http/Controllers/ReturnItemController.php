<?php

namespace App\Http\Controllers;

use App\Models\billing;
use App\Models\Inventory;
use App\Models\ReturnItem;
use Illuminate\Http\Request;

class ReturnItemController extends Controller
{
    public function create(Request $request){
       $returned = new ReturnItem();
       $returned->inventory_id = $request->inventory_id;
       $returned->billing_id = $request->billing_id;
       $returned->returned_by = $request->returned_by;
       $returned->quantity_stocks = $request->quantity_stocks;
       $returned->reason = $request->reason;
       $query = $returned->save();

       if($query){
        $getBilling = billing::find($request->billing_id);
        $getBilling->returned = "RETURNED";
        $queryBilling = $getBilling->save();
        $getInventory = Inventory::find($request->inventory_id);
        $getInventory->quantity_stocks = $getInventory->quantity_stocks + $request->quantity_stocks;
        $queryInventory = $getInventory->save();
        if($queryInventory){
            return response()->json(['code' => 1, 'msg' => 'Return Items has been saved!']);
        }
       }else{
        return response()->json(['code' => 2, 'msg' => 'Something Went Wrong!']);
       }
    }
}

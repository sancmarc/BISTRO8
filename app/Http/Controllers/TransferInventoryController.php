<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\TransferInventory;
use Illuminate\Http\Request;

class TransferInventoryController extends Controller
{
    public function create(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'quantity_stocks' => 'required',
            'to' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $transfer = new TransferInventory();
            $transfer->inventory_id = $request->dataID;
            $transfer->quantity_stocks = $request->quantity_stocks;
            $transfer->from = $request->from;
            $transfer->to = $request->to;
            $query = $transfer->save();
            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
            } else {
                $getInventory = Inventory::find($request->dataID);
                $maxID = Inventory::max('id');
                if ($getInventory->quantity_stocks >= $request->quantity_stocks) {

                    $getInventory->quantity_stocks = $getInventory->quantity_stocks - $request->quantity_stocks;
                    $note = "Transfer quantity :" . $request->quantity_stocks . " Storage From :" . $request->from ." Part Number :". $maxID + 1;
                    $getInventory->note = $note;
                    $queryGetTInventory = $getInventory->save();

                    $NewInventory = new Inventory();
                    $NewInventory->part_name = $getInventory->part_name;
                    $NewInventory->part_area = $getInventory->part_area;
                    $NewInventory->weight = $request->quantity_stocks;
                    $NewInventory->quantity_stocks = $request->quantity_stocks;
                    $NewInventory->basic_unit_price = $getInventory->basic_unit_price;
                    $NewInventory->cost_price = $getInventory->cost_price;
                    $NewInventory->unit_price = $getInventory->unit_price;
                    $NewInventory->selling_price = $getInventory->selling_price;
                    $NewInventory->arrival_date = $getInventory->arrival_date;
                    $NewInventory->expiration_date = $getInventory->expiration_date;
                    $NewInventory->storage_location = $request->to;
                    $queryNewInventory = $NewInventory->save();

                    if ($queryNewInventory) {
                        return response()->json(['code' => 1, 'msg' => 'Transfer Storage has been successfully!']);
                    } else {
                        return response()->json(['code' => 00, 'msg' => 'Something Went Wrong!']);
                    }
                }
            }
        }
    }
}

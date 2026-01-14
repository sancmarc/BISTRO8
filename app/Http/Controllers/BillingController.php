<?php

namespace App\Http\Controllers;

use App\Models\billing;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BillingController extends Controller
{

    public function index()
    {
        return view('dashboard.admin.billing');
    }

    public function create(Request $request)
    {

        $formData = $request->except('_token','part_name','part_area','basic_unit','cost_price','unit_price','selling_price','arrival_date','expiration_date','storage_location');
        $validator = \Validator::make($request->all(), [
            'sold_to' => 'required',
            'delivery_receipt' => 'required',
            'delivery_date' => 'required',
            'delivered_by' => 'required',
            'billing_date' => 'required',
            'payment_date' => 'required',
            'processing' => 'required',
            'usage' => 'required',
            'cut_fee' => 'required',
            'final_price' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $billing = new billing();
            foreach ($formData as $form => $value) {
                $billing->$form = $value;
            }
            $inventory = Inventory::find($request->inventory_id);

            if ($inventory->quantity_stocks >= $request->usage) {
                $total_usage = $inventory->quantity_stocks - $request->usage;

                $inventory->quantity_stocks = $total_usage;
                $inventory->save();

                $query = $billing->save();

                if (!$query) {
                    return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
                } else {
                    return response()->json(['code' => 1, 'msg' => 'Process successfully!']);
                }
            } else {
                return response()->json(['code' => 2, 'msg' => 'Out of Stocks!']);
            }
        }
    }

    public function show()
    {

        $billing = Inventory::join('billings', 'billings.inventory_id', '=', 'inventories.id')
            ->select('inventories.id as inventoryID', 'billings.id as billedID', 'inventories.part_name as partName', 'billings.sold_to as soldTo', 'billings.delivery_date as deliveryDate', 'billings.billing_date as billingDate', 'billings.payment_date as paymentDate', 'billings.cut_fee as cutFee', 'billings.final_price as finalPrice', 'billings.usage as brought', 'billings.processing as processing', 'billings.memo', 'billings.delivery_receipt as deliveryReceipt', 'billings.delivered_by as deliveredBy', 'billings.returned as returned')->orderBy('billings.id', 'desc')->get();
        // dd($billing);
        return DataTables::of($billing)
            ->addColumn('actions', function ($row) {
                $data = '<div class="btn-group">';
                if (Auth::user()->role == 1) {
                    $data .= '<a href="' . route("print.history", '' . $row->billedID . '') . '" target="_BLANK" class="btn btn-sm btn-primary" data-id="' . $row->id . '">Print</a>';
                    if($row->returned == null){
                        $data .='<button class="btn btn-sm btn-warning" id="returnBtn" value="' . $row->inventoryID . '" data-id="' . $row->billedID . '">Return</button>';
                    }
                    $data .='<button class="btn btn-sm btn-danger" id="deleteBtn" value="' . $row->inventoryID . '" data-id="' . $row->billedID . '">Delete</button>';
                } else {
                }
                $data .= '</div>';
                return $data;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function edit(Request $request)
    {
        $details = billing::find($request->billingId);

        return response()->json(['details' => $details]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\InquireMail;
use App\Models\billing;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ViewHistoryController extends Controller
{
    public function index(Request $request)
    {
        $inventory_id = $request->inventory_id;
        $showInventory = Inventory::join('billings', 'inventories.id', '=', 'billings.inventory_id')->where('billings.inventory_id', $inventory_id)->orderBy('inventories.id', 'desc')->get();
        $checkRole = Auth::user()->role;
        return view('dashboard.admin.history')->with('inventory_id', $inventory_id)->with('showInventory', $showInventory)->with('checkRole', $checkRole);
    }
    public function print(Request $request)
    {
        $billedID = $request->billedID;
        $printData = Inventory::join('billings', 'inventories.id', '=', 'billings.inventory_id')->where('billings.id', $billedID)->first();

        return view('dashboard.admin.print')->with('billedID', $billedID)->with('printData', $printData);
    }
    public function checkBarcode(Request $request)
    {


        if ($request->barcodeID) {
            $barcodeID = $request->barcodeID;
            $printData = Inventory::join('billings', 'inventories.id', '=', 'billings.inventory_id')->where('billings.id', $barcodeID)->first();
        } else {
            $barcodeID = '';
            $printData = '';
        }
        return view('dashboard.admin.check-barcode')->with('barcodeID', $barcodeID)->with('printData', $printData);
    }
    public function inquire(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'inquire' => 'required',
    ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $email = $request->email;
            $name = $request->name;
            $inquire = $request->inquire;


            Mail::to($email)->bcc('info@b8-italian.com')->send(new InquireMail($email,$name,$inquire));
                
            if (Mail::flushMacros()) {
                return response()->json(['code' => 0, 'msg' => 'Sorry! Please try again latter']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Thank You for Inquiring! Wait for our team to respond within 24 hours']);
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\billing;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkRole = Auth::user()->role;
        return view('dashboard.admin.index')->with('checkRole', $checkRole);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formData = $request->except('_token');
        $validator = \Validator::make($request->all(), [
            'part_name' => 'required',
            'part_area' => 'required',
            'weight' => 'required',
            'basic_unit_price' => 'required',
            'cost_price' => 'required',
            'unit_price' => 'required',
            'selling_price' => 'required',
            'arrival_date' => 'required',
            'expiration_date' => 'required',
            'storage_location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $inventory = new Inventory();
            foreach ($formData as $form => $value) {
                $inventory->$form = $value;
            }
            $inventory->quantity_stocks = $request->weight;
            $query = $inventory->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Part Name has been successfully saved!']);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $inventory = Inventory::orderBy('id', 'desc');

        return DataTables::of($inventory)
            ->addColumn('actions', function ($row) {
                $checkBilled = billing::where('inventory_id', $row->id)->count();
                $data = '';
                if (Auth::user()->role == 1) {
                    $data .= '<div class="btn-group">';
                    $data .= '<button class="btn btn-sm btn-success" id="yesBtn" data-id="' . $row->id . '">Process</button>';
                    $data .= '<button class="btn btn-sm btn-info" id="editBtn" data-id="' . $row->id . '">Update</button>';
                    if ($checkBilled == 0) {
                        $data .= '<button class="btn btn-sm btn-danger" id="deleteBtn" data-id="' . $row->id . '">Delete</button>';
                    } else {
                        $data .= '<a href="' . route("view.history", '' . $row->id . '') . '" target="_BLANK" class="btn btn-sm btn-primary" id="noBtn" data-id="' . $row->id . '">History</a>';
                    }
                    $data .= '</div>';
                    $data .= '<br>';
                    $data .= '<div class="btn-group">';

                    $data .= '<button class="btn btn-sm btn-secondary" id="updateBtn" data-id="' . $row->id . '">Update Price</button>';
                    if ($row->quantity_stocks > 0) {
                        $data .= '<button class="btn btn-sm btn-warning" id="transferBtn" data-id="' . $row->id . '">Transfer</button>';
                    }
                    // if ($row->note != null) {
                    //     $data .= '<button class="btn btn-sm btn-primary" id="viewNoteBtn" data-id="' . $row->id . '">View Note</button>';
                    // }
                    $data .= '</div>';
                } else {
                    $data .= '<div class="btn-group">';

                    if ($checkBilled > 0) {
                        $data .= '<a href="' . route("view.history", '' . $row->id . '') . '" target="_BLANK" class="btn btn-sm btn-primary" id="noBtn" data-id="' . $row->id . '">History</a>';
                    }
                    $data .= '</div>';
                }

                return $data;
            })
            ->addColumn('notes', function ($row) {
                return '<span class="transferNotes">' . $row->note . '</span>';
            })
            ->rawColumns(['actions', 'notes'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $details = Inventory::find($request->dataID);
        return response()->json(['details' => $details]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $formData = $request->except('_token', 'dataID');
        // dd($formData);
        $validator = \Validator::make($request->all(), [
            'part_name' => 'required',
            'part_area' => 'required',
            'weight' => 'required',
            'basic_unit_price' => 'required',
            'cost_price' => 'required',
            'unit_price' => 'required',
            'selling_price' => 'required',
            'arrival_date' => 'required',
            'expiration_date' => 'required',
            'storage_location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $updateInventory = Inventory::find($request->dataID);

            foreach ($formData as $form => $value) {

                $updateInventory->$form = $value;
            }
            $updateInventory->quantity_stocks = $request->weight;
            $query = $updateInventory->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Updated Successfully!']);
            }
        }
    }
    public function updatePrice(Request $request)
    {

        $formData = $request->except('_token', 'dataID');
        // dd($formData);
        $validator = \Validator::make($request->all(), [
            'basic_unit_price' => 'required',
            'cost_price' => 'required',
            'unit_price' => 'required',
            'selling_price' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $updateInventory = Inventory::find($request->dataID);

            foreach ($formData as $form => $value) {
                $updateInventory->$form = $value;
            }
            $query = $updateInventory->save();

            if (!$query) {
                return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
            } else {
                return response()->json(['code' => 1, 'msg' => 'Updated Price Successfully!']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $details = Inventory::find($request->dataID);
        $query = $details->delete();

        if (!$query) {
            return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'User has been Deleted!']);
        }
    }

    public function searchInventory(Request $request)
    {
        if($request->all()){
            $validated = $request->validate([
                'from' => 'required',
                'to' => 'required',
            ]);
            if ($validated) {
                $from = $request->from;
                $to = $request->to;
                return view('dashboard.admin.search-inventory')->with('from',$from)->with('to',$to);
            } else {
                return redirect()->back()->withInput()->withErrors([
                    'username' => 'The provided credentials do not match our records.',
                    'password' => 'The provided credentials do not match our records.',
                ]);
            }
        }else{
            $from = '';
            $to = '';
            return view('dashboard.admin.search-inventory')->with('from',$from)->with('to',$to);
        }
      
    }
}

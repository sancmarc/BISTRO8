<?php

namespace App\Http\Controllers;

use App\Models\BistroMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BistroMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = BistroMenu::orderBy('id')->paginate(6);
        $fetch = '';
        if ($request->ajax()) {
            foreach ($results as $result) {
                $fetch .= '<div class="col-md-4">
                <div class="card shadow my-5 text-center">
                    <img src="/images/menu/' . $result->menu_image . '" class="img-fluid img-tumb mx-auto" alt="">
                    <div class="card-body">
                        <h5 class="card-title">' . $result->name . '</h5>
                        <p class="card-text">'.$result->details.' <br>' . $result->price . '</p>
                    </div>
                </div>
            </div>';
            }
            return $fetch;
        }
        return view('menu');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $checkRole = Auth::user()->role;
        return view('dashboard.admin.bistro8-menu')->with('checkRole', $checkRole);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|unique:bistro_menus',
            'price' => 'required|string'
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $path = 'images/menu/';
            $file = $request->file('menu_image');
            $file_name = "menu" . time() . '_' . $request->name;
            //    $upload = $file->storeAs($path, $file_name);
            $upload = $file->move(public_path($path), $file_name);
            if ($upload) {
                $menuUpload = new BistroMenu();
                $menuUpload->name = $request->name;
                $menuUpload->price = $request->price;
                $menuUpload->details = $request->details;
                $menuUpload->menu_image = $file_name;
                $query = $menuUpload->save();
                if (!$query) {
                    return response()->json(['code' => 2, 'msg' => 'Something went wrong']);
                } else {
                    return response()->json(['code' => 1, 'msg' => 'New Menu Has been added']);
                }
            }
        }
    }
    public function fetchMenu(Request $request)
    {
        $listMenu = BistroMenu::all();
        $data = \View::make('dashboard.admin.all-menu')->with('listMenu', $listMenu)->render();
        return response()->json(['code' => 1, 'result' => $data]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BistroMenu $bistroMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $details = BistroMenu::find($request->dataID);

        return response()->json(['details' => $details]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $dataID = $request->update_id;
        $menuUpload = BistroMenu::find($dataID);
        $path = 'images/menu/';
        $validator = \Validator::make($request->all(), [
            'update_name' => 'required|string|unique:bistro_menus,name,' . $request->update_id,
            'update_price' => 'required|string'
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            if ($request->hasFile('update_menu_image')) {
                //remove old image
                $oldPicture = $menuUpload->menu_image;
            
                if ($oldPicture != '') {
                    if (\File::exists(public_path($path . $oldPicture))) {
                        \File::delete(public_path($path . $oldPicture));
                    }
                }
                $path = 'images/menu/';
                $file = $request->file('update_menu_image');
                $file_name = "menu" . time() . '_' . $request->update_name;
                //    $upload = $file->storeAs($path, $file_name);
                $upload = $file->move(public_path($path), $file_name);
                if ($upload) {
                    $menuUpload->name = $request->update_name;
                    $menuUpload->price = $request->update_price;
                    $menuUpload->details = $request->update_details;
                    $menuUpload->menu_image = $file_name;
                    $query = $menuUpload->save();
                    if (!$query) {
                        return response()->json(['code' => 2, 'msg' => 'Something went wrong']);
                    } else {
                        return response()->json(['code' => 1, 'msg' => 'Updated Menu']);
                    }
                }
            } else {

                $menuUpload->name = $request->update_name;
                $menuUpload->price = $request->update_price;
                $menuUpload->details = $request->details;

                $query = $menuUpload->save();
                if (!$query) {
                    return response()->json(['code' => 2, 'msg' => 'Something went wrong']);
                } else {
                    return response()->json(['code' => 1, 'msg' => 'Updated Menu']);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $details = BistroMenu::find($request->dataID);
        $query = $details->delete();

        if (!$query) {
            return response()->json(['code' => 0, 'msg' => 'Error! Error!']);
        } else {
            return response()->json(['code' => 1, 'msg' => 'Menu has been Deleted!']);
        }
    }
}

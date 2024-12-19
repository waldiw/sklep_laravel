<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('can:isAdministrator');
    }

    public function filter(Request $request)
    {
        if($request->ajax())
        {
            $data = Orders::where('delete', 0)->get();

            if($request->filled('from_date') && $request->filled('to_date'))
            {
                $data = $data->whereBetween('created_at', [$request->from_date, $request->to_date]);
            }
            $data = DataTables::of($data)->addIndexColumn()->make(true);
            return $data;
        }

        return view('admin.filter');
    }
}

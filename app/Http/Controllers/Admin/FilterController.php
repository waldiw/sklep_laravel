<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\User;
use Carbon\Carbon;
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
        if ($request->ajax()) {
            $query = 0;
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query = 1;
            }
            if ($request->filled('status')) {
                $query = 2;
            }
            if ($request->filled('from_date') && $request->filled('to_date') && $request->filled('status')) {
                $query = 3;
            }

            $data = $this->query($query, $request);
            $data = DataTables::of($data)->addIndexColumn()
                ->addColumn('suma', function ($data) {
                    $orderCart = $data->carts;
                    $totlOrder = number_format(totalOrder($orderCart) / 100, 2, '.', ' ');
                    return $totlOrder;
                })
                ->make(true);

            return $data;
        }

        return view('admin.filter');
    }

    private function query(int $query, Request $request)
    {
        if ($query == 0) {
            $result = Orders::where('delete', 0)->get();
        } elseif ($query == 1) {
            $result = Orders::createdBetweenDates([$request->from_date, $request->to_date])->where('delete', 0)->get();
        } elseif ($query == 2) {
            $result = Orders::where('delete', 0)->whereIn('status', $request->status)->get();
        } elseif ($query == 3) {
            $result = Orders::createdBetweenDates([$request->from_date, $request->to_date])->where('delete', 0)->whereIn('status', $request->status)->get();
        }

        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Region::all();
            return DataTables::of($data)
                ->addColumn('province', function ($row) {
                    return $row->province;
                })
                ->addColumn('city', function ($row) {
                    return $row->city;
                })
                ->make(true);
        }

        return view('index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'txtId' => 'required|string|max:255',
            'txtName' => 'required|string|max:255',
            'txtProvince' => 'required|string|max:255',
            'txtCity' => 'required|string|max:255',
        ]);

        $provinces = json_decode(file_get_contents('https://Mitrasunh.github.io/api-wilayah-indonesia/api/provinces.json'), true);
        $cities = json_decode(file_get_contents('https://Mitrasunh.github.io/api-wilayah-indonesia/api/regencies/' . $request->input('txtProvince') . '.json'), true);

        $provinceName = collect($provinces)->firstWhere('id', $request->input('txtProvince'))['name'];
        $cityName = collect($cities)->firstWhere('id', $request->input('txtCity'))['name'];



        $user = Region::create([
            'id' => $request->input('txtId'),
            'name' => $request->input('txtName'),
            'province' => $provinceName,
            'city' => $cityName,
        ]);

        if ($request->ajax()) {
            return response()->json($user);
        }

        return redirect()->back()->with('success', 'Data saved successfully!');
    }
}

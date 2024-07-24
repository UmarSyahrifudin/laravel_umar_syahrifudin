<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();
        return view('hospitals.index', compact('hospitals'));
    }

    public function store(Request $request)
    {
        Hospital::create($request->all());
        return response()->json(['success' => 'Hospital created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->name = $request->input('name');
        $hospital->address = $request->input('address');
        $hospital->email = $request->input('email');
        $hospital->phone = $request->input('phone');
        $hospital->save();

        return response()->json(['success' => 'Hospital updated successfully']);
    }

    public function destroy($id)
    {
        Hospital::find($id)->delete();
        return response()->json(['success' => 'Hospital deleted successfully.']);
    }
}

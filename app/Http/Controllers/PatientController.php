<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('hospital')->get();
        $hospitals = Hospital::all();
        return view('patients.index', compact('patients', 'hospitals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);
    
        $patient = Patient::create($request->all());
    
        return response()->json(['success' => 'Patient added successfully']);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->name = $request->input('name');
        $patient->address = $request->input('address');
        $patient->phone = $request->input('phone');
        $patient->hospital_id = $request->input('hospital_id');
        $patient->save();

        return response()->json(['success' => 'Patient updated successfully']);
    }

    public function destroy($id)
    {
        Patient::find($id)->delete();
        return response()->json(['success' => 'Patient deleted successfully.']);
    }

    public function getPatientsByHospital($hospitalId)
    {
        if ($hospitalId) {
            $patients = Patient::with('hospital')->where('hospital_id', $hospitalId)->get();
        } else {
            $patients = Patient::with('hospital')->get();
        }

        return response()->json(['patients' => $patients]);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentsResource;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Students::all();

        return new StudentsResource(true, 'Data Students !', $students);
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
        $validator = Validator::make($request->all(), [
            'idnumber' => 'required|unique:students,idnumber',
            'fullname' => 'required',
            'gender' => 'required',
            'phone' => 'required|numeric|unique:students,phone',
            'address' => 'required',
            'emailaddress' => 'required|email|unique:students,emailaddress'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $students = Students::create([
                'idnumber' => $request->idnumber,
                'fullname' => $request->fullname,
                'gender' => $request->gender,
                'address' => $request->address,
                'emailaddress' => $request->emailaddress,
                'phone' => $request->phone,
                'photo' => ''
            ]);

            return new StudentsResource(true, 'Data Berhasil Disimpan !',$students);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $students = Students::find($id);

        if($students){
            return new StudentsResource(true, 'Data Ditemukan !', $students);
        }else{
            return response()->json([
                'message' => 'Data Tidak Ditemukan !'
            ], 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'gender' => 'required',
            'phone' => 'required|numeric|unique:students,phone',
            'address' => 'required',
            'emailaddress' => 'required|email|unique:students,emailaddress'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }else{
            $students = Students::find($id);

            if($students) {
                $students->fullname = $request->fullname;
                $students->gender = $request->gender;
                $students->phone = $request->phone;
                $students->address = $request->address;
                $students->emailaddress = $request->emailaddress;
                $students->save();

                return new StudentsResource(true, 'Data Berhasil Diubah !',$students);

            }else{
                return response()->json([
                    'message' => 'Data Tidak Ditemukan !'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $students = Students::find($id);

            if($students) {
                $students->delete();

                return new StudentsResource(true, 'Data Berhasil Dihapus !', '');

            }else{
                return response()->json([
                    'message' => 'Data Tidak Ditemukan !'
                ]);
            }
    }
}

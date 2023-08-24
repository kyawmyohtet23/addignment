<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        if (!Auth::check()) {
            return response()->json(['error' => 'authenticated'], 401);
        } else {
            $employees = Employee::all();
            return response()->json([
                'result' => 200,
                'message' => 'success',
                'data' => $employees
            ]);
        }
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
        //

        // return $request->all();

        $validation = $this->validation($request);
        if ($validation->fails()) {
            return response()->json([
                'result' => 500,
                'message' => 'Error',
            ]);
        }

        Employee::create([
            'slug' => uniqid() . Str::slug($request->name),
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department,
        ]);

        $employee = Employee::all();

        return response()->json([
            'result' => 201,
            'message' => 'success',
            'data' => $employee
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $slug)
    {
        //
        $validation = $this->validation($request);
        if ($validation->fails()) {
            return response()->json([
                'result' => 500,
                'message' => 'Error',
            ]);
        }



        $employee = Employee::where('slug', $slug)->update([
            'slug' => uniqid() . Str::slug($request->name),
            'name' => $request->name,
            'email' => $request->email,
            'department' => $request->department
        ]);

        return response()->json([
            'result' => 200,
            'message' => 'success',

        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug,)
    {
        //
        // return $slug;
        Employee::where('slug', $slug)->delete();


        return response()->json([
            'result' => 204,
            'message' => 'No Content'
        ]);
    }


    // validation
    private function validation($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'department' => 'required',
        ]);
    }
}

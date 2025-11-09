<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::all());
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'address_complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'registration_date' => 'nullable|date',
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:customers,email,' . $id,
            'phone' => 'string|max:20',
            'birth_date' => 'date',
            'address' => 'string|max:255',
            'address_complement' => 'nullable|string|max:255',
            'neighborhood' => 'string|max:255',
            'zipcode' => 'string|max:10',
            'registration_date' => 'nullable|date',
        ]);

        $customer->update($validated);
        return response()->json($customer);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => 'Customer removed successfully']);
    }
}

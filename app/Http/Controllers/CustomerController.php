<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::paginate(10);
    
        return view('admin.customer', [
            'title' => 'Customer',
            'customers' => $customers,
        ]);
    }

    public function update(Request $request, User $customer)
    {
        $validateData = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:50|unique:users,username,' . $customer->id,
            'phone' => 'nullable|numeric|digits_between:10,15',
            'address' => 'nullable|string|max:255',
        ]);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('user-profile');
        }

        User::where('id', $customer->id)->update($validateData);
        
        return redirect()->route('customer')->with('success', 'Customer updated successfully!');
    }

    public function getCustomerByName(Request $request) {
        $query = $request->input('query-input');
        
        $customers = User::where('name', 'like', '%'.$query.'%')
        ->orWhere('username', 'like', '%'.$query.'%')
        ->paginate(10);

        return view('admin.customer', [
            'title' => 'Customer',
            'customers' => $customers
        ]);
    }
}

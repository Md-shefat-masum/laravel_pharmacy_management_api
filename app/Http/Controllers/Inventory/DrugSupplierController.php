<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\UserSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DrugSupplierController extends Controller
{
    public function all()
    {
        try {
            $query = DB::table('user_suppliers');
            if (request()->has('key') && strlen(request()->key) > 0) {
                $query->where('supplier_name', 'LIKE', '%' . request()->key . '%');
                // $query->where('id', request()->key)
                //     ->orWhere('supplier_name', request()->key)
                //     ->orWhere('company_name', request()->key)
                //     ->orWhere('contact_number', request()->key)
                //     ->orWhere('supplier_name', 'LIKE', '%' . request()->key . '%')
                //     ->orWhere('company_name', 'LIKE', '%' . request()->key . '%')
                //     ->orWhere('contact_number', 'LIKE', '%' . request()->key . '%');
            }
            $categories = $query->where('pharmacy_id', Auth::user()->id)->latest()->where('status', 1)->paginate(10);
            return response()->json($categories, 200);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function get(UserSupplier $category)
    {
        return response()->json($category, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name' => ['required', 'min:4'],
            'company_name' => ['required', 'min:4'],
            'contact_number' => ['required', 'min:4'],
            'email' => ['required', 'min:4'],
            'address' => ['required',],
            // 'city' => ['required','min:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $drug_category = UserSupplier::create($request->all());
        $drug_category->pharmacy_id = Auth::user()->id;
        $drug_category->creator = Auth::user()->id;
        $drug_category->slug = Auth::user()->id . $drug_category->id . rand(1000, 9999);
        $drug_category->save();

        return response()->json($drug_category->only('name', 'description'), 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_name' => ['required', 'min:4'],
            'company_name' => ['required', 'min:4'],
            'contact_number' => ['required', 'min:4'],
            'email' => ['required', 'min:4'],
            'address' => ['required',],
            // 'description' => ['required','min:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $drug_category = UserSupplier::find($request->id);
        $drug_category->fill($request->all());
        $drug_category->save();

        return response()->json($drug_category->only('name', 'description'), 200);
    }

    public function delete(Request $request)
    {
        $drug_category = UserSupplier::find($request->id);
        $drug_category->status = 0;
        $drug_category->save();
        return response()->json('data deleted successfully', 200);
    }
}

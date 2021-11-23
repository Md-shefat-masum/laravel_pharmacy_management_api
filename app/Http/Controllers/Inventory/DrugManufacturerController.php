<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\DrugManufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DrugManufacturerController extends Controller
{
    public function all()
    {
        $categories = DrugManufacturer::where('pharmacy_id', Auth::user()->id)->latest()->where('status', 1)->paginate(10);
        return response()->json($categories, 200);
    }

    public function get(DrugManufacturer $category)
    {
        return response()->json($category, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:4'],
            // 'description' => ['required','min:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $drug_category = DrugManufacturer::create($request->all());
        $drug_category->pharmacy_id = Auth::user()->id;
        $drug_category->creator = Auth::user()->id;
        $drug_category->slug = Auth::user()->id . $drug_category->id . rand(1000, 9999);
        $drug_category->save();

        return response()->json($drug_category->only('name', 'description'), 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:4'],
            // 'description' => ['required','min:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        $drug_category = DrugManufacturer::find($request->id);
        $drug_category->fill($request->all());
        $drug_category->save();

        return response()->json($drug_category->only('name', 'description'), 200);
    }

    public function delete(Request $request)
    {
        $drug_category = DrugManufacturer::find($request->id);
        $drug_category->status = 0;
        $drug_category->save();
        return response()->json('data deleted successfully', 200);
    }
}

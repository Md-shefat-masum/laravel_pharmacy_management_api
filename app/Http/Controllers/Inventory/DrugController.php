<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\DrugInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
    public function all()
    {
        $categories = Drug::where('pharmacy_id', Auth::user()->id)
                        ->withCount(['related_categories','related_drug_manufacturer','related_drug_storage'])
                        ->with(['related_categories:id,name','related_drug_manufacturer:id,name','related_drug_storage:id,name'])
                        ->latest()
                        ->where('status', 1)
                        ->paginate(10);
        return response()->json($categories, 200);
    }

    public function get(Drug $drug)
    {
        return response()->json($drug, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3'],
            'category_id' => ['required', 'min:3'],
            'manufacturer_id' => ['required', 'min:3'],
            'storage_location_id' => ['required', 'min:3'],
            'supplier_id' => ['required', 'min:3'],
            'need_prescription' => ['required','integer'],
            'storage_temperature' => ['required'],
            'dangerous_level' => ['required'],
            'no_of_unit_in_package' => ['required'],
            'unit_price' => ['required'],
            'manufacturing_date' => ['required'],
            'expiry_date' => ['required'],
            'date_of_entry' => ['required'],
            'photo' => ['required'],
        ], [
            'category_id.min' => 'category field is required',
            'manufacturer_id.min' => 'category field is required',
            'storage_location_id.min' => 'category field is required',
            'supplier_id.min' => 'category field is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'data' => $validator->errors(),
            ], 422);
        }

        // return request()->all();

        $drug_data = $request->only([
            'name',
            'need_prescription',
            'scientific_name',
            'storage_temperature',
            'dangerous_level',
            'no_of_unit_in_package',
            'unit_price',
        ]);

        try {
            if (request()->hasFile('photo')) {
                // Storage::put('uploads/drug',request()->file('photo'));
                if ($request->hasFile('photo')) {
                    $image = $request->file('photo');
                    $path = 'uploads/drug/dr-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                    $file = Image::make($image);
                    $file->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $canvas = Image::canvas(400, 400);
                    $canvas->insert($file, 'center-center');
                    $canvas->save(public_path($path));
                    $drug_data['photo'] = $path;
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'data' =>['photo'=>$th->getMessage() ] ]
            , 421);
        }

        $drug_info_data = $request->only([
            'manufacturing_date',
            'expiry_date',
            'quantity',
            'date_of_entry',
        ]);
        $drug_info_data['quantity'] = $request->no_of_unit_in_package;

        $drug = Drug::create($drug_data);
        $drug->pharmacy_id = Auth::user()->id;
        $drug->creator = Auth::user()->id;
        $drug->slug = Auth::user()->id . $drug->id . rand(1000, 9999);
        $drug->save();

        $drug_info = DrugInformation::create($drug_info_data);
        $drug_info->drug_id = $drug->id;
        $drug_info->creator = Auth::user()->id;
        $drug_info->slug = Auth::user()->id . $drug_info->id . rand(1000, 9999);
        $drug_info->save();

        $drug->related_categories()->attach(json_decode($request->category_id));
        $drug->related_drug_manufacturer()->attach(json_decode($request->manufacturer_id));
        $drug->related_drug_storage()->attach(json_decode($request->storage_location_id));
        $drug->related_user_supplier()->attach(json_decode($request->supplier_id));

        return response()->json([$drug,$drug_info], 200);
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

        $drug_category = Drug::find($request->id);
        $drug_category->fill($request->all());
        $drug_category->save();

        return response()->json($drug_category->only('name', 'description'), 200);
    }

    public function delete(Request $request)
    {
        $drug_category = Drug::find($request->id);
        $drug_category->status = 0;
        $drug_category->save();
        return response()->json('data deleted successfully', 200);
    }
}

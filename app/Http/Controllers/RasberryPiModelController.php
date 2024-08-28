<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RasberryPiModel;

class RasberryPiModelController extends Controller
{
    public function view (Request $request) {
        $models = RasberryPiModel::all();

        return view('livewire.pages.manage-rasberry-pi-models.view', compact('models'));
    }

    public function create (Request $request) {
        return view('livewire.pages.manage-rasberry-pi-models.edit');
    }

    public function edit (Request $request, $id) {
        $model = RasberryPiModel::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi-models.edit', compact('model'));
    }

    public function delete (Request $request, $id) {
        $model = RasberryPiModel::where('id', $id)->first();
        return view('livewire.pages.manage-rasberry-pi-models.delete', compact('model'));
    }

    public function destroy (Request $request, $id) {
        RasberryPiModel::where('id', $id)->delete();
        return redirect()->route('rasberry-pi-modal.view')->with("success", "Record(s) deleted successfully.");
    }

    public function save(Request $request) {
        // Validate the request
        $request->validate([
            'model_name' => 'required|max:255',
            'model_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate that the image is of a valid type and size
        ]);
    
        // Prepare data for saving
        $data = [
            "model_name" => $request->model_name,
        ];
    
        // Handle image upload
        if ($request->hasFile('model_image')) {
            $image = $request->file('model_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/model_images', $imageName); // Store image in storage/app/public/model_images folder
            $data['model_image'] = $imageName; // Save the image name to the database
        }
    
        // Check if we are updating an existing record
        if ($request->id) {
            RasberryPiModel::where('id', $request->id)->update($data);
        } else {
            RasberryPiModel::create($data);
        }
    
        return redirect()->route('rasberry-pi-modal.view')->with('success', 'Record(s) saved successfully.');
    }
}

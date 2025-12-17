<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonDeleteController extends Controller
{
     public function delete(Request $request)
    {
        $request->validate([
            'model'  => 'required|string',   // Model Name
            'id'     => 'required|integer',  // Record ID
            'column' => 'required|string',   // Column name
            'path'   => 'required|string',   // Folder path
        ]);

        $modelName = "App\\Models\\" . $request->model;
        
        if (!class_exists($modelName)) {
            return back()->with('error', 'Model not found');
        }

        $model = $modelName::find($request->id);

        if (!$model) {
            return back()->with('error', 'Record not found');
        }

        // Helper call
        removeFileAndUpdateDB($model, $request->column, $request->path);
        
        

        return back()->with('success', 'File deleted successfully!');
    }
}

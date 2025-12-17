<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileAppContent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MobileContentController extends Controller
{
    public function index(Request $request)
    {
        $data = MobileAppContent::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $data->where(function($q) use ($search) {
                $q->where('page_name', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $data->where('status', $request->input('status'));
        }
        
        $data = $data->orderBy('id')->paginate(10);

        return view('admin.mobilecontent.index', compact('data'));
    }

    public function create()
    {
        return view('admin.mobilecontent.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|max:255|unique:mobile_app_contents,page_name',
            'title' => 'nullable|string|min:3|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:1,2,3',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'page_name.required' => 'Page name is required.',
            'page_name.unique' => 'This page name already exists.',
            'status.required' => 'Status field is required.',
            'attachment.image' => 'The file must be a valid image.',
            'attachment.max' => 'Image size should not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = time() . '_' . $attachment->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/img/mobileAppContent');

            

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $attachment->move($destinationPath, $attachmentName);

            $data['attachment'] = $attachmentName;
            
        }

        MobileAppContent::create($data);

        return redirect()
            ->route('admin.mobile-content.index')
            ->with('success', 'Page created successfully.');

    }

    public function edit($id)
    {
        $data = MobileAppContent::findOrFail($id);
        return view('admin.mobilecontent.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = MobileAppContent::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'page_name' => 'required|string|max:255',
            'title' => 'nullable|string|min:3|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:1,2,3',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'page_name.required' => 'Page name is required.',
            'page_name.unique' => 'This page name already exists.',
            'status.required' => 'Status field is required.',
            'attachment.image' => 'The file must be a valid image.',
            'attachment.max' => 'Image size should not exceed 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = time() . '_' . $attachment->getClientOriginalName();
            $destinationPath = public_path('assets/uploads/img/mobileAppContent');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $attachment->move($destinationPath, $attachmentName);

            // $attachment->attachment = $attachmentName;
            $data['attachment'] = $attachmentName;
        }

        MobileAppContent::where('id', $id)->update($data);

        return redirect()
            ->route('admin.mobile-content.index')
            ->with('success', 'Page updated successfully.');
    }

     public function destroy($id)
    {
        $content = MobileAppContent::findOrFail($id);
        $content->delete();
        return redirect()->route('admin.mobile-content.index')
                         ->with('success', 'Page deleted successfully.');
    }

    public function trashed()
    {
        $contents = MobileAppContent::onlyTrashed()->get();
        return view('admin.mobile-content.trashed', compact('contents'));
    }

    public function restore($id)
    {
        $content = MobileAppContent::onlyTrashed()->findOrFail($id);
        $content->restore();
        return redirect()->route('admin.mobile-content.index')
                         ->with('success', 'Page restored successfully.');
    }

    public function forceDelete($id)
    {
        $content = MobileAppContent::onlyTrashed()->findOrFail($id);

        if ($content->attachment && File::exists(public_path('assets/uploads/img/mobileAppContent/'.$content->attachment))) {
            File::delete(public_path('assets/uploads/img/mobileAppContent/'.$content->attachment));
        }

        $content->forceDelete();
        return redirect()->route('admin.mobile-content.index')
                         ->with('success', 'Page permanently deleted.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show(){
        //
    }

    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Feedback deleted successfully.');
    }

    public function feedbackReply(Request $request, $id){
        $request->validate([
            'reply' => 'required|string'
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->reply = $request->reply;
        $feedback->status = '1';
        $feedback->replied_at = now();
        $feedback->save();

        return back()->with('success', 'Reply sent successfully!');
    }
}

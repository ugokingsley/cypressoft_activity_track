<?php

namespace App\Http\Controllers;
use App\Models\ActivityCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $data = ActivityCalendar::all()->where('user_id', $user->id);
        return view('activity.index', [
            'data' => $data
        ]);
    }

    public function create(Request $request)
    {
        return view('activity.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'activity_day' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|string',
            'user_id' => 'exists:users,id',
        ]);

        $data['user_id'] = $user->id;

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }

        ActivityCalendar::create($data);
        return redirect()->route('activity')->with('success','Added Activity!');
        //return response()->json($activity);
    }

    public function edit($id){
        $activity = ActivityCalendar::find($id);
        return view('activity.edit')->with([
               'activity' => $activity,
           ]);
    }

    public function update(Request $request, ActivityCalendar $activity)
    {
        $user = $request->user();
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|string',
            'user_id' => 'exists:users,id',
        ]);
        $data['user_id'] = $user->id;
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }

        $activity->update($data);
        return redirect()->route('activity')->with('success','Added Activity!');
        //return response()->json($activity);
    }


    public function destroy(ActivityCalendar $activity, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $activity->user_id) {
            return abort(403, 'Unauthorized action.');
        }
        $activity->delete();
        return redirect()->route('activity');
        //return response('', 204);
    }


}

<?php

namespace App\Http\Controllers;
use App\Models\ActivityCalendar;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
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

    //Admin Index
    public function admin_index()
    {
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = ActivityCalendar::all();
        return view('activity.index', compact('data'));
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

        $activity_day_count =  ActivityCalendar::all()
                                ->where('user_id', $user->id)
                                ->where('activity_day', $request->input('activity_day'))
                                ->count();
        $data['user_id'] = $user->id;

        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/Image'), $filename);
            $data['image']= $filename;
        }

        if($activity_day_count >= 4){
            return back()->withErrors('You have entered up to four activity for this day');
        }

        ActivityCalendar::create($data);
        return redirect()->route('activity')->with('success','Added Activity!');

    }

    public function edit(Request $request, $id){
        $user = $request->user();
        $activity = ActivityCalendar::find($id);

        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }
        return view('activity.edit')->with([
               'activity' => $activity,
           ]);
    }

    public function update(Request $request, ActivityCalendar $activity)
    {
        $user = $request->user();
        $data = $this->validate($request, [
            'activity_day' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|string',
            'user_id' => 'exists:users,id',
        ]);
        //$data['user_id'] = $user->id;

        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }

        $activity->update($request->all());

        return redirect()->route('activity')->with('success','Added Activity!');
    }


    public function destroy(ActivityCalendar $activity, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }
        $activity->delete();
        return redirect()->route('activity');
    }


}

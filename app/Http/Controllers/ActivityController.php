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
    /**
     * Display activities created by user.
     *
     * @param \App\Models\ActivityCalendar $data
     * @return $data
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $data = ActivityCalendar::all()->where('user_id', $user->id);
        //$admin_data = ActivityCalendar::all()->where(Gate::denies('admin_access'));
        return view('activity.index', [
            'data' => $data,
            //'admin_data' => $admin_data,
        ]);
    }

    /**
     * Display all activities in the app for admin users alone.
     *
     * @param \App\Models\ActivityCalendar $data
     * @return $data
     */
    public function admin_index()
    {
        //check to see is user has admin permission
        abort_if(Gate::denies('admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = ActivityCalendar::all();
        return view('activity.index', compact('data'));
    }

    /**
     * Display Activity form.
     */
    public function create(Request $request)
    {
        return view('activity.create');
    }

    /**
     * Save activity to database.
     *
     * @param \App\Models\ActivityCalendar $data
     * @return $data
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'activity_day' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'user_id' => 'exists:users,id',
        ]);

        // count the activity posted for a particular calender day
        $activity_day_count =  ActivityCalendar::all()
                                ->where('user_id', $user->id)
                                ->where('activity_day', $request->input('activity_day'))
                                ->count();
        $data['user_id'] = $user->id;

        //check to see if image was uploaded
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('images'), $filename);
            $data['image']= $filename;
        }
        //throw error is user has created four or more
        // activity in a calendar day
        if($activity_day_count >= 4){
            return back()->withErrors('You have entered up to four activity for this day');
        }

        ActivityCalendar::create($data);
        return redirect()->route('activity')->with('success','Added Activity!');

    }

    /**
     * Display the specified activity.
     *
     * @param \App\Models\ActivityCalendar $activity
     * @return  $activity
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $activity = ActivityCalendar::find($id);

        // check to make sure that admin and user who created this
        // activity can view
        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }
        return view('activity.show')->with([
               'activity' => $activity,
           ]);
    }


    /**
     * Display activity form with contents.
     * for editing by both the creator(user)
     * and admin
     */
    public function edit(Request $request, $id){
        $user = $request->user();
        $activity = ActivityCalendar::find($id);

        // check to make sure that admin and user who created this
        // activity can only update it and display form
        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }
        return view('activity.edit')->with([
               'activity' => $activity,
           ]);
    }

    /**
     * save the updated activity to database
     */
    public function update(Request $request, ActivityCalendar $activity)
    {
        $user = $request->user();
        $data = $this->validate($request, [
            'activity_day' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable',
            'user_id' => 'exists:users,id',
        ]);


        // check to make sure that admin and user who created this
        // activity can only update it and save to db
        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }

        $activity->update($request->all());

        return redirect()->route('activity')->with('success','Added Activity!');
    }


    /**
     * Delete activity
     */
    public function destroy(ActivityCalendar $activity, Request $request)
    {
        $user = $request->user();
        // only user that created this activity and
        // user with admin access can delete
        if ($user->id !== $activity->user_id AND Gate::denies('admin_access')) {
            return abort(403, 'Unauthorized action.');
        }
        $activity->delete();
        return redirect()->route('activity');
    }


}

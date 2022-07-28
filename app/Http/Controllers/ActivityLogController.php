<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function all_activity_log(Request $request)
    {
        $user = $request->user();
        $all = Activity::all();
        return response()->json([
            'message' => 'success',
            'all_logs' => $all,
        ]);

    }

    public function user_activity_log(Request $request)
    {
        $user = $request->user();
        $all = Activity::all()->where('causer_id', $user->id);
        return response()->json([
            'message' => 'success',
            'all_logs' => $all,
        ]);

    }
}

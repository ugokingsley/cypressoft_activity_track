<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;
use DB;

class ActivityLogController extends Controller
{
    /**
     * Display user activity logs of currently logged in users
     * @return $data
     */

    public function user_activity_log(Request $request)
    {
        $from_day = Carbon::parse($request->start_date)->toDateTimeString();
        $to_day = Carbon::parse($request->end_date)->toDateTimeString();

        $user = $request->user();
        if(!empty($request->from_day)){
            $all = DB::table('activity_log')
                    ->where('causer_id', $user->id)
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->orderBy('id','DESC')
                    ->get();
        } else {
            $all = DB::table('activity_log')->where('causer_id', $user->id)->get();
        }
        return response()->json([
            'message' => 'success',
            'all_logs' => $all,
        ]);

    }
}

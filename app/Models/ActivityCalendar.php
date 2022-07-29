<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ActivityCalendar extends Model
{
    use HasFactory;
    use LogsActivity;

    // log changes for the fields
    protected static $logAttributes = ['activity_day','user_id', 'title','description','image'];
    // name of log
    protected static $logName = 'Activity';
    // log only change attributes
    protected static $logOnlyDirty = true;
    // record events of the following
    protected static $recordEvents = ['created','updated','deleted'];

    public function getDescriptionForEvent(string $eventName):string{
        return "Activity {$eventName}";
    }

    function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['user_id', 'updated_at', 'title']);
    }


    protected $fillable = [
        'user_id',
        'activity_day',
        'title',
        'description',
        'image'
    ];



}

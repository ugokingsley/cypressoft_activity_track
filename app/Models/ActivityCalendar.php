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


    protected static $logAttributes = ['activity_day','user_id', 'title'];

    protected static $logName = 'Activity';

    protected static $logOnlyDirty = true;

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

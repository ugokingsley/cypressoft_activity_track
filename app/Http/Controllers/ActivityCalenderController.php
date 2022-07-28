<?php

namespace App\Http\Controllers;
use App\Models\ActivityCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ActivityCalenderController extends Controller
{
    /**
     * Save image in local file system and return saved image path
     *
     * @param $image
     * @throws \Exception
     * @author ugokingsley <ugokingsley5@gmail.com>
     */
    private function saveImage($image)
    {
        // Check if image is valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without mime type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('did not match data URI with image data');
        }

        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }


    public function index(Request $request)
    {
        $user = $request->user();
        if($request->ajax()) {
            $data = ActivityCalendar::all()->where('user_id', $user->id);
            return response()->json($data);
        }
        return view('dashboard');
    }


    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'nullable|string',
            'user_id' => 'exists:users,id',
        ]);
        $data['user_id'] = $user->id;
        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath  = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $activity = ActivityCalendar::create($data);
        return response()->json($activity);
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

        // Check if image was given and save on local file system
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;

            // If there is an old image, delete it
            if ($activity->image) {
                $absolutePath = public_path($activity->image);
                File::delete($absolutePath);
            }
        }

        $activity->update($data);
        return response()->json($activity);
    }


    public function destroy(ActivityCalendar $activity, Request $request)
    {
        $user = $request->user();
        if ($user->id !== $activity->user_id) {
            return abort(403, 'Unauthorized action.');
        }
        $activity->delete();
        // If there is an old image, delete it
        if ($activity->image) {
            $absolutePath = public_path($activity->image);
            File::delete($absolutePath);
        }

        return response('', 204);
    }


    public function calendarActivity(Request $request)
    {
        $user = $request->user();
        switch ($request->type) {
            case 'create':
                $data = $this->validate($request, [
                    'title' => 'required',
                    'description' => 'required',
                    'image' => 'nullable|string',
                    'user_id' => 'exists:users,id',
                ]);
                $data['user_id'] = $user->id;
                // Check if image was given and save on local file system
                if (isset($data['image'])) {
                    $relativePath  = $this->saveImage($data['image']);
                    $data['image'] = $relativePath;
                }

                $event = ActivityCalendar::create($data);

              return response()->json($event);
             break;

           case 'edit':
              $event = ActivityCalendar::find($request->id)->update($data);
              return response()->json($event);
             break;

           case 'delete':
              $event = ActivityCalendar::find($request->id)->delete();

              return response()->json($event);
             break;

           default:

             break;
        }
    }
}

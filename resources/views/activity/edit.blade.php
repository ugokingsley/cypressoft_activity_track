<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Activity') }}
        </h2>
    </x-slot>
    <div class="card"><br>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    @if($errors->any())
                    <div class="alert alert-danger" >
                        <p><strong>Opps Something went wrong</strong></p>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <h2 style="text-align: center;"><b>Edit Activity</b></h2>
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <form action="{{ route('update',$activity->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="day" class="form-label">Activity Day</label>
                            <input type="date" value="{{ old('activity_day', $activity->activity_day) }}"  name="activity_day" class="form-control" id="day" aria-describedby="day">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" value="{{ old('title', $activity->title) }}"  name="title" class="form-control" id="title">
                        </div>
                        <div class="mb-3">
                            <label class="description" for="description">description</label>
                            <input type="text" value="{{ old('description', $activity->description) }}"  name="description" class="form-control" id="exampleCheck1">
                        </div>
                        <div class="mb-3">
                            <label class="file" for="image">Image</label>
                            <input type="file" value="{{ old('image',$activity->image) }}" name="image" class="form-control" id="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form><br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

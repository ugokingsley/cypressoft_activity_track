<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Activity') }}
        </h2>
    </x-slot>
    <div class="card"><br>
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
        <div class="container">
            <h2 style="text-align: center;"><b>Enter and Save Activity</b></h2>
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                    <form action="{{ route('created') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="day" class="form-label">Activity Day</label>
                            <input type="date" required name="activity_day" class="form-control" id="day" aria-describedby="day">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" required name="title" class="form-control" id="title">
                        </div>
                        <div class="mb-3">
                            <label class="description" for="description">description</label>
                            <input type="text" required name="description" class="form-control" id="exampleCheck1">
                        </div>
                        <div class="mb-3">
                            <label class="file" for="image">Image</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form><br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

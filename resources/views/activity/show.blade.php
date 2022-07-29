<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Activity') }}
        </h2>
    </x-slot>
    <div class="card"><br>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2>{{ $activity->title }}</h2>
                    {{ $activity->activity_day }}<br>
                    {{ $activity->description }}
                    <img src="{{ asset('images/'.$activity->image) }}" id="Image" name="Image" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

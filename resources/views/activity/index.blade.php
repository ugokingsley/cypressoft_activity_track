<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Activity') }}
        </h2>
    </x-slot>
    <div class="container">
        <a href="{{ route('created') }}" class="btn btn-primary btn-sm" style="margin:0 3em 3em 0;">Add Activity</a>
        <div class="card">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Day</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($data as $dt)
                        <tr>
                            <th scope="row">{{ $dt->activity_day }}</th>
                            <td>{{ $dt->title }}</td>
                            <td>{{ $dt->description }}</td>
                            <td><a href="{{ route('edit', $dt->id) }}">edit</a></td>
                            <td>
                                <form class="inline-block" action="{{ route('destroy', $dt->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="text-red-600 hover:text-red-900 mb-2 mr-2" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

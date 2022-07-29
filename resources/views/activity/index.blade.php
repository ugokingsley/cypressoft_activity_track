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
                    <th scope="col">User</th>
                    <th scope="col"></th>

                </tr>
                </thead>

                <tbody>
                    @foreach ($data as $dt)
                        <tr>
                            <th scope="row">{{ $dt->activity_day }}</th>
                            <td>{{ $dt->title }}</td>
                            <td>{{ $dt->description }}</td>
                            <td>{{ $dt->user_id }}</td>
                            <td><a class="btn btn-success" href="{{ route('show', $dt->id) }}">view</a></td>
                            <td><a class="btn btn-success" href="{{ route('edit', $dt->id) }}">edit</a></td>

                            <td>
                                <form class="inline-block" action="{{ route('destroy', $dt->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Activity Users') }}
        </h2>
    </x-slot>
    <div class="container">
        <a href="{{ route('users_create') }}" class="btn btn-primary btn-sm" style="margin:0 3em 3em 0;">Add User</a>
        <div class="card">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Email Verified At</th>
                    <th scope="col">Roles</th>
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->email_verified_at }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $role->title }}
                            </span>
                            @endforeach
                        </td>
                        <td>
                            <form class="inline-block" action="{{ route('users_destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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

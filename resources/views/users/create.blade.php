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
        <h2 style="text-align: center;"><b>Create a New User</b></h2>
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <form method="post" action="{{ route('users_create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="day" class="form-label">Name</label>
                        <input value="{{ old('name', '') }}" type="text" required name="name" class="form-control" id="name" aria-describedby="day">
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input value="{{ old('email', '') }}" type="email" required name="email" class="form-control" id="name" aria-describedby="day">
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="day" class="form-label">Password</label>
                        <input type="password" required name="password" class="form-control" id="name" aria-describedby="day">
                        @error('password')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Roles</label>
                        <select name="roles[]" id="roles">
                            @foreach($roles as $id => $role)
                                <option value="{{ $id }}"{{ in_array($id, old('roles', [])) ? ' selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form><br>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

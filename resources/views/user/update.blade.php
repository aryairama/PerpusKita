@extends('layouts.global')
@section('title')
Update Profile
@endsection
@section('css')

@endsection
@section('js')

@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">User Profile</h2>
                <h5 class="text-white op-7 mb-2">Show & Update User Profile</h5>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">
                            @if (session('status'))
                            <span class="badge badge-{{ session('type') }}">{{ session('status') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method("POST")
                        <div class="form-group">
                            <label for="name">Fullname</label>
                            <input class="form-control w-50 @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ $user->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control w-50 @error('email') is-invalid @enderror" type="email"
                                name="email" id="email" value="{{ $user->email }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input class="form-control w-50 @error('password') is-invalid @enderror" type="password"
                                name="password" id="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input class="form-control w-50 @error('confirm_password') is-invalid @enderror"
                                type="password" name="confirm_password" id="confirm_password">
                            @error('confirm_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input class="form-control w-50 @error('old_password') is-invalid @enderror" type="password"
                                name="old_password" id="old_password">
                            @error('old_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" class="form-control w-50 @error('address') is-invalid @enderror"
                                rows="3" name="address">{{ $user->address }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input class="form-control w-50 @error('phone') is-invalid @enderror" type="number"
                                name="phone" id="phone" value="{{ $user->phone }}">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-check form-check-inline">
                            @if ($user->gender == "L")
                            <input class="form-check-input  @error('gender') is-invalid @enderror" type="radio"
                                name="gender" id="gender" value="L" checked>
                            <label class="form-check-label" for="gender">Male</label>
                            <input class="form-check-input  @error('gender') is-invalid @enderror" type="radio"
                                name="gender" id="gender" value="P">
                            <label class="form-check-label" for="gender">Female</label>
                            @endif
                            @if ($user->gender == "P")
                            <input class="form-check-input  @error('gender') is-invalid @enderror" type="radio"
                                name="gender" id="gender" value="L">
                            <label class="form-check-label" for="gender">Male</label>
                            <input class="form-check-input  @error('gender') is-invalid @enderror" type="radio"
                                name="gender" id="gender" value="P" checked>
                            <label class="form-check-label" for="gender">Female</label>
                            @endif
                            @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-sm btn-rounded btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

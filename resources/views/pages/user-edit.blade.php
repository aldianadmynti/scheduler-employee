@extends('partials.index')
@section('content')
    @error('error')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- head --}}
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Schedule</h5>

            <nav>
                <div class="">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">edit</li>
                    </ol>
                </div>
            </nav>

            <div class="">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create</button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center gap-2">
        <div class="col-md-12 p-3 bg-white shadow-sm">
            <form action="{{ route('user.update', $user->id) }}" method="post" class="needs-validation" novalidate>
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="input text"
                        required value="{{ $user->name }}">
                    <div class="invalid-feedback">please input</div>
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="input text"
                        required value="{{ $user->email }}">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                    <div class="invalid-feedback">please input</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save user</button>
                </div>
            </form>
        </div>
        <div class="col-md-12 p-3 bg-white shadow-sm">
            <form action="{{ route('user.change.password', $user->id) }}" method="post" class="needs-validation"
                novalidate>
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="input text">
                    <div class="invalid-feedback">please input</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save password</button>
                </div>
            </form>
        </div>
    </div>
@endsection

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
                        <li class="breadcrumb-item"><a href="#">Schedul</a></li>
                        <li class="breadcrumb-item active">edit</li>
                    </ol>
                </div>
            </nav>
        </div>
    </div>

    <form action="{{ route('scheduller.update', $scheduller->id) }}" method="post" class="needs-validation" novalidate>
        @csrf
        @method('PUT')
        @if (auth()->user()->role->name == 'admin')
            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" class="form-select" id="user_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $scheduller->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">please select</div>
            </div>
        @else
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        @endif
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input name="title" type="text" class="form-control" id="title" placeholder="input title schedule"
                required value="{{ $scheduller->title }}">
            <div class="invalid-feedback">please input</div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="start_date" class="form-label">Start Date:</label>
                    <input name="start_date" type="date" class="form-control" id="start_date"
                        placeholder="input start date time" required value="{{ $scheduller->start_date }}">
                    <div class="invalid-feedback">please input</div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="end_date" class="form-label">End Date:</label>
                    <input name="end_date" type="date" class="form-control" id="end_date"
                        placeholder="input end date time" required value="{{ $scheduller->end_date }}">
                    <div class="invalid-feedback">please input</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="place" class="form-label">Place</label>
                    <input name="place" type="text" class="form-control" id="place" placeholder="input place"
                        required value="{{ $scheduller->place }}">
                    <div class="invalid-feedback">please input</div>
                </div>
                <div class="col-md-12 mb-3">
                    <!-- TinyMCE Editor -->
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description">{{ $scheduller->description }}</textarea><!-- End TinyMCE Editor -->
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update schedule</button>
        </div>
    </form>
@endsection

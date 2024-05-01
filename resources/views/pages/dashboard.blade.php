@extends('partials.index')
@section('script-head')
@endsection
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
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">index</li>
                    </ol>
                </div>
            </nav>
        </div>
    </div>

    <div id="welcome">
        <div class="row justify-content-center">
            <!-- Sales Card -->
            <div class="col-md-6">
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Schedulle <span>| alert</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ auth()->user()->getUnreadScheduller->count() }}</h6>
                                <span class="text-muted small pt-2 ps-1">Unread schedule</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Schedulle <span>| alert</span></h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-info-circle"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ auth()->user()->getDeadlineScheduller->count() }}</h6>
                                <span class="text-muted small pt-2 ps-1">In deadline</span>

                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- End Revenue Card -->
        </div>
    </div>
@endsection

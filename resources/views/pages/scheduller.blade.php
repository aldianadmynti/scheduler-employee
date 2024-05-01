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
                        <li class="breadcrumb-item active">index</li>
                    </ol>
                </div>
            </nav>

            <div class="">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createModal">
                    Create</button>
            </div>
        </div>
    </div>

    <form action="{{ route('scheduller.index') }}" method="get" role="search">
        <div class="row justify-content-center mb-3">
            <div class="col-md-2">
                <input name="date" type="date" class="form-control" id="date" placeholder="input date">
            </div>
            <div class="col-md-7 text-center d-flex">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">Search</button>
            </div>
        </div>
    </form>

    {{-- items --}}
    @if ($datas->isEmpty())
        @include('components.empty')
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    @if (auth()->user()->role->name == 'admin')
                        <th scope="col">Name User</th>
                    @endif
                    <th scope="col">Title</th>
                    <th scope="col">Start date</th>
                    <th scope="col">Start end</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $index => $data)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        @if (auth()->user()->role->name == 'admin')
                            <td>{{ $data->user->name }}</td>
                        @endif
                        <td>{{ $data->title }}</td>
                        <td>
                            {{ $data->start_date }}
                        </td>
                        <td>
                            {{ $data->end_date }}
                        </td>
                        <td class="d-flex gap-2">
                            <button title="go view" data-title="{{ $data->title }}"
                                data-description="{{ $data->description }}" data-start-date="{{ $data->start_date }}"
                                data-end-date="{{ $data->end_date }}" data-place="{{ $data->place }}"
                                data-bs-toggle="modal" data-bs-target="#viewModal" class="btn btn-outline-dark"><i
                                    class="bi bi-eye"></i></button>
                            <form action="{{ route('scheduller.destroy', $data->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button title="mark complate" class="btn btn-dark" type="submit">Done</button>
                            </form>
                            <form action="{{ route('scheduller.edit', $data->id) }}" method="get">
                                @csrf
                                <button title="mark complate" class="btn btn-dark" type="submit">Edit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('scheduller.store') }}" method="post" class="needs-validation" novalidate>
                        @csrf
                        @if (auth()->user()->role->name == 'admin')
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" class="form-select" id="user_id" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">please select</div>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        @endif
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input name="title" type="text" class="form-control" id="title"
                                placeholder="input title schedule" required>
                            <div class="invalid-feedback">please input</div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="start_date" class="form-label">Start Date:</label>
                                    <input name="start_date" type="date" class="form-control" id="start_date"
                                        placeholder="input start date time" required>
                                    <div class="invalid-feedback">please input</div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="end_date" class="form-label">End Date:</label>
                                    <input name="end_date" type="date" class="form-control" id="end_date"
                                        placeholder="input end date time" required>
                                    <div class="invalid-feedback">please input</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="place" class="form-label">Place</label>
                                    <input name="place" type="text" class="form-control" id="place"
                                        placeholder="input place" required>
                                    <div class="invalid-feedback">please input</div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <!-- TinyMCE Editor -->
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description"></textarea><!-- End TinyMCE Editor -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create schedule</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">View Schedule</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="view-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="view-title" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view-description" class="form-label">Description</label>
                        <textarea class="form-control" id="view-description" readonly></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="view-start-date" class="form-label">Start Date</label>
                        <input type="text" class="form-control" id="view-start-date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view-end-date" class="form-label">End Date</label>
                        <input type="text" class="form-control" id="view-end-date" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="view-place" class="form-label">Place</label>
                        <input type="text" class="form-control" id="view-place" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-body')
    <script>
        document.querySelectorAll('.btn-outline-dark').forEach(button => {
            button.addEventListener('click', () => {
                const title = button.getAttribute('data-title');
                const description = button.getAttribute('data-description');
                const startDate = button.getAttribute('data-start-date');
                const endDate = button.getAttribute('data-end-date');
                const place = button.getAttribute('data-place');

                document.getElementById('view-title').value = title;
                document.getElementById('view-description').value = description;
                document.getElementById('view-start-date').value = startDate;
                document.getElementById('view-end-date').value = endDate;
                document.getElementById('view-place').value = place;
            });
        });
    </script>
@endsection

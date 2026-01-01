@extends('layout.master')

@section('title', 'Session Progress')

@section('admincontent')

<div class="container-fluid py-4">

    <div class="card shadow-lg">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Session Progress</h5>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Session ID</th>
                            <th>PDF</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($progress as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->session_id }}</td>

                                <td>
                                    <a href="{{ asset('storage/'.$item->pdf_file) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-primary">
                                        View PDF
                                    </a>
                                </td>

                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.session.progress.updateStatus', $item->id) }}">
                                        @csrf

                                        <select name="pdf_status"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()">

                                            <option value="pending" {{ $item->pdf_status === 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>

                                            <option value="approved" {{ $item->pdf_status === 'approved' ? 'selected' : '' }}>
                                                Approved
                                            </option>

                                            <option value="rejected" {{ $item->pdf_status === 'rejected' ? 'selected' : '' }}>
                                                Rejected
                                            </option>

                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No uploaded sessions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection

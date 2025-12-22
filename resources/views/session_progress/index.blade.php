@extends('layout.master')

@section('title', 'Session Progress')

@section('admincontent')

<div class="container-fluid py-4">

    <div class="card shadow-lg">
        <div class="card-header bg-gradient-dark text-white">
            <h5 class="mb-0">Session Progress (PDF Uploads)</h5>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>User ID</th>
                            <th>Course ID</th>
                            <th>Subject ID</th>
                            <th>Section ID</th>
                            <th>Session ID</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($progress as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user_id }}</td>
                                <td>{{ $item->course_id }}</td>
                                <td>{{ $item->subject_id }}</td>
                                <td>{{ $item->section_id }}</td>
                                <td>{{ $item->session_id }}</td>

                                <td>
                                    @if($item->pdf_file)
                                        <a href="{{ asset('storage/'.$item->pdf_file) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-primary">
                                            View PDF
                                        </a>
                                    @else
                                        <span class="badge bg-secondary">No File</span>
                                    @endif
                                </td>

                                <td>
                                    <span class="badge
                                        {{ $item->pdf_status === 'approved' ? 'bg-success' :
                                           ($item->pdf_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($item->pdf_status) }}
                                    </span>
                                </td>

                                <td>
                                    @if($item->pdf_status === 'pending')
                                        <form method="POST"
                                              action="{{ route('admin.session.progress.approvePdf', $item->id) }}"
                                              class="d-inline">
                                            @csrf
                                            <button class="btn btn-success btn-sm">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('admin.session.progress.rejectPdf', $item->id) }}"
                                              class="d-inline">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">
                                                Reject
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection

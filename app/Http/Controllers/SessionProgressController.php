<!-- @extends('layout.master')

@section('title', 'Session Progress')

@section('admincontent')

<div class="container-fluid py-4">

    <div class="card shadow-lg">
        <div class="card-header bg-gradient-dark text-white">
            <h5 class="mb-0">Session Progress (PDF Uploads)</h5>
        </div>

        <div class="card-body">

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Course</th>
                            <th>Subject</th>
                            <th>Section</th>
                            <th>Session</th>
                            <th>PDF</th>
                            <th>Status</th>
                            <th>Change Status</th>
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

                                {{-- PDF --}}
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

                                {{-- CURRENT STATUS --}}
                                <td>
                                    <span class="badge
                                        {{ $item->pdf_status === 'approved' ? 'bg-success' :
                                           ($item->pdf_status === 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                        {{ ucfirst($item->pdf_status) }}
                                    </span>
                                </td>

                                {{-- STATUS DROPDOWN --}}
                                <td>
                                    <form method="POST"
                                          action="{{ route('admin.session.progress.updateStatus', $item->id) }}">
                                        @csrf

                                        <select name="pdf_status"
                                                class="form-select form-select-sm"
                                                onchange="confirm('Change status?') && this.form.submit()"
                                                {{ $item->pdf_status === 'approved' ? 'disabled' : '' }}>

                                            <option value="pending"
                                                {{ $item->pdf_status === 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>

                                            <option value="approved">
                                                Approved
                                            </option>

                                            <option value="rejected">
                                                Rejected
                                            </option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-muted">No records found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection
 -->

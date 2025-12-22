@extends('layout.master')

@section('admincontent')
<div class="container py-4">
    <h3 class="mb-4">Session Upload Approvals</h3>

    @foreach (['success','error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : 'success' }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Pending Approvals</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>User</th>
                        <th>Session</th>
                        <th>Step</th>
                        <th>File</th>
                        <th>Status</th>
                        <th width="160">Actions</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($uploads as $u)
                    @php
                        $steps = ['pdf','task','exam'];
                    @endphp

                    @foreach($steps as $step)
                        @php
                            $fileColumn = $step . "_file";
                            $statusColumn = $step . "_status";
                            $file = $u->$fileColumn;
                            $status = $u->$statusColumn;
                        @endphp

                        @if($file)
                        <tr>
                            <td>{{ $u->user_name }}</td>
                            <td>{{ $u->session_title }}</td>
                            <td>{{ strtoupper($step) }}</td>

                            <td>
                                <a href="{{ asset('storage/' . $file) }}"
                                   target="_blank" class="btn btn-sm btn-info">
                                    View File
                                </a>
                            </td>

                            <td>
                                <span class="badge
                                    {{ $status == 'pending' ? 'bg-warning' : ($status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                @if($status == 'pending')
                                <form method="POST" action="{{ route('admin.session.uploads.approve') }}" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="progress_id" value="{{ $u->id }}">
                                    <input type="hidden" name="step" value="{{ $step }}">
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form method="POST" action="{{ route('admin.session.uploads.reject') }}" style="display:inline">
                                    @csrf
                                    <input type="hidden" name="progress_id" value="{{ $u->id }}">
                                    <input type="hidden" name="step" value="{{ $step }}">
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                                @else
                                    <span class="text-muted">No action</span>
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach

                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">No uploads found.</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection

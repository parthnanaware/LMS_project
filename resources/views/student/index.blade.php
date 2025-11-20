@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Student List</h6>
                        <a href="{{ route('student.create') }}" class="btn btn-sm btn-primary me-3">Add New Student</a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body px-3 pb-2">

                    <!-- Alerts -->
                    @foreach (['success', 'error', 'warning'] as $msg)
                        @if(session($msg))
                            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} alert-dismissible fade show" id="alert-{{ $msg }}">
                                {{ session($msg) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    @endforeach

                    <script>
                        // Auto-hide all alerts after 3 seconds
                        setTimeout(function() {
                            document.querySelectorAll('.alert').forEach(function(alert) {
                                alert.classList.remove('show');
                                alert.classList.add('hide');
                                alert.style.display = 'none';
                            });
                        }, 3000);
                    </script>

                    <!-- Table -->
                    @if($data->isEmpty())
                        <p class="text-muted">No students found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Photo</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $student)
                                        <tr>
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>
                                                @if ($student->photo)
                                                    <img src="{{ asset('storage/profiles/'.$student->photo) }}" alt="Profile" width="50" height="50" class="rounded-circle">
                                                @else
                                                    <span class="text-muted">No Photo</span>
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($student->role) }}</td>
                                            <td>
                                                <form action="{{ route('student.toggleStatus', $student->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $student->status ? 'btn-success' : 'btn-danger' }}">
                                                        {{ $student->status ? 'Active ' : 'Inactive'}}
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="d-flex gap-1">
                                                <a href="{{ route('student.edit', $student->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('student.destroy', $student->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

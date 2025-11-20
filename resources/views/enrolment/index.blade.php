@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white ps-3">Enrolments List</h6>
                    <a href="{{ route('enrolment.create') }}" class="btn btn-sm btn-primary me-3">Add New Enrolment</a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif

                    @if($enrolments->isEmpty())
                        <p class="text-center my-3">No enrolments found.</p>
                    @else
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>MRP</th>
                                        <th>Sell Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrolments as $enrolment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $enrolment->student->name  }}</td>
                                            <td>{{ $enrolment->course->course_name ?? 'N/A' }}</td>
                                            <td>{{ $enrolment->mrp }}</td>
                                            <td>{{ $enrolment->sell_price }}</td>
                                            <td>
                                                <a href="{{ route('enrolment.edit', $enrolment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('enrolment.destroy', $enrolment->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this enrolment?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

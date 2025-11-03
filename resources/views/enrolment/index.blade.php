@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3 mb-0">Enrolment List</h6>
                    <a href="{{ route('enrolment.create') }}" class="btn btn-sm btn-primary ms-auto me-3">Add New Enrolment</a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif

                    {{-- @if($enrolments->isEmpty())
                        <p class="text-center my-3">No enrolments found.</p>
                    @else --}}
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Course Name</th>
                                        <th>MRP</th>
                                        <th>Sell Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($enrolments as $enrolment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $enrolment->student->student_name ?? 'N/A' }}</td>
                                            <td>{{ $enrolment->course->course_name ?? 'N/A' }}</td>
                                            <td>₹{{ number_format($enrolment->mrp, 2) }}</td>
                                            <td>₹{{ number_format($enrolment->sell_price, 2) }}</td>

                                            <td>
                                                <a href="{{ route('enrolment.edit', $enrolment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('enrolment.destroy', $enrolment->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this enrolment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

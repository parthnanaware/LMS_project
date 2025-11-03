@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
     <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
    <h6 class="text-white text-capitalize ps-3 mb-0">Course List</h6> <!-- mb-0 to remove bottom margin -->
    <a href="{{ route('corse.create') }}" class="btn btn-sm btn-primary ms-auto me-3">Add New Course</a> <!-- ms-auto for right alignment, me-3 for spacing -->
</div>


                <div class="card-body px-0 pt-0 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success m-3">{{ session('success') }}</div>
                    @endif

                    @if($courses->isEmpty())
                        <p class="text-center my-3">No courses found.</p>
                    @else
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Course Name</th>
                                        <th>Description</th>
                                        <th>Subjects</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $course->course_name }}</td>
                                            <td>{{ $course->course_description }}</td>

                                            <td>
                                                @php
                                                    $subjectNames = \App\Models\tbl_subject::whereIn('subject_id', $course->subject_id ?? [])->pluck('subject_name')->toArray();
                                                @endphp
                                                {{ implode(', ', $subjectNames) }}
                                            </td>

                                            <td>
                                                @if($course->course_image)
                                                    <img src="{{ asset('storage/course_images/' . $course->course_image) }}" width="60" class="img-fluid">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('corse.edit', $course->course_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('corse.destroy', $course->course_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this course?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
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

@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Course List</h4>
                </div>
                <div class="card-body">

                    <div class="mb-4">
                        <a href="{{ route('corse.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Create New Course
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        @foreach($courses as $course)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <img src="{{ asset('storage/' . $course->course_image) }}" alt="Course Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $course->course_title }}</h5>
                                        <p class="card-text">
                                            {{ Str::limit($course->course_description, 100) }}
                                        </p>
                                        <p class="text-muted">Subject:
                                            <span class="font-weight-bold">
                                                {{ $course->subject ? $course->subject->subject_name : 'No Subject Assigned' }}
                                            </span>
                                        </p>
                                        <a href="{{ route('course.show', $course->id) }}" class="btn btn-primary w-100">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

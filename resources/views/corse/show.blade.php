@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <h4 class="mb-0">Course Details</h4>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $course->course_image) }}"
                             alt="Course Image"
                             class="img-fluid rounded"
                             style="max-height: 300px; object-fit: cover;">
                    </div>

                    <h3 class="text-center mb-3">{{ $course->course_title }}</h3>

                    <p class="text-center text-muted">
                        <strong>Subject:</strong>
                        {{ $course->subject ? $course->subject->subject_name : 'No Subject Assigned' }}
                    </p>

                    <div class="mb-4">
                        <h5 class="text-dark">Description</h5>
                        <p class="text-muted">
                            {{ $course->course_description }}
                        </p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('corse.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>

                        <div>
                            <a href="{{ route('corse.edit', $course->id) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('corse.destroy', $course->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this course?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

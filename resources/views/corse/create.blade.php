@extends('layout.master')

@section('admincontent')
<br><br>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Create New Course</h4>
                </div>

                <div class="card-body px-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('corse.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Course Name</label>
                            <input type="text" name="name" id="name" class="form-control shadow-sm"
                                   placeholder="Enter course name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control shadow-sm" id="description" placeholder="Enter description" rows="4">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="course_image" class="form-label">Course Image</label>
                            <input type="file" name="course_image" id="course_image" class="form-control shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Select Subjects</label>
                            <div class="row">
                                @foreach($subjects as $subject)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="subject_{{ $subject->subject_id }}" name="subject_id[]" value="{{ $subject->subject_id }}"
                                                   {{ in_array($subject->subject_id, old('subject_id', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="subject_{{ $subject->subject_id }}">{{ $subject->subject_name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success w-45">
                                <i class="fa fa-save"></i> Save Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

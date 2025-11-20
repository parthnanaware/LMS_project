@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">

                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Edit Course</h4>
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

                    <form action="{{ route('corse.update', $course->course_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Course Name --}}
                        <div class="mb-3">
                            <label class="form-label">Course Name</label>
                            <input type="text"
                                   name="course_name"
                                   class="form-control shadow-sm"
                                   value="{{ old('course_name', $course->course_name) }}"
                                   required>
                        </div>

                        {{-- Course Image --}}
                        <div class="mb-3">
                            <label class="form-label">Course Image</label>
                            <input type="file" name="course_image" class="form-control shadow-sm">

                            @if($course->course_image)
                                <div class="mt-3 border rounded p-2 text-center bg-light">
                                    <img src="{{ asset('storage/course_images/' . $course->course_image) }}"
                                         width="200"
                                         class="rounded shadow-sm"
                                         alt="Course Image">
                                </div>
                            @endif
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="course_description"
                                      class="form-control shadow-sm"
                                      rows="4"
                                      required>{{ old('course_description', $course->course_description) }}</textarea>
                        </div>

                        {{-- MRP --}}
                        <div class="mb-3">
                            <label class="form-label">MRP</label>
                            <input type="text"
                                   name="mrp"
                                   class="form-control shadow-sm"
                                   value="{{ old('mrp', $course->mrp) }}"
                                   required>
                        </div>

                        {{-- Sell Price --}}
                        <div class="mb-3">
                            <label class="form-label">Sell Price</label>
                            <input type="text"
                                   name="sell_price"
                                   class="form-control shadow-sm"
                                   value="{{ old('sell_price', $course->sell_price) }}"
                                   required>
                        </div>

                        {{-- Subjects --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Subjects</label>
                            <div class="border rounded shadow-sm p-3 bg-light">
                                <div class="row">
                                    @php
                                        // Ensure subject_id is an array
                                        $selectedSubjects = is_array($course->subject_id)
                                            ? $course->subject_id
                                            : explode(',', $course->subject_id ?? '');
                                    @endphp

                                    @foreach($subjects as $subject)
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="subject_id[]"
                                                       value="{{ $subject->subject_id }}"
                                                       id="subject_{{ $subject->subject_id }}"
                                                       {{ in_array($subject->subject_id, $selectedSubjects) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-semibold" for="subject_{{ $subject->subject_id }}">
                                                    {{ $subject->subject_name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle"></i> Select one or more subjects for this course.
                            </small>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('courselist') }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>

                            <button type="submit" class="btn bg-gradient-dark text-white w-45">
                                <i class="fa fa-save"></i> Update Course
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

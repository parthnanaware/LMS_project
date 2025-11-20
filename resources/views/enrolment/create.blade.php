@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Add Enrolment</h4>
                </div>

                <div class="card-body px-4">

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Select Course --}}
                    <form method="GET" action="{{ route('enrolment.create') }}">
                        <div class="mb-3">
                            <label class="form-label">Select Course</label>
                            <select name="course_id" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}"
                                        {{ (isset($selectedCourseId) && $selectedCourseId == $course->course_id) ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    {{-- Enrolment Form --}}
                    <form action="{{ route('enrolment.store') }}" method="POST">
                        @csrf

                        {{-- Student --}}
                        <div class="mb-3">
                            <label class="form-label">Select Student</label>
                            <select name="student_id" class="form-control" required>
                                <option value="">-- Select Student --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach 
                            </select>
                        </div>

                        {{-- MRP --}}
                        <div class="mb-3">
                            <label class="form-label">MRP</label>
                            <input type="text" name="mrp" class="form-control"
                                   value="{{ old('mrp', $mrp) }}" readonly required>
                        </div>

                        {{-- Sell Price --}}
                        <div class="mb-3">
                            <label class="form-label">Sell Price</label>
                            <input type="text" name="sell_price" class="form-control"
                                   value="{{ old('sell_price', $sell_price) }}" readonly required>
                        </div>

                        {{-- Hidden Course ID --}}
                        <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('enrolment.index') }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn bg-gradient-dark text-white w-45">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

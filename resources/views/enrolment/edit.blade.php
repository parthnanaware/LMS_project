@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Edit Enrolment</h4>
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

                    <form action="{{ route('enrolment.update', $enrolment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Select Student</label>
                            <select name="student_id" class="form-control" required>
                                @foreach($students as $student)
                                    <option value="{{ $student->student_id }}" {{ $enrolment->student_id == $student->student_id ? 'selected' : '' }}>
                                        {{ $student->student_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Course</label>
                            <select name="course_id" class="form-control" required>
                                @foreach($courses as $course)
                                    <option value="{{ $course->course_id }}" {{ $enrolment->course_id == $course->course_id ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">MRP</label>
                            <input type="text" name="mrp" class="form-control" value="{{ $enrolment->mrp }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sell Price</label>
                            <input type="text" name="sell_price" class="form-control" value="{{ $enrolment->sell_price }}" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('enrolment.index') }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn bg-gradient-dark text-white w-45">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
    
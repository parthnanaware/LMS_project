@extends('layout.master')
@section('admincontent')
<div class="card">
    <div class="card-header">
        <h3>Course Add</h3>
        <div class="card-header-right">
            <a href="{{ route('ccorse') }}" class="btn btn-primary btn-round">Course List</a>
        </div>
    </div>

    <div class="shadow-lg p-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('courseadd') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <div class="col-sm-6">
                    <label class="form-label">Course Name</label>
                    <input type="text" name="course_name" class="form-control" required>
                </div>

                <div class="col-sm-6">
                    <label for="course_image">Course Image</label>
                    <input type="file" name="course_image" class="form-control-file" id="course_image" required />
                </div>
            </div>

            <div class="form-group">
                <label>Course Description</label>
                <textarea name="course_description" rows="5" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label>Select Subjects</label>
                <div class="row">
                    @foreach ($subjects as $subject)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" name="subject[]" value="{{ $subject->subject_id }}" class="form-check-input" id="subject{{ $subject->sub_id }}">
                                <label class="form-check-label" for="subject{{ $subject->subject_id }}">{{ $subject->subject_name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center">

                <button class="btn btn-success btn-round">Submit</button>
                <a href="{{ route('courselist') }}" class="btn btn-danger btn-round">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

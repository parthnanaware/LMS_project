@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Add Course</h4>
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

                    <form action="{{ route('courseadd') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course Name</label>
                            <input type="text" name="course_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="course_image" class="form-label">Course Image</label>
                            <input type="file" name="course_image" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="course_description" class="form-label">Description</label>
                            <textarea name="course_description" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Subjects</label>
                            <div class="row">
                                @foreach ($subjects ?? [] as $subject)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="subject_id[]" value="{{ $subject->subject_id }}" class="form-check-input">
                                            <label class="form-check-label">{{ $subject->subject_name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('courselist') }}" class="btn btn-secondary w-45">
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

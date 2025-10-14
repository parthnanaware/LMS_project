@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Add Subject</h4>
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

                    <form action="{{ route('subject.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <input type="text" name="subject_name" class="form-control shadow-sm" value="{{ old('subject_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject Image</label>
                            <input type="file" name="subject_img" class="form-control shadow-sm">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject Description</label>
                            <textarea name="subject_des" class="form-control shadow-sm" rows="3" required>{{ old('subject_des') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('subject.index') }}" class="btn btn-secondary w-45">Cancel</a>
                            <button type="submit" class="btn bg-gradient-dark text-white w-45">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

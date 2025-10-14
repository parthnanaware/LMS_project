@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Edit Section</h4>
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

                    <form action="{{ route('section.update', $section->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="tital" class="form-control shadow-sm"
                                   value="{{ old('tital', $section->tital) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="dis" class="form-control shadow-sm" rows="3" required>{{ old('dis', $section->dis) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Subject</label>
                            <select name="sub_id" class="form-control shadow-sm" required>
                                @foreach($subjects as $sub)
                                    <option value="{{ $sub->subject_id }}"
                                        {{ (string) old('sub_id', $section->sub_id) === (string) $sub->subject_id ? 'selected' : '' }}>
                                        {{ $sub->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('section.index') }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Cancel
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

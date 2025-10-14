@extends('layout.master')

@section('admincontent')
<br><br>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">

                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Add Section</h4>
                </div>

                <div class="card-body px-4">

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Add Section Form --}}
                    <form action="{{ route('section.store', $selectedSubjectId ?? '') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tital" class="form-label">Section Title</label>
                            <input type="text" name="tital" id="tital" class="form-control shadow-sm"
                                   placeholder="Enter section title" value="{{ old('tital') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="dis" class="form-label">Description</label>
                            <textarea name="dis" class="form-control shadow-sm" id="dis" placeholder="Enter description"
                                      rows="3">{{ old('dis') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="sub_id" class="form-label">Subject</label>
                            <select name="sub_id" id="sub_id" class="form-control shadow-sm" required>
                                <option value="">-- Select Subject --</option>
                                @foreach($sub as $role)
                                    <option value="{{ $role->subject_id }}"
                                        {{ (old('sub_id') ?? ($selectedSubjectId ?? '')) == $role->subject_id ? 'selected' : '' }}>
                                        {{ $role->subject_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success w-45">
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

@extends('layout.master')

@section('admincontent')
<br><br><br>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg">

                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Edit Session</h4>
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

               <form action="{{ route('session.update', $session->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="titel" class="form-control shadow-sm"
               value="{{ old('titel', $session->titel) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Type</label>
        <input type="text" name="type" class="form-control shadow-sm"
               value="{{ old('type', $session->type) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Section</label>
        <input type="text" class="form-control shadow-sm"
               value="{{ $session->section ? $session->section->tital : 'No Section Assigned' }}" readonly>
    </div>

    <input type="hidden" name="section_id" value="{{ $session->section_id }}">

    <div class="mb-3">
        <label class="form-label">Session Video</label>
        <input type="file" name="video" class="form-control shadow-sm">
        @if($session->video)
            <div class="mt-3 border rounded p-2 text-center bg-light">
                <video width="300" controls>
                    <source src="{{ asset('storage/' . $session->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">Session PDF</label>
        <input type="file" name="pdf" class="form-control shadow-sm">
        @if($session->pdf)
            <div class="mt-3 border rounded p-2 bg-light">
                <a href="{{ asset('storage/' . $session->pdf) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                    View Current PDF
                </a>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-between mt-4">
     <a href="{{ route('session.bySection', ['section_id' => $session->section_id ?? 0]) }}" class="btn btn-secondary w-45">
    <i class="fa fa-arrow-left"></i> Back
</a>

        <button type="submit" class="btn btn-success w-45">
            <i class="fa fa-save"></i> Update Session
        </button>
    </div>
</form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

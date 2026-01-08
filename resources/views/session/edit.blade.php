@extends('layout.master')

@section('admincontent')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-gradient-dark text-white">
            <h6>Edit Session ({{ strtoupper($session->type) }})</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('session.update', $session->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- TITLE --}}
                <div class="mb-3">
                    <label>Session Title</label>
                    <input type="text"
                           name="titel"
                           class="form-control"
                           value="{{ old('titel', $session->titel) }}"
                           required>
                </div>

                {{-- TYPE (READ ONLY) --}}
                <div class="mb-3">
                    <label>Session Type</label>
                    <input type="text"
                           class="form-control"
                           value="{{ strtoupper($session->type) }}"
                           readonly>
                    <input type="hidden" name="type" value="{{ $session->type }}">
                </div>

                {{-- VIDEO --}}
                @if($session->type === 'video')
                    <div class="mb-3">
                        <label>Video URL</label>
                        <input type="text"
                               name="video"
                               class="form-control"
                               value="{{ old('video', $session->video) }}"
                               required>
                    </div>
                @endif

                {{-- PDF --}}
                @if($session->type === 'pdf')
                    <div class="mb-3">
                        <label>Upload PDF</label>
                        <input type="file"
                               name="pdf"
                               class="form-control"
                               accept="application/pdf">
                        @if($session->pdf)
                            <small class="text-success">
                                Current PDF:
                                <a href="{{ asset('storage/'.$session->pdf) }}" target="_blank">View</a>
                            </small>
                        @endif
                    </div>
                @endif

                {{-- SECTION --}}
                <div class="mb-3">
                    <label>Section</label>
                    <select name="section_id" class="form-control" required>
                        @foreach($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ $session->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->title ?? 'Section '.$section->id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('session.bySection', $session->section_id) }}"
                       class="btn btn-secondary me-2">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

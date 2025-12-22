@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3">
                    <h4 class="mb-0 text-light">Add Session</h4>
                </div>

                <div class="card-body px-4">

                    {{-- SHOW ERRORS --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $selectedSectionId = request('section_id') ?? ($section_id ?? '');
                        $selectedTitel     = request('titel') ?? '';
                        $selectedType      = request('type') ?? '';
                    @endphp

                    {{-- ===========================
                        GET FORM — Select Data
                    ============================ --}}
                    <form id="getForm"
                          action="{{ isset($section_id) ? route('session.createForSection', $section_id) : route('session.create') }}"
                          method="GET" class="mb-4">

                        {{-- SECTION ID --}}
                        <input type="hidden" name="section_id" value="{{ $selectedSectionId }}">

                        {{-- SECTION --}}
                        <div class="mb-3">
                            <label class="form-label">Select Section</label>
                            <select class="form-control"
                                    name="section_id"
                                    onchange="document.getElementById('getForm').submit()">

                                <option value="">-- Select Section --</option>

                                @foreach($sections as $section)
                                    @php
                                        $val = $section->section_id ?? $section->id;
                                        $label = $section->tital ?? $section->titel;
                                    @endphp
                                    <option value="{{ $val }}"
                                            {{ $selectedSectionId == $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- TITLE FIELD --}}
                        <div class="mb-3">
                            <label class="form-label">Session Title</label>
                            <input type="text"
                                   id="titel"
                                   class="form-control"
                                   name="titel"
                                   placeholder="Enter session title"
                                   value="{{ $selectedTitel }}">
                        </div>

                        {{-- TYPE FIELD --}}
                        <div class="mb-3">
                            <label class="form-label">Session Type</label>
                            <select name="type" class="form-control"
                                    onchange="document.getElementById('getForm').submit()">

                                <option value="">-- Select Type --</option>
                                <option value="video" {{ $selectedType == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="pdf"   {{ $selectedType == 'pdf'   ? 'selected' : '' }}>PDF</option>
                                <option value="task"  {{ $selectedType == 'task'  ? 'selected' : '' }}>Task</option>
                                <option value="exam"  {{ $selectedType == 'exam'  ? 'selected' : '' }}>Exam</option>

                            </select>
                        </div>

                    </form>

                    {{-- ===========================
                        POST FORM — STORE SESSION
                    ============================ --}}
                    <form action="{{ route('session.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- PRESERVE FIELDS --}}
                        <input type="hidden" name="section_id" value="{{ $selectedSectionId }}">
                        <input type="hidden" name="titel" value="{{ $selectedTitel }}">
                        <input type="hidden" name="type" value="{{ $selectedType }}">

                        {{-- SHOW INPUT BASED ON TYPE --}}
                        @if($selectedType == 'video')
                            <div class="mb-3">
                                <label class="form-label">Video URL</label>
                                <input type="url" name="video" class="form-control" placeholder="Enter video URL" required>
                            </div>

                        @elseif($selectedType == 'pdf')
                            <div class="mb-3">
                                <label class="form-label">Upload PDF</label>
                                <input type="file" name="pdf" class="form-control" accept="application/pdf" required>
                            </div>

                        @elseif($selectedType == 'task')
                            <div class="mb-3">
                                <label class="form-label">Upload Task (PDF)</label>
                                <input type="file" name="task" class="form-control" accept="application/pdf" required>
                            </div>

                        @elseif($selectedType == 'exam')
                            <div class="mb-3">
                                <label class="form-label">Upload Exam (PDF)</label>
                                <input type="file" name="exam" class="form-control" accept="application/pdf" required>
                            </div>

                        @else
                           
                        @endif

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-45">
                                Cancel
                            </a>

                            <button type="submit" class="btn bg-gradient-dark text-white w-45">
                                Save Session
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

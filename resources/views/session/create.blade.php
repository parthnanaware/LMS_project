@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card my-4 shadow-lg">
                <div class="card-header bg-gradient-dark text-center py-3 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-light">Add Session</h4>
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

                    @php
                        // determine values to preserve across GET/POST
                        $selectedSectionId = old('section_id', request('section_id') ?? ($section_id ?? null));
                        $selectedTitel = old('titel', request('titel') ?? '');
                        $selectedType  = old('type', request('type') ?? '');
                    @endphp

                    {{-- GET form: choose section/title/type (submits to same route to render fields) --}}
                    <form action="{{ isset($section_id) ? route('session.createForSection', $section_id) : route('session.create') }}" method="GET" class="mb-4">
                        {{-- Always include section_id so onchange submit keeps it --}}
                        @if($selectedSectionId)
                            <input type="hidden" name="section_id" value="{{ $selectedSectionId }}">
                        @endif

                        {{-- If section_id was passed via route we show readonly section (and keep hidden input).
                             Otherwise show the select so user can choose. --}}
                        @if(isset($section_id))
                            <div class="mb-3">
                                <label class="form-label">Section</label>
                                @php
                                    // find the section object for display
                                    $displaySection = $sections->firstWhere('section_id', $section_id) ?? $sections->firstWhere('id', $section_id) ?? $sections->first() ?? null;
                                    $displayTitle = $displaySection->titel ?? $displaySection->title ?? 'Section';
                                @endphp
                                <input type="text" class="form-control" value="{{ $displayTitle }}" disabled>
                                <input type="hidden" name="section_id" value="{{ $section_id }}">
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="section_id" class="form-label">Select Section</label>
                                <select name="section_id" id="section_id" class="form-control shadow-sm" required>
                                    <option value="">-- Select Section --</option>
                                    @foreach($sections as $section)
                                        @php
                                            $val = $section->section_id ?? $section->id ?? null;
                                            $label = $section->tital ?? $section->tital;
                                        @endphp
                                        <option value="{{ $val }}" {{ (string)$selectedSectionId === (string)$val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="titel" class="form-label">Title</label>
                            <input type="text" name="titel" id="titel" class="form-control shadow-sm"
                                   value="{{ $selectedTitel }}" placeholder="Enter session title">
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Select Type</label>
                            <select name="type" id="type" class="form-control shadow-sm" onchange="this.form.submit()">
                                <option value="">-- Select Type --</option>
                                <option value="video" {{ $selectedType == 'video' ? 'selected' : '' }}>Video</option>
                                <option value="pdf"   {{ $selectedType == 'pdf'   ? 'selected' : '' }}>PDF</option>
                                <option value="task"  {{ $selectedType == 'task'  ? 'selected' : '' }}>Task</option>
                                <option value="exam"  {{ $selectedType == 'exam'  ? 'selected' : '' }}>Exam</option>
                            </select>
                        </div>
                    </form>
                    {{-- end GET form --}}

                    {{-- POST form: actual create --}}
                    <form action="{{ route('session.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- carry selected values into POST via hidden inputs --}}
                        <input type="hidden" name="section_id" value="{{ $selectedSectionId }}">
                        <input type="hidden" name="titel" value="{{ $selectedTitel }}">
                        <input type="hidden" name="type" value="{{ $selectedType }}">

                        @if($selectedType == 'video')
                            <div class="mb-3">
                                <label for="video" class="form-label">Video URL</label>
                                <input type="url" name="video" id="video" class="form-control shadow-sm"
                                       placeholder="Enter video URL" value="{{ old('video') }}" required>
                            </div>
                        @elseif($selectedType == 'pdf')
                            <div class="mb-3">
                                <label for="pdf" class="form-label">Upload PDF</label>
                                <input type="file" name="pdf" id="pdf" class="form-control shadow-sm"
                                       accept="application/pdf" required>
                            </div>
                        @elseif($selectedType == 'task')
                            <div class="mb-3">
                                <label for="task" class="form-label">Upload Task (PDF)</label>
                                <input type="file" name="task" id="task" class="form-control shadow-sm"
                                       accept="application/pdf" required>
                            </div>
                        @elseif($selectedType == 'exam')
                            <div class="mb-3">
                                <label for="exam" class="form-label">Upload Exam (PDF)</label>
                                <input type="file" name="exam" id="exam" class="form-control shadow-sm"
                                       accept="application/pdf" required>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Choose a type above (the page will reload) to display the correct inputs.
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-secondary w-45">
                                <i class="fa fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn bg-gradient-dark text-white w-45">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                    {{-- end POST form --}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

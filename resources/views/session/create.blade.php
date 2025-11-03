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

                        <form action="{{ route('session.create') }}" method="GET" class="mb-4">
                            <div class="mb-3">
                                <label for="section_id" class="form-label">Select Section</label>
                                <select name="section_id" id="section_id" class="form-control shadow-sm" required>
                                    <option value="">-- Select Section --</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ request('section_id') == $section->section_id ? 'selected' : '' }}>
                                            {{ $section->tital }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="titel" class="form-label">Title</label>
                                <input type="text" name="titel" id="titel" class="form-control shadow-sm"
                                    value="{{ request('titel') }}" placeholder="Enter session title">
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Select Type</label>
                                <select name="type" id="type" class="form-control shadow-sm" required onchange="this.form.submit()">
                                    <option value="">-- Select Type --</option>
                                    <option value="video" {{ request('type') == 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="pdf" {{ request('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="task" {{ request('type') == 'task' ? 'selected' : '' }}>Task</option>
                                    <option value="exam" {{ request('type') == 'exam' ? 'selected' : '' }}>Exam</option>
                                </select>
                            </div>
                        </form>

                        <form action="{{ route('session.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                            <input type="hidden" name="titel" value="{{ request('titel') }}">
                            <input type="hidden" name="type" value="{{ request('type') }}">

                            @if(request('type') == 'video')
                                <div class="mb-3">
                                    <label for="video" class="form-label">Video URL</label>
                                    <input type="url" name="video" id="video" class="form-control shadow-sm"
                                        placeholder="Enter video URL" required>
                                </div>
                            @elseif(request('type') == 'pdf')
                                <div class="mb-3">
                                    <label for="pdf" class="form-label">Upload PDF</label>
                                    <input type="file" name="pdf" id="pdf" class="form-control shadow-sm"
                                        accept="application/pdf" required>
                                </div>
                            @elseif(request('type') == 'task')
                                <div class="mb-3">
                                    <label for="task" class="form-label">Upload Task (PDF)</label>
                                    <input type="file" name="task" id="task" class="form-control shadow-sm"
                                        accept="application/pdf" required>
                                </div>
                            @elseif(request('type') == 'exam')
                                <div class="mb-3">
                                    <label for="exam" class="form-label">Upload Exam (PDF)</label>
                                    <input type="file" name="exam" id="exam" class="form-control shadow-sm"
                                        accept="application/pdf" required>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @extends('layout.master')

    @section('admincontent')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <!-- Card Header - Exact same as other pages -->
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Sessions Management</h6>

                            @if(isset($section_id) && $section_id)
                                <a href="{{ route('session.create', ['section_id' => $section_id]) }}"
                                class="btn btn-sm btn-primary me-3">
                                    + Add New Session
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body - Same structure -->
                    <div class="card-body px-0 pb-2">
                        <!-- Alerts -->
                        @foreach (['success', 'error', 'warning'] as $msg)
                            @if(session($msg))
                                <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} alert-dismissible fade show mx-3">
                                    {{ session($msg) }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        @endforeach

                        @if($sessions->isEmpty())
                            <p class="text-muted text-center py-4">No sessions found.</p>
                        @else
                            <!-- Group by Sections -->
                            @foreach($sessions as $sectionId => $sectionSessions)
                            <div class="px-3 mb-4">
                                {{-- <!-- Section Header -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 text-dark fw-bold">Section ID: {{ $sectionId }}</h6>
                                    <a href="{{ route('session.create', ['section_id' => $sectionId]) }}"
                                    class="btn btn-sm btn-success">
                                        + Add Session
                                    </a>
                                </div> --}}

                                <!-- Sessions Table for this Section -->
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">ID</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-2">Session Title</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Type</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Resources</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sectionSessions as $session)
                                            <tr>
                                                <!-- ID Column -->
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <span class="text-secondary text-xs font-weight-bold">{{ $session->id }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Session Title -->
                                                <td class="align-middle">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $session->titel }}</span>
                                                </td>

                                                <!-- Session Type -->
                                                <td class="align-middle">
                                                    <span class="badge bg-info text-xs">{{ ucfirst($session->type) }}</span>
                                                </td>

                                                <!-- Resources -->
                                                <td class="align-middle">
                                                    <div class="d-flex gap-1">
                                                        <!-- VIDEO -->
                                                        @if(!empty($session->video))
                                                        @php
                                                            $videoUrl = trim($session->video);
                                                            if (Str::contains($videoUrl, 'youtu.be/')) {
                                                                $videoUrl = str_replace('youtu.be/', 'www.youtube.com/watch?v=', $videoUrl);
                                                            } elseif (Str::contains($videoUrl, 'youtube.com/embed/')) {
                                                                $videoUrl = str_replace('embed/', 'watch?v=', $videoUrl);
                                                            } elseif (Str::contains($videoUrl, 'drive.google.com/file/d/')) {
                                                                $fileId = Str::between($videoUrl, '/file/d/', '/');
                                                                $videoUrl = "https://drive.google.com/file/d/{$fileId}/view";
                                                            } elseif (Str::endsWith($videoUrl, ['.mp4', '.webm', '.ogg'])) {
                                                                $videoUrl = asset('storage/' . ltrim($videoUrl, '/'));
                                                            }
                                                        @endphp
                                                        <a href="{{ $videoUrl }}" target="_blank"
                                                        class="btn btn-sm bg-gradient-danger mb-0 px-2 py-1"
                                                        data-bs-toggle="tooltip" title="Video">
                                                            <i class="fas fa-play-circle fa-xs text-white"></i>
                                                        </a>
                                                        @endif

                                                        <!-- PDF -->
                                                        @if($session->pdf)
                                                        <a href="{{ asset('storage/' . $session->pdf) }}" target="_blank"
                                                        class="btn btn-sm bg-gradient-danger mb-0 px-2 py-1"
                                                        data-bs-toggle="tooltip" title="PDF">
                                                            <i class="fas fa-file-pdf fa-xs text-white"></i>
                                                        </a>
                                                        @endif

                                                        <!-- TASK -->
                                                        @if($session->task)
                                                        <a href="{{ asset('storage/' . $session->task) }}" target="_blank"
                                                        class="btn btn-sm bg-gradient-warning mb-0 px-2 py-1"
                                                        data-bs-toggle="tooltip" title="Task">
                                                            <i class="fas fa-tasks fa-xs text-white"></i>
                                                        </a>
                                                        @endif

                                                        <!-- EXAM -->
                                                        @if($session->exam)
                                                        <a href="{{ asset('storage/' . $session->exam) }}" target="_blank"
                                                        class="btn btn-sm bg-gradient-success mb-0 px-2 py-1"
                                                        data-bs-toggle="tooltip" title="Exam">
                                                            <i class="fas fa-file-alt fa-xs text-white"></i>
                                                        </a>
                                                        @endif

                                                        @if(empty($session->video) && !$session->pdf && !$session->task && !$session->exam)
                                                            <span class="text-muted text-xs">No resources</span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <!-- Actions - Exactly like your other pages -->
                                                <td class="align-middle text-center">
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('session.edit', $session->id) }}"
                                                        class="btn btn-sm btn-warning mb-0">
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('session.destroy', $session->id) }}"
                                                            method="POST" class="d-inline mb-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger mb-0"
                                                                    onclick="return confirm('Are you sure you want to delete this session?')">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="horizontal dark my-3 mx-3">
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 3 seconds
        setTimeout(function () {
            document.querySelectorAll('.alert').forEach(function (alert) {
                alert.style.display = 'none';
            });
        }, 3000);

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    @endsection

@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">

                <!-- Card Header -->
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white ps-3">Session List</h6>

                    @if(isset($section_id) && $section_id)
                        <div class="d-flex gap-2 me-3">
                            <a href="{{ route('session.create', ['section_id' => $section_id]) }}" class="btn btn-sm btn-primary me-3">Add New Session</a>
                        </div>
                    @else
                        <span class="text-white me-3">No section selected</span>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="card-body px-0 pt-0 pb-2">

                    <!-- Alerts -->
                    @foreach (['success', 'error', 'warning'] as $msg)
                        @if(session($msg))
                            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} alert-dismissible fade show m-3" id="alert-{{ $msg }}">
                                {{ session($msg) }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    @endforeach

                    <script>
                        setTimeout(function () {
                            document.querySelectorAll('.alert').forEach(function (alert) {
                                alert.style.display = 'none';
                            });
                        }, 3000);
                    </script>

                    <!-- Table -->
                    @if(isset($sessions) && $sessions->isEmpty())
                        <p class="text-center my-3">No sessions found for this section.</p>
                    @elseif(isset($sessions))
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Type</th>
                                        <th>Video</th>
                                        <th>PDF</th>
                                        <th>Task</th>
                                        <th>Exam</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($sessions as $session)
                                    <tr>
                                        <td>{{ $session->id }}</td>
                                        <td>{{ $session->titel }}</td>
                                        <td>{{ ucfirst($session->type) }}</td>

                                        <!-- VIDEO -->
                                        <td>
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

                                                <a href="{{ $videoUrl }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-play-circle me-1"></i> View Video
                                                </a>
                                            @else
                                                <span class="text-muted">No Video</span>
                                            @endif
                                        </td>

                                        <!-- PDF -->
                                        <td>
                                            @if($session->pdf)
                                                <a href="{{ asset('storage/' . $session->pdf) }}" target="_blank"
                                                   class="btn btn-outline-info btn-sm">View PDF</a>
                                            @else
                                                <span class="text-muted">No PDF</span>
                                            @endif
                                        </td>

                                        <!-- TASK -->
                                        <td>
                                            @if($session->task)
                                                <a href="{{ asset('storage/' . $session->task) }}" target="_blank"
                                                   class="btn btn-outline-warning btn-sm">View Task</a>
                                            @else
                                                <span class="text-muted">No Task</span>
                                            @endif
                                        </td>

                                        <!-- EXAM -->
                                        <td>
                                            @if($session->exam)
                                                <a href="{{ asset('storage/' . $session->exam) }}" target="_blank"
                                                   class="btn btn-outline-danger btn-sm">View Exam</a>
                                            @else
                                                <span class="text-muted">No Exam</span>
                                            @endif
                                        </td>

                                        <!-- ACTIONS -->
                                        <td class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('session.edit', $session->id) }}"
                                               class="btn btn-sm btn-warning">Edit</a>

                                            <form action="{{ route('session.destroy', $session->id) }}"
                                                  method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete this session?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

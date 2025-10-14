@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Section List</h6>

                        <a href="/section/create/{{ $subject_id }}" class="btn btn-sm btn-primary me-3">Add New Section</a>

                    </div>
                </div>

                <div class="card-body px-3 pb-2">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($sections->isEmpty())
                        <p class="text-muted">No sections found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Title</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Description</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Subject</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">View</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sections as $sec)
                                        <tr>
                                            <td>{{ $sec->id }}</td>
                                            <td>{{ $sec->tital }}</td>
                                            <td>{{ $sec->dis }}</td>
                                            <td>{{ $subjects->firstWhere('subject_id', $sec->sub_id)->subject_name ?? 'Unknown' }}</td>

                                            <td>
                                                <a href="{{ route('session.bySection', $sec->id) }}" class="btn btn-sm btn-info">View Sessions</a>
                                            </td>

                                            <td class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('section.edit', $sec->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('section.destroy', $sec->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this section?')">
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

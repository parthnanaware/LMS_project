@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h6 class="text-white text-capitalize ps-3">Subject List</h6>
                        <a href="{{ route('subject.create') }}" class="btn btn-sm btn-primary me-3">Add New Subject</a>
                    </div>
                </div>

                <div class="card-body px-3 pb-2">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($subject->isEmpty())
                        <p class="text-muted">No subjects found.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">ID</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Photo</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Name</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Description</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">section</th>
                                        <th class="text-uppercase text-secondary text-xs font-weight-bold opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subject as $sub)
                                        <tr>
                                            <td>{{ $sub->subject_id }}</td>
                                            <td>
                                                @if($sub->subject_img)
                                                    <img src="{{ asset('storage/' . $sub->subject_img) }}" width="50">
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $sub->subject_name }}</td>
                                            <td>{{ $sub->subject_des }}</td>
                                            <td> <a href="{{ route('section.bySubject', $sub->subject_id) }}" class="btn btn-sm btn-info">View Sections</a></td>
                                            <td class="d-flex gap-1">

                                                <a href="{{ route('subject.edit', $sub->subject_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('subject.destroy', $sub->subject_id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</button>
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

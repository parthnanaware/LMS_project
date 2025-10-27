@extends('layout.master')
@section('title', 'Course List')
@section('admincontent')
    <div class="card">
        <div class="card-header">
            <h3>Course List</h3>

            <div class="card-header-right">
                <a href="{{ route('courseaddform') }}" class="btn hor-grd btn-grd-primary">Add Course</a>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th> Image</th>
                    <th>Course Name</th>
                    <th>Subjects</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <th>{{ $course->course_id }}</th>

                        <td>
                            @if ($course->course_image)
                                <img src="{{ asset('storage/course_images/' . $course->course_image) }}" alt="Course Image" width="80" height="80">
                            @else
                                <img src="{{ asset('default-avatar.png') }}" alt="Default Image" width="60" height="60">
                            @endif
                        </td>

                        <td>{{ $course->course_name }}</td>

                        <td>
                            @foreach ($course->subject as $subject)
                                <span class="badge badge-info">{{ $subject->sub_title }}</span>
                            @endforeach
                        </td>

                        <td>
                            <a href="{{ route('corse.edit', $course->course_id) }}" class="btn hor-grd btn-grd-primary"><i class="ti-pencil"></i></a>

                            <form action="{{ route('corse.destroy', $course->course_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn hor-grd btn-grd-danger" onclick="return confirm('Are you sure?')"><i class="ti-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layout.master')

@section('admincontent')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <div class="card shadow-lg">

                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3
                            d-flex justify-content-between align-items-center">
                    <h6 class="text-white ps-3">Enrolments List</h6>

                    <a href="{{ route('enrolment.create') }}"
                       class="btn btn-sm btn-primary me-3">
                        Add New Enrolment
                    </a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">

                   @if(session('success'))
    <div id="successAlert" class="alert alert-success m-3">
        {{ session('success') }}
    </div>

    <script>
        // Auto-hide notification after 3 seconds
        setTimeout(() => {
            let alertBox = document.getElementById('successAlert');
            if (alertBox) {
                alertBox.style.transition = "0.5s";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }
        }, 3000);
    </script>
@endif
    

                    <div class="table-responsive p-3">

                        <table class="table align-items-center mb-0 text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>MRP</th>
                                    <th>Sell Price</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($enrolments as $e)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $e->student->name }}</td>
                                    <td>{{ $e->course->course_name }}</td>
                                    <td>{{ $e->mrp }}</td>
                                    <td>{{ $e->sell_price }}</td>

                                    <!-- STATUS DROPDOWN -->
                                    <td>
                                        <form action="{{ route('enrolment.updateStatus', $e->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <select name="status"
                                                    class="form-select form-select-sm"
                                                    onchange="this.form.submit()">

                                                <option value="pending"
                                                    {{ $e->status == 'pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>

                                                <option value="paid"
                                                    {{ $e->status == 'paid' ? 'selected' : '' }}>
                                                    Paid
                                                </option>

                                                <option value="reject"
                                                    {{ $e->status == 'reject' ? 'selected' : '' }}>
                                                    Reject
                                                </option>

                                            </select>
                                        </form>
                                    </td>

                                    <td>
                                        <form action="{{ route('enrolment.destroy', $e->id) }}"
                                              method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete enrolment?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

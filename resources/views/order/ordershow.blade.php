@extends('layout.master')

@section('admincontent')

<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="m-0">Order Details – ORD{{ $order->order_id }}</h4>
    </div>

    <div class="card-body">

        {{-- SUCCESS / ERROR ALERTS --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        {{-- CUSTOMER INFO --}}
        <h5>Customer</h5>
        <p>
            {{ $order->user->name }} <br>
            <small>{{ $order->user->email }}</small>
        </p>

        <hr>


        {{-- ORDER SUMMARY --}}
        <h5>Order Summary</h5>

        <p>Total Amount: ₹{{ number_format($order->total_amount) }}</p>
        <p>Discount: ₹{{ number_format($order->discount_amount) }}</p>
        <p>
            <strong>Final Amount: ₹{{ number_format($order->final_amount) }}</strong>
        </p>

        <p>Status:
            @if($order->status == 'paid')
                <span class="badge bg-success">Paid</span>
            @elseif($order->status == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
            @else
                <span class="badge bg-danger">Failed</span>
            @endif
        </p>

        <p>Payment Method: {{ $order->payment_method }}</p>
        <p>Payment ID: {{ $order->payment_id }}</p>

        <hr>


        {{-- ENROLL BUTTON --}}
        <a href="{{ route('admin.orders.enroll', $order->order_id) }}"
   class="btn btn-success mb-3">
   Enroll Student
</a>

        <hr>


        {{-- PURCHASED COURSES --}}
        <h5>Purchased Courses</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>MRP</th>
                    <th>Selling Price</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->course->course_name ?? 'N/A' }}</td>
                        <td>₹{{ $item->mrp }}</td>
                        <td>₹{{ $item->sell_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

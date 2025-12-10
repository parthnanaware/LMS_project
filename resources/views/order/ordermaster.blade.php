@extends('layout.master')

@section('admincontent')

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="m-0">Orders</h4>

        <input type="text" id="searchInput" class="form-control w-25" placeholder="Search...">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mb-0" id="orderTable">
            <thead class="bg-light">
                <tr>
                    <th>#</th>
                    <th>ORDER NO</th>
                    <th>USER</th>
                    <th>TOTAL</th>
                    <th>PAYMENT</th>
                    <th>STATUS</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $key => $order)
                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <td>ORD{{ $order->order_id }}</td>

                        <td>{{ $order->user->name ?? 'Unknown' }}</td>

                        <td>₹{{ number_format($order->final_amount) }}</td>

                        {{-- PAYMENT STATUS --}}
                        <td>
                            @if($order->status == 'paid')
                                <span class="badge bg-success">paid</span>
                            @elseif($order->status == 'pending')
                                <span class="badge bg-warning text-dark">pending</span>
                            @else
                                <span class="badge bg-danger">failed</span>
                            @endif
                        </td>

                        {{-- ORDER STATUS (auto based on payment) --}}
                        <td>
                            @if($order->status == 'paid')
                                <span class="badge bg-primary">completed</span>
                            @else
                                <span class="badge bg-info text-dark">processing</span>
                            @endif
                        </td>

                        <td>{{ $order->created_at->format('d-m-Y') }}</td>

                        <td>
                            <a href="{{ route('admin.orders.show', $order->order_id) }}"
                               class="btn btn-primary btn-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

{{-- Search Filter --}}
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#orderTable tbody tr");

    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
    });
});
</script>

@endsection

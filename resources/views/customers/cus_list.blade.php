@extends('admins.index')
@section('css')
@endsection

@section('content')
    <div class="container">
        <h2>จัดการลูกค้า</h2>
        <a href="{{ route('customer_create') }}" class="btn btn-primary mb-3">เพิ่มบริการ</a>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr class="bg-dark text-light">
                    <th>#</th>
                    <th>Full Name</th>
                    <th>ID Card</th>
                    <th>Photo</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Service</th>
                    <th>Province</th>
                    <th>Speed</th>
                    <th>Price</th>
                    <th>Center</th>
                    <th>Tools</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $customer)
                        <tr>
                            <td>{{ $customer->cus_id }}</td>
                            <td>{{ $customer->cus_fullname }}</td>
                            <td>{{ $customer->id_card }}</td>
                            <td>
                                @if ($customer->cus_photo)
                                    <img src="{{ asset('storage/' . $customer->cus_photo) }}" alt="Photo" style="width: 50px; height: 50px;">
                                @else
                                    No Photo
                                @endif
                            </td>
                            <td>{{ $customer->cus_address }}</td>
                            <td>{{ $customer->type->type_name ?? 'N/A' }}</td>
                            <td>{{ $customer->service->service_name ?? 'N/A' }}</td>
                            <td>{{ $customer->province->province_name ?? 'N/A' }}</td>
                            <td>{{ $customer->speed->speed_name ?? 'N/A' }}</td> <!-- ดึงชื่อจากสัมพันธ์ speed -->
                            <td>{{ $customer->price->price_name ?? 'N/A' }}</td> <!-- ดึงชื่อจากสัมพันธ์ price -->
                            <td>{{ $customer->center->center_name ?? 'N/A' }}</td> <!-- ดึงชื่อจากสัมพันธ์ center -->
                            <td>
                                <a href="{{ route('customer_edit', $customer->cus_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('customer_delete', $customer->cus_id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="12" class="text-center">No Customer Data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Logs</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <div class="container mt-5">
        <h1>User Logs</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Model</th>
                    <th>Action</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                                <tr>
                                    <td>@if($log->user)
                                        {{ $log->user->username }}
                                    @else
                                        N/A
                                    @endif
                                    </td>
                                    <td>{{ $log->model }}</td>
                                   
                                    <td>
                                        @php
                                            $data = json_decode($log->data, true);
                                        @endphp
                                        {{ $data['message'] ?? 'ไม่มีข้อความ' }} {{ $data['username'] ?? 'N/A' }}

                                    </td>


                                    <td>{{ $log->created_at->format('m-d-Y / H:i') }}</td>
                                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
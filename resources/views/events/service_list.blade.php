@extends('admins.index')

@section('css')
@endsection

@section('content')
<table class="table table-bordered table-striped table-hover table-responsive">
    <thead class="bg-dark text-center">
        <tr>
            <th>จังหวัด</th>
            @foreach ($services as $serviceName)
                <th colspan="{{ count($serviceData[$serviceName]) }}">{{ $serviceName }}</th>
            @endforeach
        </tr>
        <tr>
            <th></th>
            @foreach ($services as $serviceName)
                @foreach ($serviceData[$serviceName] as $attributeName => $values)
                    <th>{{ $attributeName }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($provinces as $province)
            <tr>
                <td>{{ $province->province_name }}</td>
                @foreach ($services as $serviceName)
                    @foreach ($serviceData[$serviceName] as $attributeName => $values)
                        <td>{{ isset($values[$province->province_id]) ? $values[$province->province_id] : 0 }}</td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

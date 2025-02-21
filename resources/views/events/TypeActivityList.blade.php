@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการกิจกรรม</h2>

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTypeModal">
            เพิ่มกิจกรรม
        </button>

        <div class="nav-align-top mt-4">
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active text-dark bg-warning" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-fttx_broadband" aria-controls="navs-justified-announce"
                        aria-selected="true">
                        <span>Fttx Broadband</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link text-dark" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-simmy" aria-controls="navs-justified-document"
                        aria-selected="false">
                        <span>SIM my</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link text-dark" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-justified-ict_solution" aria-controls="navs-justified-form"
                        aria-selected="false">
                        <span>ICT Solution</span>
                    </button>
                </li>
            </ul>


            <!-- Tab Content -->
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-justified-fttx_broadband" role="tabpanel">

                    <div class="mb-3 d-flex justify-content-between">
                        <h5>กราฟ Fttx broadband</h5>

                        <div>
                            <label for="typeSelect" class="form-label">-เลือกกิจกรรม-</label>
                            <select id="typeSelect" class="form-select" aria-label="Single select example"
                                style="max-width: 300px;">
                                @foreach ($typeActivities as $type)
                                    <option value="{{ $type['type_id'] }}"
                                        {{ $type['type_id'] == old('typeSelect', $maxTypeId) ? 'selected' : '' }}>
                                        {{ $type['type_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h3 id="noDataMessage" style="display: block; color: red;" class="text-center">-ไม่มีข้อมูล-
                            </h3>
                        </div>
                        <canvas
                            id="installChart"style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%; display: block;"></canvas>
                    </div>
                </div>

                <div class="tab-pane fade" id="navs-justified-simmy" role="tabpanel">
                    <!-- SIM my Content -->

                    <div class="mb-3 d-flex justify-content-between">
                        <h5>กราฟ SIM my</h5>

                        <div>
                            <label for="typeSelect" class="form-label">-เลือกกิจกรรม-</label>
                            <!-- Dropdown เลือกประเภท -->
                            <select id="typeSelect1" class="form-select" aria-label="Single select example"
                                style="max-width: 300px;">
                                @foreach ($typeActivities as $type)
                                    <option value="{{ $type['type_id'] }}"
                                        {{ $type['type_id'] == old('typeSelect', $maxTypeId) ? 'selected' : '' }}>
                                        {{ $type['type_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h3 id="noDataMessage1" style="display: block; color: red;" class="text-center">-ไม่มีข้อมูล-
                            </h3>
                        </div>
                        <canvas
                            id="simMy"style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%; display: block;"></canvas>
                    </div>
                </div>

                <div class="tab-pane fade" id="navs-justified-ict_solution" role="tabpanel">
                    <div class="mb-3 d-flex justify-content-between">
                        <h5>กราฟ ICT</h5>

                        <div>
                            <label for="typeSelect" class="form-label">-เลือกกิจกรรม-</label>
                            <!-- Dropdown เลือกประเภท -->
                            <select id="typeSelect2" class="form-select" aria-label="Single select example"
                                style="max-width: 300px;">
                                @foreach ($typeActivities as $type)
                                    <option value="{{ $type['type_id'] }}"
                                        {{ $type['type_id'] == old('typeSelect', $maxTypeId) ? 'selected' : '' }}>
                                        {{ $type['type_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h3 id="noDataMessage2" style="display: block; color: red;" class="text-center">-ไม่มีข้อมูล-
                            </h3>
                        </div>
                        <canvas
                            id="ICT"style="min-height: 300px; height: 300px; max-height: 300px; max-width: 100%; display: block;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <hr>



        <table class="table table-bordered mt-3">
            <h5>สรุปรายงานผลการดำเนินงานกิจกรรมการตลาด</h5>
            <thead>
                <tr class="bg-dark text-center align-center">
                    <th rowspan="4">ดูข้อมูล</th>
                    <th rowspan="4">ชื่อกิจกรรม</th>
                    <th colspan="3">FTTX</th>
                    <th colspan="4">SIM my</th>
                    <th colspan="2">Ict Solution</th>
                    <th rowspan="4">เครื่องมือ</th>



                </tr>
                <tr class="bg-dark text-center">

                    <th rowspan="4">new</th>
                    <th rowspan="4">ติดตั้งเอง</th>
                    <th rowspan="4">จ้างผู้รับเหมา</th>


                </tr>
                <tr class="bg-dark text-center">
                    <th rowspan="2">ลูกค้าใหม่</th>
                    <th rowspan="2">ลูกค้า (ย้ายค่าย)</th>
                    <th colspan="2">เติมเงินรายปี</th>
                    <th rowspan="2">จำนวน
                        (ราย)</th>
                    <th rowspan="2">รายได้</th>

                </tr>
                <tr class="bg-dark text-center ">
                    <th>จำนวน
                        (ราย)</th>
                    <th>ยอดเงิน</th>

                </tr>

            </thead>
            <tbody class="text-center">

                @foreach ($sumByType as $typeId => $data)
                    @php
                        // กรองเฉพาะกิจกรรมที่ตรงกับ typeId ปัจจุบัน
                        $activities = collect($typeActivities)->where('type_id', $typeId);
                    @endphp

                    @foreach ($activities as $row)
                        <tr>
                            <td>
                                <a href="{{ route('event_department', $typeId) }}" class="btn btn-warning">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                            <td>{{ $row->type_name }}</td>
                            <td>{{ ($data['selfInstall'] ?? 0) + ($data['hireInstall'] ?? 0) }}</td>
                            <td>{{ $data['selfInstall'] ?? 0 }}</td>
                            <td>{{ $data['hireInstall'] ?? 0 }}</td>
                            <td>{{ $data['new'] ?? 0 }}</td>
                            <td>{{ $data['move'] ?? 0 }}</td>
                            <td>{{ $data['count'] ?? 0 }}</td>
                            <td>{{ $data['price'] ?? 0 }}</td>
                            <td>{{ $data['ictCount'] ?? 0 }}</td>
                            <td>{{ $data['ictIncome'] ?? 0 }}</td>
                            <td colspan="2">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-light btn-sm p-1 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 rounded">
                                        <li>
                                            <button class="dropdown-item text-warning editBtn"
                                                data-id="{{ $row->type_id }}" data-name="{{ $row->type_name }}"
                                                data-bs-toggle="modal" data-bs-target="#editTypeModal">
                                                <i class="bx bx-edit"></i> Edit
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('type_delete', $row->type_id) }}" method="POST"
                                                class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger deleteBtn"
                                                    id="deleteBtn{{ $row->type_id }}">
                                                    <i class="bx bx-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>


        {{-- modal add --}}
        <div class="modal fade" id="addTypeModal" tabindex="-1" aria-labelledby="addTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTypeModalLabel">เพิ่มกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addTypeForm" action="{{ route('type_insert') }}" method="POST">
                            @csrf
                            <div class="mb-3">


                                <label for="type_name" class="form-label">ชื่อกิจกรรม</label>
                                <input type="text" class="form-control" id="type_name" name="type_name" required>
                                <input type="hidden" name="created_at" value="{{ \Carbon\Carbon::now() }}">
                                <input type="hidden" name="updated_at" value="{{ \Carbon\Carbon::now() }}">
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Edit -->
        <div class="modal fade" id="editTypeModal" tabindex="-1" aria-labelledby="editTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTypeModalLabel">แก้ไขกิจกรรม</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTypeForm" action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_type_name" class="form-label">ชื่อกิจกรรม</label>
                                <input type="text" class="form-control" id="edit_type_name" name="type_name"
                                    required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        // เปิด Modal พร้อมดึงข้อมูล
        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                // อัปเดตฟิลด์ใน Modal
                document.getElementById('edit_type_name').value = name;

                // อัปเดต action ของฟอร์ม
                document.getElementById('editTypeForm').action = `/typeactivity_update/${id}`;
            });
        });
    </script>

    <script>
        document.getElementById('addTypeForm').addEventListener('submit', function(e) {
            e.preventDefault(); // ป้องกันการรีเฟรชหน้า
            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // ปิด Modal หลังจากบันทึกเสร็จ
                        $('#addTypeModal').modal('hide');

                        // แสดงข้อความสำเร็จด้วย SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: data.message,
                            showConfirmButton: true,
                            timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                            timerProgressBar: true,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload(); // รีเฟรชหน้าเมื่อกด OK
                        });
                    } else {
                        Swal.fire('ผิดพลาด!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('ผิดพลาด!', 'เกิดข้อผิดพลาดบางอย่าง', 'error');
                });
        });
    </script>



    <script>
        // Event listener สำหรับปุ่มลบ
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener สำหรับปุ่มลบ
            document.querySelectorAll('.deleteBtn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault(); // ป้องกันการลบโดยตรง

                    const form = this.closest('form');
                    const deleteUrl = form.action;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // หากยืนยันการลบ
                        }
                    });
                });
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 1500, // เพิ่มเวลาให้แสดงนานขึ้น
                    timerProgressBar: true,
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
    <script>
        document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.nav-tabs .nav-link').forEach(el => {
                    el.classList.remove('active', 'bg-warning', 'text-light');
                    el.classList.add('text-dark');
                });
                this.classList.add('active', 'bg-warning', 'text-light');
            });
        });
    </script>

    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('installChart').getContext('2d');
            const typeSelect = document.getElementById('typeSelect');
            const noDataMessage = document.getElementById('noDataMessage');
            let installChart = null;

            const maxTypeId = @json($maxTypeId);
            const typeIds = @json(collect($typeActivities)->pluck('type_id')->toArray());
            const fttxDataArray = @json($fttxNewData);
            const selfInstallDataArray = @json($selfInstallData);
            const hireInstallDataArray = @json($hireInstallData);


            function updateChart(selectedTypeId) {
                const index = typeIds.indexOf(parseInt(selectedTypeId));

                if (index === -1) {
                    console.error("ไม่พบ type_id ที่เลือก");
                    return;
                }

                const selectedTypeName = @json($typeNames)[index] ?? 'ไม่ระบุ';
                const fttxData = fttxDataArray[index] ?? 0;
                const selfInstallData = selfInstallDataArray[index] ?? 0;
                const hireInstallData = hireInstallDataArray[index] ?? 0;

                console.log("Data:", fttxData, selfInstallData, hireInstallData);

                if (fttxData === 0 && selfInstallData === 0 && hireInstallData === 0) {
                    noDataMessage.style.display = 'block';
                    document.getElementById('installChart').style.display = 'none';
                    return;
                } else {
                    noDataMessage.style.display = 'none';
                    document.getElementById('installChart').style.display = 'block';
                }

                if (installChart) {
                    installChart.destroy();
                }

                installChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [selectedTypeName],
                        datasets: [{
                                label: 'New',
                                backgroundColor: 'rgba(32, 118, 232, 0.8)',
                                borderColor: 'rgba(32, 118, 232, 1)',
                                borderWidth: 1,
                                data: [fttxData]
                            },
                            {
                                label: 'ติดตั้งเอง',
                                backgroundColor: 'rgba(32, 232, 93, 0.8)',
                                borderColor: 'rgba(32, 232, 93, 1)',
                                borderWidth: 1,
                                data: [selfInstallData]
                            },
                            {
                                label: 'จ้างผู้รับเหมา',
                                backgroundColor: 'rgba(232, 201, 32, 0.8)',
                                borderColor: 'rgba(232, 201, 32, 1)',
                                borderWidth: 1,
                                data: [hireInstallData]
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true, // เริ่มต้นที่ 0
                                ticks: {
                                    stepSize: 1, // กำหนดขนาดแต่ละขั้นที่แกน Y
                                    callback: function(value) {
                                        return value.toFixed(
                                            1); // แสดงค่าของ Y ในรูปแบบทศนิยม 1 ตำแหน่ง
                                    }
                                }
                            }
                        }
                    }
                });
            }

            typeSelect.value = maxTypeId;
            updateChart(maxTypeId);

            typeSelect.addEventListener('change', function() {
                updateChart(parseInt(this.value));
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('simMy').getContext('2d');
            const typeSelect = document.getElementById('typeSelect1');
            const noDataMessage = document.getElementById('noDataMessage1');
            let installChart = null;

            const maxTypeId = @json($maxTypeId);
            const typeIds = @json(collect($typeActivities)->pluck('type_id')->toArray());
            const newDataArray = @json(collect($sumByType)->pluck('new')->toArray());
            const moveDataArray = @json(collect($sumByType)->pluck('move')->toArray());
            const countDataArray = @json(collect($sumByType)->pluck('count')->toArray());
            const typeNames = @json($typeNames); // ชื่อประเภท

            function updateChart(selectedTypeId) {
                const index = typeIds.indexOf(parseInt(selectedTypeId));

                if (index === -1) {
                    console.error("ไม่พบ type_id ที่เลือก");
                    return;
                }

                const selectedTypeName = typeNames[index] ?? 'ไม่ระบุ';
                const newData = newDataArray[index] ?? 0;
                const moveData = moveDataArray[index] ?? 0;
                const countData = countDataArray[index] ?? 0;

                if (newData === 0 && moveData === 0 && countData === 0) {
                    noDataMessage.style.display = 'block';
                    document.getElementById('simMy').style.display = 'none';
                    return;
                } else {
                    noDataMessage.style.display = 'none';
                    document.getElementById('simMy').style.display = 'block';
                }

                if (installChart) {
                    installChart.destroy();
                }

                installChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [selectedTypeName], // แสดงชื่อประเภทที่เลือก
                        datasets: [{
                                label: 'ลูกค้าใหม่',
                                backgroundColor: 'rgba(153, 102, 255, 1)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1,
                                data: [newData] // ข้อมูลลูกค้าใหม่
                            },
                            {
                                label: 'ลูกค้า(ย้ายค่าย)',
                                backgroundColor: 'rgba(255, 159, 64, 1)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1,
                                data: [moveData] // ข้อมูลลูกค้า (ย้ายค่าย)
                            },
                            {
                                label: 'เติมเงินรายปี',
                                backgroundColor: 'rgba(255, 205, 86, 1)',
                                borderColor: 'rgba(255, 205, 86, 1)',
                                borderWidth: 1,
                                data: [countData] // ข้อมูลเติมเงินรายปี
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true, // เริ่มต้นที่ 0
                                ticks: {
                                    stepSize: 1, // กำหนดขนาดแต่ละขั้นที่แกน Y
                                    callback: function(value) {
                                        return value.toFixed(
                                            1); // แสดงค่าของ Y ในรูปแบบทศนิยม 1 ตำแหน่ง
                                    }
                                }
                            }
                        }
                    }
                });
            }

            typeSelect.value = maxTypeId;
            updateChart(maxTypeId);

            typeSelect.addEventListener('change', function() {
                updateChart(parseInt(this.value));
            });
        });
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('ICT').getContext('2d');
    const typeSelect = document.getElementById('typeSelect2');
    const noDataMessage = document.getElementById('noDataMessage2');
    let ICTchart = null;

    const maxTypeId = @json($maxTypeId);
    const typeIds = @json(collect($typeActivities)->pluck('type_id')->toArray());
    const typeNames = @json($typeNames);
    const ictCountData = @json(collect($sumByType)->pluck('ictCount')->toArray());
    const ictIncomeData = @json(collect($sumByType)->pluck('ictIncome')->toArray());

    function updateChart(selectedTypeId) {
        const index = typeIds.indexOf(parseInt(selectedTypeId));
        if (index === -1) {
            console.error("ไม่พบ type_id ที่เลือก");
            return;
        }

        const selectedTypeName = typeNames[index] ?? 'ไม่ระบุ';
        const ictCount = ictCountData[index] ?? 0;
        const ictIncome = ictIncomeData[index] ?? 0;

        console.log("Data:", selectedTypeName, ictCount, ictIncome);

        if (ictCount === 0 && ictIncome === 0) {
            noDataMessage.style.display = 'block';
            document.getElementById('ICT').style.display = 'none';
            return;
        } else {
            noDataMessage.style.display = 'none';
            document.getElementById('ICT').style.display = 'block';
        }

        if (ICTchart) {
            ICTchart.destroy();
        }

        ICTchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [selectedTypeId], // ใช้ selectedTypeId เพื่อค้นหาข้อมูลที่ตรงกัน
                datasets: [
                    {
                        label: 'รายได้ ICT',
                        backgroundColor: 'rgba(232, 201, 32, 0.8)',
                        borderColor: 'rgba(232, 201, 32, 1)',
                        borderWidth: 1,
                        data: [ictIncome]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (tooltipItem) {
                                const selectedIndex = typeIds.indexOf(parseInt(tooltipItem.label));
                                if (selectedIndex === -1) return "ไม่มีข้อมูล";

                                const activityName = typeNames[selectedIndex] ?? 'ไม่ระบุ';
                                const ictCountValue = ictCountData[selectedIndex] ?? 0;
                                const ictIncomeValue = ictIncomeData[selectedIndex] ?? 0;
                                return ` จำนวน: ${ictCountValue} ราย / รายได้: ${ictIncomeValue} บาท`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                           
                            callback: function (value) {
                                return value.toFixed(1);
                            }
                        }
                    }
                }
            }
        });
    }

    typeSelect.value = maxTypeId;
    updateChart(maxTypeId);

    typeSelect.addEventListener('change', function () {
        updateChart(parseInt(this.value));
    });
});

</script>
@endsection

@extends('admins.index')
@section('css')
@endsection
@section('content')
    <div class="container">
        <h2>จัดการบริการ</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#serviceModal">เพิ่มบริการ</button>
        <table class="table table-bordered ">
            <thead>
                <tr class="bg-dark text-light">
                    <th>ชื่อบริการ</th>
                    <th>เครื่องมือ</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $row)
                        <tr>

                            <td class="col-5">{{ $row->service_name }}</td>

                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editServiceModal"
                                    data-url="{{ route('serve_update', $row->service_id) }}"
                                    data-id="{{ $row->service_id }}" data-name="{{ $row->service_name }}">
                                    แก้ไข
                                </button>

                                <form action="{{ route('service_delete', $row->service_id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm delete-button"
                                        data-url="{{ route('service_delete', $row->service_id) }}"
                                        onclick="showDeleteConfirm(event)">
                                        ลบ
                                    </button>
                                </form>

                                <a href="{{ route('promotion_list', $row->service_id) }}"
                                    class="btn btn-info btn-sm">ดูโปรโมชั่น</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">ไม่มีข้อมูลบริการ</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Modal สำหรับเพิ่ม -->
        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="serviceForm" action="{{ route('service_insert') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" id="service_id">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="serviceModalLabel">เพิ่ม/แก้ไขบริการ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="service_name" class="form-label">ชื่อบริการ</label>
                                <input type="text" class="form-control" id="service_name" name="service_name" required>
                            </div>
                            <div id="fields-container">
                                <div class=" d-flex align-items-center">
                                    <div class="me-3">
                                        <label for="sub_service" class="form-label">ข้อมูลของบริการ</label>
                                        <input type="text" class="form-control" id="sub_service" name="sub_service[]"
                                            >
                                    </div>
                                    <div>
                                        <label for="type_sub" class="form-label">ประเภทข้อมูล</label>
                                        <select name="type_sub[]" id="type_sub" class="form-control">
                                            <option value="" disabled selected>-- เลือกประเภทข้อมูล --</option>
                                            <option value="boolean">ตัวเลือก</option>
                                            <option value="number">ตัวเลข</option>
                                            <option value="string">ตัวหนังสือ</option>
                                        </select>
                                      
                                    </div>
                                    <button type="button" id="addField" class="btn btn-success mt-4">+เพิ่มฟิลด์</button>
                                </div>
                                  <!-- แสดงฟิลด์สำหรับกรอกค่า True/False -->
                                  <div id="booleanFields" style="display: none;">
                                    <div  class="d-flex align-items-center">
                                    <div class="mb-3">
                                        <label for="true_value" class="form-label">ตัวเลือกที่ 1</label>
                                        <input type="text" class="form-control" id="true_value"
                                            name="true_value[]">
                                    </div>
                                    <div class="mb-3">
                                        <label for="false_value" class="form-label">ตัวเลือกที่ 2</label>
                                        <input type="text" class="form-control" id="false_value"
                                            name="false_value[]">
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <!-- Modal สำหรับแก้ไข -->
        <div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editServiceModalLabel">แก้ไขบริการ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editServiceForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="serviceName" class="form-label">ชื่อบริการ</label>
                                <input type="text" class="form-control" id="serviceName" name="service_name"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editServiceModal = document.getElementById('editServiceModal');
            editServiceModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // ปุ่มที่เรียก Modal
                const url = button.getAttribute('data-url');
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');


                // ใส่ค่าลงในฟอร์ม
                const form = document.getElementById('editServiceForm');
                form.action = url;
                form.querySelector('#serviceName').value = name;
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
        function showDeleteConfirm(event) {
            event.preventDefault(); // หยุดการ reload หน้า
            const form = event.target.closest('form'); // หาฟอร์มที่เกี่ยวข้อง

            Swal.fire({
                title: 'ลบข้อมูลหรือไม่?',
                text: "คุณจะไม่สามารถย้อนกลับได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบเลย!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // ทำการส่งฟอร์ม
                }
            });
        }
    </script>

<script>
    // Function to add a new field
    function addField() {
        var container = document.getElementById('fields-container');
        var newField = document.createElement('div');
        newField.classList.add('mb-3', 'd-flex', 'align-items-center');
        newField.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <label for="sub_service" class="form-label">ข้อมูลของบริการ</label>
                    <input type="text" class="form-control" name="sub_service[]">
                </div>
                <div>
                    <label for="type_sub" class="form-label">ประเภทข้อมูล</label>
                    <select name="type_sub[]" class="form-control">
                        <option value="" disabled selected>-- เลือกประเภทข้อมูล --</option>
                        <option value="boolean">ตัวเลือก</option>
                        <option value="number">ตัวเลข</option>
                        <option value="string">ตัวหนังสือ</option>
                    </select>
                </div>
                <button type="button" class="btn btn-success mt-4 addFieldBtn">+เพิ่มฟิลด์</button>
                <button type="button" class="btn btn-danger mt-4 removeFieldBtn">-ลบฟิลด์</button>
            </div>
            <div class="booleanFields" style="display: none;">
                
                    <div class="mb-3">
                        <label for="true_value" class="form-label">ตัวเลือกที่ 1</label>
                        <input type="text" class="form-control" name="true_value[]">
                    </div>
                    <div class="mb-3">
                        <label for="false_value" class="form-label">ตัวเลือกที่ 2</label>
                        <input type="text" class="form-control" name="false_value[]">
                    </div>
           
            </div>
        `;
        container.appendChild(newField);

        // Add event listener to the remove button
        newField.querySelector('.addFieldBtn').addEventListener('click', addField);


        newField.querySelector('.removeFieldBtn').addEventListener('click', function() {
            newField.remove(); // Remove the field when delete button is clicked
        });

        // Handle changes in type_sub select
        newField.querySelector('select[name="type_sub[]"]').addEventListener('change', function() {
            var booleanFields = newField.querySelector('.booleanFields');
            if (this.value === 'boolean') {
                booleanFields.style.display = 'block';
            } else {
                booleanFields.style.display = 'none';
            }
        });
    }

    // Initial event listener for the first add button
    document.getElementById('addField').addEventListener('click', addField);
</script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSubSelect = document.getElementById('type_sub');
            const booleanFields = document.getElementById('booleanFields');

            // ตรวจจับการเปลี่ยนแปลงของประเภทข้อมูล
            typeSubSelect.addEventListener('change', function() {
                if (this.value === 'boolean') {
                    // ถ้าเลือก "boolean" ให้แสดงฟิลด์สำหรับกรอกค่า True/False
                    booleanFields.style.display = 'block';
                } else {
                    // ถ้าไม่ใช่ "boolean" ให้ซ่อนฟิลด์ True/False
                    booleanFields.style.display = 'none';
                }
            });
        });
    </script>
@endsection

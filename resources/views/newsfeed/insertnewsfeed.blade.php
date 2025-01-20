@extends('admins.index')
@section('title')
รายการข้อมูล
@endsection
@section('header')
รายการข้อมูล
@endsection
@section('css')

@endsection
@section('content')

<h4 class="fw-bold py-2 mb-3"><span class="text-muted fw-light">
            <a href="{{ route('home') }}" class="">
                หน้าแรก
            </a>
            /
            <a href="javascript:history.back()" class="">
            รายการจัดการข่าว
            </a>
            /
        </span> รายการจัดการข่าว</h4>

<div class="card card-warning mt-2">
    <div class="d-flex justify-content-between align-items-center gap-2">
        <h3 class="card-header ">
            เพิ่มข่าว
        </h3>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-dark me-4" data-bs-toggle="modal" data-bs-target="#modalScrollable">
                <i class="fas fa-question-circle"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body text-dark">
        <form action="{{ route('createnews') }}" class="form-group" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">หัวข้อ</label>
                <input class="form-control" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                @error('name')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="description">คำอธิบาย</label>
                <input class="form-control" type="text" placeholder="Description" name="description"
                    value="{{ old('description') }}">
                @error('description')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="categories">หมวดหมู่</label>
                <select class="form-control" name="categories" required>
                    <option value="" disabled selected>เลือกหมวดหมู่</option>
                    <option value="ข่าว" {{ old('categories') == 'ข่าว' ? 'selected' : '' }}>ข่าว</option>
                    <option value="เอกสาร" {{ old('categories') == 'เอกสาร' ? 'selected' : '' }}>เอกสาร ไม่เป็นสาธารณะ
                    </option>
                    <option value="แบบฟอร์ม" {{ old('categories') == 'แบบฟอร์ม' ? 'selected' : '' }}>แบบฟอร์ม</option>
                </select>
                @error('categories')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="content_type">ประเภทข้อมูล</label>
                <select class="form-control" name="content_type" id="content_type" required>

                    <option value="file" {{ old('content_type') == 'file' ? 'selected' : '' }}>ไฟล์</option>
                    <option value="link" {{ old('content_type') == 'link' ? 'selected' : '' }}>ลิงค์</option>
                    <option value="youtube" {{ old('content_type') == 'youtube' ? 'selected' : '' }}>ลิงค์วิดีโอ 
                    </option>
                </select>
                @error('content_type')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3" id="file_input">
                <label for="file">ไฟล์</label>
                <input class="form-control" type="file" name="file">
                @error('file')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3" id="link_input" style="display: none;">
                <label for="link">ลิงก์</label>
                <input class="form-control" type="url" name="link" placeholder="https://example.com"
                    value="{{ old('link') }}">
                @error('link')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3" id="youtube_input" style="display: none;">
                <label for="youtube">ลิงก์วิดีโอ YouTube</label>
                <input class="form-control" type="url" name="youtube" placeholder="https://youtube.com/watch?v=..."
                    value="{{ old('youtube') }}">
                @error('youtube')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>


    </div>


    </tbody>
    </table>

    <div class="col-12 mb-3 text-center">
        <a href="/listnewsfeed" class="btn bg-danger">
            Cancel
        </a>
        <input type="submit" class="btn btn-success" value="Submit">
    </div>
    </form>
</div>
<!-- /.card-body -->





<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalScrollableTitle">คู่มือการใช้งานหน้าจัดการข่าวสาร</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body text-dark">
            <h6 style="color: black; font-weight: bold;">
            1.การดูข้อมูลข่าวสาร(Read)
          </h6>
          <p>
            • แสดงรายการข่าวสารทั้งหมดในรูปแบบตาราง
          </p>
          <p>
            • สามารถค้นหาข่าวสารได้โดย ชื่อข่าวสาร
          </p>
          <p>
            • แสดงจำนวนรายการต่อหน้าได้ตามที่กำหนด
          </p>
          <h6 style="color: black; font-weight: bold;">
            2.การเพิ่มข่าวสารใหม่ (Create)
          </h6>
          <p>
            • คลิกปุ่ม "เพิ่มเอกสาร" ที่ด้านบนของตาราง
          </p>
          <p>
            • กรอกข้อมูลในแบบฟอร์ม
          </p>
          <p>
            • คลิกปุ่ม "บันทึก" เพื่อสร้างเอกสารใหม่
          </p>
          <h6 style="color: black; font-weight: bold;">
            3.การแก้ไขข้อมูลข่าวสาร (Update)
          </h6>
          <p>
            • • คลิกไอคอนลบ (รูปถังดินสอ) ตรงเครื่องมือดำเนินการ
          </p>
          <p>
            • แก้ไขข้อมูลในแบบฟอร์ม
          </p>
          <p>
            • คลิกปุ่ม "บันทึก" เพื่อบันทึกการเปลี่ยนแปลง
          </p>
          <h6 style="color: black; font-weight: bold;">
            3.การลบข่าวสาร (Delete)
          </h6>
          <p>
            • คลิกไอคอนลบ (รูปถังขยะ) ตรงเครื่องมือดำเนินการ
          </p>
          <p>
            • ระบบจะแสดงหน้าต่างยืนยันการลบ
          </p>
          <p>
            • คลิก "ยืนยัน" เพื่อลบผู้ใช้งาน หรือ "ยกเลิก" เพื่อยกเลิกการลบ
          </p>
          <h6 style="color: black; font-weight: bold;">
            คุณสมบัติเพิ่มเติม
          </h6>
          <p>
            • ระบบจะบันทึกประวัติการดำเนินการ (Audit Log)
          </p>
          <p>
            •มีระบบการแจ้งเตือนเมื่อดำเนินการสำเร็จหรือเกิดข้อผิดพลาด
          </p>
          <p>
            • รองรับการทำงานแบบ Responsive บนอุปกรณ์ทุกขนาดหน้าจอ
          </p>
          <h6 style="color: red;font-weight: bold;">
            ข้อควรระวัง
          </h6>
          
          <p>
            • การลบข้อมูลข่าวสารไม่สามารถเรียกคืนได้
          </p>
          <p>
            • ควรตรวจสอบความถูกต้องของข้อมูลก่อนการบันทึกทุกครั้ง
          </p>
          
          
          
        </div>

      </div>
    </div>
  </div>

@endsection

@section('script')

<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });

    document.getElementById('content_type').addEventListener('change', function () {
        const value = this.value;
        document.getElementById('file_input').style.display = value === 'file' ? 'block' : 'none';
        document.getElementById('link_input').style.display = value === 'link' ? 'block' : 'none';
        document.getElementById('youtube_input').style.display = value === 'youtube' ? 'block' : 'none';
    });
</script>
@endsection
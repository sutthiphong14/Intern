@extends('admins.index')
@section('title')
แก้ไขข้อมูล
@endsection
@section('header')
แก้ไขข้อมูล
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
        </span> แก้ไขข้อมูลการข่าว</h4>

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

    <div class="card-body text-dark">
        <form action="{{ route('updatenews', $oldnews->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">หัวข้อ</label>
                <input class="form-control" type="text" placeholder="Name" name="name"
                    value="{{ old('name', $oldnews->name) }}">
                @error('name')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3 mt-3">
                <label for="description">คำอธิบาย</label>
                <input class="form-control" type="text" placeholder="Description" name="description"
                    value="{{ old('description', $oldnews->description) }}">
                @error('description')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="categories">หมวดหมู่</label>
                <select class="form-control" name="categories" required>
                    <option value="" disabled>เลือกหมวดหมู่</option>
                    <option value="ข่าว" {{ old('categories', $oldnews->categories) == 'ข่าว' ? 'selected' : '' }}>ข่าว
                    </option>
                    <option value="เอกสาร" {{ old('categories', $oldnews->categories) == 'เอกสาร' ? 'selected' : '' }}>
                        เอกสาร</option>
                    <option value="แบบฟอร์ม" {{ old('categories', $oldnews->categories) == 'แบบฟอร์ม' ? 'selected' : '' }}>แบบฟอร์ม</option>
                </select>
                @error('categories')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="content_type">ประเภทข้อมูล</label>
                <select class="form-control" name="content_type" id="content_type" required>
                    <option value="" disabled>เลือกประเภทข้อมูล</option>
                    <option value="file" {{ old('content_type', $oldnews->content_type) == 'file' ? 'selected' : '' }}>
                        ไฟล์</option>
                    <option value="link" {{ old('content_type', $oldnews->content_type) == 'link' ? 'selected' : '' }}>
                        ลิงก์</option>
                    <option value="youtube" {{ old('content_type', $oldnews->content_type) == 'youtube' ? 'selected' : '' }}>วิดีโอ YouTube</option>
                </select>
                @error('content_type')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3" id="file_input"
                style="display: {{ $oldnews->content_type == 'file' ? 'block' : 'none' }};">
                <label for="file">ไฟล์</label>
                <input class="form-control" type="file" name="file">
                @error('file')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3" id="link_input"
                style="display: {{ $oldnews->content_type == 'link' ? 'block' : 'none' }};">
                <label for="link">ลิงค์</label>
                <input class="form-control" type="url" name="link" placeholder="https://example.com"
                    value="{{ old('link', $oldnews->link) }}">
                @error('link')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mt-3" id="youtube_input"
                style="display: {{ $oldnews->content_type == 'youtube' ? 'block' : 'none' }};">
                <label for="youtube">ลิงค์วิดีโอ</label>
                <input class="form-control" type="url" name="youtube" placeholder="https://youtube.com/watch?v=..."
                    value="{{ old('youtube', $oldnews->youtube) }}">
                @error('youtube')
                    <p class="text-danger my-2"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                @enderror
            </div>

            <div class="col-12 mb-3 text-center mt-3">
                <a href="/listnewsfeed" class="btn bg-danger">Cancel</a>
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="modalScrollable" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalScrollableTitle">คำอธิบายข้อมูล</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-dark">
                <p>
                    รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                    หน้าหลัก รายงานระยะเวลาเฉลี่ยในการติดตั้ง
                </p>
                <p>
                    หมายเหตุ : รายงานระยะเวลาเฉลี่ยในการติดตั้ง ตามศูนย์บริการติดตั้ง
                </p>
                <p>
                    • จำนวนวงจร : จะนับเฉพาะใบคำขอที่ทำการปิดงานเรียบร้อยบนระบบ FTTxSM เท่านั้น (ไม่รวมข้อมูลใบคำขอที
                    import มาจากสผ.และใบคำขอที่ยังไม่เคยปิดงานเรียบร้อย) ตามช่วงเวลาที่เลือก
                </p>
                <p>
                    • ระยะเวลาเตรียมข้อมูลรวม : ยอดรวมระยะเวลาที่ใช้ในเตรียมเอกสารของวงจรตามช่วงเวลาที่เลือก
                    โดยนับระยะเวลาตั้งแต่วันที่สร้างคำขอ - รับชำระเงิน
                </p>
                <p>
                    • ระยะเวลาดำเนินการรวม : ยอดรวมระยะเวลาที่ใช้ในการติดตั้งของวงจรตามช่วงเวลาที่เลือก
                    โดยนับระยะเวลาตั้งแต่รับชำระเงิน - ปิดงานเรียบร้อย ยกเว้น ช่วงรอลูกค้า
                </p>
                <p>
                    • ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจร :

                </p>
                <p>
                    - กำหนดSDP/ODP :
                </p>
                <p>
                    >> กรณีส่งงานโยงสายถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงานโยงสาย หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีส่งงานNMSถัดไป ยอดรวมจำนวนวัน นับจากวันที่รับชำระเงินจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    - โยงสาย (ถ้าส่งงาน) : ยอดรวมจำนวนวัน นับจากวันที่ส่งงานโยงสายจนถึงส่งงาน NMS หารด้วย จำนวนวงจร
                    (ช่องที่ 1)
                </p>
                <p>
                    - การดำเนินการของ NMS, นัดหมายและกำหนดช่าง, ปิดงาน : ยอดรวมจำนวนวัน
                    นับจากวันที่รับงานมาดำเนินการจนถึงวันที่จ่ายงานให้งานถัดไป หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    - รอลูกค้า :
                </p>
                <p>
                    >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่ติดตั้ง หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่ส่งงานลากสายและติดตั้งจนถึงวันที่นัดหมายลูกค้า หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    - ลากสายและติดตั้ง :
                </p>
                <p>
                    >> กรณีติดตั้งเร็วกว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน นับจากวันที่ติดตั้งจนถึงวันที่ส่งงานปิดงาน
                    หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    >> กรณีติดตั้งช้ากว่าวันที่นัดหมายลูกค้า ยอดรวมจำนวนวัน
                    นับจากวันที่วันนัดหมายลูกค้าจนถึงวันที่ส่งงานปิดงาน หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • รวมระยะเวลาเฉลี่ยที่ใช้ต่อวงจร : ระยะเวลารวม (ช่องที่ 3) หารด้วย จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • ร้อยละการติดตั้งภายใน 3 วัน : ร้อยละการปิดงานเรียบร้อยภายใน 3 วัน(รับชำระเงิน - ปิดงานเรียบร้อย
                    ยกเว้นช่วงรอลูกค้า) เมื่อเทียบกับ จำนวนวงจร (ช่องที่ 1)
                </p>
                <p>
                    • กรณีมีการติดตั้งวงจร แต่ระยะเวลาเฉลี่ยที่ใช้ในการดำเนินการต่อวงจรเท่ากับ 0.00 :
                    ใช้ระยะเวลาในการดำเนินการเป็นระดับวินาที จึงไม่สามารถแสดงตัวเลขได้
                </p>
                <p>
                    • รายงานเดือนตุลา ที่มีตัวเลขติดลบในบางพื้นที่ ทางระบบกำลังดำเนินการตรวจสอบและแก้ไขค่ะ
                    เนื่องจากมีการเลือกวันที่ติดตั้งและส่งงานไม่ถูกต้อง
                </p>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contentTypeSelect = document.querySelector('#content_type');
        const fileInput = document.querySelector('#file_input');
        const linkInput = document.querySelector('#link_input');
        const youtubeInput = document.querySelector('#youtube_input');

        function toggleInputs() {
            const selectedValue = contentTypeSelect.value;
            fileInput.style.display = selectedValue === 'file' ? 'block' : 'none';
            linkInput.style.display = selectedValue === 'link' ? 'block' : 'none';
            youtubeInput.style.display = selectedValue === 'youtube' ? 'block' : 'none';
        }

        // Initial toggle based on current value
        toggleInputs();

        // Event listener for changes in content_type
        contentTypeSelect.addEventListener('change', toggleInputs);
    });
</script>

@endsection
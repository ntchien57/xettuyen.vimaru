@extends('layout')
@section('title','Thí sinh trúng tuyển')

@section('content')
<div class="container-fluid">
  <div class="card card-secondary">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
      <h3 class="card-title mb-0">Danh sách trúng tuyển</h3>

      {{-- Bộ lọc + search --}}
      <form method="GET" class="d-flex align-items-center gap-2">
        {{-- Lọc ngành --}}
        <select name="major" class="form-control form-select" style="width: 220px;">
          <option value="">— Tất cả ngành —</option>
          @foreach($majors as $m)
            <option value="{{ $m->code }}" @selected($major === $m->code)>
              {{ $m->code }} - {{ $m->name }}
            </option>
          @endforeach
        </select>

        {{-- Sort điểm --}}
        <select name="sort" class="form-control form-select" style="width: 180px;">
          <option value="desc" @selected($sort==='desc')>Điểm: cao → thấp</option>
          <option value="asc"  @selected($sort==='asc')>Điểm: thấp → cao</option>
        </select>

        {{-- Tìm kiếm --}}
        <div class="input-group input-group-sm" style="width: 320px;">
          <input type="text" name="q" class="form-control" placeholder="Tìm tên/email/CCCD" value="{{ $q }}">
          <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
      </form>
    </div>

    <div class="card-body table-responsive p-0">
      <table class="table table-hover table-striped align-middle mb-0">
        <thead>
          <tr>
            <th class="text-center" style="width:60px;">#</th>
            <th>Thí sinh</th>
            <th>Email</th>
            <th>CCCD</th>
            <th style="width:120px;">SBD</th>
            <th class="text-center" style="width:70px;">NV</th>
            <th style="width:140px;">Mã ngành</th>
            <th>Chuyên ngành</th>
            <th class="text-end" style="width:130px;">Điểm D01</th>
            <th class="text-nowrap" style="width:160px;">Thời điểm đậu</th>
          </tr>
        </thead>
        <tbody>
          @forelse($wishes as $i => $w)
            <tr>
              <td class="text-center">{{ $wishes->firstItem() + $i }}</td>
              <td>{{ $w->student_name }}</td>
              <td>{{ $w->email }}</td>
              <td>{{ $w->cccd }}</td>
              <td>{{ $w->exam_id ?? '—' }}</td>
              <td class="text-center">{{ $w->order_no }}</td>
              <td><span class="badge bg-dark">{{ $w->major_code }}</span></td>
              <td>{{ $w->major_name ?? '—' }}</td>
              <td class="text-end">{{ is_null($w->score_d01) ? '—' : number_format($w->score_d01, 2) }}</td>
              <td class="text-nowrap">{{ \Carbon\Carbon::parse($w->updated_at)->format('d/m/Y H:i') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="10" class="text-center text-muted">Chưa có thí sinh trúng tuyển.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Bottom pagination --}}
    <div class="card-footer d-flex justify-content-between align-items-center">
      <small class="text-muted mb-0">
        @if($wishes->total()>0)
          Hiển thị {{ $wishes->firstItem() }}–{{ $wishes->lastItem() }} / {{ $wishes->total() }}
        @else
          Không có dữ liệu
        @endif
      </small>
      {{ $wishes->onEachSide(1)->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Edit Kelas')

@section('content')
<style>
.page-title { font-size:20px; font-weight:700; color:#111827; }
.page-sub { font-size:13px; color:#6b7280; margin-top:2px; }
.card-form { background:#ffffff; border-radius:14px; border:1px solid #e5e7eb; overflow:hidden; }
.form-header { background:#f8fafc; padding:18px 22px; }
.form-header-title { font-size:16px; font-weight:700; color:#111827; }
.form-header-sub { font-size:13px; color:#6b7280; margin-top:4px; }
.form-body { padding:22px; }
.form-group { margin-bottom:18px; }
.form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:8px; }
.form-input { width:100%; border:1px solid #d1d5db; border-radius:10px; padding:12px 14px; font-size:14px; color:#111827; outline:none; transition:border-color .15s, box-shadow .15s; background:#fff; }
.form-input:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,0.08); }
.form-hint { font-size:12px; color:#6b7280; margin-top:6px; }
.btn-submit { background:#2563eb; color:#fff; padding:11px 20px; border-radius:10px; font-size:14px; font-weight:600; border:none; cursor:pointer; }
.btn-cancel { background:#f9fafb; color:#374151; padding:11px 20px; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; border:1px solid #e5e7eb; }
.alert-error { background:#fef2f2; border-left:4px solid #ef4444; color:#991b1b; padding:14px 16px; border-radius:10px; font-size:13px; margin-bottom:18px; }
</style>

<div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
    <a href="{{ route('kelas.index') }}" 
       style="display:flex; align-items:center; justify-content:center; width:34px; height:34px; background:#fff; border:1px solid #e2e8f0; border-radius:8px; color:#64748b; text-decoration:none;">
        <i class="ti ti-arrow-left" style="font-size:16px;" aria-hidden="true"></i>
    </a>
    <div>
        <div class="page-title">Edit Kelas {{ $kelas->nama_kelas }}</div>
        <div class="page-sub">Perbarui data kelas</div>
    </div>
</div>

<div class="card-form">
    <div class="form-header">
        <div class="form-header-title">Form Edit Kelas</div>
        <div class="form-header-sub">Perbarui data kelas yang sudah ada</div>
    </div>
    <div class="form-body">

        @if($errors->any())
            <div class="alert-error">✕ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('kelas.update', $kelas) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                       class="form-input">
                <div class="form-hint">Gunakan format huruf + angka, misal A1 atau B2</div>
            </div>

            <div class="form-group">
                <label class="form-label">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}"
                       class="form-input">
                <div class="form-hint">Gunakan format tahun/tahun, misal 2024/2025</div>
            </div>

            <div style="display:flex; gap:10px; padding-top:8px; border-top:1px solid #f1f5f9; margin-top:8px;">
                <button type="submit" class="btn-submit">
                    <i class="ti ti-check" style="font-size:13px;" aria-hidden="true"></i> Perbarui Kelas
                </button>
                <a href="{{ route('kelas.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
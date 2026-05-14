<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
  use SoftDeletes;
  protected $table = 'transaksi';
  protected $fillable = [
    'siswa_id',
    'user_id',
    'nama_petugas',
    'jenis',
    'jumlah',
    'saldo_sebelum',
    'saldo_sesudah',
    'keterangan',
    'alasan_hapus',
    'user_id_hapus',
  ];

  protected function casts(): array
  {
    return [
      'jumlah' => 'decimal:2',
      'saldo_sebelum' => 'decimal:2',
      'saldo_sesudah' => 'decimal:2',
    ];
  }

  // Relasi: transaksi belongs to siswa
  public function siswa()
  {
    return $this->belongsTo(Siswa::class);
  }

  // Relasi: transaksi dicatat oleh user
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
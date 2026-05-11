<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
  protected $table = 'transaksi';
  protected $fillable = [
    'siswa_id',
    'user_id',
    'jenis',
    'jumlah',
    'saldo_sebelum',
    'saldo_sesudah',
    'keterangan',
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
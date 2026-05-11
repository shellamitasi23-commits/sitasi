<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  protected $table = 'siswa'; 
  protected $fillable = [
    'kelas_id',
    'nama',
    'saldo',
  ];

  protected function casts(): array
  {
    return [
      'saldo' => 'decimal:2',
    ];
  }

  // Relasi: siswa belongs to kelas
  public function kelas()
  {
    return $this->belongsTo(Kelas::class);
  }

  // Relasi: siswa punya banyak transaksi
  public function transaksi()
  {
    return $this->hasMany(Transaksi::class);
  }
}
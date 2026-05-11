<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
  protected $table = 'kelas';

  protected $fillable = [
    'nama_kelas',
    'tahun_ajaran',
  ];

  // Relasi: satu kelas punya banyak siswa
  public function siswa()
  {
    return $this->hasMany(Siswa::class);
  }
}
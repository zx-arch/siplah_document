<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembatalanTransaksiModel extends Model
{
    protected $table = 'pembatalan_transaksi';
    protected $fillable = [
        'kode_document',
        'user',
        'nama_document',
        'file'
    ];
    protected $hidden = [];

    protected static function boot()
    {
        parent::boot();

        // Event creating akan dipanggil sebelum data disimpan ke database
        static::creating(function ($model) {
            // Mengambil nomor urut terakhir + 1
            $lastNumber = static::max('kode_document');
            $number = ($lastNumber) ? (int) str_replace('SKPT-', '', $lastNumber) + 1 : 1;

            // Format kode_document sesuai kebutuhan
            $model->kode_document = 'SKPT-' . $number;
        });
    }

    public static function deleteDocument($user, $kode_document)
    {
        // Gunakan metode delete untuk menghapus data berdasarkan kondisi
        return static::where('kode_document', $kode_document)
            ->where('user', $user)
            ->delete();
    }
}
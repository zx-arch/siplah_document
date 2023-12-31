<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\PembatalanTransaksiModel;
use Illuminate\Support\Facades\Session;

class PembatalanTransaksiController extends Controller
{
    public function index()
    {
        $getdata = PembatalanTransaksiModel::select('kode_document', 'user', 'nama_document', 'created_at')->take(75)->get();

        return view('documents.pembatalan_transaksi', [
            'getdata' => $getdata
        ]);
    }

    public function upload(Request $request)
    {
        $file = $request->all()['document'];

        if ($file->getMimeType() == 'application/pdf') {
            if ($file->getSize() <= 307200) {

                try {
                    $fileContent = file_get_contents($file->getRealPath());

                    // Menyimpan data ke dalam database
                    PembatalanTransaksiModel::create([
                        'user' => 'user_a',
                        'nama_document' => $file->getClientOriginalName(),
                        'file' => $fileContent,
                    ]);

                    // Jika Anda ingin mengakses kode_document setelah insert
                    return redirect('/pembatalan_transaksi')->with('update_document_success', 'Berhasil upload document');
                } catch (QueryException $e) {
                    $errorInfo = $e->errorInfo;

                    // Mencetak informasi kesalahan
                    dd($errorInfo);
                }
            } else {
                return redirect('/pembatalan_transaksi')->with('size_invalid', 'Ukuran PDF minimal 300 KB');
            }
        } else {
            return redirect('/pembatalan_transaksi')->with('type_invalid', 'Jenis file tidak diijinkan');
        }
    }

    public function DownloadDocumentUpload(Request $request)
    {
        $get = PembatalanTransaksiModel::select('file', 'nama_document')->where('user', '=', $request->user)->where('kode_document', '=', $request->kode_document)->get()[0];
        // dd($get);
        // Ambil data blob (misalnya dari database)
        $blobData = $get->file; // Ambil data blob sesuai dengan implementasi Anda

        // Tentukan nama file PDF (misalnya 'file.pdf')
        $filename = $get->nama_document;

        // Atur header untuk response
        $headers = [
            'Content-Type' => 'application/pdf; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        // Kembalikan response dengan data blob dan header
        return response($blobData, 200, $headers);
    }

    public function deleteDocument($user, $kode_document)
    {
        $delete = PembatalanTransaksiModel::deleteDocument($user, $kode_document);

        if ($delete == 1) {
            return redirect('/pembatalan_transaksi')->with('delete_document_success', 'Document ' . $kode_document . ' berhasil dihapus');
        }
    }
}
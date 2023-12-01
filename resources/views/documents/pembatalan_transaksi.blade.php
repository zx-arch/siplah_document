@extends('documents.layouts.template')
@section('container')
    
    @include('documents.components.navbar')
        <div class="p-1 my-container active-cont">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 border-bottom">
                <h1 class="h4 p-2">Surat Kesepakatan Pembatalan Transaksi</h1>
            </div>
            
            <div class="containers p-2">
            <a class="btn btn-warning" href="{{ asset('template/surat_kesepakatan_pembatalan_transaksi.pdf') }}" download="Surat Kesepakatan Pembatalan Transaksi.pdf">Download</a>
                <div class="card border border-success mt-3">
                    <div class="card-header bg-success">
                        <span>Upload Document</span>
                    </div>
                    <div class="card-body">
                    <div class="update-foto w-50">
                        <img id="imagePreview" src="#" alt="Preview Gambar" class="mb-2" style="max-width: 100%; display: none;">

                        <form action="{{ url('settings/update_foto') }}" method="post" id="update_foto" class="p-2 mr-3" enctype='multipart/form-data'>
                            @php (Session::put('token', csrf_token()))
                            <div class="mb-1">
                                <input class="form-control" name="foto_profil" type="file" id="formFile" accept=".pdf" required>
                                
                                <span class="error_image text-danger p-2 mb-1"></span>
                            </div>

                            @if (Session::has('update_img_success'))
                                <p style="color: red;">{{ Session::get('update_img_success') }}</p>
                            @endif

                            <button type="submit" class="btn btn-primary">Upload</button><span class="p-2">*pdf</span>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
 <script>
        // Fungsi untuk menampilkan nama file yang dipilih
        function displayFileName() {
            const fileInput = document.getElementById('pdfFile');
            const fileNameDisplay = document.getElementById('fileName');

            fileNameDisplay.textContent = fileInput.files[0].name;
        }

        // Memicu klik pada input file saat tombol kustom diklik
        document.getElementById('custombutton').addEventListener('click', function() {
            document.getElementById('pdfFile').click();
        });
    </script>
@endsection
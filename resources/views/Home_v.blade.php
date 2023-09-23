<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>TEST FAST PRINT</title>
</head>
<style>
    body {
        background-color: #95afc0
    }

    .boxtable {
        border-radius: 10px;
        box-shadow: 1px 1px 10px 1px;
        position: relative;
        width: 100%;
        background-color: white
    }

    .pss-alert {
        position: relative;
        right: -40%;
    }
</style>

<body>
    <div class="container-fluid">
        <div class="row" style="height: 90px">
            <div class="alert alert-info alert-dismissible fade show pss-alert" style="display: none" id="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Info!</strong> Data Sudah Terbaru
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row boxtable" style="margin-top: 30px; margin-bottom: 100px">
            <div class="col-md-12">
                <div class="row" style="margin-top: 10px">
                    <div class="col-md-6">
                        <h4>DATA Product</h4>
                    </div>
                    <div class="col-md-6">
                        <button onclick="Syncronize()" class="btn btn-primary" style="float: right">Sync</button>
                        <button class="btn btn-success" style="float: right; margin-right: 10px" data-toggle="modal" data-target="#add">Tambah Data</button>
                    </div>
                </div>
                <hr>
            </div>
            <div class="table-responsive col-md-12">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Product</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table_data">
                        {{-- proccess di JS --}}
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" id="total_data">
                {{-- proccess di JS --}}
            </div>
            <div class="col-md-12 mt-2">
                <ul class="pagination" id="pagination">
                    {{-- proccess di JS --}}
                </ul>
            </div>
        </div>

        <div class="modal fade" id="add">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="product">Nama Product</label>
                            <input type="text" class="form-control" id="product-add" name="product">
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="text" class="form-control" id="harga-add" name="harga">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori-add" name="kategori">
                                {{-- proses di js --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status-add" name="status">
                                {{-- proses di js --}}
                            </select>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="simpanData">Simpan</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" style="display: none" id="id-edit">
                    <div class="form-group">
                        <label for="product">Nama Product</label>
                        <input type="text" class="form-control" id="product-edit" name="product">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" id="harga-edit" name="harga">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" id="kategori-edit" name="kategori">
                            {{-- proses di js --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status-edit" name="status">
                            {{-- proses di js --}}
                        </select>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editdatasimpan">Simpan</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="hapus">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <input type="text" style="display: none" id="id-hapus">
                    <h4>Apakah Anda Yakin Ingin Menghapus data ini ?</h4>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" id="hapusdatabutton">Ya</button>
                </div>

            </div>
        </div>
    </div>
</div>
</body>

<script>
    function Syncronize(){
        $.ajax({
            url: '/call-api',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#alert').empty();
                    $('#alert').append('<button type="button" class="close" data-dismiss="alert">&times;</button>')
                    if(response.count == 0){
                        $('#alert').append('<strong>Info!</strong> Data Sudah Terbaru');
                    }else{
                        $('#alert').append('<strong>Info!</strong> Data Sudah Terupdate');
                    }

                    $('#alert').css('display','block');
                    setTimeout(function() {
                        $('#alert').css('display', 'none');
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ' + error);
                }
            });
    }

    $('body').on('click', '.btnedit', function () {
        $('#product-edit').val($(this).data('product'));
        $('#harga-edit').val($(this).data('harga'));
        $('#kategori-edit').val($(this).data('ketegori'));
        $('#status-edit').val($(this).data('status'));
        $('#id-edit').val($(this).data('id'));
    });

    $('body').on('click', '.btnhapus', function () {
        $('#id-hapus').val($(this).data('id'));
    });

    $(document).ready(function() {
        loadPage(1);


        function loadPage(page) {
            $.ajax({
                url: '/getData?page=' + page,
                method: 'GET',
                dataType: 'json',
                data: {
                    page: page
                },
                success: function(response) {
                    var table_data = $('#table_data');
                    table_data.empty();
                    $('#total_data').empty();
                    $('#total_data').append('Total Data: '+response.total_items);

                    // option status
                    $('#status-add').empty();
                    $('#status-edit').empty();
                    $.each(response.getsta, function(index, item){
                        $('#status-add').append('<option value="'+item.id+'">'+item.nama_status+'</option>')
                        $('#status-edit').append('<option value="'+item.id+'">'+item.nama_status+'</option>')
                    });
                    
                    // option kategori
                    $('#kategori-add').empty();
                    $('#kategori-edit').empty();
                    $.each(response.getkat, function(index, item){
                        $('#kategori-add').append('<option value="'+item.id+'">'+item.nama_kategori+'</option>')
                        $('#kategori-edit').append('<option value="'+item.id+'">'+item.nama_kategori+'</option>')
                    });

                    $.each(response.data, function(index, item) {
                        table_data.append('<tr>'+
                            '<td>' + item.id + '</td>'+
                            '<td>' + item.nama_produk + '</td>'+
                            '<td>' + item.harga + '</td>'+
                            '<td>' + item.nama_kategori + '</td>'+
                            '<td>' + item.nama_status + '</td>'+
                            '<td>'+
                                '<button data-id="'+item.id+'" data-product="'+item.nama_produk+'" data-harga="'+item.harga+'"'+
                                'data-ketegori="'+item.kat_id+'" data-status="'+item.sta_id+'" class="btnedit btn btn-info"'+
                                'data-toggle="modal" data-target="#edit">'+
                                'Edit'+
                                '</button>'+
                                '<button data-id="'+item.id+'" data-toggle="modal" data-target="#hapus" class="btnhapus btn btn-danger">Hapus</button>'+
                            '</td>'+
                        '</tr>');
                    });

                    var pagination = $('#pagination');
                    pagination.empty();
                    if (response.current_page > 1) {
                        pagination.append('<li class="page-item"><a href="#" class="page-link" data-page="' + (response.current_page - 1) + '">Previous</a></li>');
                    }
                    for (var i = 1; i <= response.total_pages; i++) {
                        
                        if (i == response.current_page) {
                            pagination.append('<li class="page-item"><a class="page-link active">' + i + '</a></li>');
                        } else {
                            pagination.append('<li class="page-item"><a href="#" class="page-link" data-page="' + i + '">' + i + '</a></li>');
                        }
                    }

                    if (response.current_page < response.total_pages) {
                        pagination.append('<li class="page-item"><a href="#" class="page-link" data-page="' + (response.current_page + 1) + '">Next</a></li>');
                    }

                    // Tangani klik pada tombol paginasi
                    pagination.on('click', 'a.page-link', function(e) {
                        e.preventDefault();
                        var clickedPage = $(this).data('page');
                        loadPage(clickedPage);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ' + error);
                }
            });
        }

        $('#simpanData').click(function() {
            var CSRF_TOKEN = $("meta[name='csrf-token']").attr("content");
            let data = {
                product : $('#product-add').val(),
                harga : $('#harga-add').val(),
                ketegori: $('#kategori-add').val(),
                status : $('#status-add').val(),
                "_token": CSRF_TOKEN
            }
            $.ajax({
                url: '/addData', // Ganti sesuai dengan URL API Anda
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(response) {
                    alert(response.message);
                    $('#add').modal('hide');
                    loadPage(1);
                },
                error: function(xhr, status, error) {
                    console.log(xhr)
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        for (var field in errors) {
                            errorMessage += errors[field][0] + '\n';
                        }

                        alert('Terjadi kesalahan:\n' + errorMessage);
                    } else {
                        alert('Terjadi kesalahan: ' + error);
                    }
                }
            });
        });

        $('#editdatasimpan').click(function() {
            var CSRF_TOKEN = $("meta[name='csrf-token']").attr("content");
            let id = $('#id-edit').val();
            let data = {
                product : $('#product-edit').val(),
                harga : $('#harga-edit').val(),
                ketegori: $('#kategori-edit').val(),
                status : $('#status-edit').val(),
                "_token": CSRF_TOKEN
            }
            $.ajax({
                url: '/editData/'+id, // Ganti sesuai dengan URL API Anda
                type: 'PUT',
                dataType: 'json',
                data: data,
                success: function(response) {
                    alert(response.message);
                    $('#edit').modal('hide');
                    loadPage(1);
                },
                error: function(xhr, status, error) {
                    console.log(xhr)
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        for (var field in errors) {
                            errorMessage += errors[field][0] + '\n';
                        }

                        alert('Terjadi kesalahan:\n' + errorMessage);
                    } else {
                        alert('Terjadi kesalahan: ' + error);
                    }
                }
            });
        });

        $('#hapusdatabutton').click(function() {
            var CSRF_TOKEN = $("meta[name='csrf-token']").attr("content");
            let id = $('#id-hapus').val();
            $.ajax({
                url: '/hapusData/'+id, // Ganti sesuai dengan URL API Anda
                type: 'PUT',
                dataType: 'json',
                data: {"_token": CSRF_TOKEN},
                success: function(response) {
                    alert(response.message);
                    $('#hapus').modal('hide');
                    loadPage(1);
                },
                error: function(xhr, status, error) {
                    console.log(xhr)
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        for (var field in errors) {
                            errorMessage += errors[field][0] + '\n';
                        }

                        alert('Terjadi kesalahan:\n' + errorMessage);
                    } else {
                        alert('Terjadi kesalahan: ' + error);
                    }
                }
            });
        });


    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
</script>

</html>
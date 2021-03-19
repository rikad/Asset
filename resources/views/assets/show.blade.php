@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="block-header">
    <h2>Detail Barang</h2>
  </div>

  <!-- Basic Table -->
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            {{ $data->name }}
          </h2>
          <ul class="header-dropdown m-r--5">
            <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">more_vert</i>
              </a>
              <ul class="dropdown-menu pull-right">
                @if(\Laratrust::can("update-assets"))
                <li><a href="{{ route('assets.create') }}">Tambah</a></li>
                <li><a href="{{ route('assets.edit',$data->id) }}">Ubah</a></li>
                @endif
                <li><a href="?barcode=true">Cetak Barcode</a></li>

              </ul>
            </li>
          </ul>
        </div>

        <div class="body">
          <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
            <div class="col-lg-4 col-md-8 col-sm-8 col-xs-12" style="text-align: center">
                <a href="{{ asset('images/assets/'.$data->image) }}">
                    <img class="img-responsive thumbnail" src="{{ asset('images/assets/'.$data->image) }}" alt="{{ $data->name }}">
                </a>

                @if(\Laratrust::can("update-assets"))
                <hr>
                <a href="{{ route('assets.edit',$data->id) }}"><button class="btn btn-primary">Ubah</button></a>
                @endif

            </div>
            <div class="col-lg-8 col-md-4 col-sm-4 col-xs-12">
              <p>
                <b>Nama</b> : {{ $data->name }} <hr>
                <b>Merk/Type</b> : {{ $data->type }} <hr>
                <b>Spesifikasi</b> : {{ $data->spesification }} <hr>
                <b>Deskripsi</b> : {{ $data->description }} <hr>
                <b>Kategori</b> : 
                    @if($data->category == 1) ASSET @endif
                    @if($data->category == 0) NON-ASSET @endif
                <hr>
                <b>Di Buat</b> : {{ $data->created_at }} <hr>
                <b>Di Perbaharui</b> : {{ $data->updated_at }} <br>
              </p>
            </div>

          </div>
        </div>

        </div>
      </div>
    </div>
  <!-- #END# Basic Table -->

  <!-- Basic Table -->
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            Detail Satuan Barang
          </h2>
          <ul class="header-dropdown m-r--5">
            <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">more_vert</i>
              </a>
              <ul class="dropdown-menu pull-right">
                @if(\Laratrust::can("update-assets"))
                <li><a href="{{ route('assets.create') }}">Tambah</a></li>
                <li><a href="?barcode=true">Cetak Barcode</a></li>
                @endif
              </ul>
            </li>
          </ul>
        </div>

        <div class="body">
            <table class="table" id="satuanTable" style="text-align: center">
              <thead>
                <th style="text-align: center">#</th>
                <th style="text-align: center">Serial/Kode</th>
                <th style="text-align: center">No. PO</th>
                <th style="text-align: center">No. BST</th>
                <th style="text-align: center">Sumber Dana</th>
                <th style="text-align: center">Harga</th>
                <th style="text-align: center">Tahun</th>
                <th style="text-align: center">Kondisi</th>
                <th style="text-align: center">Status</th>
                @if(\Laratrust::can("update-assets") || \Laratrust::can("delete-assets"))
                <th style="text-align: center">Action</th>
                @endif
              </thead>
              <tbody>
              @foreach($detail as $v)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $v->serial }}</td>
                  <td>{{ $v->no_po }}</td>
                  <td>{{ $v->no_bst }}</td>
                  <td>{{ $v->sourcefund }}</td>
                  <td>Rp. {{ number_format($v->price,0,",",".") }}</td>
                  <td>{{ $v->year }}</td>
                  <td>
                    @if($v->condition == 0) Baik @endif
                    @if($v->condition == 1) Rusak Ringan @endif
                    @if($v->condition == 2) Rusak Berat @endif
                  </td>
                  <td>
                    @if($v->user_id) Di Pinjam
                    @elseif($v->room_id) <a href="{{ route('rooms.show',$v->room_id) }}">Teralokasi</a>
                    @else Belum Dialokasi
                    @endif
                  </td>
                  @if(\Laratrust::can("update-assets") || \Laratrust::can("delete-assets"))
                  <td>

                    <a href="{{ route('assetdetails.show',$v->id) }}"><button class="btn btn-primary btn-sm">Barcode</button></a>

                    @if(!$v->user_id && \Laratrust::can("update-assets"))
                    <a href="{{ route('assetdetails.edit',$v->id) }}"><button class="btn btn-primary btn-sm">Edit</button></a>
                    @else
                      @if(\Laratrust::can("update-assets"))
                      <button class="btn btn-warning btn-sm" onclick="returnData({{ $v->id }})">Konfirmasi Pengembalian</button>
                      @endif
                    @endif

                    @if(!$v->room_id && \Laratrust::can("update-assets"))
                    <button class="btn btn-success btn-sm" onclick="alocation({{ $v->id }})">Alokasi</button>
                    @endif

                    @if(!$v->user_id && !$v->room_id && \Laratrust::can("delete-assets"))
                    <button onclick="deleteData({{ $v->id }})" class="btn btn-danger btn-sm">Hapus</button>
                    @endif
                  </td>
                  @endif
                </tr>
              @endforeach
              </tbody>
            </table>

            <div id="editMode" style="display:none;">
              <div id="data" style="width: 100%; height: 40vh; overflow: hidden;"></div>
              <div align="right">
                <button id="saveButton" class="btn btn-primary" onclick="saveData()">Simpan</button>
              </div>
            </div>


        </div>

      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Alokasi Barang</h4>
        </div>
        <div class="modal-body">
          <h4 align="center">Pilih Ruangan</h4>
          <div class="form-group form-float">
            <div class="form-line">
              {!! Form::select('room_id', App\Room::pluck('name','id'), null, ['id'=>'room_id','class' => 'form-control', 'placeholder'=>'Pilih Type Barang','data-live-search'=>'true' ] ) !!}
            </div>
          </div>
          <button class="btn btn-primary" onclick="alocationAjax()">Konfirmasi Alokasi</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- End Modal -->

</div>

@endsection

@section('css')

<!-- handsontable Css -->
<link href="{{ asset('plugins') }}/handsontable/handsontable.full.min.css" rel="stylesheet" />

<!-- Sweetalert Css -->
<link href="{{ asset('plugins') }}/sweetalert/sweetalert.css" rel="stylesheet" />

<link href="{{ asset('plugins') }}/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

@endsection

@section('js')

  <!-- HandsonTable Plugin Js -->
  <script src="{{ asset('plugins') }}/handsontable/handsontable.full.min.js"></script>

  <!-- SweetAlert Plugin Js -->
  <script src="{{ asset('plugins') }}/sweetalert/sweetalert.min.js"></script>

<script>

    var indexPath = '{{ route("assetdetails.index") }}';
    var deletePath = '{{ route("assetdetails.destroy",'') }}';
    var updatePath = '{{ route("assetdetails.update",'') }}';

    @if(\Laratrust::can("delete-assets"))
    function deleteData(id) {
      swal({
          title: "Apakah Anda Yakin ?",
          text: "Data akan Hilang Setelah Di Hapus!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Hapus!",
          closeOnConfirm: false
      }, function() {
          sendAjax();
      } );

      function sendAjax() {
        $.ajax({
          url: deletePath+'/'+id,
          data: { '_token': '{{ csrf_token() }}' },
          type: 'DELETE',
          error: function() {
            alert('error');
          },
          success: function(res) {
            swal({
              title: "Berhasil Di Hapus!",
              text: "Data Telah Berhasil Di Hapus",
              type: "success"
            }, function() {
              location.reload();
            });
          }
        }); 
      }
    }
    @endif

    @if(\Laratrust::can("update-assets"))
    function returnData(id) {
      swal({
          title: "Apakah Anda Yakin ?",
          text: "Sebelum Konfirmasi Pastikan, Barang yang di kembalikan dalam kondisi baik!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Barang Dalam Kondisi Baik!",
          closeOnConfirm: false
      }, function() {
          sendAjax();
      } );

      function sendAjax() {
        $.ajax({
          url: updatePath+'/'+id,
          data: { '_token': '{{ csrf_token() }}', 'user_id' : null },
          type: 'PUT',
          error: function() {
            alert('error');
          },
          success: function(res) {
            swal({
              title: "Konfirmasi Pengembalian Barang Berhasil !",
              text: "Barang Telah Berhasil Di Kembalikan",
              type: "success"
            }, function() {
              location.reload();
            });
          }
        }); 
      }
    }

    var selectedID = 0;
    function alocation(id) {
      $('#myModal').modal();
      selectedID = id;
    }
    function alocationAjax() {
      $.ajax({
        url: updatePath+'/'+selectedID,
        data: { '_token': '{{ csrf_token() }}', 'room_id' : document.getElementById('room_id').value },
        type: 'PUT',
        error: function() {
          alert('error');
        },
        success: function(res) {
          swal({
            title: "Alokasi Barang Berhasil !",
            text: "Barang Telah Berhasil Di Alokasi",
            type: "success"
          }, function() {
            location.reload();
          });
        }
      });
    }
    @endif

</script>
@endsection

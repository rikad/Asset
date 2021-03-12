@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="block-header">
    <h2>Perencanaan Barang</h2>
  </div>

  <!-- Basic Table -->
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header bg-blue-grey">
          <h2>
            Tabel Perencanaan
          </h2>
          <ul class="header-dropdown m-r--5">
            <li class="dropdown">
              <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">more_vert</i>
              </a>
              <ul class="dropdown-menu pull-right">
                <li><a href="#" onclick="saveData()">Simpan Perencanaan</a></li>
                <li><a href="#"  onclick="listChanged()">List Perubahan</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs tab-nav-right" role="tablist">
          <li role="presentation" class="active"><a href="#barang" data-toggle="tab">Perencanaan Barang</a></li>
          <li role="presentation"><a href="#jasa" data-toggle="tab">Perencanaan Jasa</a></li>
          <li role="presentation"><a href="#" onclick="listChanged()" data-toggle="tab">List Perubahan</a></li>
          <li role="presentation"><a href="#" onclick="saveData()" data-toggle="tab">Simpan</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade in active" id="barang">  
              <div id="data" style="width: 100%; height: 70vh; overflow: hidden;"></div>
          </div>
          <div role="tabpanel" class="tab-pane fade in active" id="jasa">  
              <div id="data2" style="width: 100%; height: 70vh; overflow: hidden;"></div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- #END# Basic Table -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">List Perubahan Perencanaan</h4>
        </div>
        <div class="modal-body">
          <table class="table" id="konten">
            <thead>
              <th>No</th>
              <th>Tanggal</th>
              <th>Action</th>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

</div>

@endsection


@section('css')
<!-- JQuery DataTable Css -->
<link href="{{ asset('plugins') }}/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- Sweetalert Css -->
<link href="{{ asset('plugins') }}/sweetalert/sweetalert.css" rel="stylesheet" />

<!-- handsontable Css -->
<link href="{{ asset('plugins') }}/handsontable/handsontable.min.css" rel="stylesheet" />
@endsection

@section('js')

<!-- Jquery DataTable Plugin Js -->
<script src="{{ asset('plugins') }}/jquery-datatable/jquery.dataTables.js"></script>
<script src="{{ asset('plugins') }}/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>

<!-- SweetAlert Plugin Js -->
<script src="{{ asset('plugins') }}/sweetalert/sweetalert.min.js"></script>

<!-- HandsonTable Plugin Js -->
<script src="{{ asset('plugins') }}/handsontable/handsontable.min.js"></script>

<script>

  var showPath = '{{ route("plans.show",'') }}';
  var updatePath = '{{ route("plans.update",'') }}';
  var savePath = '{{ route("plans.store") }}';
  var editPath = '{{ route("plans.edit",'=') }}';
  var deletePath =  '{{ route("plans.destroy",'') }}';
  var addPath =  '{{ route("plans.create") }}';

@if(isset($barang))
  var data = {!! $barang !!};

  if(data[0].length != 11) {
    while(data[0].length != 11) {
      data[0].push('');
    }
  }

@else
  var data = [
      ['','','','','','','','','','',''],
      ['','','','','','','','','','','']
    ];
@endif

@if(isset($jasa))
  var data2 = {!! $jasa !!};

  if(data2[0].length != 10) {
    while(data2[0].length != 10) {
      data2[0].push('');
    }
  }

@else

  var data2 = [
      ['','','','','','','','','',''],
      ['','','','','','','','','','']
    ];

@endif

  var container = document.getElementById('data');
  var container2 = document.getElementById('data2');

  var hot = new Handsontable(container, {

    data: data,
    rowHeaders: true,
    colHeaders: true,
    colWidths: [80, 80, 160, 80, 80, 80, 80, 80, 80, 80, 80],
    manualColumnResize: true,
    manualRowResize: true,
    minSpareRows: 1,
    stretchH: 'all',
    persistentState: true,
    contextMenu: true,
    colHeaders: [
      'Nama Barang',
      'Merk/type',
      'Spesifikasi',
      'Jumlah',
      'Harga Satuan',
      'Vendor',
      'Prioritas',
      'Kategori',
      'Usulan',
      'Tahun',
      'Keterangan'
    ]
  });

  var hot2 = new Handsontable(container2, {

    data: data2,
    rowHeaders: true,
    colHeaders: true,
    colWidths: [80, 80, 160, 80, 80, 80, 80, 80, 80, 80, 80],
    manualColumnResize: true,
    manualRowResize: true,
    minSpareRows: 1,
    stretchH: 'all',
    persistentState: true,
    contextMenu: true,
    colHeaders: [
      'Nama Jasa',
      'type',
      'Deskripsi',
      'Biaya',
      'Vendor',
      'Prioritas',
      'Kategori',
      'Usulan',
      'Tahun',
      'Keterangan'
    ]
  });

  function listChanged() {

    function genEditPath(id) {
      return editPath.replace('=',id);
    }

    $('#myModal').modal();

    $('#konten').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('plans.index') !!}',
      columns: [
      { data: 'no', name: 'no' },
      { data: 'created_at', name: 'created_at' },
      { data: 'id', name: 'id', sortable: false,render: function(data) {
        return '<button onclick="showData('+data+')"class="btn btn-success btn-sm">Lihat</button> <button onclick="deleteData('+data+')" class="btn btn-danger">Hapus</button>';
      }},
      ],
      dom: 'tip',
     responsive: true,
    });
  }

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

  function saveData() {
    $.ajax({
      url: savePath,
      data: { '_token': '{{ csrf_token() }}','barang' : hot.getData(), 'jasa' : hot2.getData() },
      type: 'POST',
      error: function(res) {
        alert('ERROR : ' +res.responseJSON.message);
      },
      success: function(res) {
            swal({
              title: "Berhasil Di Simpan!",
              text: "Data Telah Berhasil Di Simpan",
              type: "success"
            }, function() {
              location.reload();
            });
      }
    }); 
  }

  function showData(id) {
    $.ajax({
      url: showPath+'/'+id,
      type: 'GET',
      error: function(res) {
        alert('ERROR : ' +res.responseJSON.message);
      },
      success: function(res) {
        var data = JSON.parse(res.data);
        hot.loadData(data.barang);
        hot2.loadData(data.jasa);
        $('#myModal').modal('hide');
      }
    }); 
  }

  setTimeout(function(){
    var jasa = document.getElementById('jasa')
    jasa.classList.remove('in');
    jasa.classList.remove('active');      
  }, 1000);

</script>
@endsection

@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="block-header">
    <h2>Manajemen Barang</h2>
  </div>

  <!-- Horizontal Layout -->
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            Edit Satuan Barang
          </h2>
        </div>
        <div class="body">

              {!! Form::model($data, ['url' => route('assetdetails.update', $data->id), 'files'=>true,'method'=>'put','class'=>'form-horizontal']) !!}

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="serial">Serial/Kode</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('serial') ? ' error' : '' }}">
                    {!! Form::number('serial', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('serial'))
                      <label class="error" for="serial">
                          {{ $errors->first('serial') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="no_po">No. PO</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('no_po') ? ' error' : '' }}">
                    {!! Form::number('no_po', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('no_po'))
                      <label class="error" for="no_po">
                          {{ $errors->first('no_po') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="no_bst">No. BST</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('no_bst') ? ' error' : '' }}">
                    {!! Form::number('no_bst', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('no_bst'))
                      <label class="error" for="no_bst">
                          {{ $errors->first('no_bst') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="sourcefund">Sumber Dana</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('sourcefund') ? ' error' : '' }}">
                    {!! Form::text('sourcefund', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('sourcefund'))
                      <label class="error" for="sourcefund">
                          {{ $errors->first('sourcefund') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="price">Harga (*)</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('price') ? ' error' : '' }}">
                    {!! Form::text('price', null, ['class'=>'form-control priceField']) !!}
                  </div>
                  @if ($errors->has('price'))
                      <label class="error" for="price">
                          {{ $errors->first('price') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="year">Tahun</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('year') ? ' error' : '' }}">
                    {!! Form::number('year', null, ['class'=>'form-control','maxlength'=>4]) !!}
                  </div>
                  @if ($errors->has('year'))
                      <label class="error" for="year">
                          {{ $errors->first('year') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="condition">Kondisi</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('condition') ? ' error' : '' }}">
                    {!! Form::select('condition', ['0'=> 'Baik','1'=>'Rusak Ringan','2'=>'Rusak Berat'], null, ['class' => 'form-control show-tick', 'placeholder'=>'Pilih Kondisi'] ) !!}
                  </div>
                  @if ($errors->has('condition'))
                      <label class="error" for="condition">
                          {{ $errors->first('condition') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="Simpan">
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- #END# Horizontal Layout -->

</div>
@endsection

@section('css')
<link href="{{ asset('plugins') }}/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">
@endsection

@section('js')
<script src="{{ asset('plugins') }}/jquery-inputmask/jquery.inputmask.bundle.js"></script>
<script>

  $(".priceField").inputmask('decimal', {
                'alias': 'numeric',
                'groupSeparator': '.',
                'autoGroup': true,
                'digits': 0,
                'radixPoint': ",",
                'digitsOptional': false,
                'allowMinus': false,
                'prefix': '',
                'placeholder': ''
    });

</script>
@endsection

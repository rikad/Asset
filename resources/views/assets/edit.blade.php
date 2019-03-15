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
            Tambah Ruangan
          </h2>
        </div>
        <div class="body">

              {!! Form::model($data, ['url' => route('assets.update', $data->id), 'files'=>true,'method'=>'put','class'=>'form-horizontal']) !!}

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="name">Name</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('name') ? ' error' : '' }}">
                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('name'))
                      <label class="error" for="name">
                          {{ $errors->first('name') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="image">Gambar</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('image') ? ' error' : '' }}">
                    {!! Form::file('image', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($data->image)
                    <label class="error" for="image">
                      <img class="img-responsive thumbnail" src="{{ asset('images/assets/'.$data->image) }}" alt="{{ $data->name }}" width="20%">
                    </label>
                  @endif
                  @if ($errors->has('image'))
                      <label class="error" for="image">
                          {{ $errors->first('image') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="type">Merk/Type</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('type') ? ' error' : '' }}">
                    {!! Form::text('type', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('type'))
                      <label class="error" for="type">
                          {{ $errors->first('type') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="spesification">Spesifikasi</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('spesification') ? ' error' : '' }}">
                    {!! Form::textarea('spesification', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('spesification'))
                      <label class="error" for="spesification">
                          {{ $errors->first('spesification') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="description">Description</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('description') ? ' error' : '' }}">
                    {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('description'))
                      <label class="error" for="description">
                          {{ $errors->first('description') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="category">Kategori</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('category') ? ' error' : '' }}">
                    {!! Form::select('category', ['1'=> 'ASSET','0'=>'NON-ASSET'], null, ['class' => 'form-control show-tick', 'placeholder'=>'Pilih Kategori'] ) !!}
                  </div>
                  @if ($errors->has('category'))
                      <label class="error" for="category">
                          {{ $errors->first('category') }}
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

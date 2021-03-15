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
            Managemen Ruangan
          </h2>
        </div>
        <div class="body">

            @if(isset($data))
              {!! Form::model($data, ['url' => route('rooms.update', $data->id), 'files'=>true,'method'=>'put','class'=>'form-horizontal']) !!}
            @else
              {!! Form::open(['url' => route('rooms.store'), 'method' => 'post','files'=>true, 'class'=>'form-horizontal']) !!}
            @endif

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
                <label for="code">Kode ITB</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('code') ? ' error' : '' }}">
                    {!! Form::text('code', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('code'))
                      <label class="error" for="code">
                          {{ $errors->first('code') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="code2">Kode Prodi</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('code2') ? ' error' : '' }}">
                    {!! Form::text('code2', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('code2'))
                      <label class="error" for="code2">
                          {{ $errors->first('code2') }}
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
                <label for="user_id">Penanggung Jawab</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('user_id') ? ' error' : '' }}">
                    {!! Form::select('user_id', App\User::join('role_user','role_user.user_id','users.id')->join('roles','role_user.role_id','roles.id')->where('roles.name','Karyawan')->pluck('users.name','users.id')->all(), null, ['class' => 'form-control show-tick', 'placeholder'=>'Pilih Penanggung Jawab'] ) !!}
                  </div>
                  @if ($errors->has('user_id'))
                      <label class="error" for="user_id">
                          {{ $errors->first('user_id') }}
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

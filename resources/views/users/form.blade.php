@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="block-header">
    <h2>Manajemen Pengguna</h2>
  </div>

  <!-- Horizontal Layout -->
  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            @if(isset($data))
            Edit Pengguna
            @else
            Tambah Pengguna
            @endif

          </h2>
        </div>
        <div class="body">

            @if(isset($data))
              {!! Form::model($data, ['url' => route('users.update', $data->id), 'files'=>true,'method'=>'put','class'=>'form-horizontal']) !!}
            @else
              {!! Form::open(['url' => route('users.store'), 'method' => 'post','files'=>true, 'class'=>'form-horizontal']) !!}
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
                <label for="username">Username</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('username') ? ' error' : '' }}">
                    {!! Form::text('username', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('username'))
                      <label class="error" for="username">
                          {{ $errors->first('username') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="email">Email</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('email') ? ' error' : '' }}">
                    {!! Form::email('email', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('email'))
                      <label class="error" for="email">
                          {{ $errors->first('email') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="phone">Phone</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('phone') ? ' error' : '' }}">
                    {!! Form::number('phone', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('phone'))
                      <label class="error" for="phone">
                          {{ $errors->first('phone') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>


          @if(isset($data) && $data->role == 4)
          @php
            $desc = json_decode($data->desc); 
          @endphp

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="wali">Wali</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('wali') ? ' error' : '' }}">
                    {!! Form::text('wali', $desc->wali, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('wali'))
                      <label class="error" for="wali">
                          {{ $errors->first('wali') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="pembimbing1">Pembimbing 1</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('pembimbing1') ? ' error' : '' }}">
                    {!! Form::text('pembimbing1', $desc->pembimbing1, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('pembimbing1'))
                      <label class="error" for="pembimbing1">
                          {{ $errors->first('pembimbing1') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="pembimbing2">Pembimbing2</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('pembimbing2') ? ' error' : '' }}">
                    {!! Form::text('pembimbing2', $desc->pembimbing2, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('pembimbing2'))
                      <label class="error" for="pembimbing2">
                          {{ $errors->first('pembimbing2') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="lab">Lab</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('lab') ? ' error' : '' }}">
                    {!! Form::text('lab', $desc->lab, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('lab'))
                      <label class="error" for="lab">
                          {{ $errors->first('lab') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="plab">Penanggung Jawab Lab</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('plab') ? ' error' : '' }}">
                    {!! Form::text('plab', $desc->plab, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('plab'))
                      <label class="error" for="plab">
                          {{ $errors->first('plab') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="wisuda">Wisuda</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('wisuda') ? ' error' : '' }}">
                    {!! Form::text('wisuda', $desc->wisuda, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('wisuda'))
                      <label class="error" for="wisuda">
                          {{ $errors->first('wisuda') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>
          @endif


            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="password">Password</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('password') ? ' error' : '' }}">
                    {!! Form::text('password', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('password'))
                      <label class="error" for="password">
                          {{ $errors->first('password') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="address">Address</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('address') ? ' error' : '' }}">
                    {!! Form::textarea('address', null, ['class'=>'form-control']) !!}
                  </div>
                  @if ($errors->has('address'))
                      <label class="error" for="address">
                          {{ $errors->first('address') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="role">Role</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('role') ? ' error' : '' }}">
                    {!! Form::select('role', App\Role::pluck('display_name','id')->all(), null, ['class' => 'form-control show-tick', 'placeholder'=>'Pilih role'] ) !!}
                  </div>
                  @if ($errors->has('role'))
                      <label class="error" for="role">
                          {{ $errors->first('role') }}
                      </label>
                  @endif
                </div>
              </div>
            </div>

            <div class="row clearfix">
              <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                <label for="is_active">Mode</label>
              </div>
              <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                <div class="form-group">
                  <div class="form-line{{ $errors->has('is_active') ? ' error' : '' }}">
                    {!! Form::select('is_active', ['1'=>'Active','0'=>'Disabled'], null, ['class' => 'form-control'] ) !!}
                  </div>
                  @if ($errors->has('is_active'))
                      <label class="error" for="is_active">
                          {{ $errors->first('is_active') }}
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

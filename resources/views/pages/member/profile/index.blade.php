@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ganti Password</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body" style="background-color: #f5f6fa">
            
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
                                <form action="{{ route('member.profile.savePassword', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="name"><strong>Nama</strong></label>
                                                <input type="text" class="form-control" name="name"  value="{{ $item->name }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="tipe_pelanggan"><strong>Username</strong></label>
                                                <input type="text" class="form-control" name="id_tipe_pelanggan"  value="{{ $item->username }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label for="new-password"><strong>Password Sebelumnya</strong></label>
                    
                                  
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>
                    
                                            @if ($errors->has('current-password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('current-password') }}</strong>
                                                </span>
                                            @endif
                                     
                                    </div>
                    
                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label for="new-password"><strong>Password Baru</strong></label>
                    
                              
                                            <input id="new-password" type="password" class="form-control" name="new-password" required>
                    
                                            @if ($errors->has('new-password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('new-password') }}</strong>
                                                </span>
                                            @endif
                                   
                                    </div>
                    
                                    <div class="form-group">
                                        <label for="new-password-confirm"><strong>Confirm New Password</strong></label>
                    
                                  
                                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                               
                                    </div>
                    
                    
                                    <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Yakin ingin mengubah password?');">
                                        Ubah Password
                                    </button>
                    
                                </form>
        </div>
    </div>

</div>

<!-- /.container-fluid -->
{{-- modal --}}

@endsection
@push('addon-script')



@endpush
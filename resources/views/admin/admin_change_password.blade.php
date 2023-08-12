@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Halaman Ubah Kata Sandi </h4><br><br>
            
                        @if(count($errors))
                            @foreach ($errors->all() as $error)
                                <p class="alert alert-danger alert-dismissible fade show"> {{ $error}} </p>
                            @endforeach
                        @endif

                        <form method="post" action="{{ route('update.password') }}" >
                            @csrf
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Kata Sandi Lama</label>
                                <div class="col-sm-9">
                                    <input name="oldpassword" class="form-control" type="password" id="oldpassword">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Kata Sandi Baru</label>
                                <div class="col-sm-9">
                                <input name="newpassword" class="form-control" type="password"  id="newpassword">
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-3 col-form-label">Konfirmasi Kata Sandi Baru</label>
                                <div class="col-sm-9">
                                    <input name="confirm_password" class="form-control" type="password" id="confirm_password">
                                </div>
                            </div>
                            <!-- end row -->

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Ubah Kata Sandi">
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

@endsection 
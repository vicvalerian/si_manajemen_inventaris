@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Halaman Home Slide </h4>
                            <form method="post" action="{{ route('update.slider') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $homeSlide->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input name="title" class="form-control" type="text"
                                            value="{{ $homeSlide->title }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Subjudul</label>
                                    <div class="col-sm-10">
                                        <input name="short_title" class="form-control" type="text"
                                            value="{{ $homeSlide->short_title }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">URL Video</label>
                                    <div class="col-sm-10">
                                        <input name="video_url" class="form-control" type="text"
                                            value="{{ $homeSlide->video_url }}" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Gambar Slider</label>
                                    <div class="col-sm-10">
                                        <input name="home_slide" class="form-control" type="file" id="image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ !empty($homeSlide->home_slide) ? url($homeSlide->home_slide) : url('storage/upload/no_image.jpg') }}"
                                            alt="Card image cap">
                                    </div>
                                </div>
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Ubah Home Slide">
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>
@endsection

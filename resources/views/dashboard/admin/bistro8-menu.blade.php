@extends('layouts.apps')

@section('content')
@if($checkRole == 0)
<div class="container text-center" id="forbidden">
    <h1>403</h1>
    <p>Forbidden Access!</p>
    <p>Permission Denied</p>
</div>
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#insertMenuModal">
                Insert Menu
            </button>
            <div class="modal fade" id="insertMenuModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="insertMenuModalLabel">Menu Form</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('insert.new.menu')}}" method="post" enctype="multipart/form-data" id="menuForm">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="details" class="form-label">Detail</label>
                                        <input type="text" class="form-control" id="details" name="details">

                                    </div>
                                    <div class="col-md-12">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price">
                                        <span class="text-danger error-text price_error"></span>
                                    </div>

                                    <div class="col-md-12 ">
                                        <label for="menu_image" class="form-label">{{ __('Menu Image') }}</label>
                                        <input type="file" name="menu_image" id="menu_image" class="form-control">
                                        <span class="error-text text-danger menu_image_error">

                                    </div>

                                    <div class="img-holder"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section class="row mb-3" id="allMenu">

        </section>
    </div>
</div>
<div class="modal fade" id="updateMenuModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateMenuModalLabel">Update Menu Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('update.menu')}}" method="post" enctype="multipart/form-data" id="updateMenuForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" class="form-control" id="update_id" name="update_id">

                        <div class="col-md-12">
                            <label for="update_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="update_name" name="update_name">
                            <span class="text-danger error-text update_name_error"></span>
                        </div>
                        <div class="col-md-12">
                            <label for="update_details" class="form-label">Detail</label>
                            <input type="text" class="form-control" id="update_details" name="update_details">

                        </div>
                        <div class="col-md-12">
                            <label for="update_price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="update_price" name="update_price">
                            <span class="text-danger error-text update_price_error"></span>
                        </div>

                        <div class="col-md-12 ">
                            <label for="update_menu_image" class="form-label">{{ __('Menu Image') }}</label>
                            <input type="file" name="update_menu_image" id="update_menu_image" class="form-control">
                            <span class="error-text text-danger update_menu_image_error">

                        </div>

                        <div class="update-img-holder"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var img_holder = $('.img-holder');
    //Reset input file
    $('input[type="file"][name="menu_image"]').val('');
    //Image preview
    $('input[type="file"][name="menu_image"]').on('change', function() {
        var img_path = $(this)[0].value;

        var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

        if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
            if (typeof(FileReader) != 'undefined') {
                img_holder.empty();
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('<img/>', {
                        'src': e.target.result,
                        'class': 'img-fluid',
                        'style': 'max-width:200px;margin-bottom:10px;'
                    }).appendTo(img_holder);
                }
                img_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                $(img_holder).html('This browser does not support FileReader');
            }
        } else {
            $(img_holder).empty();
        }
    });
    fetchAllListMenu();

    function fetchAllListMenu() {
        $.get('{{route("fetch.menu.list")}}', {}, function(data) {
            $('#allMenu').html(data.result);
        }, 'json');
    }
    $('#menuForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to save this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.code == 1) {

                            $(form)[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully!',
                                text: data.msg,
                                timer: 3500
                            })
                            $(img_holder).empty();
                            fetchAllListMenu();


                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss..',
                                text: data.msg,
                                timer: 3500
                            });
                        }
                    }
                })



            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    })
    $(document).on('click', '#deleteBtn', function(e) {
        e.preventDefault();

        const dataID = $(this).data('id');
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to Delete this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.post("{{route('delete.menu')}}", {
                    dataID: dataID
                }, function(data) {
                    if (data.code == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully!',
                            text: data.msg,
                            timer: 3500
                        })
                        fetchAllListMenu();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopss..',
                            text: data.msg,
                            timer: 3500
                        });
                    }
                })




            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    })
    $(document).on('click', '#editBtn', function() {
        $('#updateMenuModal').modal('show');
        const dataID = $(this).data('id');
        $.get("{{route('get.edit.menu')}}", {
            dataID: dataID
        }, function(data) {
            $('#updateMenuModal').find('#update_id').val(dataID);
            $('#updateMenuModal').find('#update_name').val(data.details.name);
            $('#updateMenuModal').find('#update_price').val(data.details.price);
            $('#updateMenuModal').find('.update-img-holder').html('<img src="/images/menu/' + data.details.menu_image + '" class="img-fluid" style="max-width:200px;margin-bottom:10px;">');
            $('#updateMenuModal').find('#pdate_menu_image').attr('data-value', '<img src="/img/clinic-personel/' + data.details.menu_image + '" class="img-fluid" style="max-width:200px;margin-bottom:10px;">');
            $('#updateMenuModal').find('#update_menu_image').find('input[type="file"]').val(data.details.menu_image);
        })
    })
    var img_holder_update = $('.update-img-holder');
    $('input[type="file"][name="update_menu_image"]').on('change', function() {
        var img_path = $(this)[0].value;

        var currentImage = $(this).data('value');

        var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();
        if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
            if (typeof(FileReader) != 'undefined') {
                img_holder_update.empty();
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('<img/>', {
                        'src': e.target.result,
                        'class': 'img-fluid',
                        'style': 'max-width:200px;margin-bottom:10px;'
                    }).appendTo(img_holder_update);
                }
                img_holder_update.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                $(img_holder_update).html('This browser does not support FileReader');
            }
        } else {
            $(img_holder_update).html(currentImage);
        }
    });
    $('#updateMenuForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            icon: 'warning',
            title: 'Are you sure you want to save this record?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {

                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.error-text').text('');
                    },
                    success: function(data) {

                        if (data.code == 0) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.code == 1) {

                            $(form)[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Successfully!',
                                text: data.msg,
                                timer: 3500
                            })
                            $(img_holder_update).empty();
                            fetchAllListMenu();
                            $('#updateMenuModal').modal('hide');


                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oopss..',
                                text: data.msg,
                                timer: 3500
                            });
                        }
                    }
                })



            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        });
    })
</script>
@endif
@endsection
@extends('layouts.global')
@section('title')
All Book
@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/b-1.6.5/r-2.2.6/sc-2.0.3/datatables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/fonts/dropify.ttf">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/fonts/dropify.svg">

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
<script>
    var table = $("#tabel_book").DataTable({
    responsive:true,
    processing: true,
    serverSide: true,
    ajax: "book",
    columns: [{
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            searchable: false,
            orderable: false
        },
        {
            data: "id",
            name: "id"
        },
        {
            data: "image",
            name: "image"
        },
        {
            data: "title",
            name: "title"
        },
        {
            data: "author",
            name: "author"
        },
        {
            data: "publisher",
            name: "publisher"
        },
        {
            data: "category",
            name: "category"
        },
        {
            data: "slug",
            name: "slug"
        },
        {
            data: "synopsis",
            name: "synopsis"
        },
        {
            data: "status",
            name: "status"
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false
        }
    ]
});
    $("#category").select2({
    dropdownParent: $("#modal_dialog"),
    ajax: {
        url: "category/select",
        processResults: function (data) {
            return {
                results: data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    };
                })
            };
        }
    }
});

function deleteForm(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "deleted data cannot be recovered!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#28a745',
        confirmButtonText: 'Ya, Delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: `book/${id}`,
                method: `DELETE`,
                success: function (ress) {
                    if (ress.method === "delete") {
                        notifAlert1('Sukses', 'Data Deleted Successfully', 'success')
                    } else if(ress == 403){
                        notifAlert1('Error', 'Data cannot be deleted, because it is related to other data', 'error')
                    } else if(ress == 404){
                        notifAlert1('Error', 'Data Not Found', 'error')
                    }
                },
                error: function (err) {
                    if(err.status == 404){
                        notifAlert1('Error', 'Data Not Found', 'error')
                    }
                }
            })
        }
    })
}

let input_img = `<input type="file" class="custom-file-input" id="cover" name="cover" data-allowed-file-extensions="png jpg jpeg" data-max-file-size-preview="2M" data-errors-position="outside"/>`
    function addForm(){
    save_method = "add";
    $('input[name="_method"]').val("POST");
    $("#modal_dialog form")[0].reset();
    $(".modal-title").html("Create Book");
    $('#cover').dropify();
    $(".create form")
        .validate()
        .resetForm();
    $(".btn-submit").prop("disabled", false);
    $(".dropify-clear").trigger("click");
    $("#category").val(null).trigger("change");
    $("#modal_dialog").modal("show");
    }

    function editForm(id) {
    save_method = "update"
    update_id = id
    $('input[name="_method"]').val('PATCH');
    $.ajax({
        url: `book/${id}/edit`,
        method: `GET`,
        success: function (data) {
            if(data == 404){
                notifAlert1('Error', 'Data missing', 'error')
            } else {
            $('.modal-title').html('Change Book Data')
            $('#modal_dialog form')[0].reset()
            $('.create form').validate().resetForm()
            $('#id').val(data.id)
            $('#title').val(data.title)
            $('#synopsis').html(data.synopsis)
            $('#author').val(data.author)
            $('#publisher').val(data.publisher)
            $('.gambar').empty().append(input_img)
            $('#cover').attr("data-default-file", `storage/${data.cover}`);
            $('#cover').dropify()
            $("#category").val(null).trigger("change");
            data.categories.forEach(function(category){
            var option = new Option(category.name, category.id, true, true);
            $('#category').append(option).trigger('change');
    });

            $('#modal_dialog').modal('show');
            checkChangeFormData($('.btn-submit'), $('.form_data_book'), $('.form_data_book :input'))
            }
        },
        error: function (xhr, status, error) {
            if(xhr.status == 404){
                notifAlert1('Error', 'Data missing', 'error')
            }
            let all_error = JSON.parse(xhr.responseText)
            $.each(all_error.errors, function (key, error) {
                console.log(key, error)
            })
        }
    })
}

    function checkChangeFormData(button, form, event) {
    button.prop("disabled", true)
    let forms = form.serialize()
    event.on('change input keyup', function () {
        if (forms !== form.serialize()) {
            button.prop("disabled", false)
        } else {
            button.prop("disabled", true)
        }
    });
}

    function notifAlert1(header, pesan, type) {
    Swal.fire(`${header}`, `${pesan}`, `${type}`).then(result => {
        if (result.isConfirmed) {
            table.ajax.reload();
        }
    });
}

    $(function () {
    //validation
    $('.form_data_book').validate({
        rules: {
            id : {
                required : true,
                minlength : 5,
                maxlength: 20,
            },
            title: {
                required: true,
                minlength: 5,
                maxlength: 255,
            },
            synopsis: {
                required : true,
                minlength: 20,
            },
            author: {
                required: true,
                minlength:5,
                maxlength:255,
            },
            publisher: {
                required : true,
                minlength:5,
                maxlength:255,
            },
            cover : {
                required : function(){
                    if (save_method == "add") {
                    return true
                } else {
                    return false
                }
                }
            }
        },
        submitHandler: function (form, event) {
            if (!event.isDefaultPrevented()) {
                let data = new FormData($('.form_data_book')[0])
                if (save_method == "add") {
                    url = "book"
                } else {
                    data.append('book_id',update_id);
                    url = `book/${update_id}`
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (ress) {
                        if (ress.method === "save") {
                            notifAlert1("Success", "Book data has been saved successfully",
                                "success")
                        } else if (ress.method === "update") {
                            notifAlert1("Sukses", "Book data has been successfully updated",
                                "success")
                        }
                        $('#modal_dialog').modal('hide')
                    },
                    error: function (xhr, status, error) {
                        if(xhr.status == 404){
                            notifAlert1('Error', 'Data missing', 'error')
                        }
                        let all_error = JSON.parse(xhr.responseText)
                        $.each(all_error.errors, function (key, error) {
                            $(`#${key}`).parent().append(`
                            <label id = "${key}-error"
                            class = "error"
                            for = "${key}" > ${error} </label>
                            `)
                        })
                    }
                })
                return false;
            }
            return false
        }
    })
    //end validation
})
</script>
@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">CRUD Book</h2>
                <h5 class="text-white op-7 mb-2">Create Read Update Delete Book Data</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                <a href="#" onclick="addForm()" class="btn btn-secondary btn-round">Create Book</a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">All Book Data</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_book" class="display table table-hover nowrap  w-100" cellspacing="0">
                            <thead>
                                <th>No</th>
                                <th>Book Id</th>
                                <th>Cover</th>
                                <th>Tite</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Category</th>
                                <th>Slug</th>
                                <th>Synopsis</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('book.modal')
@endsection

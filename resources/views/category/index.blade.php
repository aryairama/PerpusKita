@extends('layouts.global')
@section('title')
All Category
@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/b-1.6.5/r-2.2.6/sc-2.0.3/datatables.min.css" />
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    var table = $("#tabel_category").DataTable({
    processing: true,
    serverSide: true,
    ajax: "category",
    columns: [{
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            searchable: false,
            orderable: false
        },
        {
            data: "name",
            name: "name"
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false
        }
    ]
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
                url: `category/${id}`,
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

function addForm(){
    save_method = "add";
    $('input[name="_method"]').val("POST");
    $("#modal_dialog form")[0].reset();
    $(".modal-title").html("Create Category Book");
    $(".create form")
        .validate()
        .resetForm();
    $(".btn-submit").prop("disabled", false);
    $("#modal_dialog").modal("show");
    }

    function editForm(id) {
    save_method = "update"
    update_id = id
    $('input[name="_method"]').val('PATCH');
    $.ajax({
        url: `category/${id}/edit`,
        method: `GET`,
        success: function (data) {
            console.log(data);
            if(data == 404){
                notifAlert1('Error', 'Data missing', 'error')
            } else {
            $('.modal-title').html('Ubah Data')
            $('#modal_dialog form')[0].reset()
            $('.create form').validate().resetForm()
            $('#name').val(data.name)
            $('#modal_dialog').modal('show');
            checkChangeFormData($('.btn-submit'), $('.form_data_category'), $('.form_data_category :input'))
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
    $('.form_data_category').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 255,
            }
        },
        submitHandler: function (form, event) {
            if (!event.isDefaultPrevented()) {
                let data = new FormData($('.form_data_category')[0])
                if (save_method == "add") {
                    url = "category"
                } else {
                    data.append('category_id',update_id);
                    url = `category/${update_id}`
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
                        console.log(ress);
                        if (ress.method === "save") {
                            notifAlert1("Success", "Category data has been saved successfully",
                                "success")
                        } else if (ress.method === "update") {
                            notifAlert1("Sukses", "Category data has been successfully updated",
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
                <h2 class="text-white pb-2 fw-bold">CRUD Category Book</h2>
                <h5 class="text-white op-7 mb-2">Create Read Update Delete Category Book Data</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                <a href="#" onclick="addForm()" class="btn btn-secondary btn-round">Create Category</a>
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
                        <div class="card-title">All Category Data</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_category" class="display table table-hover nowrap  w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('category.modal')
@endsection

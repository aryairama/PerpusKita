@extends('layouts.global')
@section('title')
All User
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
    var table = $("#tabel_petugas").DataTable({
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    order : [[ 0, "desc" ]],
    ajax: "/user/listpetugas",
    columns: [{
            data: "DT_RowIndex",
            name: "users.id",
            searchable: false,
            orderable: true
        },
        {
            data: "name",
            name: "name"
        },
        {
            data: "email",
            name: "email"
        },
        {
            data: "address",
            nama: "address"
        },
        {
            data: "phone",
            name: "phone"
        },
        {
            data: "gender",
            nama: "gender"
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false
        }
    ]
});

var table2 = $("#tabel_siswa").DataTable({
    autoWidth: false,
    responsive: true,
    processing: true,
    serverSide: true,
    order : [[ 0, "desc" ]],
    ajax: "/user/listsiswa",
    columns: [{
            data: "DT_RowIndex",
            name: "users.id",
            searchable: false,
            orderable: true
        },
        {
            data: "name",
            name: "name"
        },
        {
            data: "email",
            name: "email"
        },
        {
            data: "address",
            nama: "address"
        },
        {
            data: "phone",
            name: "phone"
        },
        {
            data: "gender",
            nama: "gender"
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false
        }
    ]
});
window.onresize = function() {
    table.columns.adjust().responsive.recalc();
    table2.columns.adjust().responsive.recalc();
}
$('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
    table.columns.adjust().responsive.recalc();
    table2.columns.adjust().responsive.recalc();
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
                url: `user/${id}`,
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
    $('input[name="gender"]').attr('checked',false);
    $('input[name="roles"]').attr('checked',false);
    $(".modal-title").html("Create User");
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
        url: `user/${id}/edit`,
        method: `GET`,
        success: function (data) {
            if(data == 404){
                notifAlert1('Error', 'Data missing', 'error')
            } else {
            $('.modal-title').html('Ubah Data')
            $('#modal_dialog form')[0].reset()
            $('.create form').validate().resetForm()
            $('#name').val(data.name)
            $('#email').val(data.email)
            if(data.roles === "petugas"){
                $('#roles').attr('checked',true);
            } else if(data.roles === "siswa"){
                $('#roles2').attr('checked',true);
            }
            $('#address').val(data.address)
            $('#phone').val(data.phone)
            if(data.gender === "L"){
                $('#gender').attr('checked',true);
            } else if(data.gender === "P"){
                $('#gender2').attr('checked',true);
            }
            $('#modal_dialog').modal('show');
            checkChangeFormData($('.btn-submit'), $('.form_data_user'), $('.form_data_user :input'))
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
            table2.ajax.reload();
        }
    });
}


$(function () {
    //validation
    $('.form_data_user').validate({
        rules: {
            name: {
                required: true,
                minlength: 5,
                maxlength: 255,
            },
            email: {
                required: true,
                email:true,
                maxlength: 255,
            },
            password: {
                required: function(){
                    if(save_method === "update") {
                        return false
                    } else {
                        return true
                    }
                },
                minlength: function(){
                    if(save_method === "update") {
                        return 0
                    } else {
                        return 8
                    }
                },
                maxlength: 255,
            },
            roles: {
                required: true
            },
            address: {
                required: true,
                maxlength: 255,
                minlength:20,
            },
            phone: {
                required: true,
                number:true,
                minlength: 12,
                maxlength: 14
            },
            gender: {
                required: true
            }
        },
        submitHandler: function (form, event) {
            if (!event.isDefaultPrevented()) {
                let data = new FormData($('.form_data_user')[0])
                if (save_method == "add") {
                    url = "user"
                } else {
                    data.append('user_id',update_id);
                    url = `user/${update_id}`
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
                    beforeSend: function () {
                        $(`.btn-user-save`).attr('disabled', true)
                    },
                    success: function (ress) {
                        if (ress.method === "save") {
                            notifAlert1("Success", "User data has been saved successfully",
                                "success")
                        } else if (ress.method === "update") {
                            notifAlert1("Sukses", "User data has been successfully updated",
                                "success")
                        }
                        $('#modal_dialog').modal('hide')
                        $(`.btn-user-save`).attr('disabled', false)
                    },
                    error: function (xhr, status, error) {
                        if(xhr.status == 404){
                            notifAlert1('Error', 'Data missing', 'error')
                        }
                        $(`.btn-user-save`).attr('disabled', false)
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
                <h2 class="text-white pb-2 fw-bold">CRUD User</h2>
                <h5 class="text-white op-7 mb-2">Create Read Update Delete User Data</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="#" class="btn btn-white btn-border btn-round mr-2">Manage</a>
                <a href="#" onclick="addForm()" class="btn btn-secondary btn-round">Create User</a>
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
                        <div class="card-title">All User Data</div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab-nobd" data-toggle="pill" href="#roles_petugas"
                                role="tab" aria-controls="roles_petugas" aria-selected="true">Petugas</a>
                        </li>
                        <li class="nav-item jos">
                            <a class="nav-link" id="pills-profile-tab-nobd" data-toggle="pill" href="#roles_user"
                                role="tab" aria-controls="roles_user" aria-selected="false">Siswa</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                        <div class="tab-pane fade show active" id="roles_petugas" role="tabpanel"
                            aria-labelledby="pills-home-tab-nobd">
                            <div class="table-responsive">
                                <table id="tabel_petugas" class="display table table-hover nowrap  w-100"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Lengkap</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>No.Hp</th>
                                            <th>Gender</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade show " id="roles_user" role="tabpanel"
                            aria-labelledby="pills-home-tab-nobd">
                            <div class="table-responsive">
                                <table id="tabel_siswa" class="display table table-hover nowrap  w-100" cellspacing="0">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>No.Hp</th>
                                        <th>Gender</th>
                                        <th>Action</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('user.modal')
@endsection

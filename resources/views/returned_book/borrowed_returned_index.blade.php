@extends('layouts.global')
@section('title')
Borrow & Return Books
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
    var table = $("#tabel_borrow_return").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: "/returns/borrows/book",
    order : [[ 0, "desc" ]],
    columns: [{
            data: "DT_RowIndex",
            name: "returned_books.id",
            searchable: false,
            orderable: true
        },
        {
            data: "users.name",
            name: "users.name",
            orderable: false
        },
        {
            data: "books.id",
            name: "books.id",
            orderable: false
        },
        {
            data: "books.title",
            name: "books.title",
            orderable: false
        },
        {
            data: "status_return",
            name: "status_return",
        },
        {
            data: "borrows.borrow_date",
            name: "borrows.borrow_date",
            orderable: false
        },
        {
            data: "return_date",
            name: "return_date",
            orderable: false
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false
        }
    ]
});

function returnForm(id){
    Swal.fire({
        title: 'Want to return this book?',
        text: "Wait for the book returns to be verified!",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Return!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            let data = new FormData();
            data.append('_method', 'PATCH')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: `/returns/${id}`,
                method: `POST`,
                data: data,
                processData: false,
                contentType: false,
                success: function (ress) {
                    if (ress.method === "save") {
                        notifAlert1('Sukses', 'Data has been saved successfully', 'success')
                    } else if (ress == 404) {
                        notifAlert1('Error', 'Data Not Found', 'error')
                    }
                },
                error: function (err) {
                    if (err.status == 404) {
                        notifAlert1('Error', 'Data Not Found', 'error')
                    } else if (err.status == 403) {
                        notifAlert1('Info', err.responseText, 'info')
                    }
                }
            })
        }
    })
}

function verifReturnForm(id){
    $('.modal-title').html('Status Return Book')
    $('input[name="_method"]').val("POST");
    $("#modal_dialog form")[0].reset();
    $("#modal_dialog").modal("show");
    $('.btn-user-status').attr('disabled',true)
    $('#status_return').on('change',function(){
        if($('#status_return').val() === ""){
            $('.btn-user-status').attr('disabled',true)
        } else {
            $('.btn-user-status').attr('disabled',false)
        }
    })
    $('.btn-user-status').on('click',function(e){
        e.preventDefault()
        let data = new FormData();
        data.append('status_return',$('#status_return').val())
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                url: `/returns/verifreturn/${id}`,
                method: `POST`,
                data: data,
                processData: false,
                contentType: false,
                success: function (ress) {
                    if (ress.method === "save") {
                        notifAlert1('Sukses', 'Data has been saved successfully', 'success')
                    } else if (ress == 404) {
                        notifAlert1('Error', 'Data Not Found', 'error')
                    }
                    $("#modal_dialog").modal("hide");
                },
                error: function (err) {
                    if (err.status == 404) {
                        notifAlert1('Error', 'Data Not Found', 'error')
                    } else if (err.status == 403) {
                        notifAlert1('Info', err.responseText, 'info')
                    }
                    $("#modal_dialog").modal("hide");
                }
            })
    })
}

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
                url: `/returns/${id}`,
                method: `DELETE`,
                success: function (ress) {
                    if (ress.method === "delete") {
                        notifAlert1('Sukses', 'Data Deleted Successfully', 'success')
                    } else if(ress == 403){
                        notifAlert1('Error', 'Data cannot be deleted, because the borrowed book is lost / damaged', 'error')
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

function notifAlert1(header, pesan, type) {
    Swal.fire(`${header}`, `${pesan}`, `${type}`).then(result => {
        if (result.isConfirmed) {
            table.ajax.reload()
        }
    });
}

window.onresize = function() {
    table.columns.adjust().responsive.recalc();
}
</script>
@endsection
@section('borrow1')
active
@endsection
@section('borrow2')
show
@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Borrow & Return Book List</h2>
                <h5 class="text-white op-7 mb-2">To verify book returns, book loans and book returns.</h5>
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
                        <div class="card-title">All Borrow & Return Book</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_borrow_return" class="display table table-hover wrap  w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Book ID</th>
                                    <th>Book</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                    <th class="none">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('returned_book.modal')
@endsection

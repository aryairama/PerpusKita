@extends('layouts.global')
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
    var table = $("#tabel_borrow").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    order : [[ 4, "desc" ]],
    ajax: "/borrows/bookslist",
    columns: [{
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            searchable: false,
            orderable: false
        },
        {
            data: "users.name",
            name: "users.name"
        },
        {
            data: "books.id",
            name: "books.id"
        },
        {
            data: "books.title",
            name: "books.title"
        },
        {
            data: "borrow_date",
            name: "borrow_date"
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
}
</script>
@endsection
@section('title')
    All Borrow Books
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
                <h2 class="text-white pb-2 fw-bold">Borrow Book List</h2>
                <h5 class="text-white op-7 mb-2">Read Update Delete Borrow Book List Data</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="{{ route('borrows.index') }}" class="btn btn-secondary btn-round">Create Borrow Book</a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head">
                        <div class="card-title">All Borrow Book List</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_borrow" class="display table table-hover nowrap  w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="all">No</th>
                                    <th class="all">User</th>
                                    <th class="all">Book Id</th>
                                    <th>Book</th>
                                    <th>Date</th>
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
@endsection

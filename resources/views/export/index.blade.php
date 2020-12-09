@extends('layouts.global')
@section('title')
Export Excel
@endsection
@section('css')

@endsection
@section('js')

@endsection
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Export Excel</h2>
                <h5 class="text-white op-7 mb-2">Export loan recap and book repayment</h5>
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
                        <div class="card-title">Export Excel Borrow & Return Book</div>
                        <div class="card-tools">
                            @if (session('status_export_all'))
                            <span class="badge badge-danger">{{ session('status_export_all') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('export.excel.borrowreturn') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("POST")
                        <div class="form-group">
                            <label for="all_rekap">Export All Borrow & Return Book</label>
                            <select class="form-control w-50" id="all_rekap" name="all_rekap" disabled>
                                <option>===================</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Export" class="btn btn-primary btn-rounded">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

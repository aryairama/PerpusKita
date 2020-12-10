@extends('layouts.global')
@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                <h5 class="text-white op-7 mb-2">Welcome {{ \Auth::user()->name }}</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                @can('rolePetugas')
                <a href="{{ route('returns.borrows.book') }}" class="btn btn-white btn-border btn-round mr-2">Manage
                    Borrow & Return Book</a>
                @endcan
                @can('roleSiswa')
                <a href="{{ route('borrows.index') }}" class="btn btn-white btn-border btn-round mr-2">Borrow Book</a>
                @endcan
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    @can('rolePetugasSiswa')
    <div class="row row-card-no-pd">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                @can('roleSiswa')
                                <i class="fas fa-book-reader text-success"></i>
                                @elsecan('rolePetugas')
                                <i class="fas flaticon-users text-warning"></i>
                                @endcan
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">
                                    @can('roleSiswa')
                                    Book Borrowing
                                    @elsecan('rolePetugas')
                                    Total Users
                                    @endcan
                                </p>
                                <h4 class="card-title">
                                    @can('roleSiswa')
                                    {{ $borrow }}
                                    @elsecan('rolePetugas')
                                    {{ $users }}
                                    @endcan
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                @can('roleSiswa')
                                <i class="fas fa-book-medical text-primary"></i>
                                @elsecan('rolePetugas')
                                <i class="fas fa-book-open text-success"></i>
                                @endcan
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">
                                    @can('roleSiswa')
                                    Book Return
                                    @elsecan('rolePetugas')
                                    Total Book
                                    @endcan
                                </p>
                                <h4 class="card-title">
                                    @can('roleSiswa')
                                    {{ $return }}
                                    @elsecan('rolePetugas')
                                    {{ $books }}
                                    @endcan
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                @can('roleSiswa')
                                <i class="fas fa-window-close text-warning"></i>
                                @elsecan('rolePetugas')
                                <i class="fas fa-book-reader text-danger"></i>
                                @endcan
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">
                                    @can('roleSiswa')
                                    Book Gone
                                    @elsecan('rolePetugas')
                                    Total Borrowing
                                    @endcan
                                </p>
                                <h4 class="card-title">
                                    @can('roleSiswa')
                                    {{ $gone }}
                                    @elsecan('rolePetugas')
                                    {{ $borrows }}
                                    @endcan
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                @can('roleSiswa')
                                <i class="fas fa-book-dead text-danger"></i>
                                @elsecan('rolePetugas')
                                <i class="fas fa-book-medical text-primary"></i>
                                @endcan
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">
                                    @can('roleSiswa')
                                    Book Broken
                                    @elsecan('rolePetugas')
                                    Total Return
                                    @endcan
                                </p>
                                <h4 class="card-title">
                                    @can('roleSiswa')
                                    {{ $broken }}
                                    @elsecan('rolePetugas')
                                    {{ $returns }}
                                    @endcan
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('rolePetugas')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Student book loan statistics</div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        {!! $chartPinjam->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">
                            @can('roleSiswa')
                            All Borrow Book
                            @elsecan('rolePetugas')
                            All book returns verification
                            @endcan
                        </div>
                        <div class="card-tools">
                            @can('roleSiswa')
                            <a href="{{ route('returns.borrows.book') }}"
                                class="btn btn-rounded btn-primary btn-sm">Return Book</a>
                            @elsecan('rolePetugas')
                            <a href="{{ route('returns.borrows.book') }}"
                                class="btn btn-rounded btn-primary btn-sm">Book return verification</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @can('roleSiswa')
                    <div class="table-responsive">
                        <table id="dashboard_siswa" class="display table table-hover wrap  w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Book ID</th>
                                    <th>Book</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @elsecan('rolePetugas')
                    <div class="table-responsive">
                        <table id="dashboard_petugas" class="display table table-hover wrap  w-100" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Book ID</th>
                                    <th>Book</th>
                                    <th>Status</th>
                                    <th>Borrow Date</th>
                                    <th>Return Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@include('returned_book.modal')
@endsection
@section('js')
@can('roleSiswa')
<script src="{{ asset('js/siswa.js') }}"></script>
@elsecan('rolePetugas')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
    integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"
    integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA=="
    crossorigin="anonymous"></script>

<script src="{{ asset('js/petugas.js') }}"></script>
@endcan
@endsection
@section('css')
<link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.22/b-1.6.5/r-2.2.6/sc-2.0.3/datatables.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"
    integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
    crossorigin="anonymous" />
@endsection

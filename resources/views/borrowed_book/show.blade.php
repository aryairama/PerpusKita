@extends('layouts.global')
@section('title')
Detail Book {{ $show_book->title }}
@endsection
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('js')
<script src="{{ asset('js/borrow.js') }}"></script>
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
                <h2 class="text-white pb-2 ">Detail Book "{{ $show_book->title }}"</h2>
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
                        <div class="card-tools">
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-rounded btn-primary">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="img text-center">
                                <img src="/storage/{{ $show_book->cover }}" alt="" class=" img-fluid ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered border">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="font-weight-bold">Title</td>
                                            <td>{{ $show_book->title }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Slug</td>
                                            <td>{{ $show_book->slug }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Author</td>
                                            <td>{{ $show_book->author }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Publisher</td>
                                            <td>{{ $show_book->publisher }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Status Buku</td>
                                            <td>{{ $show_book->status }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Synopsis</td>
                                            <td>{{ $show_book->synopsis }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button onclick="borrow_book('{{ $show_book->id }}')"
                                class="btn btn-sm btn-rounded btn-primary {{ $show_book->id }}">Select
                                Book</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Related books
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($random_book as $book)
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3 card-group">
                            <div class="card shadow rounded">
                                <img src="{{ asset('storage/'.$book->cover) }}" alt="" class="card-img-top">
                                <div class="card-body">
                                    <h4 class="card-title text-truncate font-weight-bolder">
                                        {{ $book->title }}
                                    </h4>
                                    <h6 class="card-subtitle text-truncate mt-1">
                                        Category :
                                        @foreach ($book->categories as $category)
                                        {{ $category->name }},
                                        @endforeach
                                    </h6>
                                </div>
                                <div class="card-footer pt-0 align-self-center text-center">
                                    <button onclick="borrow_book('{{ $book->id }}')"
                                        class="btn btn-sm btn-rounded btn-outline-primary mt-2 {{ $book->id }}">Select
                                        Book</button>
                                    <a href="{{ route('borrows.show',[$book->id]) }}" class="btn btn-sm btn-rounded btn-outline-secondary mt-2">Detail Book</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

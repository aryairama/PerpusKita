@extends('layouts.global')
@section('title')
Borrowed Book
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
    <div class="row page-inner py-5">
        <div class="col-md-8">
            <form action="{{ route('borrows.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control w-50 form-control-sm" placeholder="Search Book"
                        name="search_book" value="{{ Request::get('search_book') }}">
                    <select class="custom-select w-25" id="inputGroupSelect02" name="category">
                        <option value="" selected>Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <input type="submit" value="Search" class="btn btn-primary btn-sm">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        @if (Request::get('search_book'))
                        search results for "{{ Request::get('search_book') }}"
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($all_book as $book)
                        <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3 card-group">
                            <div class="card shadow rounded">
                                <img src="storage/{{ $book->cover }}" alt="" class="card-img-top" height="240px"
                                    width="180px">
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
                                    <h6 class="card-subtitle text-truncate mt-1">
                                        Status : @if ($book->status == "ada")
                                        <span class="badge badge-success">{{ $book->status }}</span>
                                        @elseif($book->status == "pinjam")
                                        <span class="badge badge-primary">{{ $book->status }}</span>
                                        @elseif($book->status == "rusak")
                                        <span class="badge badge-warning">{{ $book->status }}</span>
                                        @elseif($book->status == "hilang")
                                        <span class="badge badge-danger">{{ $book->status }}</span>
                                        @endif
                                    </h6>
                                </div>
                                <div class="card-footer pt-0 align-self-center text-center">
                                    @if ($book->status == "ada")
                                    <button onclick="borrow_book('{{ $book->id }}')"
                                        class="btn btn-sm btn-rounded btn-outline-primary mt-2 {{ $book->id }}">Select
                                        Book</button>
                                    @endif
                                    <a href="{{ route('borrows.show',[$book->id]) }}"
                                        class="btn btn-sm btn-rounded btn-outline-secondary mt-2">Detail Book</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    {{$all_book->appends(Request::all())->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="container">
    <form action="{{ route('test.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method("POST")
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="cover" name="cover">
            <label class="custom-file-label" for="cover">Cover</label>
        </div>
        <input type="submit" value="Test">
    </form>
</div>
@endsection
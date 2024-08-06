@extends('redirector.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Create Redirect</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('redirects.store') }}" method="POST">
                    @csrf
                    @include('redirector._form')
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('redirector.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Redirects</h1>
                <a href="{{ route('redirects.create') }}" class="btn btn-primary mb-3">Create Redirect</a>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Source URL</th>
                        <th>Destination URL</th>
                        <th>Status Code</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($redirects as $redirect)
                        <tr>
                            <td>{{ $redirect->source_url }}</td>
                            <td>{{ $redirect->destination_url }}</td>
                            <td>{{ $redirect->status_code }}</td>
                            <td>{{ $redirect->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('redirects.edit', $redirect) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('redirects.destroy', $redirect) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

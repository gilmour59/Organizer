@extends('layout.app')

@section('content')
    <div class="text-center my-4">
        <h2>Organizer Test</h2>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            Search
        </div>
        <div class="card-body">
            <form method="POST" action="">
                @csrf
                <div class="form-group">
                    <input id="search" name="search" class="form-control offset-3 col-sm-6" type="text">
                </div>
            </form>
        </div>
    </div>
@endsection
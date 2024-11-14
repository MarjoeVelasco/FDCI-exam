@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Confirmation</div>

                <div class="card-body text-center bg-white">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <br>
                    <h2>Thank you for registering</h2>
                    <a href="/home" class="btn btn-success">continue</a>
                    <br>
                    <br>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

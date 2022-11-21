@extends('_layouts.main')

@section('container')
<div class="container my-5">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-4 col-md-6 col-sm-12 align-self-center">
            <div class="card shadow">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                    <form action="login" method="post">
                        <div class="my-3">
                            <label for="username">Username</label>
                            <input class="form-control" type="text" name="username" type="text" required />
                        </div>

                        <div class="my-3">
                            <label for="password">Password</label>
                            <input class="form-control" type="text" name="password" type="password" required />
                        </div>

                        <div class="my-3">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

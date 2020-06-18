@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload orders for faction {{ $faction->name }}</div>
                <div class="card-body">
                    <form action="{{ route('factions.orders.store', $faction) }}" method="post">
                        @csrf
                        <!--  -->
                        @if ($errors->any())
                        <div class="alert alert-danger" role="alert">Please fix the following errors</div>
                        @endif
                        <div class="form-group">
                            <label for="orders">Orders</label>
                            <textarea class="form-control @error('orders') is-invalid @enderror"
                                id="orders" name="orders" placeholder="post your orders here">{{ old('orders') }}</textarea>
                            @error('orders')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

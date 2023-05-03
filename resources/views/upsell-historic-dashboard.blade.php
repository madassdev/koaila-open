@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1">
                            @foreach($customers as $customer)
                                <div class="flex">
                                    <h1>{{$customer->states()->latest()->first()->date}}</h1>
                                    @if($customer->first()->states->first())
                                        <h1>{{$customer->first()->states->first()->state[$customer_info]}}</h1>
                                    @endif
                                    <a href="{{ route('customer-dashboard', ['email'=>$customer['email']]) }}">{{$customer['email']}}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

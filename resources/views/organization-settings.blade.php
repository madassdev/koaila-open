@extends('layouts.app') @section('content') @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif @if(session()->has('message'))
<div
    class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4"
    role="alert"
>
    <p>{{ session()->get('message') }}</p>
</div>
@endif @php $routes = [ "create_organization" =>
route('organization-settings.create'), "add_member" =>
route('organization-settings.members.add'),"update_member" =>
route('organization-settings.members.update'), ]; @endphp
<div class="container">
    <organization-settings
        :user="{{ json_encode(auth()->user()) }}"
        :organization="{{ json_encode($organization) }}"
        :members="{{ json_encode($members) }}"
        :errors="{{json_encode($errors->messages())}}"
        :routes="{{ json_encode($routes) }}"
        :roles="{{json_encode($roles)}}"
        :old-values="{{ json_encode(old()) }}"
    />
</div>
@endsection

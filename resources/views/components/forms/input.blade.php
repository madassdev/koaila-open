@props(['label','id', 'name'])

<div class="row mb-3 mt-3">
    <label for="{{$id}}" class="col-md-4 col-form-label text-md-end">{{ $label }}</label>

    <div class="col-md-6">
        <input id="{{$id}}" name="{{$name}}" class="form-control" autocomplete="api-amplitude" autofocus>
    </div>
</div>

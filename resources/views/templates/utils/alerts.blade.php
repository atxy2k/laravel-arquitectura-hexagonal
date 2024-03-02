@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>
@endif

@foreach (Alert::getMessages() as $type => $messages)
    @foreach ($messages as $message)
        <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }}">{{ $message }}</div>
    @endforeach
@endforeach
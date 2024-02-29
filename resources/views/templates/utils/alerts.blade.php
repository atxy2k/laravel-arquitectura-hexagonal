@foreach (Alert::getMessages() as $type => $messages)
    @foreach ($messages as $message)
        <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }}">{{ $message }}</div>
    @endforeach
@endforeach
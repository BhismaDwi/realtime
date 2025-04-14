<div>
    <h1>Chat Realtime</h1>

    <ul>
        @foreach ($conversations as $item)
            <li>{{ $item['username'] }} : {{ $item['message'] }}</li>
        @endforeach
    </ul>

    <form wire:submit="submit">
        <input type="text" wire:model="message" placeholder="Enter your message">
        <button type="submit">Send</button>
    </form>

</div>

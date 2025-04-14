<div>
    <h1>Chat Private Realtime</h1>

    <ul>
        @foreach ($conversations as $item)
            <li>{{ $item['username'] }} : {{ $item['message'] }}</li>
        @endforeach
    </ul>

    <form wire:submit="submit">
        <select wire:model="received">
            <option value="">Select User</option>
            @foreach ($users as $row)
                <option value="{{ $row->id }}">{{ $row->name }}</option>
            @endforeach
        </select>
        <input type="text" wire:model="message" placeholder="Enter your message">
        <button type="submit">Send</button>
    </form>

</div>

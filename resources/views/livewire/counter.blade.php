<div>
    <h1>{{ $count }}</h1>

    <button wire:click="increment">+</button>

    <button wire:click="decrement">-</button>
    <button class="btn btn-primary" type="button" wire:click="$refresh">Refresh</button>
</div>

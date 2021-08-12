<div class="col-md-1 mt-1 text-center">
    <a wire:click.prevent="vote(1)" href="#">
        <i style="font-size: 1.5rem" class="fas fa-sort-up" aria-hidden="true"></i>
    </a>
    <div class="mb-2" style="font-size: 1.3rem">
        {{ $question->votes }}
    </div> 
    <a wire:click.prevent="vote(-1)" href="#">
        <i style="font-size: 1.5rem" class="fas fa-sort-up" aria-hidden="true"></i>
    </a>
</div>
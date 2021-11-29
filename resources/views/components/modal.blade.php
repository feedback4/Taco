@props(['formAction' => false])

<div class="modal fade">
    @if($formAction)
        <form wire:submit.prevent="{{ $formAction }}">
            @endif
            <div class="modal-header">
                @if(isset($title))
                    <h3 class="modal-title>
                        {{ $title }}
                    </h3>
                @endif
            </div>
            <div class="modal-body">
                <div class="space-y-6">
                    {{ $content }}
                </div>
            </div>

            <div class="modal-footer">
                {{ $buttons }}
            </div>
            @if($formAction)
        </form>
    @endif
</div>

<div>
    @if ($selectedConversation)
        <form wire:submit.prevent='sendMessage' action="">
            <div class="chatbox_footer">
                <div class="custom_form_group">
                    <input wire:model=body type="text" class="control" placeholder="Mensaje...">
                    <button type="submit" class="submit">Enviar</button>
                </div>
            </div>
        </form>
    @endif
</div>

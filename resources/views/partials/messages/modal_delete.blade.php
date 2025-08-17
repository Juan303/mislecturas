<div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <input type="hidden" id="item_id" name="item_id" value="">
        <input type="hidden" id="item_nombre" name="item_nombre" value="">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¡Atención!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning w-25 mr-1">{{ __('SI') }}</button>
                    <button type="button" data-dismiss="modal" class="btn btn-primary w-25">{{ __('NO') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>

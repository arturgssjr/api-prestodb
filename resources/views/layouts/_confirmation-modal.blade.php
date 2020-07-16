<div class="modal fade" id="confirmation-modal" tabindex="-1" role="dialog" aria-labelledby="confirmation-modal-title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                {!! Form::open(['url' => '', 'method' => 'POST']) !!}
                @method('DELETE')
                <button class="btn btn-sm btn-danger" type="submit">
                    <i class="fas fa-trash-alt"></i> Confirmar
                </button>
                <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

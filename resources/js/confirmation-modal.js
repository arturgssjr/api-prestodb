var Modal = {
    init: function () {
        this.initConfirmationModal()
    },
    initConfirmationModal: function () {
        $(document)
            .on('click', '.load-confirmation-modal', function (event) {
                var nome = $(this).attr('data-name');
                var tipo = $(this).attr('data-type');
                $('#confirmation-modal')
                    .modal({
                        backdrop: 'static'
                    });
                $('#confirmation-modal h5.modal-title')
                    .html('Confirmar Exclusão - ' + tipo);
                $('#confirmation-modal div.modal-body p')
                    .html('Deseja realmente excluir <strong>' + nome + '</strong> ?');
                $('#confirmation-modal form')
                    .attr('action', $(this).attr('data-url'));
                event.preventDefault()
            })
    }
};
Modal.init();
newFunction();

function newFunction() {
    $(document).ready(function () {
        $('#create_source').click(function () {
            $('#modal_source').modal('show');
        });
        $('#create_adc').click(function () {
            $('#modal_adc').modal('show');
        });
        $('#create_trigger').click(function () {
            $('#modal_trigger').modal('show');
        });
        $('#cancel_source').click(function () {
            $('#modal_source').modal('hide');
        });
        $('#cancel_adc').click(function () {
            $('#modal_adc').modal('hide');
        });
        $('#cancel_trigger').click(function () {
            $('#modal_trigger').modal('hide');
        });
    });
}

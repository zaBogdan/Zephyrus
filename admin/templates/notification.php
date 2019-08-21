<script>
$(document).ready(function() {
    $.notify({
        // options
        icon: '%%icon%%',
        title: '%%header%%',
        message: '%%message%%' 
    },{
        // settings
        type: '%%type%%',
        allow_dismiss: true,
        animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutUp'
        },
        timer: 5000,
    });
});

</script>
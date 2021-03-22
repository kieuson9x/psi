<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="<?php echo URLROOT ?>/public/js/app.js">
<!-- JavaScript Bundle with Popper -->
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js">
</script>
<script src="https://unpkg.com/bootstrap-table@1.18.2/dist/extensions/editable/bootstrap-table-editable.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(function() {
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('.navbar-toggler').on('click', function() {
                $('#sidebar').toggleClass('active');
                $('.main-panel').toggleClass('full-panel');
            });
            // $('.sidebar').addClass('sidebar-offcanvas');
        } else {
            $('.sidebar').removeClass('sidebar-offcanvas');
            $('.navbar-toggler').on('click', function() {
                $('#sidebar').toggleClass('hidden');
                $('.main-panel').toggleClass('full-panel');
            });
        }
    })

    $(window).resize(function() {
        if (window.matchMedia('(max-width: 991px)').matches) {
            // $('.sidebar').addClass('sidebar-offcanvas');
        } else {
            // $('.sidebar').removeClass('sidebar-offcanvas');
        }
    });
</script>
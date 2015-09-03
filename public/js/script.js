$(document).ready(function () {
    $('#example').DataTable(
            {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            }
    );
});
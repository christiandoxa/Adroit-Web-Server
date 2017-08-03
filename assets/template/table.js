$(document).ready(function () {
    $('#dataTables-example').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [3]},
            {"bSearchable": false, "aTargets": [3]}],
        responsive: true
    });
});

$(document).ready(function () {
    $('#dataTables-device').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [1]},
            {"bSearchable": false, "aTargets": [1]}],
        responsive: true
    });
});

$(document).ready(function () {
    $('#dataTables-2').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [2]},
            {"bSearchable": false, "aTargets": [2]}],
        responsive: true
    });
});

$(document).ready(function () {
    $('#dataTables-pesan').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [4, 5]},
            {"bSearchable": false, "aTargets": [4, 5]}],
        order: [[3, 'desc']],
        responsive: true
    });
});

$(document).ready(function () {
    $('#dataTables-pelanggan-baru').DataTable({
        "aoColumnDefs": [{"bSortable": false, "aTargets": [3, 4]},
            {"bSearchable": false, "aTargets": [3, 4]}],
        responsive: true
    });
});
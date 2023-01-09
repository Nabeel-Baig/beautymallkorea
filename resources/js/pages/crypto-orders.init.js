/*
Project Name: MNB - Admin & Dashboard
Author: Nabeel Baig
Version: 4.0.0.
Website: https://technosavvyllc.com
Contact: info@technosavvyllc.com
File: Crypto orders select2 Js File
*/

// Select2
$(".select2-search-disable").select2({
    minimumResultsForSearch: Infinity
});

// datatable
$(document).ready(function() {
    $('.datatable').DataTable();

    $(".dataTables_length select").addClass('form-select form-select-sm');
});

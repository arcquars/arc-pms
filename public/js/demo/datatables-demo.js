// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
      language: {
          url: '//cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json',
      },
  });
});

var deleteExts = [];
$("table").on("page-change.bs.table", function () {
	$(".btn-remove").prop("disabled", true);
	deleteExts = [];
});
$("table").on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
	var toolbar = $(this).data("toolbar"), button = $(toolbar).find(".btn-remove"), id = $(this).prop("id");
	button.prop('disabled', !$("#"+id).bootstrapTable('getSelections').length);
	deleteExts = $.map($("#"+id).bootstrapTable('getSelections'), function (row) {
		return row.id;
  });
});
$(".btn-remove").click(function() {
	var btn = $(this);
	if(confirm(_("Are you sure you wish to remove these users from Zulu?"))) {
		btn.find("span").text(_("Removing..."));
		btn.prop("disabled", true);
		$.post( "ajax.php", {command: "remove", module: "zulu", users: deleteExts}, function(data) {
			if(data.status) {
				btn.find("span").text(_("Delete"));
				$("table").bootstrapTable('remove', {
					field: "id",
					values: deleteExts
				});
				deleteExts = [];
				toggle_reload_button("show");
				$("#header-message").html(data.header);
			} else {
				btn.find("span").text(_("Delete"));
				btn.prop("disabled", true);
				alert(data.message);
			}
		});
	}
});

function userActions(table, row) {
	return '<a href="?display=userman&action=showuser&user='+row.id+'"><i class="fa fa-edit"></i></a>';
}

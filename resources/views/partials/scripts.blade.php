<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset('/plugins/jsnumeral/min/numeral.min.js') }}" type="text/javascript"></script>

<!-- Graph Lib -->
<!--<script src="{ asset('/plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>-->
<script src="{{ asset('/plugins/highchart/highcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/highchart/modules/exporting.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/bootstrap4/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/jquerymask/jquery.mask.min.js') }}" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="{{ asset('/js/full-calendar/fullcalendar.min.js') }}"></script>

<script src="{{ asset('/js/base.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/jqueryui-editable/js/jqueryui-editable.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/lib/jquery.event.drag-2.3.0.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/SlickGrid-2.3.16/slick.core.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/plugins/slick.autotooltips.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/plugins/slick.cellrangedecorator.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/plugins/slick.cellrangeselector.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/plugins/slick.cellexternalcopymanager.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/plugins/slick.cellselectionmodel.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/plugins/slick.rowselectionmodel.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/slick.formatters.js')}}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/slick.editors.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/SlickGrid-2.3.16/slick.grid.js') }}" type="text/javascript"></script>

<!-- DataTables -->
<!--<script src="{ asset('/plugins/DataTables/datatables.min.js') }}" type="text/javascript"></script>-->
<script src="{{ asset('/plugins/DataTables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/dataTables.buttons.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/buttons.flash.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/buttons.html5.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/DataTables/buttons.print.min.js') }}" type="text/javascript"></script>

{{-- <script src="{{  asset('/plugins/morris/raphael.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('/plugins/morris/morris.min.js') }}" type="text/javascript"></script> --}}

<script type="text/javascript" src="{{ asset('/js/symva.js') }}"></script>

<script type="text/javascript">
	
	var screen = $('#loading-screen');
	configureLoadingScreen(screen);

	function configureLoadingScreen(screen){
		$(document)
			.ajaxStart(function() {
				screen.fadeIn();
			})
			.ajaxStop(function() {
				screen.fadeOut();
			});
	}
</script>
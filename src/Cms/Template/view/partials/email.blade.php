<!-- Modal -->
<div class="modal fade email-modal" id="modal-email" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title">Email confirmation</h4>
			</div>
			<div class="modal-body">
				<?
				$form = new \Form('email');
				$form->render();
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default do-skip-email">Skip</button>
				<button type="button" class="btn btn-primary do-send-email" data-loading-text="<span class='fa fa-spinner fa-spin fa-3x fa-fw'></span>">Send</button>
			</div>
		</div>
	</div>
</div>
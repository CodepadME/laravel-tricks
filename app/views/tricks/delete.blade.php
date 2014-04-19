<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">{{trans('tricks.delete.confirm')}}</h4>
      </div>
      <div class="modal-body">
          {{trans('tricks.delete.confirm_message')}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('tricks.delete.cancel_button')}}</button>
        <a href="{{$link}}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>{{trans('tricks.delete.remove_button')}}</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
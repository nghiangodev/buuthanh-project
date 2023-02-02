<div class="modal-header">
    <h5 class="modal-title">Log Detail</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12 form-group">
            <label for="textarea_content">Content</label>
            <textarea name="" class="form-control" id="textarea_content" cols="30" rows="10">{{ $content }}</textarea>
        </div>
        <div class="col-lg-12">
            <label for="textarea_stack">Stack</label>
            <textarea name="" class="form-control" id="textarea_stack" cols="30" rows="10">{{ $stack }}</textarea>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">@lang('Close')</button>
</div>
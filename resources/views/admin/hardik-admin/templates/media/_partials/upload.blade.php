<div class="modal fade" id="_media_upload" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Media Library</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="library-tab" data-toggle="tab" href="#library" role="tab" aria-controls="home" aria-selected="true">Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="profile" aria-selected="false">Upload</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="embeded-tab" data-toggle="tab" href="#embeded" role="tab" aria-selected="false">Embeded</a>
          </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="library" role="tabpanel">
            <select class="" id="object-type-selector" name="">
              <option value="image">Image</option>
              <option value="video">Video</option>
              <option value="application">PDF</option>
            </select>
            <div class="" id="_library">

            </div>
          </div>
          <div class="tab-pane" id="upload" role="tabpanel">
            <form method="post" action="{{ route('media.upload') }}" enctype="multipart/form-data" novalidate="" class="box has-advanced-upload">
            		<div class="box__input">
            			<svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path></svg>
            			<input type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple="">
            			<label for="file" id="_upload_label"><strong class="_choose">Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
            			<button type="submit" class="box__button">Upload</button>
            		</div>
              	<input type="hidden" name="ajax" value="1">
            </form>
            <div class="progress" id="_progress_wrapper">
              <div class="progress-bar" id="_progress" style="width:0%"></div>
            </div>
          </div>
          <div class="tab-pane" id="embeded" role="tabpanel">
            {!! $form->start('embeded-form', 'embeded-form', route('media.add.embeded')) !!}
              {!! $form->text([
                'name' => 'code',
                'label' => 'Embeded Code',
                'required' => true,
                'textarea' => true,
              ]) !!}
              <button type="submit" class="btn btn-primary btn-lg" name="button">Save</button>
            {!! $form->end() !!}
          </div>
        </div>
      </div>
      <div class="modal-footer none">
        <button type="button" class="btn btn-success" id="insert-selected-image">Select</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

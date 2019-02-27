<!-- --------- PAINTINGS --------- -->

<!-- Picture exists modal for insert -->

<div class="modal" id="picture-exists" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
    			<h5 class="modal-title">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                A picture with the same title has been found. Try with a new one.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Insert picture success -->

<div class="modal" id="i-picture-success" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>The picture has been successfully uploaded.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update picture success -->

<div class="modal" id="u-picture-success" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>The picture has been successfully updated.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Upload new picture -->

<div class="modal fade" id="upload-picture" tabindex="-1" role="dialog" aria-labelledby="upload-picture-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="upload-picture-title">Upload picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="index.php?mod=picture&op=uploadPicture" method="post" enctype="multipart/form-data" id="upload-picture-form">

  			<div class="form-group">
    			<label for="title">Title</label>
    			<input type="text" class="form-control" name="title" placeholder="Title">
  			</div>
              
            <div class="form-group">
    			<label for="date">Date</label>
    			<input type="date" class="form-control" name="date" placeholder="Date">
  			</div>

            <div class="form-group">
    			<label for="description">Description</label>
                <textarea class="form-control" rows="5" name="description" id="description"></textarea>
  			</div>

            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="hidden" name="mod" value="picture">
                    <input type="hidden" name="op" value="uploadPicture">
                    <input type="file" class="custom-file-input" aria-describedby="uploadImage" id="uploadImage" accept="image/*" name="image" />
                    <label class="custom-file-label" for="uploadImage">Choose file</label>
                </div>
            </div>

            <div id="preview"></div>
            <div id="err"></div>
     
            <button type="submit" class="btn btn-warning">Upload</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</form>
      
      </div>

    </div>
  </div>
</div>

<!-- Forbidden type uploading picture -->

<div class="modal fade" id="forbidden-type" tabindex="-1" role="dialog" aria-labelledby="forbidden-type-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forbidden-type-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Review the uploading process. Something went wrong.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Uploading success -->

<div class="modal fade" id="upload-success" tabindex="-1" role="dialog" aria-labelledby="upload-success-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="upload-success-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        The image was loaded successfully.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Uploaded image exists -->

<div class="modal fade" id="upload-exists" tabindex="-1" role="dialog" aria-labelledby="upload-exists-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="upload-exists-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        The image already exists. Try with another name.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Exceeded size reached -->

<div class="modal fade" id="forbidden-size" tabindex="-1" role="dialog" aria-labelledby="forbidden-size-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forbidden-size-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        The size is too large. Maximum is 5 kilobytes(0.5MB).
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Forbidden extension -->

<div class="modal fade" id="forbidden-extension" tabindex="-1" role="dialog" aria-labelledby="forbidden-extension-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forbidden-extension-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Detected a problem with the extension. Make sure it is a file type
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Empty parameters -->

<div class="modal fade" id="empty-parameters" tabindex="-1" role="dialog" aria-labelledby="empty-parameters-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="empty-parameters-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        You have to fill all parameters.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
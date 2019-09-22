<div class="input-group" file-uploader is-multiple="false" identifier="app-image" style="border: 1px dashed;">
    <span class="input-group-btn">
        <span class="btn btn-default btn-file">
           <i class="fa fa-folder-open"></i> Drop or Browse…  <input type="file" name="file_upload" value="@{{ details.image_app.name }}" >
        </span>
    </span>
    <input type="text" class="form-control" readonly ng-model=" details.image_app.name">
</div>

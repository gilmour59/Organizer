<!-- Modal -->
<div class="modal fade" id="addFile" tabindex="-1" role="dialog" aria-labelledby="FileTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FileTitle">Add File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="addFileForm" method="POST" action="/store" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label for="addLetter">Select Type of Letter:</label>
                            <select class="form-control" id="addLetter" name="addLetter">
                                <option value="1">Ingoing</option>
                                <option value="0">Outgoing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="addDate">Date Received:</label>
                            <input class="form-control <?php $errors->has('addDate') ? "is-invalid": ""?>" type="date" name="addDate" id="addDate" autofocus>
                            <span id="error-addDate" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="addTo">To:</label>
                            <input class="form-control" type="text" name="addTo" id="addTo">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="addFrom">From:</label>
                            <input class="form-control" type="text" name="addFrom" id="addFrom">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="addName">Name:</label>
                            <input class="form-control" type="text" name="addName" id="addName">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="addSubject">Subject:</label>
                            <textarea name="addSubject" class="form-control <?php $errors->has('addSubject') ? "is-invalid": ""?>" id="addSubject" cols="5" rows="3"></textarea>
                            <span id="error-addSubject" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="addFileUpload">Upload File: </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?php $errors->has('addFileUpload') ? "is-invalid": ""?>" id="addFileUpload" name="addFileUpload">
                                <label class="custom-file-label form-control-file" for="addFileUpload">Choose file</label>
                                <span id="error-addFileUpload" class="invalid-feedback"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button id="closeAddFilebtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="addFileForm" class="btn btn-primary" value="Submit">Save</button>
            </div>
        </div>
    </div>
</div>
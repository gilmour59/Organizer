<!-- Modal Edit-->
<div class="modal fade" id="editFile" tabindex="-1" role="dialog" aria-labelledby="FileEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="FileEditTitle">Edit File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="editFileForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label for="editLetter">Select Type of Letter:</label>
                            <select class="form-control" id="editLetter" name="editLetter">
                                <option value="1">Ingoing</option>
                                <option value="0">Outgoing</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="editDate">Date Received:</label>
                            <input class="form-control <?php $errors->has('editDate') ? "is-invalid": ""?>" type="date" name="editDate" id="editDate" autofocus>
                            <span id="error-editDate" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="editTo">To:</label>
                            <input class="form-control" type="text" name="editTo" id="editTo">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="editFrom">From:</label>
                            <input class="form-control" type="text" name="editFrom" id="editFrom">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="editName">Name:</label>
                            <input class="form-control" type="text" name="editName" id="editName">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="editSubject">Subject:</label>
                            <textarea name="editSubject" class="form-control <?php $errors->has('editSubject') ? "is-invalid": ""?>" id="editSubject" cols="5" rows="3"></textarea>
                            <span id="error-editSubject" class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="editFileUpload">Upload File: </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?php $errors->has('editFileUpload') ? "is-invalid": ""?>" id="editFileUpload" name="editFileUpload">
                                <label class="custom-file-label form-control-file" for="editFileUpload">Choose file</label>
                                <span id="error-editFileUpload" class="invalid-feedback"></span>
                            </div>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button id="closEditFilebtn" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="editFileForm" class="btn btn-primary" value="Submit">Save</button>
            </div>
        </div>
    </div>
</div>
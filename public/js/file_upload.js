class FileUploadModal {

    constructor(uploadUrl, csrfToken, modalTitle = 'upload file'){
        this.uploadUrl = uploadUrl;
        this.csrf = csrfToken;
        this.modalTitle = modalTitle;
        this.onSuccessHandler = () => {}
        this.onErrorHandler = () => {}
        this.modalId = Math.random();
    }

    setUploadUrl(uploadUrl){
        this.uploadUrl = uploadUrl

    }

    getUploadUrl(){
        return this.uploadUrl
    }

    init(){
        let modalId = 'file-upload-modal'
        this.modalId = modalId
        let formId = 'dropzone-form'
        let submitBtnId = 'submit-file-upload'
        $('body').append(
            '<div class="modal fade" id="'+modalId+'" tabindex="-1" role="dialog" aria-hidden="true">\n' +
            '    <div class="modal-dialog" role="document">\n' +
            '        <div class="modal-content">\n' +
            '            <div class="modal-header text-center">\n' +
            '                <h4 class="modal-title w-100 font-weight-bold">'+this.modalTitle+'</h4>\n' +
            '                <button id="dismiss-modal-pict" type="button" class="close" data-dismiss="modal" aria-label="Close">\n' +
            '                    <span aria-hidden="true">×</span>\n' +
            '                </button>\n' +
            '            </div>\n' +
            '            <div id="dropzone" style="margin-top:20px;" class="form-group">\n' +
            '                <form class="dropzone needsclick mx-4 mt-3 mb-2" style="border:1px; border-style:dashed; " id="'+formId+'" ' +
            'action="'+this.uploadUrl+'">\n' +
            '                    <input type="hidden"/>\n' +
            '                    <div class="dz-message needsclick form-control btn btn-outline-success">\n' +
            '                        Drop the file here or click here for select file\n' +
            '                        <i class="fa fa-paper-plane-o ml-1"></i>\n' +
            '                        <br/>\n' +
            '                    </div>\n' +
            '                </form>\n' +
            '            </div>\n' +
            '            <div class="modal-footer justify-content-center d-flex" style="margin-top:20px;">\n' +
            '                <button id="'+submitBtnId+'" class="submit btn btn-block btn-primary" style="margin-top: 0px;margin-left:0px;">Upload</button>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>')

        let onSuccessHandler = this.onSuccessHandler;
        let onErrorHandler = this.onErrorHandler;
        let self = this
        this.dropzone = $('#'+formId).dropzone({
            url : this.uploadUrl,
            headers : { 'X-CSRF-TOKEN': this.csrf } ,
            maxFiles : 1,
            autoProcessQueue : false,
            init : function() {
                let myDropzone = this;
                var prevFile = null;
                this.on("addedfile", function(file) {
                    if(prevFile != null){
                        this.removeFile(prevFile);
                    }
                    prevFile = file;
                });

                $('#'+submitBtnId).click( () => {
                    console.log(self.uploadUrl)
                    this.options.url = self.uploadUrl
                    myDropzone.processQueue();
                });

                this.on('success',onSuccessHandler);
                this.on('error',onErrorHandler);
            }
        })

    }
    setOnSuccessHandler(onSuccessHandler){
        this.onSuccessHandler = onSuccessHandler;
    }

    setOnErrorHandler(onErrorHandler){
        this.onErrorHandler = onErrorHandler;
    }

    getModalId(){
        return this.modalId;
    }


}
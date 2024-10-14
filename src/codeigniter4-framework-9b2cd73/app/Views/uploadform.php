<?= $this->extend('base_template') ?>
<!-- Test page -->

<?= $this->section('content') ?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

</head>

<body>
<h2>File Upload</h2>

<form action="<?= base_url('uploadform'); ?>" class="dropzone" id="myDropzone">
    <?= csrf_field() ?>
</form>

<div id="message" class="message"></div>

<script>
    Dropzone.options.myDropzone ={
        paramName: "file",
        maxFilesize: 2, // Megabytes
        acceptedFiles: ".jpg,.jpeg,.png,.gif",
        init: function(){
            this.on("success", function(file,response){
                if (response.success){
                    showMessage("File upload successful", "success");
                } else{
                    showMessage("File upload error", "error");
                }
            });
            this.on("error", function(file, errorMessage){
                showMessage("File upload error" + errorMessage, "error");
            });
        }

    };

    function showMessage(message, type){
        var messageElement = document.getElementById("message");
        messageElement.textContent = message;
        messageElement.classname = "message " + type;
    }

</body>

<?= $this->endSection() ?>
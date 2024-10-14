<?= $this->extend('base_template') ?>

<?= $this->section('content') ?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

</head>
<h2><?= $title ?></h2>

<?php if (session()->get('user_type') === 'Business'): ?>
<!-- This is so ugly, I will need to change it. It does upload an -->
    <form method="post" action="<?= $menu ? base_url('menu_list/update/' . $menu['item_id']) : base_url('menu_list/saveitem') ?>"class="dropzone" id="myDropzone">>
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
        </script>
        <div class="mb-3">
            <label for="item_name" class="form-label">Item Name</label>
            <input type="text" name="item_name" id="item_name" class="form-control" value="<?= $menu ? $menu['item_name'] : '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="item_category" class="form-label">Item Category</label>
            <input type="text" name="item_category" id="item_category" class="form-control" value="<?= $menu ? $menu['item_category'] : '' ?>" required>
        </div>
    
        <div class="mb-3">
            <label for="item_price" class="form-label">Item Price</label>
            <input type="text" name="item_price" id="item_price" class="form-control" value="<?= $menu ? $menu['item_price'] : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?= $menu ? 'Update' : 'Save' ?></button>
    </form>

<?php else: ?>
    <?php if (!session()->has('user_type')): ?>
        <p>Insufficient permissions. Please log in and try again.</p>
    <?php else: ?>
        <p>Insufficient permissions. This page is for businesses only.</p>
    <?php endif; ?>
    <a href="<?= base_url('/home'); ?>" class="home">Return Home</a>


<?php endif; ?>
<?= $this->endSection() ?>
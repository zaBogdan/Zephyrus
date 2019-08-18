<?php include "widgets/header.php"?>
<?php

if(isset($_POST['submit'])){
    $post = new ContentManager();
    $post->createPost($_POST,$_FILES);
    $post->save_to_db();
}

?>

<body id="page-top">

    <?php include "widgets/navbar.php" ?>


    <div id="content-wrapper">

        <div class="container-fluid">


            <!-- Page Content -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.php">Administrator</a>
                </li>
                <li class="breadcrumb-item active">Create a post</li>
            </ol>

            <form action="" method="post" enctype="multipart/form-data">
<!-- <div class="row"> -->
<div class="col-12">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-label-group">
                                <input type="text" id="inputTitle" class="form-control"
                                    <?=isset($_POST['title'])? 'value="'.$_POST['title'].'"' : 'placeholder="Title"'?>
                                    name="title" required="required" autofocus="autofocus">
                                <label for="inputTitle">Title</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="custom-file">
                                <input type="file" class="form-control custom-file-input" name="file_upload"
                                    id="customFile">
                                <label class="custom-file-label" for="customFile">Add an image</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="text" id="categoryLabel" class="form-control" name="category"
                                    <?=isset($_POST['category'])? 'value="'.$_POST['category'].'"' : 'placeholder="Category"'?>
                                    required="required">
                                <label for="categoryLabel">Category</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="text" id="satus" class="form-control" name="status"
                                    <?=isset($_POST['status'])? 'value="'.$_POST['status'].'"' : 'placeholder="Status"'?>
                                    required="required">
                                <label for="satus">Status</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-label-group">
                                <input type="text" id="format" class="form-control" name="format"
                                    <?=isset($_POST['format'])? 'value="'.$_POST['format'].'"' : 'placeholder="Format"'?>
                                    required="required">
                                <label for="format">Format</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="textarea1">Text</label>
                    <textarea class="form-control" onkeyup="textAreaAdjust(this)" id="textarea1" rows="3" name="content" placehold="Text" required></textarea>
                </div>
                <br>
                <button class="btn btn-primary btn-block" name="submit">Create post</button>
            </form>


        </div></div>
        <!-- </div> -->

        <?php include "widgets/footer.php"?>

        <script>
            // Add the following code if you want the name of the file appear on select
            $(".custom-file-input").on("change", function () {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
            function textAreaAdjust(o) {
                o.style.height = "1px";
                o.style.height = (25+o.scrollHeight)+"px";
            }
        </script>
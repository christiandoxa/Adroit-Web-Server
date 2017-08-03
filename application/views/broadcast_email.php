<style>
    #iframe-render {
        width: -webkit-fill-available;
        height: -webkit-fill-available;
        border: none;
    }
</style>
<div class="col-lg-5">
    <?php
    if (!empty($notif)) {
        echo '<div class="alert alert-danger alert-dismissable">';
        echo '<button class="close" data-dismiss="alert">&times;</button>';
        echo $notif;
        echo '</div>';
    } else if (!empty($notifs)) {
        echo '<div class="alert alert-success alert-dismissable">';
        echo '<button class="close" data-dismiss="alert">&times;</button>';
        echo $notifs;
        echo '</div>';
    }
    ?>

    <div class="form-group">
        <label>Isi Email</label>
        <textarea rows="19" id="core_input" name="email" class="form-control"></textarea>
    </div>
    <br>
    <div style="align-content: center">
        <input type="submit" name="submit" value="Broadcast" class="btn btn-success">
        <button id="process" class="btn btn-primary">Preview</button>
        <input type="reset" name="reset" value="Reset" class="btn btn-danger">
    </div>


</div>
<div class="col-lg-7" id="render-frame" style="visibility: hidden">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Preview Email
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div id="iframe-body"></div>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        document.getElementById("process").addEventListener("click", function () {
            if (document.getElementById("core_input").value !== '') {
                document.getElementById('render-frame').setAttribute('style', 'visibility: visible');
            } else {
                document.getElementById('render-frame').setAttribute('style', 'visibility: hidden');
            }

            var $iframe = document.getElementById("iframe-render"),
                iframe, iframeDoc;

            if (!$iframe) {
                iframe = document.createElement("iframe");
                iframe.id = "iframe-<?php echo 'render'?>";

                document.getElementById("iframe-body").appendChild(iframe);
            } else {
                iframe = $iframe;
            }

            iframeDoc = iframe.contentWindow ?
                iframe.contentWindow :
                iframe.contentDocument.document ?
                    iframe.contentDocument.document :
                    iframe.contentDocument;

            iframeDoc.document.open();
            iframeDoc.document.write(
                document.getElementById("core_input").value
            );
            iframeDoc.document.close();

        }, false);
    }, false);
</script>
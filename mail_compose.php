<?php
include("./top.php");
?>
<div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-primary compose-mail" href="mail_compose.html">Compose Mail</a>
                            <div class="space-25"></div>
                            <h5>Folders</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="mailbox.html"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right">16</span> </a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger pull-right">2</span></a></li>
                                <li><a href="mailbox.html"> <i class="fa fa-trash-o"></i> Trash</a></li>
                            </ul>
                            <h5>Categories</h5>
                            <ul class="category-list" style="padding: 0">
                                <li><a href="#"> <i class="fa fa-circle text-navy"></i> Work </a></li>
                                <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                                <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li>
                            </ul>

                            <h5 class="tag-title">Labels</h5>
                            <ul class="tag-list" style="padding: 0">
                                <li><a href=""><i class="fa fa-tag"></i> Family</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Work</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Home</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Children</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Holidays</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Music</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Photography</a></li>
                                <li><a href=""><i class="fa fa-tag"></i> Film</a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>
                    <a href="mailbox.html" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                </div>
                <h2>
                    Compse mail
                </h2>
            </div>
                <div class="mail-box">


                <div class="mail-body">

                    <form class="form-horizontal" method="get">
                        <div class="form-group"><label class="col-sm-2 control-label">To:</label>

                            <div class="col-sm-10"><input type="text" class="form-control" value="alex.smith@corporat.com"></div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Subject:</label>

                            <div class="col-sm-10"><input type="text" class="form-control" value=""></div>
                        </div>
                        </form>

                </div>

                    <div class="mail-text h-200">

                        <div class="summernote">
                            <h3>Hello Jonathan! </h3>
                            dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                            when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                            typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                            <br/>
                            <br/>

                        </div>
<div class="clearfix"></div>
                        </div>
                    <div class="mail-body text-right tooltip-demo">
                        <a href="mailbox.html" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Send"><i class="fa fa-reply"></i> Send</a>
                        <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                        <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>
                    </div>
                    <div class="clearfix"></div>



                </div>
            </div>
        </div>
        </div>
<?php
include("bottom.php");
?>

    <!-- SUMMERNOTE -->
    <script src="js/plugins/summernote/summernote.min.js"></script>
    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

        });

    </script>
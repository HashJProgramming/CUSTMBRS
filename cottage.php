<?php
include_once 'functions/menu/offcanva-menu.php';
include_once 'functions/authentication.php';
include_once 'functions/tables/datatables.php';
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Cottages - CUSTMBRS</title>
    <meta name="description" content="CUSTMBRS - Cottage Usage Scheduling with Transaction Monitoring for a Beach Resort System">
    <link rel="icon" type="image/png" sizes="128x128" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="128x128" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="128x128" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="128x128" href="assets/img/icon.png">
    <link rel="icon" type="image/png" sizes="128x128" href="assets/img/icon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/Application-Form.css">
    <link rel="stylesheet" href="assets/css/Articles-Cards-images.css">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Links-icons.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <nav class="navbar navbar-expand-md bg-body py-3 mb-5">
                <div class="container-fluid"><img src="assets/img/icon.png" width="32"><a class="navbar-brand d-flex align-items-center" href="#"><span>&nbsp; Sere's Point Beach Resort</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-2">
                        <ul class="navbar-nav ms-auto"></ul><button class="btn btn-light ms-md-2" data-bs-toggle="offcanvas" data-bss-tooltip="" data-bs-placement="left" type="button" data-bs-target="#offcanvas-menu" title="Here you can see all the menu list of the site such as (Dashboard, Customers, Rents and etc.).">Menu</button>
                    </div>
                </div>
            </nav>
            <div id="content">
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Cottage Management</h3><a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#" data-bs-target="#add" data-bs-toggle="modal"><i class="fas fa-user fa-sm text-white-50"></i>&nbsp;Add Cottage</a>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2" data-bs-toggle="tooltip" data-bss-tooltip="" title="Here you can see your montly earnings.">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>TOTAL COTTAGE</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo get_total_cottage() ?? 0 ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2" data-bs-toggle="tooltip" data-bss-tooltip="" title="Heres your latest customer registered.">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span>NEW COTTAGE</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo new_cottage() ?? 'None' ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-friends fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <p class="text-primary m-0 fw-bold">Cottage List</p>
                                </div>
                                <!-- <div class="col-3">
                                    <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                                        <div class="input-group"><input class="bg-light form-control border-0 small bg-white" type="text" data-bs-toggle="tooltip" data-bss-tooltip="" placeholder="Search for ..." title="Here you can search for cottage name." style="background: var(--bs-info-border-subtle);"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                    </form>
                                </div> -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                                <?php cottage_list(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © CUTMBRS 2023</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
<?php menu(); ?>
    <div class="modal fade" role="dialog" tabindex="-1" id="add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Cottage</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="functions/cottage-create.php" method="post" enctype="multipart/form-data" novalidate>
                    <div class="mb-1"><label class="form-label">Cottage No.</label><input class="form-control" type="number" name="name" required="" placeholder="Cottage No.">
                        <div class="invalid-feedback">
                            Please enter your cottage number.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Type</label>
                        <select class="selectpicker select" data-live-search="true" name="type">
                            <optgroup label="SELECT COTTAGE">
                                <option value="NIPA" selected>NIPA</option> 
                                <option value="CONCRETE" selected>CONCRETE</option> 
                            </optgroup>
                        </select>
                        <div class="invalid-feedback">
                            Please enter your cottage type.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Price Day</label><input class="form-control" type="number" name="priceDay" required="" value="0">
                        <div class="invalid-feedback">
                            Please enter your price.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Price Night</label><input class="form-control" type="number" name="priceNight" required="" value="0">
                        <div class="invalid-feedback">
                            Please enter your price.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Picture</label><input class="form-control" type="file" name="picture" required="" accept="image/*">
                        <div class="invalid-feedback">
                            Please add cottage picture.
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" tabindex="-1" id="update">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Cottage</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" action="functions/cottage-update.php" method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="id">
                    <div class="mb-1"><label class="form-label">Cottage No.</label><input class="form-control" type="number" name="name" required="" placeholder="Cottage No.">
                        <div class="invalid-feedback">
                            Please enter your cottage number.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Type</label>
                        <select class="selectpicker select" data-live-search="true" name="type">
                            <optgroup label="SELECT COTTAGE">
                                <option value="NIPA" selected>NIPA</option> 
                                <option value="CONCRETE" selected>CONCRETE</option> 
                            </optgroup>
                        </select>
                        <div class="invalid-feedback">
                            Please enter your cottage type.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Price Day</label><input class="form-control" type="number" name="priceDay" required="" value="0">
                        <div class="invalid-feedback">
                            Please enter your price.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Price Night</label><input class="form-control" type="number" name="priceNight" required="" value="0">
                        <div class="invalid-feedback">
                            Please enter your price.
                        </div>
                    </div>
                    <div class="mb-1"><label class="form-label">Picture</label><input class="form-control" type="file" name="picture" required="" accept="image/*">
                        <div class="invalid-feedback">
                            Please add cottage picture.
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-primary" type="submit">Save</button></div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" role="dialog" tabindex="-1" id="remove">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Remove Customer</h4><button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this customer?</p>
                </div>
                <form action="functions/cottage-remove.php" method="post">
                    <input type="hidden" name="id">
                    <div class="modal-footer"><button class="btn btn-light" type="button" data-bs-dismiss="modal">Close</button><button class="btn btn-danger" type="submit">Remove</button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/index.global.min.js"></script>
    <script src="assets/js/tinymce.min.js"></script>
</body>

</html>
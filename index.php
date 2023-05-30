<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube Downloader</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark p-4 bg-transparent px-5">
        <a class="navbar-brand" href="#">
            <i class="fab fa-youtube"></i> Youtube Downloader
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/Getdecryptcode/GetDecryptCode.php">Refresh Decrypt Function</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <section class="first_container container">
            <div class="flex-column justify-content-center mt-5 h-100">
                <h3 class="text-center mb-4">Youtube Video Downloader<i class="bi bi-arrow-left"></i></h3>
                <div class="row justify-content-center pt-3">
                    <div class="col-md-8">
                        <form onSubmit="fetchUrls()" method="post" class="form-inline justify-content-center">
                            <input type="text" class="form-control w-75" id="Urltext" placeholder="Paste Url Here .." autocomplete="off">
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </form>
                    </div>
                </div>
                <div id="result" class="row py-4 text-center">
                    <div class="col-12 pb-4">
                        <h5 class="text-primary border-bottom border-primary py-2"><i class="fas fa-save pr-2"></i>Download Links</h5>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <img id="thumbnil" src="" class="w-md-75 w-50 rounded border" alt="">
                        <h5 id="title" class="py-4" ></h5>
                        <h6 class="py-1" >Duration : <span id="duration" ></span></h6>
                    </div>
                    <div class="col-lg-6 col-md-12" id="links">
                    </div>
                </div>
                <div class="errorbox border  border-danger mt-5 text-center p-4">
                        <h5 class="text-danger" id="error"></h5>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/src/js/main.js"></script>
    <script src="/Getdecryptcode/decrypt.js"></script>
</body>

</html>

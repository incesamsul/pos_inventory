<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <title>TOKO SMART!</title>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center flex-column mt-5 pt-5">
        <div class="ilustration">
            <img src="{{ asset('img/svg/ilustration/welcome.svg') }}" alt="" width="500">
        </div>
        <div class="caption text-center">
            <p>Selamat datang di toko smart<br> Penuhi semua kebutuhan Atk anda disini</p>
            <p>Belum ada info apa-apa disini :(<br> </p>
        </div>
        <div class="search-wrapper">
            <div class="search">
                <i class="fa fa-times close-button"></i>
                <form action="{{ URL::to('/cek_loundry') }}" id="formCekLoundry" method="GET">
                    @csrf
                <input type="text" class="form-control" id="id_loundry" name="id_loundry" placeholder="Mau cek loundry? Input id disini... ">
                <button type="submit" class="btn btn-primary" id="btn-cek-loundry"><i class="fas fa-search"></i></button>
            </form>
            </div>
        </div>
        <div class="button-wrapper d-flex flex-row">
            {{-- <div class="button search-button p-4 d-flex align-items-center justify-content-center mx-3">
                <i class="fas fa-search"></i>
            </div> --}}
            {{-- <div class="button qrcode p-4 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-qrcode"></i>
            </div> --}}
            <a href="{{ URL::to('/login') }}" class="btn btn-secondary">Kunjungi kasir</a>
        </div>
    </div>

    <footer class="bg-secondary text-center p-5 text-white">
        <p>Made with <i class="text-danger fas fa-heart"></i> by <a class="text-white text-decoration-none" href="http://incesamsul.epizy.com">ince samsul</a></p>
        <p>Copyright <i class="fas fa-copyright"></i> {{ Date('Y') }}</p>
    </footer>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script>

    </script>
</body>

</html>

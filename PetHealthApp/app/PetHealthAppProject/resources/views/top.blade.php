<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- オリジナルなCSSの読み込み -->
        <link href="{{asset('/css/app.css')}}" rel="stylesheet">

    <!-- BootstrapのCSSの読み込み -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
 
    <!-- BootstrapのJSの読み込み -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

    <title>Top</title>
</head>
<body class="bg-main">
    <div class="flex-bes">
        <div class="flex-vert top-main-box">
            <div class="fw-bold display-2 top-txt-height">
                <p class="txt-user-M ">
                    あなたと<br>
                    ペットの為の
                </p>
                <p class="txt-accent-M">
                    健康管理アプリ
                </p>
            </div>
            <div class="mt-auto mb-3">
                <div>
                    <a class="px-3 py-2 fs-2 rounded-3 btn-user" href="{{ route('user.login') }}">
                        ご利用はこちらから
                        <i class="ms-4 bi bi-chevron-right"></i>
                    </a>
                </div>
                <div class="mt-2 fs-5">
                    <a class="vet-top-link" href="{{ route('vet.login') }}">獣医師の方はこちらから</a>
                </div>
            </div>
        </div>
        <div class="top-pic-box">
            <img src="{{ asset('static/img/top_cat.png') }}" class="img-fluid" alt="top_cat">
        </div>
    </div>
</body>
</html>
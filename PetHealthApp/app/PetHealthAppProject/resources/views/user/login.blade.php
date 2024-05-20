<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- BootstrapのCSSの読み込み -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- オリジナルなCSSの読み込み -->
        <link href="{{asset('/css/app.css')}}" rel="stylesheet">
    <!-- BootstrapのJSの読み込み -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

    <title>Vet Login</title>
</head>

<body class="bg-main"> 
    <div class="pre-menu-box flex-vert bg-menu-user-1">
        <div class="bg-menu-user-2 mt-auto py-5">
        </div>
        <div class="bg-menu-user-3 py-5">
        </div>
        <div class="deco bg-main main-shadow"></div>
    </div>
    <div class="pre-main-box flex-vert bg-main">
        <div class="mx-auto mb-auto">
            <h1 class="txt-user-M fw-bold display-4">ログイン</h1>
        </div>
        <form class="flex-vert mx-auto w-75 h-75" action="{{ route('user.login-process') }}" method="POST">
            @csrf
            <div class="mt-auto">
                <label for="email" class="mb-1 fs-6 txt-user-S">メールアドレス</label>
                <input type="email" class="px-2 w-100 fs-5 input_user_field txt-gray" id="email" name="email" value="{{ old('email', '') }}">
                @if ($errors->has('email'))
                    @foreach($errors->get('email') as $message)
                        <p class="txt-error"> {{ $message }} </p>
                    @endforeach
                @endif
            </div>
            <div class="mt-3">
                <label for="password" class="mb-1 fs-6 txt-user-S">パスワード</label>
                <input type="password" class="px-2 fs-5 w-100 input_user_field txt-gray" id="password" name="password" value="{{ old('password', '') }}">
                @if ($errors->has('password'))
                    @foreach($errors->get('password') as $message)
                        <p class="txt-error"> {{ $message }} </p>
                    @endforeach
                @endif
            </div>
            <div class="mt-auto text-center">
                @if(!empty($errorMessages))
                    <p class="mb-2 txt-error" >{{ $errorMessages }}</p>
                @endif
                @if (session('errorMessages'))
                    <p class="mb-2 txt-error" >{{ session('errorMessages') }}</p>
                @endif
                <button class="py-1 fs-4 rounded-3 btn-user-action" type="submit">ログイン</button>
            </div>
        </form>
        <div class="mx-auto mt-3">
            <p class="mb-1 fs-6 txt-accent-S text-center">初めて利用する方</p>
            <a class="py-1 fs-4 rounded-3 btn-accent-action" href="{{ route('user.create') }}">新規登録</a>
        </div>
    </div>
    <div class="pre-pic-box bg-main">
        <img src="{{ asset('static/img/public_cat.png') }}" class="pic main-shadow" alt="top_cat">
    </div>
</body>
</html>
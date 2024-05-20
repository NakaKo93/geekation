<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
            
    <!-- BootstrapのCSSの読み込み -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- オリジナルなCSSの読み込み -->
        <link href="{{asset('/css/app.css')}}" rel="stylesheet">
    <!-- BootstrapのJSの読み込み -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>

    <title>Demo</title>

<body>
    <div class="pre-menu-box flex-vert bg-menu-user-1">
        <div class="bg-menu-user-2 mt-auto py-5">
        </div>
        <div class="bg-menu-user-3 py-5">
        </div>
        <div class="deco bg-main main-shadow"></div>
    </div>
    <div class="pre-main-box flex-vert bg-main">
        <div class="radius-caontent bg-content">
            <p>{{$userId}}</p>
            <p>{{$vetId}}</p>
            <p>{{$chatData['message']}}</p>
            <p>{{$fromVet ? 'Yes' : 'No' }}</p>
        </div>
        <div class="m-middle radius-caontent bg-content">
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
        </div>
        <div class="radius-caontent bg-content">
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
            <p>ddddddddddddddddddddd</p>
        </div>
    </div>
    <div class="pre-pic-box bg-main">
        <img src="{{ asset('static/img/public_cat.png') }}" class="pic main-shadow" alt="top_cat">
    </div>
</body>
</html>
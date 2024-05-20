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
    
    <script>
        function confirmPetDeletion(event) {
            // 確認ダイアログを表示
            var result = confirm('本当に退会しますか？この操作は元に戻せません。');
            if (!result) {
                // ユーザーがキャンセルを選択した場合、デフォルトのリンク動作をキャンセル
                event.preventDefault();
            }
        }
    </script>

    <title>Pet Edit</title>
</head>
<body class="bg-main">
    <div class="menu-box flex-vert bg-menu-user-1">
        <div class="mt-2 mb-auto">
            @foreach ($petList as $pet)
                <a href="{{ route('user.home', ['petId' => $pet->pet_id]) }}" class="px-3 py-2 flex-bes @if($pet->pet_id == $petDetails->pet_id) me-30px bg-menu-user-3 menu-selected main-shadow txt-white @else txt-gray @endif">
                    <div class="menu-circle bg-pic-ex"></div>
                    <div class="menu-info">
                        <p class="fs-4 fw-bold">{{ $pet->name }}</p>
                        @if($pet->message)
                            <p class="fs-7">
                                <span>今日の</span>
                                <span>健康状態を</span>
                                <span>記入しましょう</span>
                            </p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="py-2 text-center bg-menu-user-2 pe-20px">
            <a href="{{ route('user.pet.add') }}" class="m-auto w-75 fs-4 text-white">
                <i class="fs-5 bi bi-plus-circle-fill"></i>
                追加
            </a>
        </div>
        <div class="flex-vert text-center bg-menu-user-3 pe-20px">
            <a href="{{ route('user.profile') }}" class="mx-auto my-2 w-75 fs-4 text-white">会員情報</a>
            <a href="{{ route('user.logout') }}" class="mx-auto mb-2 w-75 fs-4 text-white">ログアウト</a>
        </div>
        <div class="deco bg-main main-shadow"></div>
    </div>
    <div class="main-box flex-vert bg-main">
        <div class="mx-auto mb-auto">
            <h1 class="txt-user-M fw-bold display-4">プロフィール編集</h1>
        </div>
            <form class="flex-vert mx-auto w-75 h-75" action="{{ route('user.pet.edit-process', ['petId' => $petDetails->pet_id]) }}" method="POST">
                @csrf
                <div class="flex-vert">
                    <label for="photo_address" class="mx-auto my-1 fs-6 txt-user-S upload-button bg-pic-ex"></label>
                    <input type="file" id="photo_address" style="display: none;"  name="photo_address" value="{{ old('photo_address', $petDetails->photo_address ?? '') }}">
                    @if ($errors->has('photo_address'))
                        @foreach($errors->get('photo_address') as $message)
                            <p class="txt-error"> {{ $message }} </p>
                        @endforeach
                    @endif
                </div>
                <div>
                    <label for="name" class="my-1 fs-6 txt-user-S">名前</label>
                    <input type="text" class="px-2 fs-5 w-100 input_user_field txt-gray" id="name" name="name" value="{{ old('name', $petDetails->name ?? '') }}">
                    @if ($errors->has('name'))
                        @foreach($errors->get('name') as $message)
                            <p class="txt-error"> {{ $message }} </p>
                        @endforeach
                    @endif
                </div>
                <div class="flex-bes">
                    <div class="me-1 w-50">
                        <div>
                            <label for="type" class="my-1 fs-6 txt-user-S">種類</label>
                            <input type="text" class="px-2 fs-5 w-100 input_user_field txt-gray" id="type" name="type" value="{{ old('type', $petDetails->type ?? '') }}">
                            @if ($errors->has('type'))
                                @foreach($errors->get('type') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            <label for="birth" class="my-1 fs-6 txt-user-S">誕生日</label>
                            <input type="date" class="px-2 fs-5 w-100 input_user_field txt-gray" id="birth" name="birth" value="{{ old('birth', $petDetails->birth ?? '') }}">
                            @if ($errors->has('birth'))
                                @foreach($errors->get('birth') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="ms-1 w-50">
                        <div class="flex-bes">
                            <div class="me-1 w-50">
                                <label for="age" class="my-1 fs-6 txt-user-S">年齢</label>
                                <input type="number" class="px-2 fs-5 w-100 input_user_field txt-gray" id="age" name="age" value="{{ old('age', $petDetails->age ?? '') }}" min="0">
                                @if ($errors->has('age'))
                                    @foreach($errors->get('age') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="ms-1 w-50">
                                <label for="gender" class="my-1 pb-2px fs-6 txt-user-S">性別</label>
                                <select class="px-2 fs-5 w-100 input_user_field txt-gray" id="gender" name="gender" required>
                                    <option value="">選択してください</option>
                                    <option value="true" {{ (old('gender', $petDetails->gender ?? '') == 'true') ? 'selected' : 'selected' }}>オス</option>
                                    <option value="false" {{ (old('gender', $petDetails->gender ?? '') == 'false') ? 'selected' : '' }}>メス</option>
                                </select>
                                @if ($errors->has('gender'))
                                    @foreach($errors->get('gender') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div>
                            <label for="adoption" class="my-1 fs-6 txt-user-S">迎えた日</label>
                            <input type="date" class="px-2 fs-5 w-100 input_user_field txt-gray" id="adoption" name="adoption" value="{{ old('adoption', $petDetails->date ?? '') }}">
                            @if ($errors->has('adoption'))
                                @foreach($errors->get('adoption') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <label for="memo" class="my-1 fs-6 txt-user-S">メモ</label>
                    <textarea class="px-2 fs-5 w-100 input_user_field txt-gray" id="memo" name="memo">{{ old('memo', $petDetails->memo ?? '') }}</textarea>
                    @if ($errors->has('memo'))
                        @foreach($errors->get('memo') as $message)
                            <p class="txt-error"> {{ $message }} </p>
                        @endforeach
                    @endif
                </div>
                <div class="mt-auto text-center">
                    @if (session('errorMessages'))
                        <p class="mb-2 txt-error" >{{ session('errorMessages') }}</p>
                    @endif
                    <button class="py-1 fs-4 rounded-3 btn-user-action" type="submit">更新</button>
                </div>
            </form>
            <div class=" mt-3 text-center">
                    <a class="py-1 fs-4 rounded-3 btn-accent-action" href="{{ route('user.pet.delete', ['petId' => $petDetails->pet_id]) }}" onclick="confirmPetDeletion(event)">消去</a>
            </div>
        </div>
    </div>
    <div class="pic-box bg-main">
        <img src="{{ asset('static/img/public_cat.png') }}" class="pic main-shadow" alt="top_cat">
    </div>
</body>
</html>
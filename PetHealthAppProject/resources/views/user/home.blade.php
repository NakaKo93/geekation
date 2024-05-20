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

    <title>User home</title>
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
    <div class="home-main-box flex-vert bg-main">
        <div class="radius-caontent bg-content">
            <div class="flex-bes">
                <h1 class="txt-accent-M fw-bold fs-1">プロフィール</h1>
                <a class="my-auto vet-top-link fs-4" href="{{ route('user.pet.edit', ['petId' => $petDetails->pet_id]) }}">プロフィール編集</a>
            </div>
            <div class="flex-bes my-3">
                <div class="home-circle bg-pic-ex">
                </div>
                <div class="home-pet-info-box flex-vert">
                    <div class="mt-1">
                        <p class="mt-1 fs-6 txt-gray">名前</p>
                        <p class="fw-bold display-2 txt-user-M">{{ $petDetails->name }}</p>
                    </div>
                    <div class="flex-bes">
                        <div class="w-50">
                            <p class="mt-1 fs-6 txt-gray">種類</p>
                            <p class="fs-5 txt-user-S">{{ $petDetails->type }}</p>
                        </div>
                        <div class="flex-bes w-50">
                            <div class="w-50">
                                <p class="mt-1 fs-6 txt-gray">年齢</p>
                                <p class="fs-5 txt-user-S">{{ $petDetails->age }} 才</p>                                   
                            </div>
                            <div class="w-50">
                                <p class="mt-1 fs-6 txt-gray">性別</p>
                                <div class="fs-5 txt-user-S">
                                    @if($petDetails->gender)
                                        <p>オス</p>
                                    @else
                                        <p>メス
                                    @endif
                                </div>                            
                            </div>
                        </div>
                    </div>
                    <div class="flex-bes">
                        <div class="w-50">
                            <p class="mt-1 fs-6 txt-gray">誕生日</p>
                            <p class="fs-5 txt-user-S">{{ $petDetails->birth }}</p>        
                        </div>
                        <div class="w-50">
                            <p class="mt-1 fs-6 txt-gray">迎えた人</p>
                            <p class="fs-5 txt-user-S">{{ $petDetails->adoption }}</p>        
                        </div>
                    </div>
                    <div>
                        <p class="mt-1 fs-6 txt-gray">メモ</p>
                        <p class="fs-5 txt-user-S">{{ $petDetails->memo }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-middle radius-caontent bg-content">
            <div class="flex-bes">
                <h1 class="txt-accent-M fw-bold fs-1">今日の健康状態</h1>
                <p class="my-auto txt-accent-S fs-4">{{ $today }}</p>
            </div>
            <form class="my-3" action="{{ route('user.pet.todayHealth-process', ['petId' => $petDetails->pet_id]) }}" method="POST">
                @csrf
                <div class="flex-vert">
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <label for="breakfast_type" class="fs-5 txt-gray">朝食の種類</label>
                        </div>
                        <div class="flex-bes W-50">
                            <div class="W-70 pe-2">
                                <input type="text" class="w-100 fs-5 input_user_field txt-gray" id="breakfast_type" name="breakfast_type" value="{{ old('breakfast_type', optional($todayHealth)->breakfast_type) }}">
                                @if ($errors->has('breakfast_type'))
                                    @foreach($errors->get('breakfast_type') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="W-20">
                                <input type="text" id="breakfast_amount" class="W-100 fs-5 input_user_field txt-gray" name="breakfast_amount" value="{{ old('breakfast_amount', optional($todayHealth)->breakfast_amount) }}">
                                @if ($errors->has('breakfast_amount'))
                                    @foreach($errors->get('breakfast_amount') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="W-10 ">
                                <p class="W-20 fs-5 txt-user-S">g</p>
                            </div>
                        </div>
                        <div class="W-20">
                            <label for="weight" class="fs-5 txt-gray">体重</label>
                        </div>
                        <div class="flex-bes W-10">
                            <input type="number" step="0.01" class="W-80 fs-5 input_user_field txt-gray" id="weight" name="weight" value="{{ old('weight', optional($todayHealth)->weight) }}">
                            @if ($errors->has('weight'))
                                @foreach($errors->get('weight') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                            <p class="W-20 fs-5 txt-user-S">kg</p>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <label for="lunch_type" class="fs-5 txt-gray">昼食の種類</label>
                        </div>
                        <div class="flex-bes W-50">
                            <div class="W-70 pe-2">
                                <input type="text" class="w-100 fs-5 input_user_field txt-gray" id="lunch_type" name="lunch_type" value="{{ old('lunch_type', optional($todayHealth)->lunch_type) }}">
                                @if ($errors->has('lunch_type'))
                                    @foreach($errors->get('lunch_type') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="W-20">
                                <input type="text" id="lunch_amount" class="W-100 fs-5 input_user_field txt-gray" name="lunch_amount" value="{{ old('lunch_amount', optional($todayHealth)->lunch_amount) }}">
                                @if ($errors->has('lunch_amount'))
                                    @foreach($errors->get('lunch_amount') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="W-10 ">
                                <p class="W-20 fs-5 txt-user-S">g</p>
                            </div>
                        </div>
                        <div class="W-20">
                            <label for="weight" class="fs-5 txt-gray">散歩</label>
                        </div>
                        <div class="flex-bes W-10">
                            <input type="number" step="0.01" class="W-80 fs-5 input_user_field txt-gray" id="walk" name="walk" value="{{ old('walk', optional($todayHealth)->walk) }}">
                            @if ($errors->has('walk'))
                                @foreach($errors->get('walk') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                            <p class="W-20 fs-5 txt-user-S">分</p>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <label for="dinner_type" class="fs-5 txt-gray">夕食の種類</label>
                        </div>
                        <div class="flex-bes W-50">
                            <div class="W-70 pe-2">
                                <input type="text" class="w-100 fs-5 input_user_field txt-gray" id="dinner_type" name="dinner_type" value="{{ old('dinner_type', optional($todayHealth)->dinner_type) }}">
                                @if ($errors->has('dinner_type'))
                                    @foreach($errors->get('dinner_type') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="W-20">
                                <input type="text" id="dinner_amount" class="W-100 fs-5 input_user_field txt-gray" name="dinner_amount" value="{{ old('dinner_amount', optional($todayHealth)->dinner_amount) }}">
                                @if ($errors->has('dinner_amount'))
                                    @foreach($errors->get('dinner_amount') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                            <div class="W-10 ">
                                <p class="W-20 fs-5 txt-user-S">g</p>
                            </div>
                        </div>
                        <div class="W-20">
                            <label for="weight" class="fs-5 txt-gray">トイレの回数</label>
                        </div>
                        <div class="flex-bes W-10">
                            <input type="number" step="1" class="W-80 fs-5 input_user_field txt-gray" id="toilet" name="toilet" value="{{ old('toilet', optional($todayHealth)->toilet) }}">
                            @if ($errors->has('toilet'))
                                @foreach($errors->get('toilet') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                            <p class="W-20 fs-5 txt-user-S">回</p>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <label for="medicine" class="fs-5 txt-gray">飲んだ薬</label>
                        </div>
                        <div class="W-50">
                            <input type="text" class="W-90 fs-5 input_user_field txt-gray" id="medicine" name="medicine" value="{{ old('medicine', optional($todayHealth)->medicine) }}">
                            @if ($errors->has('medicine'))
                                @foreach($errors->get('medicine') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                        </div>
                        <div class="flex-bes W-30">
                            <div class="W-90">
                                <label for="trimming" class="fs-5 txt-gray">トリミングに行きましたか</label>
                            </div>
                            <div class="W-10">
                                <input type="checkbox" id="trimming" name="trimming" value="1" {{ old('trimming', optional($todayHealth)->trimming) ? 'checked' : '' }}>
                                @if ($errors->has('toilet'))
                                    @foreach($errors->get('toilet') as $message)
                                        <p class="txt-error"> {{ $message }} </p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="flex-vert W-20">
                            <label for="memo" class="my-auto fs-5 txt-gray">メモ</label>
                        </div>
                        <div class="W-80">
                            <textarea class="W-100 fs-5 input_user_field txt-gray" id="memo" name="memo">{{ old('memo', optional($todayHealth)->memo) }}</textarea>
                            @if ($errors->has('memo'))
                                @foreach($errors->get('memo') as $message)
                                    <p class="txt-error"> {{ $message }} </p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button class="py-1 fs-5 rounded-3 btn-user-action" type="submit">{{ $bottonMessage }}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="radius-caontent bg-content">
            <div class="m-1">
                <h1 class="txt-accent-M fw-bold display-6">過去のデータ</h1>
                <div class="py-5"></div>
            </div>
        </div>
    </div>
    <div class="message-box bg-main">
        <div class="message-deco main-shadow bg-message flex-vert flex-vert-bottom">
            @if (!$status)
                <div class="m-auto text-center">
                    <p class="pb-2 fs-5 txt-gray"> 
                        有料会員になると<br>
                        使用できます 
                    </p>
                    <a class="py-1 fs-5 rounded-3 btn-user-action" href="{{ route('user.premium') }}">有料会員登録</a>
                </div>
                <div class="flex-bes px-3 py-2 bg-pic-ex message-form-deco">
                    <div class="flex-grow">
                        <div class="message-form-inp W-100 py-auto"></div>
                    </div>
                    <div class="message-form-icon px-2 fs-5">
                        <i class="bi bi-send-fill"></i>
                    </div>
                </div>
            @elseif($vetName)
                <div class="flex-vert m-3">
                    @foreach ($chatsList as $chat)
                        @if($chat['from_vet'])
                            <div class="flex-vert-s W-90 my-1">
                                <div class="message-box-s ps-3 pe-1 py-2 bg-menu-vet-2">
                                    <p class="txt-white">{{ $chat->message  ?? 'メッセージを取得できませんでした'}}</p>
                                </div>
                                <div class="flex-bes txt-gray fs-7">
                                    <p>{{ $vetName }}</p>
                                    <p>{{ date('n/j G:i', strtotime($chat->date)) }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex-vert-e W-90 my-1">
                                <div class="message-box-e ps-3 pe-1 py-2 bg-menu-user-2">
                                    <p class="txt-white">{{ $chat->message  ?? 'メッセージを取得できませんでした'}}</p>
                                </div>
                                <div class="flex-bes txt-gray fs-7">
                                    <p class="ms-auto">{{ date('n/j G:i', strtotime($chat->date)) }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <form class="flex-bes px-3 py-2 bg-pic-ex message-form-deco" action="{{ route('user.send-process', ['petId' => $petDetails->pet_id, 'vetId' => $chatsList[0]->vet_id]) }}" method="POST">
                    @csrf
                    <div class="flex-grow">
                        <textarea class="message-form-inp W-100 py-auto" id="message" name="message">{{ old('message', '') }}</textarea>
                        @if ($errors->has('message'))
                            @foreach($errors->get('message') as $message)
                                <p class="txt-error fs-7"> {{ $message }} </p>
                            @endforeach
                        @endif
                        @if (session('errorMessages'))
                            <p class="txt-error fs-7" >{{ session('errorMessages') }}</p>
                        @endif
                    </div>
                    <button class="message-form-icon px-2 fs-5" type="submit">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            @else
                <div class="flex-vert m-3">
                    <p class="mx-auto txt-gray">
                        メッセージはありません<br>
                        メッセージが送られてくるまで<br>
                        メッセージを送ることは出来ません
                    </p>
                </div>
                <div class="flex-bes px-3 py-2 bg-pic-ex message-form-deco">
                    <div class="flex-grow">
                        <div class="message-form-inp W-100 py-auto"></div>
                    </div>
                    <div class="message-form-icon px-2 fs-5">
                        <i class="bi bi-send-fill"></i>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
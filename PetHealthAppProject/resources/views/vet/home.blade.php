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
    <div class="menu-box flex-vert bg-menu-vet-1">
        <div class="mt-2 mb-auto">
            @foreach ($userList as $user)
                <div class="my-2 pb-2 me-30px menu-user-section bg-white">
                    <p class="ms-1 py-2 fs-4 fw-bold txt-gray">{{ $user['name'] }}</p>
                    @foreach ($petList as $pet)
                        @if ($pet['user_id'] === $user['user_id'])
                            <a href="{{ route('vet.home', ['petId' => $pet->pet_id]) }}" class="px-3 py-2 flex-bes @if($pet->pet_id == $petDetails->pet_id) bg-menu-vet-3 menu-selected main-shadow txt-white @else txt-gray @endif">
                                <div class="menu-circle bg-pic-ex"></div>
                                <div class="menu-info fs-4 fw-bold">
                                    {{ $pet['name'] }}
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
        <div class="flex-vert text-center bg-menu-vet-3 pe-20px">
            <a href="{{ route('vet.profile') }}" class="mx-auto my-2 w-75 fs-4 text-white">会員情報</a>
            <a href="{{ route('vet.logout') }}" class="mx-auto mb-2 w-75 fs-4 text-white">ログアウト</a>
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
                        <p class="fw-bold display-2 txt-vet-M">{{ $petDetails->name }}</p>
                    </div>
                    <div class="flex-bes">
                        <div class="w-50">
                            <p class="mt-1 fs-6 txt-gray">種類</p>
                            <p class="fs-5 txt-vet-S">{{ $petDetails->type }}</p>
                        </div>
                        <div class="flex-bes w-50">
                            <div class="w-50">
                                <p class="mt-1 fs-6 txt-gray">年齢</p>
                                <p class="fs-5 txt-vet-S">{{ $petDetails->age }} 才</p>                                   
                            </div>
                            <div class="w-50">
                                <p class="mt-1 fs-6 txt-gray">性別</p>
                                <div class="fs-5 txt-vet-S">
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
                            <p class="fs-5 txt-vet-S">{{ $petDetails->birth }}</p>        
                        </div>
                        <div class="w-50">
                            <p class="mt-1 fs-6 txt-gray">迎えた人</p>
                            <p class="fs-5 txt-vet-S">{{ $petDetails->adoption }}</p>        
                        </div>
                    </div>
                    <div>
                        <p class="mt-1 fs-6 txt-gray">メモ</p>
                        <p class="fs-5 txt-vet-S">{{ $petDetails->memo }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-middle radius-caontent bg-content">
            <div class="my-3">
                <div class="flex-vert">
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <p class="fs-5 txt-gray">朝食の種類</p>
                        </div>
                        <div class="flex-bes W-50">
                            <div class="W-70 pe-2">
                                <div class="w-100 fs-5 txt-vet-S">
                                    @isset($todayHealth->breakfast_type)
                                        <p>{{ $todayHealth->breakfast_type }}</p>
                                    @endisset
                                </div>
                            </div>
                            <div class="W-20">
                                <div class="W-100 fs-5 txt-vet-S">
                                    @isset($todayHealth->breakfast_amount)
                                        <p>{{ $todayHealth->breakfast_amount }}</p>
                                    @endisset
                                </div>
                            </div>
                            <div class="W-10 ">
                                <p class="W-20 fs-5 txt-vet-S">g</p>
                            </div>
                        </div>
                        <div class="W-20">
                            <p class="fs-5 txt-gray">体重</p>
                        </div>
                        <div class="flex-bes W-10">
                            <div class="W-80 fs-5 txt-vet-S">
                                @isset($todayHealth->weight)
                                    <p>{{ $todayHealth->weight }}</p>
                                @endisset
                            </div>
                            <p class="W-20 fs-5 txt-vet-S">kg</p>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <p class="fs-5 txt-gray">昼食の種類</p>
                        </div>
                        <div class="flex-bes W-50">
                            <div class="W-70 pe-2">
                                <div class="w-100 fs-5 txt-vet-S">
                                    @isset($todayHealth->lunch_type)
                                        <p>{{ $todayHealth->lunch_type }}</p>
                                    @endisset
                                </div>
                            </div>
                            <div class="W-20">
                                <div class="W-100 fs-5 txt-vet-S">
                                    @isset($todayHealth->lunch_amount)
                                        <p>{{ $todayHealth->lunch_amount }}</p>
                                    @endisset
                                </div>
                            </div>
                            <div class="W-10 ">
                                <p class="W-20 fs-5 txt-vet-S">g</p>
                            </div>
                        </div>
                        <div class="W-20">
                            <p class="fs-5 txt-gray">散歩</p>
                        </div>
                        <div class="flex-bes W-10">
                            <div class="W-80 fs-5 txt-vet-S">
                                @isset($todayHealth->walk)
                                    <p>{{ $todayHealth->walk }}</p>
                                @endisset
                            </div>
                            <p class="W-20 fs-5 txt-vet-S">分</p>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <p class="fs-5 txt-gray">夕食の種類</p>
                        </div>
                        <div class="flex-bes W-50">
                            <div class="W-70 pe-2">
                                <div class="w-100 fs-5 txt-vet-S">
                                    @isset($todayHealth->dinner_type)
                                        <p>{{ $todayHealth->dinner_type }}</p>
                                    @endisset
                                </div>
                            </div>
                            <div class="W-20">
                                <div class="W-100 fs-5 txt-vet-S">
                                    @isset($todayHealth->dinner_amount)
                                        <p>{{ $todayHealth->dinner_amount }}</p>
                                    @endisset
                                </div>
                            </div>
                            <div class="W-10 ">
                                <p class="W-20 fs-5 txt-vet-S">g</p>
                            </div>
                        </div>
                        <div class="W-20">
                            <p class="fs-5 txt-gray">トイレの回数</p>
                        </div>
                        <div class="flex-bes W-10">
                            <div class="W-80 fs-5 txt-vet-S">
                                @isset($todayHealth->toilet)
                                    @if($todayHealth->toilet)
                                        <p>{{ $todayHealth->toilet }}</p>
                                    @endif
                                @endisset
                            </div>
                            <p class="W-20 fs-5 txt-vet-S">回</p>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="W-20">
                            <p class="fs-5 txt-gray">飲んだ薬</p>
                        </div>
                        <div class="W-50">
                            <div class="W-90 fs-5 txt-vet-S">
                                @isset($todayHealth->medicine)
                                    <p>{{ $todayHealth->medicine }}</p>
                                @endisset
                            </div>
                        </div>
                        <div class="flex-bes W-30">
                            <div class="W-90">
                                <p class="fs-5 txt-gray">トリミングに行きましたか</p>
                            </div>
                            <div class="W-10">
                                @isset($todayHealth->trimming)
                                    <p class="txt-vet-S">●</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="flex-bes pb-2">
                        <div class="flex-vert W-20">
                            <p class="my-auto fs-5 txt-gray">メモ</p>
                        </div>
                        <div class="W-80">
                            <div class="W-100 fs-5 txt-vet-S">
                                @isset($todayHealth->memo)
                                    <p>{{ $todayHealth->memo }}</p>
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="ms-auto">
                        @if(!$todayHealth)
                            <p class="txt-accent-S">記入されていません</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="radius-caontent bg-content">
            <div class="m-1">
                <h1 class="txt-accent-M fw-bold display-6">過去のデータ</h1>
            </div>
            <div class="py-5"></div>
        </div>
    </div>
    <div class="message-box bg-main">
        <div class="message-deco shadow bg-message flex-vert flex-vert-bottom">
            @if(!$status)
                <div class="m-auto text-center">
                    <p class="pb-2 fs-5 txt-gray"> 
                        このユーザーは<br>
                        無料会員です
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
            @else
                <div class="flex-vert m-3">
                    @if($chatsList)
                        @foreach ($chatsList as $chat)
                            @if($chat['from_vet'])
                                <div class="flex-vert-e W-90 my-1">
                                    <div class="message-box-e ps-2 pe-2 py-1 bg-menu-vet-2">
                                        <p class="txt-white">{{ $chat->message  ?? 'メッセージを取得できませんでした'}}</p>
                                    </div>
                                    <div class="flex-bes txt-gray fs-7">
                                        <p class="ms-auto">{{ date('n/j G:i', strtotime($chat->date)) }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex-vert-s W-90 my-1">
                                    <div class="message-box-s ps-2 pe-1 py-2 bg-menu-user-2">
                                        <p class="txt-white">{{ $chat->message  ?? 'メッセージを取得できませんでした'}}</p>
                                    </div>
                                    <div class="flex-bes txt-gray fs-7">
                                        <p>{{ $userName }}</p>
                                        <p>{{ date('n/j G:i', strtotime($chat->date)) }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                    <p class="mx-auto txt-gray">メッセージはありません</p>
                    @endif
                </div>
                <form class="flex-bes px-3 py-2 bg-pic-ex message-form-deco" action="{{ route('vet.send-process', ['petId' => $petDetails->pet_id, 'userId' => $userId]) }}" method="POST">
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
            @endif
        </div>
    </div>
</body>
</html>
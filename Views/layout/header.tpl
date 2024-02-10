<div class="row">
    <div class="col-md-12 col-xs-10 px-0" style="background-color:lightgray;">
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color:lightgray;">
                <h1 class="index_level1" class="navbar-brand">Casteria</h1>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Food</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Drink</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="/contacts/form">お問合せ</a>
                        </li>

                        <form class="d-flex">
                            <input clas
                            s="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-black" type="submit">Search</button>
                        </form>

                        {if $auth === false}
                            <li class="nav-item">
                                <a class="nav-link" href="/user/log-in">ログイン</a>
                            </li>
                        {else}
                            <li class="nav-item">
                                <a class="nav-link" href="/user/my-page">マイページ</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/user/log-out" onclick="return confirm('ログアウトしますか?')">ログアウト</a>
                            </li>
                        {/if}
                    </ul>
                </div>
            </nav>
    </div>
</div>
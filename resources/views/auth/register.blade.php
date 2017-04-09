@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">


                    <?php if (count($errors) > 0): ?>
                    <ul>
                        <?php foreach ($errors->all() as $error): ?>
                        <li> - <?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <div class="signup-form"><!--sign up form-->
                        <h2>Регистрация на сайте</h2>
                        <form action="{{ url('/register') }}" method="post">
                            {{ csrf_field() }}
                            <input id="name" type="text" name="name" placeholder="Имя" value="{{ old('name') }}" required autofocus/>
                            <input id="email" type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required/>
                            <input id="password" type="password" name="password" placeholder="Пароль" required/>
                            <input id="password-confirm" type="password" name="password_confirmation" placeholder="Пароль" required/>
                            <input type="submit" name="submit" class="btn btn-default" value="Регистрация" />
                        </form>
                    </div><!--/sign up form-->


                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </section>
@endsection

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
                        <h2>Вход на сайт</h2>
                        <form action="{{ url('/login') }}" method="post">
                            {{ csrf_field() }}
                            <input id="email" type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required autofocus/>
                            <input id="password" type="password" name="password" placeholder="Пароль" required/>
                            <input type="submit" name="submit" class="btn btn-default" value="Вход" />
                        </form>
                    </div><!--/sign up form-->


                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </section>
@endsection

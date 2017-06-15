@extends('layouts.app_admin')

@section('content')
    <section>
        <div class="container">
            <div class="row">

                <br/>

                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="/admin">Админпанель</a></li>
                        <li><a href="/admin/order">Управление категориями</a></li>
                        <li class="active">Добавить категорию</li>
                    </ol>
                </div>


                <h4>Добавить новую категорию</h4>

                <br/>

                <?php if (count($errors) > 0): ?>
                <ul>
                    <?php foreach ($errors->all() as $error): ?>
                    <li> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>

                <div class="col-lg-4">
                    <div class="login-form">
                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <p>Название</p>
                            <input type="text" name="name" placeholder="" value="">

                            <p>Порядковый номер</p>
                            <input type="text" name="sort_order" placeholder="" value="">

                            <p>Статус</p>
                            <select name="status">
                                <option value="1" selected="selected">Отображается</option>
                                <option value="0">Скрыта</option>
                            </select>

                            <br><br>

                            <input type="submit" name="submit" class="btn btn-default" value="Сохранить">
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
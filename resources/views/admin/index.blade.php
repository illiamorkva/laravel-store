@extends('layouts.app_admin')

@section('content')
    <section>
        <div class="container">
            <div class="row">

                <br/>

                <h4>Добрый день, администратор!</h4>

                <br/>

                <p>Вам доступны такие возможности:</p>

                <br/>

                <ul>
                    <li><a href="/admin/product">Управление товарами</a></li>
                    <li><a href="/admin/category">Управление категориями</a></li>
                    <li><a href="/admin/order">Управление заказами</a></li>
                </ul>

            </div>
        </div>
    </section>
@endsection
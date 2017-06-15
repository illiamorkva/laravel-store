@extends('layouts.app_admin')

@section('content')
<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/order">Управление заказами</a></li>
                    <li class="active">Удалить заказ</li>
                </ol>
            </div>


            <h4>Удалить заказ #<?php echo $id; ?></h4>


            <p>Вы действительно хотите удалить этот заказ?</p>

            <form method="post">
                {{ csrf_field() }}
                <input type="submit" name="submit" value="Удалить" />
            </form>

        </div>
    </div>
</section>
@endsection
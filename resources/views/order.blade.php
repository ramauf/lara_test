<div class="panel panel-default">
    <div class="panel-heading">
        Редактирование заказа
    </div>
    <div class="panel-body">
        <form role="form" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="text" name="client_email" value="{{ $order['client_email'] }}" />
            </div>
            <div class="form-group">
                <label>Партнер</label>
                <select name="partner_id" class="form-control">
                    @foreach ($partners as $partner)
                        <option value="{{ $partner['id'] }}" {{ $partner['id'] == $order['partners']['id'] ? 'selected' : '' }}>{{ $partner['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Статус</label>
                <select name="status" class="form-control">
                    @foreach ($statusList as $ind => $val)
                        <option value="{{ $ind }}" {{ $ind == $order['status'] ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Товары</label>
                @foreach ($order['products'] as $ind => $product)
                    {{ $product['pivot']['quantity'] }} x {{ $product['name'] }}{{ $ind < count($order['products']) - 1 ? ', ' : '' }}
                @endforeach
            </div>
            <div class="form-group">
                <label>Стоимость заказа</label>
                {{ $order['price'] }}
            </div>
            <button type="button" class="btn btn-primary" onclick="this.form.submit()">Сохранить</button>
        </form>
    </div>
</div>



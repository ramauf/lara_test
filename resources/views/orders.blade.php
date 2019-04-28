<div class="panel-body">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#overdue" data-toggle="tab">просроченные</a>
        </li>
        <li><a href="#current" data-toggle="tab">текущие</a>
        </li>
        <li><a href="#new" data-toggle="tab">новые</a>
        </li>
        <li><a href="#complete" data-toggle="tab">выполненные</a>
        </li>
    </ul>

    <div class="tab-content">
        @foreach ($data as $type => $orders)
            <div class="tab-pane fade in {{ $type == 'overdue' ? 'active' : ''}}" id="{{ $type }}">

                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>ид_заказа</th>
                        <th>название_партнера</th>
                        <th>стоимость_заказа</th>
                        <th>наименование_состав_заказа</th>
                        <th>статус_заказа</th>
                    </tr>
                    @foreach ($orders as $order)
                        <tr>
                            <td><a href="/orders/{{ $order['id'] }}">{{ $order['id'] }}</a></td>
                            <td>{{ $order['partners']['name'] }}</td>
                            <td>{{ $order['price'] }}</td>
                            <td>{{ $order['items'] }}</td>
                            <td>{{ $order['status'] }}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        @endforeach
    </div>

</div>


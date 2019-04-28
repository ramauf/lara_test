<table class="table table-striped table-bordered table-hover">
    <tr>
        <th>ид_продукта</th>
        <th>наименование_продукта</th>
        <th>наименование_поставщика</th>
        <th>цена</th>
    </tr>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product['id'] }}</td>
            <td>{{ $product['name'] }}</td>
            <td>{{ $product['vendors']['name'] }}</td>
            <td>
                <span id="span_{{ $product['id'] }}">{{ $product['price'] }}</span>
                <input type="text" class="form-control editInputClass" id="input_{{ $product['id'] }}"
                       style="width:80px;display:none;" value="{{ $product['price'] }}" forid="{{ $product['id'] }}"/>
                <a href="#" class="editButtonClass" forid="{{ $product['id'] }}">edit</a>
            </td>
        </tr>
    @endforeach
</table>
<div class="col-xs-12">
    <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
        <ul class="pagination">

            <li class="paginate_button previous disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous">
                <a href="#">Страницы</a>
            </li>
            @for ($i = 1; $i <= $pages; $i++)
                <li class="paginate_button {{ $i == $page ? 'active' : ''}}" aria-controls="dataTables-example" tabindex="0">
                    <a href="/products/?page={{ $i  }}">{{ $i  }}</a>
                </li>
            @endfor
        </ul>
    </div>
</div>
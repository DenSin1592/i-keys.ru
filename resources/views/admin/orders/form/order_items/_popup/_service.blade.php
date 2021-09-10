<table class="services-container">
    <tr data-element-list="element">
        <td class="title">
            <label>Название услуги:</label>
        </td>
        <td class="name">
            <input type="text" class="form-control" data-name="">
        </td>

        <td class="add">
            <button type="button" class="btn btn-xs btn-success add" aria-label="add"
                    data-item-type="service"
                    data-url="{{ route('cc.orders.items.services.add') }}"
                    data-method="post"
                    >
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </td>
    </tr>
</table>
<style>
    tr {
        background-color: #F6F6F6;
        height: 60px;
        border-radius: 5px;
        padding-top: 16px;
    }
</style>
<tr class="p-3 bg-light mb-6 d-flex flex-row justify-content-between" style="display: flex;justify-content: space-between;  margin-bottom: 25px;">
    <td style="margin-left: 15px;">
        <a href="car/{{$id}}" class="text-decoration-none d-block p-3 bg-light text-dark underline text-medium text-gray-600 hover:text-gray-900">
            {{ $carName }} - {{ $modelName }}
        </a>
    </td>
    <td style="width: 60px;display: flex;justify-content: space-between;margin-right: 15px;">
        <a href="{{ route('car.upgrade', ['id' => $id, 'status' => 1]) }}" style="color: gray; text-decoration: none;" onmouseover="this.style.color='black'" onmouseout="this.style.color='gray'">
            <x-ri-edit-2-fill class="w-6 h-6 " />
        </a>

        <a href="car/delete/{{$id}}" style="color: red; text-decoration: none;" onmouseover="this.style.color='darkred'" onmouseout="this.style.color='red'">
            <x-fas-trash class="w-5 h-5 " />
        </a>
    </td>
</tr>
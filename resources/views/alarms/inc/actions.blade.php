@if (auth()->user()->can('edit alarms'))
    <a
        class='btn btn-warning btn-sm mr-2'
        href="{{ route('alarms.edit', $item->id) }}"
    >
        <i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit
    </a>
@endif
<a
    class='btn btn-info btn-sm mr-2'
    href="{{ route('alarms.show', $item->id) }}"
>
    <i title='Add' class='nav-icon mr-2 fa fa-eye'></i>View
</a>
@if (auth()->user()->can('delete alarms'))
    <button class='btn btn-danger btn-sm delete-alarm' data-id="{{ $item->id }}"><i class='fa fa-trash'></i> Delete</button>
@endif

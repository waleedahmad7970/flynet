@if (auth()->user()->can('edit roles'))
    <a
        class='btn btn-warning btn-sm mr-2'
        href="{{ route('roles.edit', $item->id) }}"
    >
        <i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit
    </a>
@endif


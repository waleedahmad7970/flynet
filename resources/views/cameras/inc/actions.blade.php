@if (auth()->user()->can('edit cameras'))
    <a
        class='btn btn-warning btn-sm mr-2'
        href={{ route('cameras.edit', $item->id) }}
    >
        <i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit
    </a>
@endif
<a
    class='btn btn-info btn-sm mr-2'
    href="{{ route('cameras.show', $item->id) }}"
>
    <i title='View' class='nav-icon mr-2 fa fa-eye'></i>View
</a>
@if (auth()->user()->can('delete cameras'))
    <button
        class='btn btn-danger btn-sm delete-camera'
        data-id='{$item->id}'
    >
        <i class='fa fa-trash'></i> Delete
    </button>
@endif

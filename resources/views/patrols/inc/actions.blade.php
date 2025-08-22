@if (auth()->user()->can('edit patrols'))
    <a
        class='btn btn-warning btn-sm mr-2'
        href="{{ route('patrols.edit', $item->id) }}"
    >
        <i title='Edit' class='nav-icon mr-2 fa fa-edit'></i>Edit
    </a>
@endif
@if (auth()->user()->can('delete patrols'))
    <button class='btn btn-danger btn-sm delete-patrol' data-id="{{ $item->id }}"><i class='fa fa-trash'></i> Delete</button>
@endif

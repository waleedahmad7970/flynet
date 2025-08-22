<a
    class="btn btn-primary btn-sm mr-2"
    href="{{ route('reports.download', $item->id) }}"
>
    <i title='Download' class='nav-icon mr-2 fa fa-download'></i>Download
</a>
@if (auth()->user()->can('delete reports'))
    <form action="{{ route('reports.destroy', $item->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button
            type="submit"
            class="btn btn-sm btn-danger"
            onclick="return confirm('Are you sure you want to delete this report?')"
        >
            <i title='Delete' class='nav-icon mr-2 fa fa-times'></i>
            Delete
        </button>
    </form>
@endif

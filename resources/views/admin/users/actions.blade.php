<div class="btn-group">
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm" title="View">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    @if($user->type->value === 'company' && !$user->company_verified_at)
    <form action="{{ route('admin.users.verify', $user) }}" method="POST" style="display: inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success btn-sm" title="Verify Company" onclick="return confirm('Are you sure you want to verify this company?')">
            <i class="fas fa-check"></i>
        </button>
    </form>
    @endif
    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div> 
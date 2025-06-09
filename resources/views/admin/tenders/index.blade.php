@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.tenders') }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tenders.create') }}" class="btn btn-primary">
                            {{ __('admin.create_tender') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filter Form -->
                    <form action="{{ route('admin.tenders.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_id">{{ __('admin.user') }}</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">{{ __('admin.select_user') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('admin.filter') }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <a href="{{ route('admin.tenders.index') }}" class="btn btn-secondary btn-block">
                                        {{ __('admin.reset') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('admin.subject') }}</th>
                                <th>{{ __('admin.user') }}</th>
                                <th>{{ __('admin.country') }}</th>
                                <th>{{ __('admin.city') }}</th>
                                <th>{{ __('admin.category') }}</th>
                                <th>{{ __('admin.contract_start_date') }}</th>
                                <th>{{ __('admin.contract_end_date') }}</th>
                                <th>{{ __('admin.closing_date') }}</th>
                                <th>{{ __('admin.status') }}</th>
                                <th>{{ __('admin.proposals') }}</th>
                                <th>{{ __('admin.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenders as $tender)
                                <tr>
                                    <td>{{ $tender->subject }}</td>
                                    <td>{{ $tender->user->full_name }}</td>
                                    <td>{{ $tender->country->arabic_name }}</td>
                                    <td>{{ $tender->city->arabic_name }}</td>
                                    <td>{{ $tender->workCategoryClassification->arabic_name }}</td>
                                    <td>{{ $tender->contract_start_date_text }}</td>
                                    <td>{{ $tender->contract_end_date_text }}</td>
                                    <td>{{ $tender->closing_date_text }}</td>
                                    <td>
                                        <span class="badge badge-{{ $tender->status->value === 'in_progress' ? 'success' :
                                            ($tender->status->value === 'draft' ? 'warning' :
                                            ($tender->status->value === 'closed' ? 'info' : 'danger')) }}">
                                            {{ __('admin.' . $tender->status->value) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $tender->proposals_count }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.tenders.edit', $tender) }}" class="btn btn-sm btn-info">
                                            {{ __('admin.edit') }}
                                        </a>
                                        <form action="{{ route('admin.tenders.destroy', $tender) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('admin.confirm_delete') }}')">
                                                {{ __('admin.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $tenders->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

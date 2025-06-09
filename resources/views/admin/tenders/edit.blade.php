@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('admin.edit_tender') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tenders.update', $tender) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="subject">{{ __('admin.subject') }}</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                id="subject" name="subject" value="{{ old('subject', $tender->subject) }}" required>
                            @error('subject')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contract_start_date">{{ __('admin.contract_start_date') }}</label>
                            <input type="date" class="form-control @error('contract_start_date') is-invalid @enderror"
                                id="contract_start_date" name="contract_start_date"
                                value="{{ old('contract_start_date', $tender->contract_start_date->format('Y-m-d')) }}" required>
                            @error('contract_start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="contract_end_date">{{ __('admin.contract_end_date') }}</label>
                            <input type="date" class="form-control @error('contract_end_date') is-invalid @enderror"
                                id="contract_end_date" name="contract_end_date"
                                value="{{ old('contract_end_date', $tender->contract_end_date->format('Y-m-d')) }}" required>
                            @error('contract_end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="closing_date">{{ __('admin.closing_date') }}</label>
                            <input type="date" class="form-control @error('closing_date') is-invalid @enderror"
                                id="closing_date" name="closing_date"
                                value="{{ old('closing_date', $tender->closing_date->format('Y-m-d')) }}" required>
                            @error('closing_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="country_id">{{ __('admin.country') }}</label>
                            <select class="form-control @error('country_id') is-invalid @enderror"
                                id="country_id" name="country_id" required>
                                <option value="">{{ __('admin.select_country') }}</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', $tender->country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->arabic_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="city_id">{{ __('admin.city') }}</label>
                            <select class="form-control @error('city_id') is-invalid @enderror"
                                id="city_id" name="city_id" required>
                                <option value="">{{ __('admin.select_city') }}</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}"
                                        data-country="{{ $city->country_id }}"
                                        {{ old('city_id', $tender->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->arabic_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">{{ __('admin.category') }}</label>
                            <select class="form-control @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="">{{ __('admin.select_category') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $tender->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->arabic_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="activity_id">{{ __('admin.activity') }}</label>
                            <select class="form-control @error('activity_id') is-invalid @enderror"
                                id="activity_id" name="activity_id" required>
                                <option value="">{{ __('admin.select_activity') }}</option>
                                @foreach($activities as $activity)
                                    <option value="{{ $activity->id }}"
                                        {{ old('activity_id', $tender->activity_id) == $activity->id ? 'selected' : '' }}>
                                        {{ $activity->arabic_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('activity_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">{{ __('admin.status') }}</label>
                            <select class="form-control @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->value }}"
                                        {{ old('status', $tender->status->value) == $status->value ? 'selected' : '' }}>
                                        {{ __('admin.' . $status->value) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                        <a href="{{ route('admin.tenders.index') }}" class="btn btn-secondary">{{ __('admin.cancel') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countrySelect = document.getElementById('country_id');
        const citySelect = document.getElementById('city_id');
        const cityOptions = citySelect.querySelectorAll('option');

        function filterCities() {
            const selectedCountryId = countrySelect.value;

            cityOptions.forEach(option => {
                if (option.value === '') return; // Skip the placeholder option

                const countryId = option.getAttribute('data-country');
                if (selectedCountryId === '' || countryId === selectedCountryId) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });

            // Reset city selection if the current selection is not valid for the selected country
            const selectedCity = citySelect.value;
            const selectedCityOption = citySelect.querySelector(`option[value="${selectedCity}"]`);
            if (selectedCity && selectedCityOption && selectedCityOption.style.display === 'none') {
                citySelect.value = '';
            }
        }

        // Initial filter
        filterCities();

        // Add event listener for country changes
        countrySelect.addEventListener('change', filterCities);
    });
</script>
@endsection




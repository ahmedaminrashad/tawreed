@if ($errors->any())
    <div class="alert alert-danger" style="margin: 8px 0; padding: 8px 12px; border-radius: 8px; background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; position: relative; display: inline-block; max-width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 2px; left: 6px; font-size: 18px; line-height: 1; padding: 0; background: transparent; border: 0; cursor: pointer; color: #721c24; opacity: 0.7; font-weight: bold; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; z-index: 1;">
            <span aria-hidden="true">&times;</span>
        </button>
        <div style="padding-left: 25px; font-size: 13px; line-height: 1.4;">
            <strong style="font-weight: 600; display: block; margin-bottom: 4px;">{{ __('web.error') }}</strong>
            <ul style="margin: 0; padding-left: 15px; font-size: 12px;">
                @foreach ($errors->all() as $error)
                    <li style="margin: 2px 0;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(session('status'))
    <div class="alert alert-success" style="margin: 8px 0; padding: 8px 12px; border-radius: 8px; background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; font-size: 13px; position: relative; display: inline-block; max-width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.1); line-height: 1.4;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 2px; left: 6px; font-size: 18px; line-height: 1; padding: 0; background: transparent; border: 0; cursor: pointer; color: #155724; opacity: 0.7; font-weight: bold; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; z-index: 1; margin: 0;">
            <span aria-hidden="true" style="margin: 0;">&times;</span>
        </button>
        <div style="padding-left: 25px;">{{ session('status') }}</div>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success" style="margin: 8px 0; padding: 8px 12px; border-radius: 8px; background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; font-size: 13px; position: relative; display: inline-block; max-width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.1); line-height: 1.4;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 2px; left: 6px; font-size: 18px; line-height: 1; padding: 0; background: transparent; border: 0; cursor: pointer; color: #155724; opacity: 0.7; font-weight: bold; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; z-index: 1; margin: 0;">
                <span aria-hidden="true" style="margin: 0;">&times;</span>
        </button>
        <div style="padding-left: 25px;"><strong style="font-weight: 600;">{{ __('web.success') }}:</strong> {{ session('success') }}</div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" style="margin: 8px 0; padding: 8px 12px; border-radius: 8px; background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; font-size: 13px; position: relative; display: inline-block; max-width: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.1); line-height: 1.4;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 2px; left: 6px; font-size: 18px; line-height: 1; padding: 0; background: transparent; border: 0; cursor: pointer; color: #721c24; opacity: 0.7; font-weight: bold; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; z-index: 1; margin: 0;">
            <span aria-hidden="true" style="margin: 0;">&times;</span>
        </button>
        <div style="padding-left: 25px;"><strong style="font-weight: 600;">{{ __('web.error') }}:</strong> {{ session('error') }}</div>
    </div>
@endif


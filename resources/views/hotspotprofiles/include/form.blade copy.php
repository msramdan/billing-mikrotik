<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($hotspotprofile) ? $hotspotprofile->name : old('name') }}" placeholder="{{ __('Name') }}" required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="pool">{{ __('Pool') }}</label>
            <input type="text" name="pool" id="pool" class="form-control @error('pool') is-invalid @enderror" value="{{ isset($hotspotprofile) ? $hotspotprofile->pool : old('pool') }}" placeholder="{{ __('Pool') }}" required />
            @error('pool')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="limit">{{ __('Limit') }}</label>
            <input type="text" name="limit" id="limit" class="form-control @error('limit') is-invalid @enderror" value="{{ isset($hotspotprofile) ? $hotspotprofile->limit : old('limit') }}" placeholder="{{ __('Limit') }}" required />
            @error('limit')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="session">{{ __('Session') }}</label>
            <input type="text" name="session" id="session" class="form-control @error('session') is-invalid @enderror" value="{{ isset($hotspotprofile) ? $hotspotprofile->session : old('session') }}" placeholder="{{ __('Session') }}" required />
            @error('session')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="shared">{{ __('Shared') }}</label>
            <input type="text" name="shared" id="shared" class="form-control @error('shared') is-invalid @enderror" value="{{ isset($hotspotprofile) ? $hotspotprofile->shared : old('shared') }}" placeholder="{{ __('Shared') }}" required />
            @error('shared')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="comment">{{ __('Comment') }}</label>
            <input type="text" name="comment" id="comment" class="form-control @error('comment') is-invalid @enderror" value="{{ isset($hotspotprofile) ? $hotspotprofile->comment : old('comment') }}" placeholder="{{ __('Comment') }}" required />
            @error('comment')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>
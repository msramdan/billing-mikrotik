<div class="row mb-2">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">{{ __('Name') }}<span
                style="color: red">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ isset($olt) ? $olt->name : old('name') }}" placeholder="{{ __('Name') }}" required />
            @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="type">{{ __('Type') }}<span
                style="color: red">*</span></label>
            <select class="form-select @error('type') is-invalid @enderror" name="type" id="type" class="form-control" required>
                <option value="" selected disabled>-- {{ __('Select type') }} --</option>
                <option value="Zte" {{ isset($olt) && $olt->type == 'Zte' ? 'selected' : (old('type') == 'Zte' ? 'selected' : '') }}>Zte</option>
		        {{-- <option value="Huawei" {{ isset($olt) && $olt->type == 'Huawei' ? 'selected' : (old('type') == 'Huawei' ? 'selected' : '') }}>Huawei</option> --}}
            </select>
            @error('type')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="host">{{ __('Host') }}<span
                style="color: red">*</span></label>
            <input type="text" name="host" id="host" class="form-control @error('host') is-invalid @enderror" value="{{ isset($olt) ? $olt->host : old('host') }}" placeholder="{{ __('Host') }}" required />
            @error('host')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="telnet_port">{{ __('Telnet Port') }}<span
                style="color: red">*</span></label>
            <input type="number" name="telnet_port" id="telnet_port" class="form-control @error('telnet_port') is-invalid @enderror" value="{{ isset($olt) ? $olt->telnet_port : old('telnet_port') }}" placeholder="{{ __('Telnet Port') }}" required />
            @error('telnet_port')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="telnet_username">{{ __('Telnet Username') }}<span
                style="color: red">*</span></label>
            <input type="text" name="telnet_username" id="telnet_username" class="form-control @error('telnet_username') is-invalid @enderror" value="{{ isset($olt) ? $olt->telnet_username : old('telnet_username') }}" placeholder="{{ __('Telnet Username') }}" required />
            @error('telnet_username')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="telnet_password">{{ __('Telnet Password') }}<span
                style="color: red">*</span></label>
            <input type="text" name="telnet_password" id="telnet_password" class="form-control @error('telnet_password') is-invalid @enderror" value="{{ isset($olt) ? $olt->telnet_password : old('telnet_password') }}" placeholder="{{ __('Password') }}" required />
            @error('telnet_password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="snmp_port">{{ __('Snmp Port') }}<span
                style="color: red">*</span></label>
            <input type="number" name="snmp_port" id="snmp_port" class="form-control @error('snmp_port') is-invalid @enderror" value="{{ isset($olt) ? $olt->snmp_port : old('snmp_port') }}" placeholder="{{ __('Snmp Port') }}" required />
            @error('snmp_port')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="ro_community">{{ __('Ro Community') }}<span
                style="color: red">*</span></label>
            <input type="text" name="ro_community" id="ro_community" class="form-control @error('ro_community') is-invalid @enderror" value="{{ isset($olt) ? $olt->ro_community : old('ro_community') }}" placeholder="{{ __('Ro Community') }}" required />
            @error('ro_community')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="ip_acs">{{ __('IP Acs') }}</label>
            <input type="text" name="ip_acs" id="ip_acs" class="form-control @error('ip_acs') is-invalid @enderror" value="{{ isset($olt) ? $olt->ip_acs : old('ip_acs') }}" placeholder="{{ __('IP Acs') }}" />
            @error('ip_acs')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="acs_username">{{ __('Acs Username') }}</label>
            <input type="text" name="acs_username" id="acs_username" class="form-control @error('acs_username') is-invalid @enderror" value="{{ isset($olt) ? $olt->acs_username : old('acs_username') }}" placeholder="{{ __('Acs Username') }}" />
            @error('acs_username')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="acs_password">{{ __('Acs Password') }}</label>
            <input type="text" name="acs_password" id="acs_password" class="form-control @error('acs_password') is-invalid @enderror" value="{{ isset($olt) ? $olt->acs_password : old('acs_password') }}" placeholder="{{ __('Acs Password') }}" />
            @error('acs_password')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body pb-2">
        <h5>Pickup #{{ request()->input('i') }}</h5>
        <hr>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Pickup Location</label>
                    <select name="pickup[{{ request()->input('i') }}][location]" class="form-control location-field">
                        <option selected disabled required>-- Please Select --</option>
                        @foreach(auth()->user()->shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }} ({{ $shop->address }})</option>
                        @endforeach
                    </select>
                    <span class="mt-2 d-block">Don't see a location? <a href="javascript:;" onclick="$('#newLocationModal').modal()">Click here </a> to add a new location.</span>

                </div>
                <div class="col-md-3">
                    <label>Choose Type</label>
                    <select name="pickup[{{ request()->input('i') }}][type]" id="type-{{ request()->input('i') }}"  class="form-control" onchange="changeType({{ request()->input('i') }})">
                        <option value="oneoff">One Off Collection</option>
                        <option value="recurring">Recurring Collection</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Pickup Amount ($) (Optional)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Amount" name="pickup[{{ request()->input('i') }}][amount]">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <hr />
                    <div id="date-{{ request()->input('i') }}">
                        <label>One-off Pickup Date</label>
                        <input type="date" class="form-control col-md-3" name="pickup[{{ request()->input('i') }}][date]" value="{{ date('Y-m-d') }}">
                    </div>
                    <div id="schedule-{{ request()->input('i') }}" style="display:none">
                        <div class="row">
                            <div class="col-md">
                                <label for="monday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][monday]" id="monday-{{ request()->input('i') }}" value="1">
                                    Monday
                                </label>
                            </div>
                            <div class="col-md">
                                <label for="tuesday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][tuesday]" id="tuesday-{{ request()->input('i') }}" value="1">
                                    Tuesday
                                </label>
                            </div>
                            <div class="col-md">
                                <label for="wednesday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][wednesday]" id="wednesday-{{ request()->input('i') }}" value="1">
                                    Wednesday
                                </label>
                            </div>
                            <div class="col-md">
                                <label for="thursday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][thursday]" id="thursday-{{ request()->input('i') }}" value="1">
                                    Thursday
                                </label>
                            </div>
                            <div class="col-md">
                                <label for="friday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][friday]" id="friday-{{ request()->input('i') }}" value="1">
                                    Friday
                                </label>
                            </div>
                            <div class="col-md">
                                <label for="saturday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][saturday]" id="saturday-{{ request()->input('i') }}" value="1">
                                    Saturday
                                </label>
                            </div>
                            <div class="col-md">
                                <label for="sunday-{{ request()->input('i') }}">
                                    <input type="checkbox" name="pickup[{{ request()->input('i') }}][sunday]" id="sunday-{{ request()->input('i') }}" value="1">
                                    Sunday
                                </label>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col">
                                <label for="weekly-{{ request()->input('i') }}">
                                    <input type="radio" name="pickup[{{ request()->input('i') }}][frequency]" id="weekly-{{ request()->input('i') }}" value="weekly" checked>
                                    Weekly
                                </label>
                            </div>
                            <div class="col">
                                <label for="biweekly-{{ request()->input('i') }}">
                                    <input type="radio" name="pickup[{{ request()->input('i') }}][frequency]" id="biweekly-{{ request()->input('i') }}" value="biweekly">
                                    Bi-weekly
                                </label>
                            </div>
                            <div class="col">
                                <label for="fourweekly-{{ request()->input('i') }}">
                                    <input type="radio" name="pickup[{{ request()->input('i') }}][frequency]" id="fourweekly-{{ request()->input('i') }}" value="fourweekly">
                                    Four Weekly
                                </label>
                            </div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                            <div class="col"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
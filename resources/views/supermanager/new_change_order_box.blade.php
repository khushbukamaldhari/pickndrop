<div class="card mb-3">
    <div class="card-body pb-2">
        <h5>Change Order #{{ request()->input('i') }}</h5>
        <hr>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label>Drop Off Location</label>
                    <select name="changeorder[{{ request()->input('i') }}][location]" class="form-control location-field">
                        <option selected disabled required>-- Please Select --</option>
                        @foreach(auth()->user()->shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }} ({{ $shop->address }})</option>
                        @endforeach
                    </select>
                    <span class="mt-2 d-block">Don't see a location? <a href="javascript:;" onclick="$('#newLocationModal').modal()">Click here </a> to add a new location.</span>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h5 class="mt-4">Denominations</h5>
                    <p>Enter the exact amount in $. For example, for 100x $1 bills, enter $100.</p>
                    <div class="form-group">
                        <div class="row mt-3">
                            <div class="col-md">
                                <label>$50</label>
                                <input type="text" class="form-control" data-denomination="50" value="0" name="changeorder[{{ request()->input('i') }}][50usd]">
                            </div>
                            <div class="col-md">
                                <label>$20</label>
                                <input type="text" class="form-control" data-denomination="20" value="0" name="changeorder[{{ request()->input('i') }}][20usd]">
                            </div>
                            <div class="col-md">
                                <label>$10</label>
                                <input type="text" class="form-control" data-denomination="10" value="0" name="changeorder[{{ request()->input('i') }}][10usd]">
                            </div>
                            <div class="col-md">
                                <label>$5</label>
                                <input type="text" class="form-control" data-denomination="5" value="0" name="changeorder[{{ request()->input('i') }}][5usd]">
                            </div>
                            <div class="col-md">
                                <label>$1</label>
                                <input type="text" class="form-control" data-denomination="1" value="0" name="changeorder[{{ request()->input('i') }}][1usd]">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md">
                                <label>1¢</label>
                                <input type="text" class="form-control" data-denomination="0.01" value="0" name="changeorder[{{ request()->input('i') }}][1cent]">
                            </div>
                            <div class="col-md">
                                <label>5¢</label>
                                <input type="text" class="form-control" data-denomintation="0.05" value="0" name="changeorder[{{ request()->input('i') }}][5cents]">
                            </div>
                            <div class="col-md">
                                <label>10¢</label>
                                <input type="text" class="form-control" data-denomination="0.10" value="0" name="changeorder[{{ request()->input('i') }}][10cents]">
                            </div>
                            <div class="col-md">
                                <label>25¢</label>
                                <input type="text" class="form-control" data-denomination="0.25" value="0" name="changeorder[{{ request()->input('i') }}][25cents]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <hr />
                    <div id="date-{{ request()->input('i') }}">
                        <label>Delivery Date</label>
                        <input type="date" class="form-control col-md-3" name="changeorder[{{ request()->input('i') }}][date]" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
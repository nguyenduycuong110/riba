<div class="ibox">
    <div class="ibox-title">
        <div>
            <h5>Chính sách học bổng</h5>
        </div>
    </div>
    <div class="ibox-content">
        <div class="variant-foot mt10">
            <button type="button" class="add-policy">Thêm chính sách mới</button>
        </div>
        <div class="program-content mt20">
            @php
                $scholarship_policies = old('scholarship_policy', json_decode($scholarship->scholarship_policy) ?? []);
            @endphp
            @if(isset($scholarship_policies) && is_array($scholarship_policies) && count($scholarship_policies))
                @foreach($scholarship_policies as $index => $scholarship_policy)
                    <div class="ibox mt20 policy-wrapper" data-policy-index="{{ $index }}">
                        <div class="ibox-title">
                            <div class="uk-flex uk-flex-middle uk-flex-space-between mb15">
                                <input type="text" 
                                    name="scholarship_policy[{{ $index }}][title]" 
                                    class="form-control" 
                                    value="{{ $scholarship_policy->title ?? '' }}" 
                                    placeholder="Nhập vào tên chính sách" style="width:75%;">
                                <div class="chapter-action">
                                    <button type="button" class="remove-policy-item">Xóa chính sách</button>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="" class="control-label text-left">Nội dung</label>
                                <textarea name="scholarship_policy[{{ $index }}][description]" class="ck-editor" id="scholarship_policy[{{ $index }}]" placeholder="Nhập mô tả chính sách" style="width:100%; margin-top:10px;">{{ $scholarship_policy->description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

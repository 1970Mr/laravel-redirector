<div class="mb-3">
    <label for="source_url" class="form-label">Source URL</label>
    <input type="text" class="form-control" id="source_url" name="source_url" value="{{ old('source_url', $redirect->source_url ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="destination_url" class="form-label">Destination URL</label>
    <input type="text" class="form-control" id="destination_url" name="destination_url" value="{{ old('destination_url', $redirect->destination_url ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="status_code" class="form-label">Status Code</label>
    <input type="number" class="form-control" id="status_code" name="status_code" value="{{ old('status_code', $redirect->status_code ?? '') }}" required>
</div>
<div class="mb-3">
    <label for="is_active" class="form-label">Active</label>
    <select class="form-control" id="is_active" name="is_active" required>
        <option value="1" {{ (old('is_active', $redirect->is_active ?? '') == '1') ? 'selected' : '' }}>Yes</option>
        <option value="0" {{ (old('is_active', $redirect->is_active ?? '') == '0') ? 'selected' : '' }}>No</option>
    </select>
</div>

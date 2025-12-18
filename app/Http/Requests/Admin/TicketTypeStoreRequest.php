<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TicketTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id'      => 'required|exists:events,id',
            'name'          => 'required|string|max:100',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'currency'      => 'required|string|size:3',
            'quantity'      => 'required|integer|min:1',
            'min_per_order' => 'required|integer|min:1',
            'max_per_order' => 'required|integer|gte:min_per_order',
            'is_free'       => 'boolean',
            'is_visible'    => 'boolean',
            'sale_start'    => 'nullable|date',
            'sale_end'      => 'nullable|date|after:sale_start',
            'sales_channel' => 'required|in:online,offline,invite',
            'status'        => 'nullable|in:active,inactive',
            'sort_order'    => 'nullable|integer|min:0',
            'metadata'      => 'nullable|array',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->boolean('is_free')) {
            $this->merge(['price' => 0]);
        }
    }
}

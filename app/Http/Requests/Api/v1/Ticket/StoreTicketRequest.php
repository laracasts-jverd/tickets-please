<?php

namespace App\Http\Requests\Api\v1\Ticket;

use App\Permissions\Abilities;

class StoreTicketRequest extends BaseTicketRequest
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
        $rules = [
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X',
            'data.relationships.author.data.id' => 'required|integer|exists:users,id',
        ];

        $user = $this->user();

        if ($this->routeIs('tickets.store')) {
            if ($user->tokenCan(Abilities::CREATE_OWN_TICKET)) {
                // author_id must be the same as the authenticated user
                $rules['data.relationships.author.data.id'] .= '|size:'.$user->id;
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'data.attributes.status' => 'The status field must be one of: A, C, H, X',
        ];
    }
}

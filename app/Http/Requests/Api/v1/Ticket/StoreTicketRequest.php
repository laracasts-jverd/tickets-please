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
        $authorId = $this->routeIs('tickets.store') ? 'data.relationships.author.data.id' : 'author';
        $user = $this->user();
        $authorRule = 'required|integer|exists:users,id';

        $rules = [
            'data.attributes.title' => 'required|string',
            'data.attributes.description' => 'required|string',
            'data.attributes.status' => 'required|string|in:A,C,H,X',
            $authorId => $authorRule.'|size:'.$user->id,
        ];

        if ($user->tokenCan(Abilities::CREATE_TICKET)) {
            $rules[$authorId] = $authorRule;
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->routeIs('tickets.store')) {
            $this->merge([
                'author' => $this->route('author'),
            ]);
        }
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

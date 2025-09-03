@include('errors.layout', [
    'code' => $code ?? 'Error',
    'icon' => '⚠️',
    'message' => $message ?? __('messages.something_went_wrong')
])

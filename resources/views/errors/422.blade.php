@extends('errors.layout')

@section('title', 'Unprocessable Entity')
@section('code', '422')
@section('message', __('messages.error_422_message', [], app()->getLocale()) ?? 'Unable to process the request. Please check your input.')
